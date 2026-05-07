<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BIS
 */

get_header();
get_template_part( 'components/layout/breadcrumb' );
?>

<!-- Archive Header -->
<section class="relative overflow-hidden bg-gradient-to-br from-red-600 to-red-800 py-20">
	<div class="max-w-7xl mx-auto px-4">
		<div class="max-w-4xl mx-auto text-center">
			<?php
			the_archive_title( '<h1 class="text-4xl md:text-5xl lg:text-6xl text-white font-bold mb-6">', '</h1>' );
			the_archive_description( '<div class="text-white/90 text-lg leading-relaxed max-w-2xl mx-auto">', '</div>' );
			?>
		</div>
	</div>
</section>

<!-- Blog Posts Grid -->
<section class="py-16 bg-gray-50">
	<div class="max-w-7xl mx-auto px-4">
		<?php if ( have_posts() ) : ?>
		<div class="max-w-7xl mx-auto">
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php
			while ( have_posts() ) :
				the_post();
					$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
					$post_date = get_the_date( 'F j, Y' );
					$reading_time = bis_calculate_reading_time();
					$excerpt = get_the_excerpt();
					$categories = get_the_category();
				?>
				<article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
					<!-- Featured Image -->
					<?php if ( $featured_image ) : ?>
					<a href="<?php the_permalink(); ?>" class="block relative h-48 overflow-hidden">
						<img src="<?php echo esc_url( $featured_image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
						<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
					</a>
					<?php else : ?>
					<a href="<?php the_permalink(); ?>" class="block relative h-48 bg-gradient-to-br from-red-600 to-red-800"></a>
					<?php endif; ?>
					
					<!-- Content -->
					<div class="p-6">
						<!-- Categories -->
						<?php if ( ! empty( $categories ) ) : ?>
						<div class="flex flex-wrap gap-2 mb-3">
							<?php foreach ( array_slice( $categories, 0, 2 ) as $category ) : ?>
							<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="inline-block bg-red-100 hover:bg-red-600 hover:text-white text-red-600 text-xs font-semibold px-3 py-1 rounded-full transition-colors">
								<?php echo esc_html( $category->name ); ?>
							</a>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
						
						<!-- Title -->
						<h2 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-red-600 transition-colors">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						
						<!-- Meta -->
						<div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
							<div class="flex items-center gap-1">
								<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
								</svg>
								<span><?php echo esc_html( $post_date ); ?></span>
							</div>
							<div class="flex items-center gap-1">
								<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
								</svg>
								<span><?php echo esc_html( $reading_time ); ?> min</span>
							</div>
						</div>
						
						<!-- Excerpt -->
						<?php if ( $excerpt ) : ?>
						<p class="text-gray-600 leading-relaxed mb-4 line-clamp-3">
							<?php echo esc_html( wp_trim_words( $excerpt, 20 ) ); ?>
						</p>
						<?php endif; ?>
						
						<!-- Read More -->
						<a href="<?php the_permalink(); ?>" class="inline-flex items-center text-red-600 hover:text-red-700 font-semibold text-sm group-hover:gap-2 transition-all">
							<span>Read More</span>
							<svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
							</svg>
						</a>
					</div>
				</article>
				<?php
				endwhile;
				?>
			</div>
			
			<!-- Pagination -->
			<div class="mt-12 flex justify-center">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => '<span class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-red-600 hover:text-white text-gray-700 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg> Previous</span>',
						'next_text' => '<span class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-red-600 hover:text-white text-gray-700 rounded-lg transition-colors">Next <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg></span>',
					)
				);
				?>
			</div>
		</div>
		<?php else : ?>
		<div class="max-w-4xl mx-auto text-center py-16">
			<h2 class="text-3xl font-bold text-gray-900 mb-4">No posts found</h2>
			<p class="text-gray-600 text-lg">It looks like nothing was found at this location. Maybe try a search?</p>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_template_part('components/sections/cta');
get_footer();
