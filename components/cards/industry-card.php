<?php
/**
 * Industry Card Component
 * Displays an industry card with refined, minimal design
 *
 * @package BIS
 */

$description = get_query_var( 'description', '' );
if ( empty( $description ) ) {
	$description = get_field( 'introtext' );
}
$permalink = get_permalink();
$iconography = get_field( 'iconography' );
if ( empty( $iconography ) ) {
	$iconography = 'https://bisworld.com/wp-content/uploads/2026/01/question-mark-outline-svgrepo-com.svg';
}
?>

<article class="industry-card group relative h-full rounded-2xl bg-white/70 backdrop-blur-sm border border-gray-500 shadow-[0_1px_3px_rgba(0,0,0,0.04)] transition-all duration-500 hover:bg-white/90 hover:border-[#ed1c24]/30 hover:shadow-[0_8px_30px_rgba(237,28,36,0.08)] overflow-hidden"
	aria-labelledby="industry-title-<?php echo get_the_ID(); ?>">
	
	<!-- Animated corner accents -->
	<div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-tl-2xl"></div>
	<div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-br-2xl"></div>
	
	<!-- Bottom accent line -->
	<div class="absolute bottom-0 left-8 right-8 h-0.5 bg-gradient-to-r from-[#ed1c24] to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
	
	<a href="<?php echo esc_url( $permalink ); ?>" class="h-full flex flex-col p-8 lg:p-10 rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed1c24]/40 focus-visible:ring-offset-2"
		aria-label="Learn more about <?php echo esc_attr(get_the_title()); ?>">
		<!-- Icon -->
		<div class="mb-10" aria-hidden="true">
			<div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#ed3437]/10 to-[#ed3437]/5 flex items-center justify-center transition-all duration-500 group-hover:from-[#ed3437]/15 group-hover:to-[#ed3437]/10 group-hover:shadow-[0_4px_12px_rgba(237,52,55,0.12)]">
				<img src="<?php echo esc_url( $iconography ); ?>" 
					 class="w-8 h-8 object-contain transition-transform duration-500 ease-out group-hover:scale-110" 
					 loading="lazy" 
					 alt="" />
			</div>
		</div>

		<!-- Content -->
		<div class="flex-1 flex flex-col">
			<h3 id="industry-title-<?php echo get_the_ID(); ?>" class="text-lg font-semibold leading-snug text-gray-800 mb-4 tracking-tight transition-colors duration-500 group-hover:text-gray-950">
				<?php the_title(); ?>
			</h3>

			<?php if ( ! empty( $description ) ) : 
				$truncated = strlen($description) > 200 ? substr($description, 0, 200) . '...' : $description;
			?>
			<p class="text-sm leading-relaxed text-gray-500 flex-1 mb-0">
				<?php echo wp_kses_post( $truncated ); ?>
			</p>
			<?php endif; ?>
		</div>

		<!-- Link Indicator -->
		<div class="mt-auto pt-6">
			<span class="inline-flex items-center text-xs font-semibold text-gray-700 tracking-wider uppercase transition-all duration-500 group-hover:text-gray-950" aria-hidden="true">
				<span>Explore</span>
				<svg class="w-4 h-4 ml-2 flex-none transition-all duration-500 ease-out group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
				</svg>
			</span>
		</div>
	</a>
</article>


