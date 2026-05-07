<?php
/**
 * Breadcrumb Component
 * Displays breadcrumb navigation for all pages except home
 *
 * @package BIS
 */

// Don't show breadcrumbs on home page
if ( is_front_page() || is_home() ) {
	return;
}

$breadcrumb_items = bis_get_breadcrumb_items();

if ( empty( $breadcrumb_items ) || count( $breadcrumb_items ) <= 1 ) {
	return;
}

/**
 * URL of the current page, used for the last BreadcrumbList ListItem so that
 * `itemprop="item"` resolves to a real WebPage IRI instead of being omitted
 * (which Google's validator flags as incomplete on every inner page).
 */
$bis_current_breadcrumb_url = '';
if ( is_singular() ) {
	$bis_current_breadcrumb_url = (string) get_permalink();
}
if ( '' === $bis_current_breadcrumb_url && isset( $_SERVER['REQUEST_URI'] ) ) {
	$bis_current_breadcrumb_url = home_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
?>

<nav class="breadcrumb-nav" aria-label="Breadcrumb">
	<div class="max-w-7xl mx-auto px-4 lg:px-0">
		<ol class="flex flex-wrap items-center gap-x-1.5 sm:gap-x-2 md:gap-x-3 gap-y-1.5 text-xs sm:text-sm md:text-base text-gray-500 py-3 sm:py-4 md:py-6 font-light tracking-wide" itemscope itemtype="https://schema.org/BreadcrumbList">
			<?php
			$position = 1;
			$total_items = count( $breadcrumb_items );
			// On mobile, show only last 3 items if there are more than 3
			$mobile_start = ( $total_items > 3 ) ? max( 0, $total_items - 3 ) : 0;
			
			foreach ( $breadcrumb_items as $index => $item ) :
				$is_last = ( $index === count( $breadcrumb_items ) - 1 );
				$is_mobile_hidden = ( $index < $mobile_start && $total_items > 3 );
			?>
			<li class="flex items-center flex-shrink-0 <?php echo $is_mobile_hidden ? 'hidden sm:flex' : ''; ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<?php if ( $is_mobile_hidden && $index === 0 ) : ?>
					<!-- Show ellipsis on mobile for hidden items -->
					<span class="text-gray-700 text-xs sm:hidden" aria-hidden="true">…</span>
					<span class="sr-only sm:hidden"><?php esc_html_e( 'Earlier breadcrumb items hidden on mobile.', 'bis' ); ?></span>
					<span class="mx-1 text-gray-500 font-light text-[10px] sm:hidden select-none" aria-hidden="true">/</span>
				<?php endif; ?>
				
				<?php if ( ! $is_last && ! empty( $item['url'] ) ) : ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>" 
					   class="group inline-flex items-center py-1.5 px-2 -mx-2 sm:py-1 sm:px-1 sm:-mx-1 rounded-md
					          text-gray-500 hover:text-gray-800
					          transition-all duration-200 ease-out
					          hover:bg-gray-100/60
					          active:bg-gray-200/60 active:scale-[0.98]
					          focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400/50 focus-visible:ring-offset-1
					          touch-manipulation" 
					   itemprop="item">
						<span itemprop="name" class="relative"><?php echo esc_html( $item['label'] ); ?></span>
					</a>
					<meta itemprop="position" content="<?php echo esc_attr( $position ); ?>" />
					<span class="mx-1 sm:mx-1.5 md:mx-2 text-gray-300/80 font-light text-[10px] sm:text-xs md:text-sm select-none" aria-hidden="true">/</span>
				<?php else : ?>
					<span class="text-gray-700 font-medium truncate max-w-[150px] sm:max-w-[200px] md:max-w-none py-1.5 px-2 sm:py-1 sm:px-1"
					      itemprop="item" itemscope itemtype="https://schema.org/WebPage" itemid="<?php echo esc_url( $bis_current_breadcrumb_url ); ?>">
						<span itemprop="name"><?php echo esc_html( $item['label'] ); ?></span>
					</span>
					<meta itemprop="position" content="<?php echo esc_attr( $position ); ?>" />
				<?php endif; ?>
			</li>
			<?php
				$position++;
			endforeach;
			?>
		</ol>
	</div>
</nav>


