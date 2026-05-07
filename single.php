<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package BIS
 */

get_header();

?>

<?php
while ( have_posts() ) :
	the_post();
	$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	$post_date = get_the_date( 'F j, Y' );
	$post_time = get_the_time( 'g:i A' );
	$reading_time = bis_calculate_reading_time();
	$categories = get_the_category();
	$tags = get_the_tags();
?>

<!-- Hero Section with Featured Image -->
<section class="relative overflow-hidden">
	<?php if ( $featured_image ) : ?>
	<div class="absolute inset-0 z-0">
		<img src="<?php echo esc_url( $featured_image ); ?>" alt="" class="w-full h-[60vh] object-cover">
		<div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/70 to-black/90"></div>
	</div>
	<?php else : ?>
	<div class="absolute inset-0 z-0 bg-gradient-to-br from-red-600 to-red-800"></div>
	<?php endif; ?>
	
	<div class="max-w-7xl mx-auto px-4 relative z-10 pt-32 pb-20">
		<div class="max-w-4xl mx-auto text-center">
			
			
			<!-- Title -->
			<h1 class="text-4xl md:text-5xl lg:text-6xl text-white font-bold mb-8 leading-tight">
				<?php the_title(); ?>
			</h1>
			
			<!-- Meta Information -->
			<div class="flex flex-wrap items-center justify-center gap-6 text-white/90">
				<div class="flex items-center gap-2">
					<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
					 <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
					</svg>
					<span class="font-medium"><?php echo esc_html( $post_date ); ?></span>
				</div>
				
				<div class="flex items-center gap-2">
					<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
					 <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>
					<span class="font-medium"><?php echo esc_html( $reading_time ); ?> min read</span>
				</div>
				
				
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'components/layout/breadcrumb' ); ?>

<!-- Content Section -->
<section class="pt-10 bg-white">
	<div class="max-w-7xl mx-auto px-4">
		<div class="max-w-7xl mx-auto">
			<!-- Blog Content -->
			<article class="prose prose-xl font-inherit max-w-none blog-text">
				<?php
				the_content();
				
				wp_link_pages(
					array(
						'before' => '<div class="page-links mt-8 pt-8 border-t border-gray-200">' . esc_html__( 'Pages:', 'bis' ),
						'after'  => '</div>',
					)
				);
				?>
			</article>
			
			<!-- Tags -->
			<?php if ( ! empty( $tags ) ) : ?>
			<div class="mt-12 pt-8 border-t border-gray-200">
				<div class="flex flex-wrap items-center gap-3">
					<span class="text-gray-700 font-semibold">Tags:</span>
					<?php foreach ( $tags as $tag ) : ?>
					<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="inline-block bg-gray-100 hover:bg-red-600 hover:text-white text-gray-700 text-sm font-medium px-4 py-2 rounded-full transition-colors">
						<?php echo esc_html( $tag->name ); ?>
					</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
			
			<!-- Post Navigation -->
			<nav class="mt-16 pt-8 border-t border-gray-200" aria-label="<?php esc_attr_e( 'Post navigation', 'bis' ); ?>">
				<h2 class="sr-only"><?php esc_html_e( 'Post navigation', 'bis' ); ?></h2>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<?php
					$prev_post = get_previous_post();
					if ( $prev_post ) :
					?>
					<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="group block p-6 bg-gray-50 hover:bg-red-50 rounded-lg transition-colors border border-gray-200 hover:border-red-300">
						<div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
							<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
							</svg>
							<span>Previous Post</span>
						</div>
						<h3 class="text-lg font-semibold text-gray-900 group-hover:text-red-600 transition-colors">
							<?php echo esc_html( get_the_title( $prev_post ) ); ?>
						</h3>
					</a>
					<?php endif; ?>
					
					<?php
					$next_post = get_next_post();
					if ( $next_post ) :
					?>
					<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="group block p-6 bg-gray-50 hover:bg-red-50 rounded-lg transition-colors border border-gray-200 hover:border-red-300 text-right md:text-left">
						<div class="flex items-center justify-end md:justify-start gap-2 text-sm text-gray-600 mb-2">
							<span>Next Post</span>
							<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
							</svg>
						</div>
						<h3 class="text-lg font-semibold text-gray-900 group-hover:text-red-600 transition-colors">
							<?php echo esc_html( get_the_title( $next_post ) ); ?>
						</h3>
					</a>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	</div>
</section>

<?php
endwhile;
?>

<?php
get_template_part('components/sections/cta');
get_template_part('components/sections/logo-carousel');

get_footer();
