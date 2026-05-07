<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package BIS
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bis_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'bis_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bis_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'bis_pingback_header' );

/**
 * Calculate reading time for post content
 *
 * @param string $content Post content.
 * @param int    $words_per_minute Reading speed (default 200).
 * @return int Reading time in minutes.
 */
function bis_calculate_reading_time( $content = '', $words_per_minute = 200 ) {
	if ( empty( $content ) ) {
		global $post;
		if ( isset( $post->post_content ) ) {
			$content = $post->post_content;
		} else {
			return 1;
		}
	}
	
	// Strip HTML tags and count words
	$text = strip_tags( $content );
	$word_count = str_word_count( $text );
	
	// Calculate reading time (round up to at least 1 minute)
	$reading_time = max( 1, ceil( $word_count / $words_per_minute ) );
	
	return $reading_time;
}

/**
 * Get breadcrumb items for navigation
 *
 * @return array Array of breadcrumb items with 'label' and 'url' keys
 */
function bis_get_breadcrumb_items() {
	$items = array();
	
	// Always start with home
	$items[] = array(
		'label' => 'Home',
		'url'   => home_url( '/' ),
	);
	
	// Handle different page types
	if ( is_page() ) {
		// Regular pages
		$ancestors = get_post_ancestors( get_the_ID() );
		if ( $ancestors ) {
			$ancestors = array_reverse( $ancestors );
			foreach ( $ancestors as $ancestor_id ) {
				$items[] = array(
					'label' => get_the_title( $ancestor_id ),
					'url'   => get_permalink( $ancestor_id ),
				);
			}
		}
		$items[] = array(
			'label' => get_the_title(),
			'url'   => '',
		);
	} elseif ( is_single() ) {
		// Single posts and custom post types
		$post_type = get_post_type();
		
		// Handle custom post types with specific page links
		$post_type_pages = array(
			'service'  => array(
				'url'   => home_url( '/services' ),
				'label' => 'Services',
			),
			'industry' => array(
				'url'   => home_url( '/industries' ),
				'label' => 'Industries',
			),
			'resource' => array(
				'url'   => home_url( '/resources' ),
				'label' => 'Resources',
			),
		);
		
		if ( isset( $post_type_pages[ $post_type ] ) ) {
			// Custom post types: service, industry, resource
			$items[] = array(
				'label' => $post_type_pages[ $post_type ]['label'],
				'url'   => $post_type_pages[ $post_type ]['url'],
			);
		} else {
			// Get post type archive link if available
			$post_type_obj = get_post_type_object( $post_type );
			if ( $post_type_obj && $post_type_obj->has_archive ) {
				$items[] = array(
					'label' => $post_type_obj->labels->name,
					'url'   => get_post_type_archive_link( $post_type ),
				);
			} elseif ( 'post' === $post_type ) {
				// Regular blog posts
				$blog_page = get_option( 'page_for_posts' );
				if ( $blog_page ) {
					$items[] = array(
						'label' => get_the_title( $blog_page ),
						'url'   => get_permalink( $blog_page ),
					);
				}
				
				// Categories
				$categories = get_the_category();
				if ( ! empty( $categories ) ) {
					$category = $categories[0];
					$items[] = array(
						'label' => $category->name,
						'url'   => get_category_link( $category->term_id ),
					);
				}
			}
		}
		
		// Current post
		$items[] = array(
			'label' => get_the_title(),
			'url'   => '',
		);
	} elseif ( is_category() ) {
		// Category archive
		$blog_page = get_option( 'page_for_posts' );
		if ( $blog_page ) {
			$items[] = array(
				'label' => get_the_title( $blog_page ),
				'url'   => get_permalink( $blog_page ),
			);
		}
		$items[] = array(
			'label' => single_cat_title( '', false ),
			'url'   => '',
		);
	} elseif ( is_tag() ) {
		// Tag archive
		$blog_page = get_option( 'page_for_posts' );
		if ( $blog_page ) {
			$items[] = array(
				'label' => get_the_title( $blog_page ),
				'url'   => get_permalink( $blog_page ),
			);
		}
		$items[] = array(
			'label' => single_tag_title( '', false ),
			'url'   => '',
		);
	} elseif ( is_post_type_archive() ) {
		// Post type archive
		$post_type = get_post_type();
		$post_type_obj = get_post_type_object( $post_type );
		if ( $post_type_obj ) {
			$items[] = array(
				'label' => $post_type_obj->labels->name,
				'url'   => '',
			);
		}
	} elseif ( is_tax() ) {
		// Taxonomy archive
		$taxonomy = get_queried_object();
		$post_type = get_post_type();
		
		// Get post type archive link if available
		$post_type_obj = get_post_type_object( $post_type );
		if ( $post_type_obj && $post_type_obj->has_archive ) {
			$items[] = array(
				'label' => $post_type_obj->labels->name,
				'url'   => get_post_type_archive_link( $post_type ),
			);
		}
		
		$items[] = array(
			'label' => $taxonomy->name,
			'url'   => '',
		);
	} elseif ( is_search() ) {
		// Search results
		$items[] = array(
			'label' => 'Search Results',
			'url'   => '',
		);
	} elseif ( is_404() ) {
		// 404 page
		$items[] = array(
			'label' => '404 - Page Not Found',
			'url'   => '',
		);
	} elseif ( is_archive() ) {
		// Generic archive
		$items[] = array(
			'label' => get_the_archive_title(),
			'url'   => '',
		);
	}
	
	return $items;
}
