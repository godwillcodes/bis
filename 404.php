<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package BIS
 */

get_header();
get_template_part( 'components/layout/breadcrumb' );
?>

<!-- 404 Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 py-20 lg:py-32">
	<div class="max-w-7xl mx-auto px-4">
		<div class="max-w-4xl mx-auto text-center">
			<!-- 404 Number -->
			<div class="mb-8">
				<h1 class="text-8xl md:text-9xl lg:text-[12rem] font-bold text-gray-200 leading-none tracking-tight">
					404
				</h1>
			</div>
			
			<!-- Main Message -->
			<h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 tracking-tight leading-tight">
				Page Not Found
			</h2>
			
			<p class="text-lg md:text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
				The page you're looking for doesn't exist or has been moved. Let's help you find what you need.
			</p>
			
			<!-- Search Form -->
			<div class="max-w-xl mx-auto mb-12">
				<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<div class="flex gap-3">
						<label for="search-404" class="sr-only">Search</label>
						<input 
							type="search" 
							id="search-404"
							class="flex-1 px-6 py-4 text-base border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all"
							placeholder="Search for services, resources, or information..."
							value="<?php echo esc_attr( get_search_query() ); ?>" 
							name="s" 
						/>
						<button 
							type="submit" 
							class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
							aria-label="Search"
						>
							<span class="hidden sm:inline">Search</span>
							<svg class="w-5 h-5 sm:ml-2 inline" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
							</svg>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- Helpful Links Section -->
<section class="py-16 bg-white">
	<div class="max-w-7xl mx-auto px-4">
		<div class="max-w-7xl mx-auto">
			<h3 class="text-2xl font-semibold text-gray-900 mb-8 text-center">Popular Pages</h3>
			
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php
				// Get popular pages
				$popular_pages = array(
					array(
						'title' => 'Our Services',
						'url'   => home_url( '/services' ),
						'icon'  => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>',
					),
					array(
						'title' => 'Industries',
						'url'   => home_url( '/industries' ),
						'icon'  => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" /></svg>',
					),
					array(
						'title' => 'Resources',
						'url'   => home_url( '/resources' ),
						'icon'  => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>',
					),
					array(
						'title' => 'About Us',
						'url'   => home_url( '/about' ),
						'icon'  => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-3.382c0-1.632-1.135-2.393-2.25-2.538a24.217 24.217 0 00-1.5-.128 24.22 24.22 0 00-1.5.128c-1.115.145-2.25.906-2.25 2.538v3.382m6 0a9.38 9.38 0 01-2.625.372M9 19.128v-3.382c0-1.632 1.135-2.393 2.25-2.538.863-.112 1.737-.128 2.5-.128s1.637.016 2.5.128c1.115.145 2.25.906 2.25 2.538v3.382m-6 0V9.75m0-3.382c0-1.632 1.135-2.393 2.25-2.538.863-.112 1.737-.128 2.5-.128s1.637.016 2.5.128c1.115.145 2.25.906 2.25 2.538v3.382" /></svg>',
					),
					array(
						'title' => 'Contact',
						'url'   => home_url( '/contact' ),
						'icon'  => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>',
					),
					array(
						'title' => 'Home',
						'url'   => home_url( '/' ),
						'icon'  => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>',
					),
				);
				
				foreach ( $popular_pages as $page ) :
				?>
				<a href="<?php echo esc_url( $page['url'] ); ?>" class="group flex items-center gap-4 p-6 bg-white border border-gray-200 hover:border-red-600 hover:shadow-lg transition-all duration-300">
					<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
						<?php echo $page['icon']; ?>
					</div>
					<div class="flex-1">
						<h4 class="text-lg font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-300">
							<?php echo esc_html( $page['title'] ); ?>
						</h4>
					</div>
					<svg class="w-5 h-5 text-gray-600 group-hover:text-red-600 group-hover:translate-x-1 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" focusable="false">
						<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
					</svg>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part('components/sections/cta');
get_footer();
