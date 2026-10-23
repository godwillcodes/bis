/**
 * Cookie consent for bisworld.com.
 *
 * Printed in <head> (functions.php) so window.bisConsent exists before anything asks for it.
 * The banner markup is components/layout/cookie-consent.php; docs/consent.md explains the model.
 *
 * Rules this file keeps:
 *  - Consent is read in the browser only. The HTML is cached and shared between visitors, so PHP
 *    never branches on the consent cookie.
 *  - Every third-party load lives here and checks consent inside its own loader, so no caller can
 *    fetch a vendor script for a visitor who has not accepted.
 *  - Global Privacy Control counts as Decline unless the visitor explicitly accepted while the
 *    signal was on.
 *  - Failing closed: with no usable consent, nothing third-party loads.
 *
 * @package BIS
 */

(function () {
	'use strict';

	const COOKIE = 'bis_cookie_consent';
	const GPC_ACK = 'bis_consent_gpc_ack';
	const COOKIE_DAYS = 365;
	const SHOW_DELAY = 800;
	const RELOAD_DELAY = 350;

	// Set in functions.php from Site Kit's settings; empty when Site Kit has no tag.
	const config = window.bisConsentConfig || {};

	const GA_ID_RE = /^(G|GT)-[A-Z0-9]{4,20}$/;
	const GOOGLE_CONSENT_TYPES = [
		'analytics_storage',
		'ad_storage',
		'ad_user_data',
		'ad_personalization',
		'functionality_storage',
		'personalization_storage',
	];
	const CLAYDAR_SRC = 'https://static.claydar.com/init.v1.js?id=coUSWCoUir';
	const HUBSPOT_FORMS_SRC = 'https://js.hsforms.net/forms/embed/v2.js';
	const PORTAL_RE = /^[0-9]{1,12}$/;
	const FORM_RE = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;
	const REGION_RE = /^[a-z]{2,3}[0-9]$/;
	const CSS_CLASS_RE = /^[A-Za-z0-9_-]{1,40}$/;
	const EMBED_SRC_RE = /^https:\/\/www\.google\.com\/maps\/embed\?/;
	const VENDOR_COOKIE_RE = /^(_ga|_gid|_gat|_gcl_|__hs|hubspotutk)/;

	const SEL = {
		banner: '[data-bisc-banner]',
		mode: '[data-bisc-mode]',
		status: '[data-bisc-status]',
		accept: '[data-bisc-accept]',
		decline: '[data-bisc-decline]',
		dismiss: '[data-bisc-dismiss]',
		opener: '[data-bis-cookie-settings]',
		form: '[data-bis-hubspot-form]',
		formTarget: '[data-bisc-form-target]',
		embed: '[data-bis-embed]',
		embedFrame: '[data-bisc-embed-frame]',
	};

	const $ = (s, ctx) => (ctx || document).querySelector(s);
	const $$ = (s, ctx) => Array.prototype.slice.call((ctx || document).querySelectorAll(s));

	/* Cookies */

	function readCookie(name) {
		const m = document.cookie.match(new RegExp('(?:^|;\\s*)' + name + '=([^;]*)'));
		return m ? m[1] : null;
	}

	function writeCookie(name, value) {
		const d = new Date();
		d.setTime(d.getTime() + COOKIE_DAYS * 24 * 60 * 60 * 1000);
		const secure = location.protocol === 'https:' ? ';Secure' : '';
		document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax' + secure;
	}

	function expireCookie(name, domain) {
		document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/' + (domain ? ';domain=' + domain : '');
	}

	/* Consent state: the read-only view the rest of the theme uses */

	const consent = {
		stored() {
			const v = readCookie(COOKIE);
			return v === 'accepted' || v === 'declined' ? v : null;
		},
		gpc() {
			return navigator.globalPrivacyControl === true;
		},
		gpcApplies() {
			return consent.gpc() && readCookie(GPC_ACK) !== '1';
		},
		effective() {
			return consent.gpcApplies() ? 'declined' : consent.stored();
		},
		isAccepted() {
			return consent.effective() === 'accepted';
		},
	};
	window.bisConsent = consent;

	/**
	 * Clear the vendor cookies that live on our own domain. Cookies on vendor domains cannot be
	 * cleared from here, so Decline prevents future loads and does not erase the past.
	 */
	function clearVendorCookies() {
		const root = location.hostname.replace(/^www\./, '');
		document.cookie.split(';').forEach((c) => {
			const name = c.split('=')[0].trim();
			if (!VENDOR_COOKIE_RE.test(name)) {
				return;
			}
			expireCookie(name);
			expireCookie(name, root);
			expireCookie(name, '.' + root);
		});
	}

	/* Google Analytics (Site Kit's own tag is blocked in functions.php; this is the only path) */

	function gtag() {
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push(arguments);
	}

	function updateGoogleConsent(granted) {
		const state = {};
		GOOGLE_CONSENT_TYPES.forEach((t) => {
			state[t] = granted ? 'granted' : 'denied';
		});
		gtag('consent', 'update', state);
	}

	function pushEvent(name) {
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push({ event: name });
	}

	const ga = { started: false };

	function loadGa() {
		// The gate lives here, in the function that fetches the vendor script.
		if (!consent.isAccepted() || ga.started || !GA_ID_RE.test(config.gaId || '')) {
			return;
		}
		ga.started = true;
		const s = document.createElement('script');
		s.async = true;
		s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(config.gaId);
		document.head.appendChild(s);
		gtag('js', new Date());
		gtag('config', config.gaId, { cookie_flags: 'SameSite=Lax;Secure' });
	}

	/* Claydar. It defaults to waiting for consent, so it is told once the visitor has given it. */

	const claydar = { started: false };

	function loadClaydar() {
		if (!consent.isAccepted() || claydar.started) {
			return;
		}
		claydar.started = true;
		const s = document.createElement('script');
		s.async = true;
		s.src = CLAYDAR_SRC;
		s.onload = () => {
			let tries = 0;
			const wait = setInterval(() => {
				tries += 1;
				if (window.Claydar && typeof window.Claydar.giveCookieConsent === 'function') {
					clearInterval(wait);
					window.Claydar.giveCookieConsent();
				} else if (tries >= 50) {
					clearInterval(wait);
				}
			}, 200);
		};
		s.onerror = () => {
			claydar.started = false;
		};
		document.head.appendChild(s);
	}

	/* HubSpot forms */

	const hs = { loaded: false, loading: false, queue: [] };

	function flushHubspot(ok, reason) {
		const q = hs.queue;
		hs.queue = [];
		q.forEach((cb) => cb(ok, reason));
	}

	/** cb(ok, reason): reason is 'consent' or 'error' when ok is false. */
	function loadHubspotScript(cb) {
		if (!consent.isAccepted()) {
			cb(false, 'consent');
			return;
		}
		if (hs.loaded) {
			cb(true);
			return;
		}
		hs.queue.push(cb);
		if (hs.loading) {
			return;
		}
		hs.loading = true;
		const s = document.createElement('script');
		s.src = HUBSPOT_FORMS_SRC;
		s.async = true;
		s.onload = () => {
			hs.loaded = true;
			hs.loading = false;
			flushHubspot(true);
		};
		s.onerror = () => {
			hs.loading = false;
			if (s.parentNode) {
				s.parentNode.removeChild(s);
			}
			flushHubspot(false, 'error');
		};
		document.head.appendChild(s);
	}

	function setState(el, state) {
		if (state) {
			el.setAttribute('data-state', state);
		} else {
			el.removeAttribute('data-state');
		}
	}

	/**
	 * Render one HubSpot form placeholder. The placeholder carries data-portal-id, data-form-id,
	 * data-region and an optional data-css-class, plus a data-bisc-form-target child that HubSpot
	 * renders into. Without consent it keeps showing its fallback (email).
	 *
	 * @param {Element} el Placeholder element.
	 * @param {Function} [done] Called with (ok, reason).
	 */
	function mountForm(el, done) {
		const report = (ok, reason) => {
			if (typeof done === 'function') {
				done(ok, reason);
			}
		};
		const portal = el.getAttribute('data-portal-id') || '';
		const form = el.getAttribute('data-form-id') || '';
		const region = el.getAttribute('data-region') || 'na1';
		const cssClass = el.getAttribute('data-css-class') || '';
		const target = $(SEL.formTarget, el);

		if (!PORTAL_RE.test(portal) || !FORM_RE.test(form) || !REGION_RE.test(region) || (cssClass && !CSS_CLASS_RE.test(cssClass)) || !target) {
			setState(el, 'error');
			report(false, 'error');
			return;
		}
		if (el.getAttribute('data-state') === 'ready') {
			report(true);
			return;
		}

		let settled = false;
		loadHubspotScript((ok, reason) => {
			settled = true;
			if (ok && (!window.hbspt || !window.hbspt.forms)) {
				ok = false;
				reason = 'error';
			}
			if (!ok) {
				setState(el, reason === 'error' ? 'error' : null);
				report(false, reason);
				return;
			}
			if (!target.id) {
				target.id = 'bisc-form-' + Math.random().toString(36).slice(2, 8);
			}
			const options = { portalId: portal, formId: form, region, target: '#' + target.id };
			if (cssClass) {
				options.cssClass = cssClass;
			}
			window.hbspt.forms.create(options);
			setState(el, 'ready');
			report(true);
		});
		// Still waiting on the script: show the loading message.
		if (!settled) {
			setState(el, 'loading');
		}
	}

	/* Google Maps embed */

	/**
	 * Point a gated iframe at its real source once the visitor has accepted. The iframe ships
	 * with data-src and no src, so nothing is requested from Google at page load. A container
	 * with display: none does not stop a browser fetching an iframe, so hiding is not gating.
	 *
	 * @param {Element} el Placeholder element containing the iframe.
	 */
	function mountEmbed(el) {
		const frame = $(SEL.embedFrame, el);
		const src = frame ? frame.getAttribute('data-src') : null;
		if (!frame || !src || !EMBED_SRC_RE.test(src)) {
			setState(el, 'error');
			return;
		}
		if (!consent.isAccepted()) {
			setState(el, null);
			return;
		}
		frame.setAttribute('src', src);
		setState(el, 'ready');
	}

	window.bisMountHubspotForm = mountForm;
	window.bisMountEmbed = mountEmbed;

	/** Every loader checks consent itself, so this is safe to call at any time. */
	function loadVendors() {
		loadGa();
		loadClaydar();
		$$(SEL.form).forEach((el) => mountForm(el));
		$$(SEL.embed).forEach((el) => mountEmbed(el));
	}

	function vendorsActive() {
		return ga.started || claydar.started || hs.loading || hs.loaded;
	}

	/* Banner */

	let banner = null;
	let lastOpener = null;

	function setMode(mode) {
		$$(SEL.mode, banner).forEach((el) => {
			el.hidden = el.getAttribute('data-bisc-mode') !== mode;
		});
		// The dialog is named and described by whichever presentation is showing.
		banner.setAttribute('aria-labelledby', 'bisc-title-' + mode);
		banner.setAttribute('aria-describedby', 'bisc-body-' + mode);
	}

	function setStatus() {
		const el = $(SEL.status, banner);
		if (!el) {
			return;
		}
		const label = { accepted: 'Accepted', declined: 'Declined' }[consent.effective()];
		el.textContent = label ? 'Current choice: ' + label : '';
		el.hidden = !label;
	}

	function openBanner(mode, fromUser) {
		if (!banner) {
			return;
		}
		setMode(mode);
		setStatus();
		banner.setAttribute('data-open', 'true');
		// Never steal focus on the first-visit prompt; only when the visitor asked for it.
		if (fromUser) {
			banner.focus();
		}
	}

	function closeBanner() {
		if (!banner) {
			return;
		}
		banner.removeAttribute('data-open');
		if (lastOpener && typeof lastOpener.focus === 'function') {
			lastOpener.focus();
		}
		lastOpener = null;
	}

	function emit(name) {
		document.dispatchEvent(new CustomEvent(name, { detail: { timestamp: Date.now() } }));
	}

	function accept() {
		writeCookie(COOKIE, 'accepted');
		// An explicit Accept while the browser sends GPC is recorded so it is honored next time.
		if (consent.gpc()) {
			writeCookie(GPC_ACK, '1');
		} else {
			expireCookie(GPC_ACK);
		}
		updateGoogleConsent(true);
		pushEvent('bis_cookie_consent_accepted');
		loadVendors();
		closeBanner();
		emit('cookieConsentAccepted');
	}

	function decline() {
		const hadVendors = vendorsActive();
		writeCookie(COOKIE, 'declined');
		expireCookie(GPC_ACK);
		updateGoogleConsent(false);
		pushEvent('bis_cookie_consent_declined');
		clearVendorCookies();
		$$(SEL.form).forEach((el) => setState(el, null));
		$$(SEL.embed).forEach((el) => setState(el, null));
		closeBanner();
		emit('cookieConsentDeclined');
		// Scripts that already ran cannot be unloaded, so a withdrawal reloads the page.
		if (hadVendors) {
			setTimeout(() => location.reload(), RELOAD_DELAY);
		}
	}

	/** Reopened from the footer so a visitor can change or withdraw an earlier choice. */
	window.bisOpenCookieSettings = (opener) => {
		lastOpener = opener || null;
		openBanner('choice', true);
	};

	function bind() {
		document.addEventListener('click', (e) => {
			const t = e.target && e.target.closest ? e.target : null;
			if (!t) {
				return;
			}
			const opener = t.closest(SEL.opener);
			if (opener) {
				e.preventDefault();
				window.bisOpenCookieSettings(opener);
			} else if (t.closest(SEL.accept)) {
				accept();
			} else if (t.closest(SEL.decline)) {
				decline();
			} else if (t.closest(SEL.dismiss)) {
				closeBanner();
			}
		});

		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && banner && banner.getAttribute('data-open') === 'true') {
				closeBanner();
			}
		});
	}

	function init() {
		banner = $(SEL.banner);
		bind();

		const eff = consent.effective();
		if (eff === 'accepted') {
			updateGoogleConsent(true);
		} else if (eff === 'declined') {
			updateGoogleConsent(false);
			clearVendorCookies();
		}
		loadVendors();

		// Global Privacy Control: persist it like a click on Decline (this also overrides a stale
		// Accept from before the signal was turned on) and tell the visitor once.
		if (consent.gpcApplies() && consent.stored() !== 'declined') {
			writeCookie(COOKIE, 'declined');
			clearVendorCookies();
			pushEvent('bis_cookie_consent_gpc');
			setTimeout(() => openBanner('gpc', false), SHOW_DELAY);
			return;
		}

		if (eff === null) {
			setTimeout(() => openBanner('choice', false), SHOW_DELAY);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
