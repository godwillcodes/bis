<?php
/**
 * Template Name: Department
 *
 * Hosts the Department of Energy intake form (Jotform-hosted).
 *
 * The original implementation pasted Jotform's full HTML document
 * (DOCTYPE, html, head, body, h1) inside the WordPress page body,
 * producing nested document landmarks, a duplicate H1, and an invalid
 * DOM. We embed the canonical hosted form via <iframe> instead so the
 * form vendor's own accessibility baseline is preserved and our page
 * structure stays valid.
 *
 * @package BIS
 */

get_header();
get_template_part( 'components/layout/banner' );
get_template_part( 'components/layout/breadcrumb' );

// Allow the form ID and intro copy to be overridden via ACF; fall back to known values.
$form_id          = get_field( 'jotform_id' ) ?: '231864400249151';
$form_height_attr = (int) ( get_field( 'jotform_height' ) ?: 1900 );
$intro_title      = get_field( 'form_intro_title' );
$intro_copy       = get_field( 'form_intro_copy' );
$form_url         = sprintf( 'https://form.jotform.com/%s', rawurlencode( $form_id ) );
$page_title       = get_the_title();

if ( have_posts() ) :
	while ( have_posts() ) : the_post(); endwhile;
endif;
?>

<section class="py-16 bg-white" aria-labelledby="department-form-heading">
	<div class="max-w-7xl mx-auto px-4 lg:px-0">
		<div class="max-w-3xl mx-auto text-center mb-10">
			<h2 id="department-form-heading" class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
				<?php echo esc_html( $intro_title ?: $page_title ); ?>
			</h2>
			<?php if ( $intro_copy ) : ?>
				<div class="prose prose-gray mx-auto text-gray-700">
					<?php echo wp_kses_post( $intro_copy ); ?>
				</div>
			<?php else : ?>
				<p class="text-gray-700">
					<?php esc_html_e( 'Please complete the form below to request services. If the form does not load, you can open it in a new tab.', 'bis' ); ?>
				</p>
			<?php endif; ?>
			<p class="mt-4 text-sm text-gray-700">
				<a href="<?php echo esc_url( $form_url ); ?>"
					target="_blank"
					rel="noopener noreferrer"
					class="text-red-700 underline hover:text-red-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600 rounded-sm">
					<?php esc_html_e( 'Open the form in a new tab (opens in new tab)', 'bis' ); ?>
				</a>
			</p>
		</div>

		<div class="bg-gray-50 rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
			<iframe
				id="JotFormIFrame-<?php echo esc_attr( $form_id ); ?>"
				title="<?php echo esc_attr( sprintf( __( '%s intake form', 'bis' ), $page_title ) ); ?>"
				src="<?php echo esc_url( $form_url ); ?>"
				allow="geolocation; microphone; camera; fullscreen"
				allowfullscreen
				allowtransparency="true"
				loading="lazy"
				referrerpolicy="strict-origin-when-cross-origin"
				class="block w-full border-0"
				style="min-height: <?php echo (int) $form_height_attr; ?>px;"
				scrolling="no">
			</iframe>
		</div>
	</div>
</section>

<script type="text/javascript">
(function () {
	if (typeof window === 'undefined') { return; }
	var script = document.createElement('script');
	script.src = 'https://cdn.jotfor.ms/s/umd/latest/for-form-embed-handler.js';
	script.async = true;
	script.onload = function () {
		if (window.jotformEmbedHandler) {
			window.jotformEmbedHandler(
				"iframe[id='JotFormIFrame-<?php echo esc_js( $form_id ); ?>']",
				'https://form.jotform.com/'
			);
		}
	};
	document.head.appendChild(script);
})();
</script>

<?php
get_template_part( 'components/sections/cta' );
get_template_part( 'components/sections/logo-carousel' );
get_footer();
