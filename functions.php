<?php
/**
 * BIS functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BIS
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bis_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on BIS, use a find and replace
		* to change 'bis' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'bis', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'bis' ),
		)
	);

	/*
		* Switch default core markup for search form, gallery, and captions
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'bis_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'bis_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bis_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bis_content_width', 640 );
}
add_action( 'after_setup_theme', 'bis_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bis_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'bis' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'bis' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'bis_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bis_scripts() {
	// Enqueue Google Fonts for Montserrat
	wp_enqueue_style( 'bis-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap', array(), null );
	
	// Enqueue Adobe Fonts for Stilson Display
	// To enable: Define BIS_ADOBE_FONTS_ID constant in wp-config.php or uncomment and add your project ID below
	// Example: define( 'BIS_ADOBE_FONTS_ID', 'abc123' );
	$adobe_fonts_id = defined( 'BIS_ADOBE_FONTS_ID' ) ? BIS_ADOBE_FONTS_ID : '';
	if ( ! empty( $adobe_fonts_id ) ) {
		wp_enqueue_style( 'bis-adobe-fonts', 'https://use.typekit.net/' . esc_attr( $adobe_fonts_id ) . '.css', array(), null );
	}
	
	// Enqueue Tailwind CSS output instead of default style.css
	$style_deps = array( 'bis-google-fonts' );
	if ( ! empty( $adobe_fonts_id ) ) {
		$style_deps[] = 'bis-adobe-fonts';
	}
	wp_enqueue_style( 'bis-style', get_template_directory_uri() . '/css/output.css', $style_deps, _S_VERSION );
	wp_style_add_data( 'bis-style', 'rtl', 'replace' );

	// Enqueue Owl Carousel CSS
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '2.3.4' );
	wp_enqueue_style( 'owl-carousel-theme', get_template_directory_uri() . '/css/owl.theme.default.min.css', array( 'owl-carousel' ), '2.3.4' );

	// Enqueue jQuery and Owl Carousel JS
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'owl-loader', get_template_directory_uri() . '/js/owl-loader.js', array( 'jquery', 'owl-carousel' ), _S_VERSION, true );

	wp_enqueue_script( 'bis-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'bis-accordion', get_template_directory_uri() . '/js/accordion.js', array(), _S_VERSION, true );
	
	// Enqueue Alpine.js configuration first (must load before Alpine initializes)
	wp_enqueue_script( 'alpine-config', get_template_directory_uri() . '/js/alpine-config.js', array(), _S_VERSION, false );
	wp_script_add_data( 'alpine-config', 'defer', true );
	
	// Enqueue Alpine.js (loads after config)
	wp_enqueue_script( 'alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js', array( 'alpine-config' ), '3.13.5', false );
	wp_script_add_data( 'alpinejs', 'defer', true );
}
add_action( 'wp_enqueue_scripts', 'bis_scripts' );

/**
 * Disable comments globally
 */
function bis_disable_comments() {
	// Close comments on the front-end
	add_filter( 'comments_open', '__return_false', 20, 2 );
	add_filter( 'pings_open', '__return_false', 20, 2 );

	// Hide existing comments
	add_filter( 'comments_array', '__return_empty_array', 10, 2 );

	// Remove comments page in menu
	add_action( 'admin_menu', function() {
		remove_menu_page( 'edit-comments.php' );
	} );

	// Remove comments links from admin bar
	add_action( 'init', function() {
		if ( is_admin_bar_showing() ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
		}
	} );

	// Remove comments metabox from dashboard
	add_action( 'admin_init', function() {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	} );

	// Remove comments metabox from post/page edit screens
	add_action( 'admin_init', function() {
		remove_meta_box( 'commentstatusdiv', 'post', 'normal' );
		remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
		remove_meta_box( 'commentsdiv', 'post', 'normal' );
		remove_meta_box( 'commentsdiv', 'page', 'normal' );
		remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
		remove_meta_box( 'trackbacksdiv', 'page', 'normal' );
	} );

	// Remove comments column from posts list
	add_filter( 'manage_posts_columns', function( $columns ) {
		unset( $columns['comments'] );
		return $columns;
	} );

	// Remove comments column from pages list
	add_filter( 'manage_pages_columns', function( $columns ) {
		unset( $columns['comments'] );
		return $columns;
	} );

	// Disable support for comments and trackbacks in post types
	add_action( 'admin_init', function() {
		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	} );
}
add_action( 'init', 'bis_disable_comments' );

/**
 * Enable SVG uploads
 */
function bis_enable_svg_uploads( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'bis_enable_svg_uploads', 10, 1 );

/**
 * Fix SVG preview in media library
 */
function bis_fix_svg_preview( $response, $attachment, $meta ) {
	if ( $response['type'] === 'image' && $response['subtype'] === 'svg+xml' ) {
		$response['image'] = array(
			'src'    => $response['url'],
			'width'  => $response['width'] ? $response['width'] : 150,
			'height' => $response['height'] ? $response['height'] : 150,
		);
		$response['thumb'] = array(
			'src'    => $response['url'],
			'width'  => $response['width'] ? $response['width'] : 150,
			'height' => $response['height'] ? $response['height'] : 150,
		);
	}
	return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'bis_fix_svg_preview', 10, 3 );

/**
 * Generate attachment metadata for SVG files
 */
function bis_generate_svg_attachment_metadata( $metadata, $attachment_id, $context ) {
	if ( get_post_mime_type( $attachment_id ) === 'image/svg+xml' ) {
		$svg_path = get_attached_file( $attachment_id );
		if ( $svg_path && file_exists( $svg_path ) ) {
			$svg_content = file_get_contents( $svg_path );
			$width = 0;
			$height = 0;
			
			if ( preg_match( '/<svg[^>]*width=["\']([^"\']*)["\']/i', $svg_content, $width_match ) ) {
				$width = floatval( $width_match[1] );
			}
			if ( preg_match( '/<svg[^>]*height=["\']([^"\']*)["\']/i', $svg_content, $height_match ) ) {
				$height = floatval( $height_match[1] );
			}
			
			if ( ! $width && ! $height && preg_match( '/<svg[^>]*viewBox=["\']([^"\']*)["\']/i', $svg_content, $viewbox_match ) ) {
				$viewbox = explode( ' ', trim( $viewbox_match[1] ) );
				if ( count( $viewbox ) === 4 ) {
					$width = floatval( $viewbox[2] );
					$height = floatval( $viewbox[3] );
				}
			}
			
			if ( $width && $height ) {
				$metadata['width'] = intval( $width );
				$metadata['height'] = intval( $height );
			}
		}
	}
	return $metadata;
}
add_filter( 'wp_generate_attachment_metadata', 'bis_generate_svg_attachment_metadata', 10, 3 );

/**
 * Display SVG in media library grid view
 */
function bis_display_svg_in_media_library( $response, $attachment, $meta ) {
	if ( $response['mime'] === 'image/svg+xml' ) {
		$response['image'] = array(
			'src'    => $response['url'],
			'width'  => isset( $meta['width'] ) ? $meta['width'] : 150,
			'height' => isset( $meta['height'] ) ? $meta['height'] : 150,
		);
	}
	return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'bis_display_svg_in_media_library', 10, 3 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Structured-data (JSON-LD) augmentation for Yoast SEO.
 */
require get_template_directory() . '/inc/schema.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

