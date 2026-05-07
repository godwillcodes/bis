<?php
/**
 * Resource Card Component
 * Displays a resource card with premium design aesthetics
 *
 * @package BIS
 *
 * @param WP_Post $post The post object
 * @param string  $description Optional description override
 */

$description = get_query_var( 'description', '' );
if ( empty( $description ) ) {
	$description = get_field( 'description' );
}
if ( empty( $description ) ) {
	$description = get_the_excerpt();
}
$permalink = get_permalink();
$has_thumbnail = has_post_thumbnail();
?>

<article class="resource-card group relative flex flex-col h-full rounded-2xl bg-white/70 backdrop-blur-sm border border-gray-500 shadow-[0_1px_3px_rgba(0,0,0,0.04)] transition-all duration-500 hover:bg-white/90 hover:border-[#ed1c24]/30 hover:shadow-[0_8px_30px_rgba(237,28,36,0.08)] overflow-hidden"
	aria-labelledby="resource-title-<?php echo get_the_ID(); ?>">
	
	<!-- Animated corner accents -->
	<div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-tl-2xl z-10"></div>
	<div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-[#ed1c24] opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-br-2xl z-10"></div>
	
	<!-- Bottom accent line -->
	<div class="absolute bottom-0 left-6 right-6 h-0.5 bg-gradient-to-r from-[#ed1c24] to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left z-10"></div>
	
	<a href="<?php echo esc_url( $permalink ); ?>" class="flex flex-col h-full rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ed1c24]/40 focus-visible:ring-offset-2"
		aria-label="Read article: <?php echo esc_attr(get_the_title()); ?>">
		
		<!-- Featured Image -->
		<div class="relative aspect-[16/9] overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 m-3 rounded-xl">
			<?php if ( $has_thumbnail ) : ?>
				<?php
				the_post_thumbnail(
					'large',
					array(
						'class'   => 'h-full w-full object-cover rounded-xl transition-transform duration-700 ease-out group-hover:scale-105',
						'loading' => 'lazy',
					)
				);
				?>
			<?php else : ?>
				<div class="flex h-full w-full items-center justify-center rounded-xl bg-gradient-to-br from-[#ed3437]/5 to-[#ed3437]/10" aria-hidden="true">
					<svg class="h-10 w-10 text-[#ed3437]/30" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
					</svg>
				</div>
			<?php endif; ?>
		</div>

		<!-- Content -->
		<div class="flex flex-1 flex-col justify-between p-6 lg:p-8">
			<div class="flex-1">
				<!-- Date -->
				<time datetime="<?php echo get_the_date('c'); ?>" class="flex items-center gap-3 mb-4 text-[10px] font-medium tracking-[0.2em] uppercase text-gray-600">
					<span class="text-2xl font-light text-gray-700 leading-none"><?php echo get_the_date('d'); ?></span>
					<span class="w-px h-4 bg-gray-300" aria-hidden="true"></span>
					<span><?php echo get_the_date('M Y'); ?></span>
				</time>
				
				<!-- Title -->
				<h3 id="resource-title-<?php echo get_the_ID(); ?>" class="text-lg font-semibold leading-snug text-gray-800 mb-4 tracking-tight transition-colors duration-500 group-hover:text-gray-950">
					<?php the_title(); ?>
				</h3>
				
			</div>
			
			<!-- Read More Footer -->
			<div class="mt-6">
				<span class="inline-flex items-center text-xs font-semibold text-gray-600 tracking-wider uppercase transition-all duration-500 group-hover:text-gray-950" aria-hidden="true">
					<span>Read article</span>
					<svg class="w-4 h-4 ml-2 flex-none transition-all duration-500 ease-out group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
					</svg>
				</span>
			</div>
		</div>
	</a>
</article>

