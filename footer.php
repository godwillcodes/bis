<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BIS
 */

?>

	</main><!-- #primary -->

	<footer id="colophon" class="site-footer bg-gray-900 text-white rounded-t-[20px] lg:rounded-t-[20px] relative overflow-hidden" aria-labelledby="footer-heading">
		<h2 id="footer-heading" class="sr-only"><?php esc_html_e( 'Site footer', 'bis' ); ?></h2>
		<!-- Pattern Background -->
		<div class="absolute inset-0 opacity-5 z-0" aria-hidden="true"
			style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/patterns-01-scaled.webp'); background-repeat: repeat; background-size: cover; background-position: center;">
		</div>
		
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 lg:pt-20 pb-6 relative z-10">
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16 mb-16">
				<!-- Logo and Contact Info -->
				<div class="lg:col-span-1">
					<div class="mb-8">
						<?php
						if ( has_custom_logo() ) {
							add_filter('get_custom_logo', function ($html) {
								$html = str_replace(
									'class="custom-logo"',
									'class="custom-logo h-auto w-auto max-w-[280px] object-contain"',
									$html
								);
								if (preg_match('/<img\b[^>]*\salt="(?P<alt>[^"]*)"/i', $html, $m)) {
									if ($m['alt'] === '') {
										$alt_attr = ' alt="' . esc_attr(get_bloginfo('name')) . '"';
										$html = preg_replace('/<img\b([^>]*)\salt="[^"]*"/i', '<img$1' . $alt_attr, $html, 1);
									}
								} else {
									$alt_attr = ' alt="' . esc_attr(get_bloginfo('name')) . '"';
									$html = preg_replace('/<img\b/i', '<img' . $alt_attr, $html, 1);
								}
								return $html;
							});
							the_custom_logo();
						} else {
							echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="text-white text-2xl font-display font-bold" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
						}
						?>
					</div>
					<address class="space-y-4 mb-10 not-italic">
						<p class="text-gray-300 text-base leading-relaxed flex items-start gap-3">
							<svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
							</svg>
							<span class="flex-1">2 Bethesda Metro Center, Bethesda, MD 20814, United States</span>
						</p>
						<p class="text-gray-300 text-base leading-relaxed flex items-center gap-3">
							<svg class="w-5 h-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
							</svg>
							<a href="mailto:info@bisworld.com" class="hover:text-red-500 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">info@bisworld.com</a>
						</p>
					</address>
					
					<!-- Social Media Icons -->
					<nav class="flex items-center gap-4" aria-label="<?php esc_attr_e( 'Social media', 'bis' ); ?>">
						<a href="https://www.facebook.com/BirnbaumInterpreting" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded" aria-label="<?php esc_attr_e( 'Visit us on Facebook (opens in new tab)', 'bis' ); ?>">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
								<path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
							</svg>
						</a>
						<a href="https://x.com/BIS__World" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded" aria-label="<?php esc_attr_e( 'Follow us on X, formerly Twitter (opens in new tab)', 'bis' ); ?>">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
								<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
							</svg>
						</a>
						<a href="https://www.linkedin.com/company/2666458/" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded" aria-label="<?php esc_attr_e( 'Connect with us on LinkedIn (opens in new tab)', 'bis' ); ?>">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
								<path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"></path>
							</svg>
						</a>
						<a href="https://www.youtube.com/@BirnbaumInterpretingServices" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded" aria-label="<?php esc_attr_e( 'Watch us on YouTube (opens in new tab)', 'bis' ); ?>">
							<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
								<path d="M24.325 8.309s-2.655-.334-8.357-.334c-5.517 0-8.294.334-8.294.334A2.675 2.675 0 0 0 5 10.984v10.034a2.675 2.675 0 0 0 2.674 2.676s2.582.332 8.294.332c5.709 0 8.357-.332 8.357-.332A2.673 2.673 0 0 0 27 21.018V10.982a2.673 2.673 0 0 0-2.675-2.673zM13.061 19.975V12.03L20.195 16l-7.134 3.975z"></path>
							</svg>
						</a>
					</nav>
				</div>

				<!-- SERVICES Column -->
				<nav class="lg:col-span-1" aria-labelledby="footer-services-heading">
					<h2 id="footer-services-heading" class="text-white font-semibold text-lg mb-6 tracking-tight"><?php esc_html_e( 'Services', 'bis' ); ?></h2>
					<?php
					$services = get_posts(array(
						'post_type'      => 'service',
						'posts_per_page' => -1,
						'post_status'    => 'publish',
						'orderby'        => 'title',
						'order'          => 'ASC',
					));
					
					if ( ! empty( $services ) ) : ?>
						<ul class="space-y-3.5">
							<?php foreach ( $services as $service ) : ?>
								<li>
									<a href="<?php echo esc_url( get_permalink( $service->ID ) ); ?>" class="text-gray-300 hover:text-white transition-colors text-base leading-relaxed inline-block focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">
										<?php echo esc_html( $service->post_title ); ?>
									</a>
								</li>
							<?php endforeach; ?>
					</ul>
					<?php else : ?>
						<p class="text-gray-400 text-sm"><?php esc_html_e( 'No menu items at this time.', 'bis' ); ?></p>
					<?php endif; ?>
				</nav>

				<!-- INDUSTRIES Column -->
				<nav class="lg:col-span-1" aria-labelledby="footer-industries-heading">
					<h2 id="footer-industries-heading" class="text-white font-semibold text-lg mb-6 tracking-tight"><?php esc_html_e( 'Industries', 'bis' ); ?></h2>
					<?php
					$industries = get_posts(array(
						'post_type'      => 'industry',
						'posts_per_page' => -1,
						'post_status'    => 'publish',
						'orderby'        => 'title',
						'order'          => 'ASC',
					));
					
					if ( ! empty( $industries ) ) : ?>
						<ul class="space-y-3.5">
							<?php foreach ( $industries as $industry ) : ?>
								<li>
									<a href="<?php echo esc_url( get_permalink( $industry->ID ) ); ?>" class="text-gray-300 hover:text-white transition-colors text-base leading-relaxed inline-block focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">
										<?php echo esc_html( $industry->post_title ); ?>
									</a>
								</li>
							<?php endforeach; ?>
					</ul>
					<?php else : ?>
						<p class="text-gray-400 text-sm"><?php esc_html_e( 'No menu items at this time.', 'bis' ); ?></p>
					<?php endif; ?>
				</nav>

				<!-- QUICK LINKS Column -->
				<nav class="lg:col-span-1" aria-labelledby="footer-quicklinks-heading">
					<h2 id="footer-quicklinks-heading" class="text-white font-semibold text-lg mb-6 tracking-tight"><?php esc_html_e( 'Quick Links', 'bis' ); ?></h2>
					<?php
					$menu_items = wp_get_nav_menu_items( 3 );
					
					if ( ! empty( $menu_items ) ) : ?>
						<ul class="space-y-3.5">
							<?php foreach ( $menu_items as $item ) : ?>
								<li>
									<a href="<?php echo esc_url( $item->url ); ?>" class="text-gray-300 hover:text-white transition-colors text-base leading-relaxed inline-block focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">
										<?php echo esc_html( $item->title ); ?>
									</a>
								</li>
							<?php endforeach; ?>
					</ul>
					<?php else : ?>
						<p class="text-gray-400 text-sm"><?php esc_html_e( 'No menu items at this time.', 'bis' ); ?></p>
					<?php endif; ?>
				</nav>
			</div>

			<!-- Copyright -->
			<div class="border-t border-gray-800 pt-4 mt-4">
				<p class="text-gray-400 text-sm text-center">
					<?php
					printf(
						/* translators: 1: current year (numeric), 2: site name. */
						esc_html__( '© %1$s | %2$s | All Rights Reserved.', 'bis' ),
						esc_html( wp_date( 'Y' ) ),
						esc_html__( 'Birnbaum Interpreting Service', 'bis' )
					);
					?>
					<button type="button" class="bisc-link bisc-link-footer" data-bis-cookie-settings><?php esc_html_e( 'Cookie settings', 'bis' ); ?></button>
				</p>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<?php get_template_part('components/layout/ai-widget'); ?>
<script src="https://unpkg.com/aos@next/dist/aos.js" defer></script>
<script>
(function () {
	function revealAll() {
		document.querySelectorAll('[data-aos]').forEach(function (el) {
			el.style.opacity = '1';
			el.style.transform = 'none';
			el.style.transition = 'none';
		});
	}
	function init() {
		var prm = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		if (typeof window.AOS === 'undefined' || prm) {
			revealAll();
			return;
		}
		try {
			window.AOS.init({
				duration: 800,
				easing: 'ease-out-cubic',
				once: true,
				offset: 50,
				disable: function () { return window.matchMedia('(prefers-reduced-motion: reduce)').matches; }
			});
			document.documentElement.classList.add('aos-loaded');
		} catch (e) {
			revealAll();
		}
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () { setTimeout(init, 0); });
	} else {
		setTimeout(init, 0);
	}
	// Hard fallback: if AOS still hasn't loaded after 3s, reveal content.
	setTimeout(function () {
		if (typeof window.AOS === 'undefined') revealAll();
	}, 3000);
})();
</script>
</body>
</html>
