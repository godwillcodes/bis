<?php
/**
 * Accordion Component
 * Displays an accordion section using ACF Repeater field
 *
 * @package BIS
 */

// Get ACF Repeater field
$faqs = get_field( 'faqs' );

if ( ! $faqs || empty( $faqs ) ) {
	return;
}

// Get optional title and description from query var (for backward compatibility)
$passed_args = get_query_var( 'accordion_args', array() );
$section_title = ! empty( $passed_args['title'] ) ? $passed_args['title'] : 'Frequently Asked Questions';
$section_description = ! empty( $passed_args['description'] ) ? $passed_args['description'] : '';
$accordion_id = ! empty( $passed_args['id'] ) ? $passed_args['id'] : 'accordion';
?>

<div class="accordion-wrapper">
	<div class="space-y-3" id="<?php echo esc_attr( $accordion_id ); ?>">
		<?php foreach ( $faqs as $index => $faq ) : 
			$question = ! empty( $faq['question'] ) ? $faq['question'] : '';
			$answer = ! empty( $faq['answer'] ) ? $faq['answer'] : '';
			
			if ( empty( $question ) ) {
				continue;
			}
			
			// First item should be open by default
			$is_first = ( $index === 0 );
			$is_expanded = $is_first ? 'true' : 'false';
			$expanded_class = $is_first ? 'is-expanded' : '';
			$content_classes = $is_first ? 'accordion-content accordion-content-wrapper overflow-hidden opacity-100 transition-all duration-500 ease-out' : 'accordion-content accordion-content-wrapper max-h-0 overflow-hidden opacity-0 transition-all duration-500 ease-out';
			$icon_transform = $is_first ? 'rotate(180deg)' : 'rotate(0deg)';
		?>
		<div class="accordion-item group bg-white/70 backdrop-blur-sm rounded-2xl border border-white/60 shadow-[0_1px_3px_rgba(0,0,0,0.04)] overflow-hidden transition-all duration-500 ease-out hover:bg-white/90 hover:border-[#ed3437]/20 hover:shadow-[0_8px_30px_rgba(237,52,55,0.08)] <?php echo esc_attr( $expanded_class ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
			<button class="accordion-toggle w-full px-8 py-6 text-left flex items-center justify-between focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed3437]/40 focus-visible:ring-offset-2 transition-colors duration-300" aria-expanded="<?php echo esc_attr( $is_expanded ); ?>">
				<span class="text-lg font-semibold text-gray-800 tracking-tight leading-snug pr-8 transition-colors duration-500 group-hover:text-gray-950"><?php echo esc_html( $question ); ?></span>
				<div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-[#ed3437]/10 to-[#ed3437]/5 flex items-center justify-center transition-all duration-500 group-hover:from-[#ed3437]/15 group-hover:to-[#ed3437]/10 group-hover:shadow-[0_4px_12px_rgba(237,52,55,0.12)]">
					<svg class="w-4 h-4 text-[#ed3437]/70 transform transition-transform duration-500 ease-out" style="transform: <?php echo esc_attr( $icon_transform ); ?>;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
					</svg>
				</div>
			</button>
			<div class="<?php echo esc_attr( $content_classes ); ?>" <?php echo $is_first ? 'data-initial-open="true"' : ''; ?>>
				<div class="px-8 pb-8 pt-0">
					<div class="text-base text-gray-500 leading-relaxed blog-text">
						<?php echo wp_kses_post( $answer ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>


