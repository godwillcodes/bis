<?php
/**
 * Cookie consent banner: markup only. Styles are css/consent.css, behavior is js/consent.js.
 * Included from header.php straight after the skip link, so keyboard and screen reader users
 * reach it before the navigation. It stays hidden until the script opens it, so a visitor
 * without JavaScript is never shown a choice that does nothing (and nothing third-party loads
 * for them either).
 *
 * Two presentations share this markup, switched by data-bisc-mode:
 *   choice  first visit, or reopened from "Cookie settings" in the footer
 *   gpc     one-time notice that the browser's Global Privacy Control signal was honored
 *
 * Copy says only what the code does. If a vendor is added to or removed from js/consent.js,
 * this copy has to change with it.
 *
 * @package BIS
 */

$bis_privacy_url = bis_privacy_policy_url();
?>
<div
	id="bisc-banner"
	class="bisc"
	role="dialog"
	aria-modal="false"
	aria-labelledby="bisc-title-choice"
	aria-describedby="bisc-body-choice"
	tabindex="-1"
	data-bisc-banner
>
	<button type="button" class="bisc-dismiss" data-bisc-dismiss aria-label="<?php esc_attr_e( 'Close cookie notice', 'bis' ); ?>">
		<svg viewBox="0 0 16 16" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" aria-hidden="true" focusable="false">
			<path d="M3.5 3.5l9 9M12.5 3.5l-9 9"/>
		</svg>
	</button>

	<div data-bisc-mode="choice">
		<h2 id="bisc-title-choice" class="bisc-title"><?php esc_html_e( 'Cookies on this site', 'bis' ); ?></h2>
		<div id="bisc-body-choice">
			<p class="bisc-copy">
				<?php esc_html_e( 'We use essential cookies to run this site. If you accept, we also use Google Analytics and Claydar to understand who visits, and HubSpot and Google Maps for our contact form and map. If you decline, those stay off.', 'bis' ); ?>
				<?php esc_html_e( 'Learn more in our', 'bis' ); ?>
				<a class="bisc-text-link" href="<?php echo esc_url( $bis_privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'bis' ); ?></a>.
			</p>
			<p class="bisc-status" data-bisc-status hidden></p>
		</div>
		<div class="bisc-actions">
			<button type="button" class="bisc-btn bisc-btn-decline" data-bisc-decline><?php esc_html_e( 'Decline', 'bis' ); ?></button>
			<button type="button" class="bisc-btn bisc-btn-accept" data-bisc-accept><?php esc_html_e( 'Accept', 'bis' ); ?></button>
		</div>
	</div>

	<div data-bisc-mode="gpc" hidden>
		<h2 id="bisc-title-gpc" class="bisc-title"><?php esc_html_e( 'Privacy signal honored', 'bis' ); ?></h2>
		<p id="bisc-body-gpc" class="bisc-copy">
			<?php esc_html_e( 'Your browser sent a Global Privacy Control signal, so we recorded a Decline. You can change this at any time with Cookie settings in the page footer.', 'bis' ); ?>
		</p>
		<div class="bisc-actions">
			<button type="button" class="bisc-btn bisc-btn-decline" data-bisc-dismiss><?php esc_html_e( 'OK', 'bis' ); ?></button>
		</div>
	</div>
</div>
