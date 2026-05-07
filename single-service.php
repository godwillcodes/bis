<?php
/**
 * Single Service Template
 *
 * Displays old or new template based on template_style taxonomy term.
 *
 * @package BIS
 */

// Get the template_style taxonomy term for this service
$template_style = get_the_terms( get_the_ID(), 'template_style' );

// Check if term exists and get the slug
$style = 'old'; // Default to old template if blank
if ( $template_style && ! is_wp_error( $template_style ) ) {
	$style = $template_style[0]->slug;
}

// Load the appropriate template
if ( $style === 'new' ) {
	get_template_part( 'components/services/new' );
} else {
	get_template_part( 'components/services/old' );
}
?>
