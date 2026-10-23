# Cookie consent (bisworld.com)

How the consent banner works, what it controls, and what to do when something third-party is added. The model matches piedmontglobal.com so the sites behave the same way.

## What it controls

Nothing below loads until the visitor clicks Accept. Before this change all of it loaded on first visit.

| Vendor | Where it came from | What gates it now |
| --- | --- | --- |
| Google Analytics | Site Kit printed its own tag in `<head>` | The Site Kit tag is blocked in `functions.php`. `js/consent.js` loads the same tag after Accept, using the ID from Site Kit's settings. |
| Claydar | Inline script in `footer.php` that loaded unless a hook said otherwise | Removed from `footer.php`. `js/consent.js` loads it after Accept and then tells it consent was given. |
| HubSpot forms | `<script>` tags in `pages/contact.php` and `components/sections/cta.php` (about 18 templates use the CTA) | Placeholders (`data-bis-hubspot-form`) that `js/consent.js` renders after Accept. |
| Google Maps | `<iframe src>` in `pages/contact.php` | The iframe ships with `data-src` and no `src`. `js/consent.js` sets `src` after Accept. |

Without consent, the form and map areas say why and offer an email address, a button that reopens the cookie choice, and for the map a plain link to Google Maps.

Still loaded before any choice and not covered by the banner: Google Fonts (Montserrat), AOS from unpkg, Alpine from jsDelivr. None sets a cookie, but each sends the visitor's IP address to a third party. Self-hosting them removes the question.

## Files

| File | Job |
| --- | --- |
| `js/consent.js` | Consent state, every third-party loader, banner behavior. Printed in `<head>`. |
| `components/layout/cookie-consent.php` | Banner markup. Included from `header.php` right after the skip link. |
| `css/consent.css` | Banner, placeholder and footer link styles. Plain CSS, not part of `npm run build`. |
| `functions.php` | Enqueues the above, passes the Google tag ID, prints the Consent Mode default, blocks Site Kit's tag. |
| `footer.php` | "Cookie settings" control (`data-bis-cookie-settings`). |
| `tests/consent.test.mjs` | `npm test`. Runs the real `consent.js` in a fake browser. |

## Rules

1. **Consent is read in the browser only.** The HTML is cached and shared, so PHP must never branch on the consent cookie.
2. **Every third-party load lives in `js/consent.js` and checks consent inside its own loader.** Do not add a `<script>`, pixel or iframe `src` from a template. A container hidden with `display: none` still fetches an iframe, so hiding is not gating.
3. **Read consent through `window.bisConsent`**, never by parsing the cookie. `effective()` applies the Global Privacy Control rule: a browser sending `navigator.globalPrivacyControl === true` counts as Decline unless the visitor clicked Accept while the signal was on (`bis_consent_gpc_ack`).
4. **Keep the footer "Cookie settings" control.** Visitors must be able to change or withdraw consent as easily as they gave it.
5. **Banner copy states only what the code does.** It names Google Analytics, Claydar, HubSpot and Google Maps. Change the copy in the same commit as any change to that list.
6. **Do not unblock Site Kit's tag** (`googlesitekit_analytics-4_tag_blocked` in `functions.php`) to fix missing analytics data. Site Kit's snippet runs before consent.
7. **Fail closed.** Missing script, unreadable cookie or no JavaScript means nothing third-party loads.

Cookies: `bis_cookie_consent` (`accepted` or `declined`, 365 days) and `bis_consent_gpc_ack`. Declining clears Google Analytics, Google Ads and HubSpot cookies on our own domain (`_ga*`, `_gid`, `_gat`, `_gcl_*`, `__hs*`, `hubspotutk`). Cookies already set on vendor domains cannot be cleared from the browser, so Decline prevents future loads and does not erase the past. Withdrawing after an Accept reloads the page, because a script that has run cannot be unloaded.

The Google Consent Mode default (everything denied) is printed first in `<head>`. Accept sends `gtag('consent', 'update', ...)` and a `bis_cookie_consent_accepted` dataLayer event; Decline sends the denied update and `bis_cookie_consent_declined`.

## Adding a third-party load

1. Add a loader function to `js/consent.js` that checks `consent.isAccepted()` as its first line and appends the script only after that.
2. Call it from `loadVendors()`. Nothing else calls loaders.
3. Add its cookie pattern to `VENDOR_COOKIE_RE` so Decline clears it, and include it in `vendorsActive()` so a later withdrawal reloads the page.
4. Update the banner copy in `components/layout/cookie-consent.php`.
5. Add a test that the loader refuses without consent, then break the gate on purpose and confirm the test fails.

## Open items

- **Privacy policy.** The banner links to `/privacy-policy/`. Legal should confirm that page lists Google Analytics, Claydar, HubSpot and Google Maps, because the banner now names them.
- **Verify the Site Kit block on staging.** The filter name is the one piedmontglobal.com uses. Confirm no request to `googletagmanager.com` or `google-analytics.com` happens before Accept. If one does, Site Kit is printing the tag another way.
- **Claydar cookies.** Not verified. After Accept, check Application, Cookies for anything Claydar sets and add its pattern to `VENDOR_COOKIE_RE` if it is a first-party cookie.
- **HubSpot portal settings.** In HubSpot, Settings, Privacy & Consent, set cookie tracking for this domain to require opt-in, so a HubSpot-served banner does not appear next to ours.
- **AI widget.** It is fixed to the bottom-right at `z-index: 9999`, so the banner sits bottom-left on desktop.
- **Stilson Display font.** `css/input.css` asks for `assets/fonts/stilson.otf` but the file in the repo is `fonnts.com-Stilson-Display-.otf`, so the font 404s and every `h1` falls back to a generic serif.
- **Global focus ring.** `css/input.css` sets `*:focus-visible` to a white outline, which is invisible on the white and light sections. The banner and its placeholders define their own ring.

## Verifying a change

Automated: `npm test`.

By hand on a staging copy, in a fresh private window with the Network tab open:

1. Load the home page and `/contact/`. No request to `googletagmanager`, `google-analytics`, `claydar`, `hsforms`, `hubspot` or `google.com/maps` before a choice. No `_ga` cookie. The banner appears after about a second and does not take focus.
2. Accept. Analytics and Claydar load, the form and map render in place. Reload: they render and the banner stays closed.
3. Cookie settings, Decline. The page reloads, the form and map are gone, and `_ga*` cookies are cleared.
4. Turn on Global Privacy Control (for example Brave or the DuckDuckGo extension) with an Accept cookie already set. The cookie becomes `declined`, nothing loads, and the privacy-signal notice appears once.
5. Tab from the top: skip link, then the banner, then the navigation. Every control shows a visible focus ring.
6. Purge every cache in front of the site after deploy. The banner is in cached HTML.
