<?php
/**
 * Template Name: FAQ
 *
 * The template for displaying the FAQ page.
 *
 * @package BIS
 */

get_header();
get_template_part('components/layout/banner');
get_template_part('components/layout/breadcrumb');
?>

<!-- FAQ Section -->
<section class="py-20 bg-white" aria-labelledby="faq-list-heading">
	<h2 id="faq-list-heading" class="sr-only"><?php esc_html_e( 'Frequently asked questions', 'bis' ); ?></h2>
	<div class="max-w-7xl mx-auto px-4">
		<div class="max-w-7xl mx-auto">
			<?php
			$faqs = get_field( 'accordion' );

			if ( ! $faqs || empty( $faqs ) ) {
				echo '<p class="text-gray-700 text-center py-12">' . esc_html__( 'No FAQs available at this time.', 'bis' ) . '</p>';
			} else {
				$accordion_id = 'faq-accordion';
			?>
				<div class="space-y-2" id="<?php echo esc_attr( $accordion_id ); ?>">
					<?php foreach ( $faqs as $index => $faq ) :
						$faq_title       = ! empty( $faq['title'] ) ? $faq['title'] : '';
						$faq_description = ! empty( $faq['description'] ) ? $faq['description'] : '';

						if ( empty( $faq_title ) ) {
							continue;
						}

						$is_first        = ( 0 === $index );
						$button_id       = 'faq-button-' . (int) $index;
						$panel_id        = 'faq-panel-' . (int) $index;
						$is_expanded     = $is_first ? 'true' : 'false';
						$expanded_class  = $is_first ? 'is-expanded' : '';
						$content_classes = $is_first
							? 'accordion-content accordion-content-wrapper overflow-hidden opacity-100 transition-all duration-500 ease-out'
							: 'accordion-content accordion-content-wrapper max-h-0 overflow-hidden opacity-0 transition-all duration-500 ease-out';
						$icon_transform  = $is_first ? 'rotate(180deg)' : 'rotate(0deg)';
					?>
					<div class="accordion-item group bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-300 overflow-hidden transition-all duration-500 ease-out hover:border-gray-400 hover:shadow-lg hover:shadow-black/5 hover:bg-white/90 <?php echo esc_attr( $expanded_class ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
						<button
							type="button"
							id="<?php echo esc_attr( $button_id ); ?>"
							class="accordion-toggle w-full px-8 py-6 text-left flex items-center justify-between focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600 focus-visible:ring-offset-2 transition-colors duration-200 hover:bg-gray-50/50"
							aria-expanded="<?php echo esc_attr( $is_expanded ); ?>"
							aria-controls="<?php echo esc_attr( $panel_id ); ?>">
							<span class="text-[20px] font-semibold text-gray-900 tracking-tight leading-snug pr-8"><?php echo esc_html( $faq_title ); ?></span>
							<span class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100/80 flex items-center justify-center transition-all duration-300 group-hover:bg-gray-200/80 <?php echo $is_first ? 'bg-red-50' : ''; ?>" aria-hidden="true">
								<svg class="w-4 h-4 text-gray-700 transform transition-transform duration-500 ease-out <?php echo $is_first ? 'text-red-600' : ''; ?>" style="transform: <?php echo esc_attr( $icon_transform ); ?>;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" focusable="false">
									<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
								</svg>
							</span>
						</button>
						<div
							id="<?php echo esc_attr( $panel_id ); ?>"
							class="<?php echo esc_attr( $content_classes ); ?>"
							role="region"
							aria-labelledby="<?php echo esc_attr( $button_id ); ?>"
							<?php echo $is_first ? 'data-initial-open="true"' : ''; ?>>
							<div class="px-8 pb-6 pt-0">
								<div class="text-base md:text-lg text-gray-700 leading-relaxed blog-text tracking-normal">
									<?php echo wp_kses_post( $faq_description ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			<?php } ?>
		</div>
	</div>
</section>




<?php
get_template_part('components/sections/cta'); 
get_template_part('components/sections/logo-carousel');
get_footer();
?>

