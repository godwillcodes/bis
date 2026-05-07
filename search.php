<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package BIS
 */

get_header();
get_template_part( 'components/layout/breadcrumb' );
?>

<!-- Search Results Header -->
<section class="relative overflow-hidden bg-gradient-to-br from-red-600 to-red-800 py-20" aria-labelledby="search-results-heading">
	<div class="max-w-7xl mx-auto px-4">
		<div class="max-w-4xl mx-auto text-center">
			<h1 id="search-results-heading" class="text-3xl md:text-4xl lg:text-5xl text-white font-bold mb-6">
				<?php
				/* translators: %s: search query. */
				printf(
					esc_html__( 'Search results for: %s', 'bis' ),
					'<span class="italic">' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
			<p class="text-white/90 text-lg leading-relaxed max-w-2xl mx-auto">
				<?php
				if ( have_posts() ) {
					global $wp_query;
					/* translators: %d: number of search results found. */
					printf(
						esc_html( _n( 'Found %d match.', 'Found %d matches.', (int) $wp_query->found_posts, 'bis' ) ),
						(int) $wp_query->found_posts
					);
				} else {
					esc_html_e( 'No matches were found. Try a different search term.', 'bis' );
				}
				?>
			</p>
		</div>
	</div>
</section>

<!-- Search Results List -->
<section class="py-16 bg-gray-50" aria-labelledby="search-results-list-heading">
	<h2 id="search-results-list-heading" class="sr-only"><?php esc_html_e( 'Search results', 'bis' ); ?></h2>
	<div class="max-w-7xl mx-auto px-4">
		<?php if ( have_posts() ) : ?>
			<ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 list-none p-0 m-0" role="list">
				<?php
				while ( have_posts() ) :
					the_post();
					$result_image  = get_the_post_thumbnail_url( get_the_ID(), 'large' );
					$result_date   = get_the_date( 'F j, Y' );
					$result_excerpt = get_the_excerpt();
				?>
					<li>
						<article class="h-full bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group flex flex-col"
							aria-labelledby="search-result-title-<?php echo (int) get_the_ID(); ?>">
							<?php if ( $result_image ) : ?>
								<a href="<?php the_permalink(); ?>" class="block relative h-48 overflow-hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600">
									<img src="<?php echo esc_url( $result_image ); ?>" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
									<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" aria-hidden="true"></div>
								</a>
							<?php endif; ?>
							<div class="p-6 flex-1 flex flex-col">
								<h3 id="search-result-title-<?php echo (int) get_the_ID(); ?>" class="text-xl font-bold text-gray-900 mb-3 group-hover:text-red-600 transition-colors">
									<a href="<?php the_permalink(); ?>" class="focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600 rounded-sm">
										<?php the_title(); ?>
									</a>
								</h3>
								<div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
									<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" focusable="false">
										<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
									</svg>
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( $result_date ); ?></time>
								</div>
								<?php if ( $result_excerpt ) : ?>
									<p class="text-gray-700 leading-relaxed mb-4 line-clamp-3">
										<?php echo esc_html( wp_trim_words( $result_excerpt, 22 ) ); ?>
									</p>
								<?php endif; ?>
								<a href="<?php the_permalink(); ?>" class="mt-auto inline-flex items-center text-red-600 hover:text-red-700 font-semibold text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600 rounded-sm">
									<span><?php esc_html_e( 'Read more', 'bis' ); ?></span>
									<svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" focusable="false">
										<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
									</svg>
								</a>
							</div>
						</article>
					</li>
				<?php endwhile; ?>
			</ul>

			<nav class="mt-12 flex justify-center" aria-label="<?php esc_attr_e( 'Search results pagination', 'bis' ); ?>">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => '<span class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-red-600 hover:text-white text-gray-700 rounded-lg transition-colors">' . esc_html__( 'Previous', 'bis' ) . '</span>',
						'next_text' => '<span class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-red-600 hover:text-white text-gray-700 rounded-lg transition-colors">' . esc_html__( 'Next', 'bis' ) . '</span>',
					)
				);
				?>
			</nav>
		<?php else : ?>
			<div class="max-w-2xl mx-auto text-center py-12">
				<h3 class="text-2xl font-bold text-gray-900 mb-4">
					<?php esc_html_e( 'No results found', 'bis' ); ?>
				</h3>
				<p class="text-gray-700 mb-8">
					<?php esc_html_e( 'Try a different search or explore our popular pages below.', 'bis' ); ?>
				</p>
				<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<div class="flex gap-3 max-w-xl mx-auto">
						<label for="search-results-input" class="sr-only"><?php esc_html_e( 'Search', 'bis' ); ?></label>
						<input
							type="search"
							id="search-results-input"
							class="flex-1 px-6 py-4 text-base border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent"
							placeholder="<?php esc_attr_e( 'Search the site…', 'bis' ); ?>"
							value="<?php echo esc_attr( get_search_query() ); ?>"
							name="s"
						/>
						<button type="submit" class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
							<?php esc_html_e( 'Search', 'bis' ); ?>
						</button>
					</div>
				</form>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_template_part( 'components/sections/cta' );
get_footer();
