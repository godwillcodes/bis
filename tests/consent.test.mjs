// Run with: npm test
// Loads the real js/consent.js into a fake browser and drives it. Each test names the rule it
// protects; docs/consent.md lists them.
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

const SOURCE = readFileSync(new URL('../js/consent.js', import.meta.url), 'utf8');
const FORM_ID = 'fcd51d31-6a18-499b-b052-67cc3d49a661';
const MAP_SRC = 'https://www.google.com/maps/embed?pb=!1m18!1m12';
const GA_ID = 'G-TEST123456';

function el(attrs = {}) {
	const a = { ...attrs };
	return {
		hidden: false,
		textContent: '',
		getAttribute: (k) => (k in a ? a[k] : null),
		setAttribute: (k, v) => { a[k] = String(v); },
		removeAttribute: (k) => { delete a[k]; },
		focus() { this.focused = true; },
	};
}

function formEl(attrs = {}) {
	const target = el();
	const form = el({ 'data-portal-id': '22423917', 'data-form-id': FORM_ID, 'data-region': 'na1', 'data-css-class': 'custom-hs-form', ...attrs });
	form.querySelector = () => target;
	return form;
}

function embedEl(src = MAP_SRC) {
	const frame = el({ 'data-src': src });
	const box = el();
	box.querySelector = () => frame;
	box.frame = frame;
	return box;
}

function boot({ cookie = '', gpc = false, forms = [], embeds = [], gaId = GA_ID, withBanner = true } = {}) {
	const jar = new Map();
	cookie.split(';').map((c) => c.trim()).filter(Boolean).forEach((c) => {
		const [k, v] = c.split('=');
		jar.set(k, v);
	});

	const appended = [];
	const listeners = {};
	const fired = [];
	const timers = [];
	const intervals = [];
	const modes = [el({ 'data-bisc-mode': 'choice' }), el({ 'data-bisc-mode': 'gpc' })];
	modes[1].hidden = true;
	const status = el();
	const banner = el();
	banner.querySelectorAll = () => modes;
	banner.querySelector = () => status;

	const location = { protocol: 'https:', hostname: 'www.example.test', reloads: 0, reload() { this.reloads += 1; } };

	const document = {
		readyState: 'complete',
		get cookie() { return [...jar].map(([k, v]) => `${k}=${v}`).join('; '); },
		set cookie(str) {
			const [pair] = str.split(';');
			const [k, v] = pair.split('=');
			if (/expires=Thu, 01 Jan 1970/.test(str)) jar.delete(k.trim());
			else jar.set(k.trim(), v);
		},
		head: { appendChild: (node) => { appended.push(node); } },
		createElement: () => ({ parentNode: null }),
		querySelector: (s) => (s === '[data-bisc-banner]' && withBanner ? banner : null),
		querySelectorAll: (s) => {
			if (s === '[data-bis-hubspot-form]') return forms;
			if (s === '[data-bis-embed]') return embeds;
			return [];
		},
		addEventListener: (type, fn) => { (listeners[type] = listeners[type] || []).push(fn); },
		dispatchEvent: (e) => { fired.push(e.type); },
	};

	const sandbox = {
		document,
		location,
		navigator: { globalPrivacyControl: gpc },
		setTimeout: (fn, ms) => { timers.push({ fn, ms }); return timers.length; },
		setInterval: (fn) => { intervals.push(fn); return intervals.length; },
		clearInterval: () => {},
		CustomEvent: class { constructor(type, init) { this.type = type; this.detail = init && init.detail; } },
		Date,
		Math,
		Array,
		encodeURIComponent,
		bisConsentConfig: { gaId },
		dataLayer: [],
	};
	sandbox.window = sandbox;
	vm.runInNewContext(SOURCE, sandbox);

	const click = (selector) => {
		const target = { closest: (s) => (s === selector ? {} : null) };
		listeners.click.forEach((fn) => fn({ target, preventDefault() {} }));
	};
	const calls = () => sandbox.dataLayer.filter((e) => e && typeof e.length === 'number' && !Array.isArray(e)).map((e) => Array.from(e));
	const events = () => sandbox.dataLayer.filter((e) => e && e.event).map((e) => e.event);

	return {
		window: sandbox, banner, modes, status, jar, appended, fired, location, forms, embeds, calls, events,
		runTimers: () => { while (timers.length) timers.shift().fn(); },
		runIntervals: () => intervals.forEach((fn) => fn()),
		click,
		key: (key) => listeners.keydown.forEach((fn) => fn({ key })),
		load: (src) => { appended.find((s) => s.src.startsWith(src)).onload(); },
		fail: (src) => { appended.find((s) => s.src.startsWith(src)).onerror(); },
		srcs: () => appended.map((s) => s.src),
		isOpen: () => banner.getAttribute('data-open') === 'true',
		mode: () => modes.find((m) => !m.hidden).getAttribute('data-bisc-mode'),
	};
}

const hbspt = () => {
	const calls = [];
	return { calls, forms: { create: (opts) => calls.push(opts) } };
};

const EVERYTHING = () => ({ forms: [formEl()], embeds: [embedEl()] });

test('first visit: banner opens after a delay and nothing third-party loads', () => {
	const page = EVERYTHING();
	const env = boot(page);
	assert.equal(env.window.bisConsent.effective(), null);
	assert.equal(env.isOpen(), false, 'banner waits for the delay');
	env.runTimers();
	assert.equal(env.isOpen(), true);
	assert.equal(env.mode(), 'choice');
	assert.deepEqual(env.srcs(), [], 'no analytics, Claydar or HubSpot script');
	assert.equal(page.embeds[0].frame.getAttribute('src'), null, 'map iframe has no src');
	assert.equal(env.jar.size, 0, 'no cookie is written before a choice');
});

test('direct calls to the loaders are refused without consent', () => {
	const page = EVERYTHING();
	const env = boot(page);
	let result;
	env.window.bisMountHubspotForm(page.forms[0], (ok, reason) => { result = { ok, reason }; });
	env.window.bisMountEmbed(page.embeds[0]);
	assert.deepEqual(result, { ok: false, reason: 'consent' });
	assert.deepEqual(env.srcs(), []);
	assert.equal(page.embeds[0].frame.getAttribute('src'), null);
});

test('accept loads analytics, Claydar, HubSpot and the map, and tells Google', () => {
	const page = EVERYTHING();
	const env = boot(page);
	env.runTimers();
	env.click('[data-bisc-accept]');
	assert.equal(env.jar.get('bis_cookie_consent'), 'accepted');
	assert.deepEqual(env.srcs(), [
		`https://www.googletagmanager.com/gtag/js?id=${GA_ID}`,
		'https://static.claydar.com/init.v1.js?id=coUSWCoUir',
		'https://js.hsforms.net/forms/embed/v2.js',
	]);
	assert.equal(page.embeds[0].frame.getAttribute('src'), MAP_SRC);
	assert.equal(page.embeds[0].getAttribute('data-state'), 'ready');

	const update = env.calls().find((c) => c[0] === 'consent' && c[1] === 'update');
	assert.equal(update[2].analytics_storage, 'granted');
	assert.equal(update[2].ad_storage, 'granted');
	assert.ok(env.calls().some((c) => c[0] === 'config' && c[1] === GA_ID));
	assert.deepEqual(env.events(), ['bis_cookie_consent_accepted']);

	const api = hbspt();
	env.window.hbspt = api;
	env.load('https://js.hsforms.net');
	assert.equal(page.forms[0].getAttribute('data-state'), 'ready');
	assert.deepEqual(
		{ portalId: api.calls[0].portalId, formId: api.calls[0].formId, region: api.calls[0].region, cssClass: api.calls[0].cssClass },
		{ portalId: '22423917', formId: FORM_ID, region: 'na1', cssClass: 'custom-hs-form' },
	);
	assert.equal(env.isOpen(), false);
	assert.ok(env.fired.includes('cookieConsentAccepted'));
});

test('Claydar is told consent was given once its script exposes the API', () => {
	const env = boot({ cookie: 'bis_cookie_consent=accepted' });
	let granted = 0;
	env.load('https://static.claydar.com');
	env.runIntervals();
	assert.equal(granted, 0, 'nothing to call yet');
	env.window.Claydar = { giveCookieConsent: () => { granted += 1; } };
	env.runIntervals();
	assert.equal(granted, 1);
});

test('a returning visitor who accepted loads everything without seeing the banner', () => {
	const env = boot({ cookie: 'bis_cookie_consent=accepted', ...EVERYTHING() });
	env.runTimers();
	assert.equal(env.isOpen(), false);
	assert.equal(env.srcs().length, 3);
	const update = env.calls().find((c) => c[0] === 'consent' && c[1] === 'update');
	assert.equal(update[2].analytics_storage, 'granted');
});

test('decline loads nothing, tells Google, and does not reload the page', () => {
	const page = EVERYTHING();
	const env = boot(page);
	env.runTimers();
	env.click('[data-bisc-decline]');
	env.runTimers();
	assert.equal(env.jar.get('bis_cookie_consent'), 'declined');
	assert.deepEqual(env.srcs(), []);
	assert.equal(page.embeds[0].frame.getAttribute('src'), null);
	assert.equal(env.location.reloads, 0);
	const update = env.calls().find((c) => c[0] === 'consent' && c[1] === 'update');
	assert.equal(update[2].analytics_storage, 'denied');
	assert.deepEqual(env.events(), ['bis_cookie_consent_declined']);
	assert.ok(env.fired.includes('cookieConsentDeclined'));
});

test('withdrawing after accept clears vendor cookies and reloads', () => {
	const env = boot({
		cookie: 'bis_cookie_consent=accepted; _ga=1; _ga_ABC123=2; _gcl_au=3; hubspotutk=4; __hstc=5; keep=1',
		...EVERYTHING(),
	});
	env.runTimers();
	env.click('[data-bis-cookie-settings]');
	assert.equal(env.status.textContent, 'Current choice: Accepted');
	env.click('[data-bisc-decline]');
	['_ga', '_ga_ABC123', '_gcl_au', 'hubspotutk', '__hstc'].forEach((name) => {
		assert.equal(env.jar.has(name), false, name);
	});
	assert.equal(env.jar.get('keep'), '1', 'unrelated cookies are left alone');
	env.runTimers();
	assert.equal(env.location.reloads, 1);
});

test('Global Privacy Control overrides a stored accept and loads nothing', () => {
	const env = boot({ cookie: 'bis_cookie_consent=accepted', gpc: true, ...EVERYTHING() });
	assert.equal(env.window.bisConsent.effective(), 'declined');
	env.runTimers();
	assert.equal(env.jar.get('bis_cookie_consent'), 'declined');
	assert.deepEqual(env.srcs(), []);
	assert.equal(env.isOpen(), true);
	assert.equal(env.mode(), 'gpc');
	assert.equal(env.banner.getAttribute('aria-labelledby'), 'bisc-title-gpc');
	assert.ok(env.events().includes('bis_cookie_consent_gpc'));
});

test('Global Privacy Control: an explicit accept is recorded and honored later', () => {
	const first = boot({ gpc: true, ...EVERYTHING() });
	first.runTimers();
	first.click('[data-bis-cookie-settings]');
	first.click('[data-bisc-accept]');
	assert.equal(first.jar.get('bis_consent_gpc_ack'), '1');
	assert.equal(first.srcs().length, 3);

	const next = boot({ cookie: 'bis_cookie_consent=accepted; bis_consent_gpc_ack=1', gpc: true, ...EVERYTHING() });
	assert.equal(next.window.bisConsent.effective(), 'accepted');
	assert.equal(next.srcs().length, 3);
});

test('values from the page or config are validated before anything is fetched', () => {
	const consented = 'bis_cookie_consent=accepted';

	const badAnalytics = boot({ cookie: consented, gaId: 'G-1; alert(1)' });
	assert.equal(badAnalytics.srcs().some((s) => s.includes('googletagmanager')), false);
	const noAnalytics = boot({ cookie: consented, gaId: '' });
	assert.equal(noAnalytics.srcs().some((s) => s.includes('googletagmanager')), false);

	[
		{ 'data-portal-id': '22423917; alert(1)' },
		{ 'data-form-id': 'not-a-guid' },
		{ 'data-region': 'na1/../x' },
		{ 'data-css-class': 'a b"onload="x' },
	].forEach((attrs) => {
		const env = boot({ cookie: consented });
		let result;
		env.window.bisMountHubspotForm(formEl(attrs), (ok, reason) => { result = { ok, reason }; });
		assert.deepEqual(result, { ok: false, reason: 'error' }, JSON.stringify(attrs));
		assert.equal(env.srcs().some((s) => s.includes('hsforms')), false);
	});

	['https://evil.example/maps/embed?x=1', 'https://www.google.com/other?x=1', 'javascript:alert(1)'].forEach((src) => {
		const embed = embedEl(src);
		const env = boot({ cookie: consented });
		env.window.bisMountEmbed(embed);
		assert.equal(embed.frame.getAttribute('src'), null, src);
		assert.equal(embed.getAttribute('data-state'), 'error');
	});
});

test('two forms on one page share a single script request', () => {
	const [one, two] = [formEl(), formEl()];
	const env = boot({ cookie: 'bis_cookie_consent=accepted', forms: [one, two] });
	assert.equal(env.srcs().filter((s) => s.includes('hsforms')).length, 1);
	const api = hbspt();
	env.window.hbspt = api;
	env.load('https://js.hsforms.net');
	assert.equal(api.calls.length, 2);
	assert.equal(one.getAttribute('data-state'), 'ready');
	assert.equal(two.getAttribute('data-state'), 'ready');
});

test('a vendor script that fails to load can be retried', () => {
	const form = formEl();
	const env = boot({ cookie: 'bis_cookie_consent=accepted', forms: [form] });
	env.fail('https://js.hsforms.net');
	assert.equal(form.getAttribute('data-state'), 'error');
	env.window.bisMountHubspotForm(form);
	assert.equal(env.srcs().filter((s) => s.includes('hsforms')).length, 2);

	env.fail('https://static.claydar.com');
	env.click('[data-bisc-accept]');
	assert.equal(env.srcs().filter((s) => s.includes('claydar')).length, 2, 'Claydar is retried after a failure');
});

test('closing the banner records no choice; Escape closes it', () => {
	const env = boot(EVERYTHING());
	env.runTimers();
	env.click('[data-bisc-dismiss]');
	assert.equal(env.isOpen(), false);
	assert.equal(env.window.bisConsent.stored(), null);
	env.window.bisOpenCookieSettings();
	assert.equal(env.isOpen(), true);
	assert.equal(env.banner.focused, true, 'focus moves in when the visitor opened it');
	env.key('Escape');
	assert.equal(env.isOpen(), false);
});

test('the first-visit prompt does not take focus', () => {
	const env = boot();
	env.runTimers();
	assert.equal(env.banner.focused, undefined);
});

test('a page without the banner markup still gates and does not throw', () => {
	const page = EVERYTHING();
	const env = boot({ withBanner: false, ...page });
	env.runTimers();
	assert.deepEqual(env.srcs(), []);
});

test('an unreadable consent value is treated as no choice', () => {
	const env = boot({ cookie: 'bis_cookie_consent=yes', ...EVERYTHING() });
	assert.equal(env.window.bisConsent.stored(), null);
	assert.deepEqual(env.srcs(), []);
});
