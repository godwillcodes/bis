<?php
/**
 * Post Meta Component
 * Displays date, time, and reading time for posts
 *
 * @package BIS
 */

if ( ! function_exists( 'bis_calculate_reading_time' ) ) {
	return;
}

$post_date = get_the_date( 'F j, Y' );
$post_time = get_the_time( 'g:i A' );
$reading_time = bis_calculate_reading_time();
?>

<div class="flex flex-wrap items-center gap-6 mb-8 pb-8 border-b border-gray-200">
	<!-- Date -->
	<div class="flex items-center gap-2 text-gray-600">
		<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
		</svg>
		<span class="font-medium"><?php echo esc_html( $post_date ); ?></span>
	</div>
	
	<!-- Time -->
	<div class="flex items-center gap-2 text-gray-600">
		<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
		</svg>
		<span class="font-medium"><?php echo esc_html( $post_time ); ?></span>
	</div>
	
	<!-- Reading Time -->
	<div class="flex items-center gap-2 text-gray-600">
		<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
		</svg>
		<span class="font-medium"><?php echo esc_html( $reading_time ); ?> min read</span>
	</div>
</div>


