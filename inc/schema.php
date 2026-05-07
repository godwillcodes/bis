<?php
/**
 * Structured-data (JSON-LD) augmentation.
 *
 * Yoast SEO is the canonical schema generator on this site. We hook into its
 * filter pipeline to enrich the @graph rather than print a parallel
 * <script type="application/ld+json"> block (which would create duplicate /
 * conflicting nodes for crawlers).
 *
 * All hooks short-circuit silently if Yoast SEO is not active.
 *
 * @package BIS
 */

defined( 'ABSPATH' ) || exit;

/**
 * Single source of truth for editable site facts that surface in schema.
 *
 * Override any value via the `bis_schema_organization_data` filter (e.g. from
 * an ACF options page) without touching the template.
 *
 * @return array
 */
function bis_schema_org_data() {
	$defaults = array(
		'email'           => 'info@bisworld.com',
		'telephone'       => '',
		'street'          => '2 Bethesda Metro Center',
		'locality'        => 'Bethesda',
		'region'          => 'MD',
		'postal_code'     => '20814',
		'country'         => 'US',
		'founding_date'   => '1995',
		'employee_count'  => 25,
		'description'     => __( 'Birnbaum Interpreting Service (BIS) provides ASL interpreting, CART/captioning, VRI, and accessibility services that help organizations build inclusive environments for the Deaf and Hard-of-Hearing community.', 'bis' ),
		// ISO 639-3 / BCP-47: en = English, ase = American Sign Language.
		'languages'       => array( 'en', 'ase' ),
		'area_served'     => 'US',
	);

	return apply_filters( 'bis_schema_organization_data', $defaults );
}

/**
 * Editable defaults for the founder Person node.
 *
 * Override via the `bis_schema_founder_data` filter (e.g. from an ACF
 * options page) without touching templates.
 *
 * @return array
 */
function bis_schema_founder_data() {
	$defaults = array(
		'name'        => 'David Birnbaum',
		'jobTitle'    => __( 'Founder', 'bis' ),
		'description' => __( 'David Birnbaum founded Birnbaum Interpreting Service in 1995 to expand access to professional ASL interpreting and accessibility services.', 'bis' ),
		'image'       => '',
		'sameAs'      => array(),
	);

	return apply_filters( 'bis_schema_founder_data', $defaults );
}

/**
 * Stable @id for the founder Person node.
 *
 * @return string
 */
function bis_schema_founder_id() {
	$founder = bis_schema_founder_data();
	$slug    = sanitize_title( ! empty( $founder['name'] ) ? $founder['name'] : 'founder' );
	return trailingslashit( home_url( '/' ) ) . '#person-' . $slug;
}

/**
 * Resolve the WP page ID for a page assigned to a given theme template.
 *
 * Cached per-template per-request to avoid repeated DB lookups.
 *
 * @param string $template Relative template path (e.g. "pages/about.php").
 * @return int 0 when no matching page is found.
 */
function bis_schema_page_id_for_template( $template ) {
	static $cache = array();
	if ( isset( $cache[ $template ] ) ) {
		return $cache[ $template ];
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'page',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'post_status'    => 'publish',
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'   => '_wp_page_template',
					'value' => $template,
				),
			),
		)
	);

	$cache[ $template ] = ! empty( $query->posts ) ? (int) $query->posts[0] : 0;
	wp_reset_postdata();

	return $cache[ $template ];
}

/**
 * @return int
 */
function bis_schema_about_page_id() {
	return bis_schema_page_id_for_template( 'pages/about.php' );
}

/**
 * @return int
 */
function bis_schema_services_page_id() {
	return bis_schema_page_id_for_template( 'pages/services.php' );
}

/**
 * @return bool
 */
function bis_is_about_page() {
	return is_page() && is_page_template( 'pages/about.php' );
}

/**
 * @return bool
 */
function bis_is_services_page() {
	return is_page() && is_page_template( 'pages/services.php' );
}

/**
 * @return int
 */
function bis_schema_industries_page_id() {
	return bis_schema_page_id_for_template( 'pages/industries.php' );
}

/**
 * @return bool
 */
function bis_is_industries_page() {
	return is_page() && is_page_template( 'pages/industries.php' );
}

/**
 * @return bool
 */
function bis_is_faq_page() {
	return is_page() && is_page_template( 'pages/faq.php' );
}

/**
 * @return int
 */
function bis_schema_team_page_id() {
	return bis_schema_page_id_for_template( 'pages/team.php' );
}

/**
 * @return bool
 */
function bis_is_team_page() {
	return is_page() && is_page_template( 'pages/team.php' );
}

/**
 * Stable @id used for Team ItemList cross-references.
 *
 * @return string
 */
function bis_schema_team_list_id() {
	return trailingslashit( home_url( '/' ) ) . '#team-members-list';
}

/**
 * Resolve the WP page ID of the blog index.
 *
 * Prefers the page assigned in Settings > Reading (`page_for_posts`), then
 * falls back to the custom blog template if that setting is not used.
 *
 * @return int
 */
function bis_schema_blog_page_id() {
	$page_for_posts = (int) get_option( 'page_for_posts' );
	if ( $page_for_posts > 0 ) {
		return $page_for_posts;
	}
	return bis_schema_page_id_for_template( 'pages/blog.php' );
}

/**
 * Whether current request is the blog listing page.
 *
 * @return bool
 */
function bis_is_blog_page() {
	if ( is_home() && ! is_front_page() ) {
		return true;
	}

	if ( is_page() && is_page_template( 'pages/blog.php' ) ) {
		return true;
	}

	$blog_page_id = bis_schema_blog_page_id();
	return $blog_page_id > 0 && is_page( $blog_page_id );
}

/**
 * Stable @id used for the blog ItemList cross-references.
 *
 * @return string
 */
function bis_schema_blog_list_id() {
	return trailingslashit( home_url( '/' ) ) . '#blog-posts-list';
}

/**
 * Build Question nodes from the FAQ page's ACF `accordion` field.
 *
 * Returns an empty array when ACF is unavailable, the field is empty,
 * or no row has both a question title and an answer body.
 *
 * @return array
 */
function bis_schema_faq_questions() {
	if ( ! function_exists( 'get_field' ) ) {
		return array();
	}

	$faqs = get_field( 'accordion' );
	if ( ! is_array( $faqs ) || empty( $faqs ) ) {
		return array();
	}

	$questions = array();
	foreach ( $faqs as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$title       = isset( $row['title'] ) ? trim( wp_strip_all_tags( $row['title'] ) ) : '';
		$answer_html = isset( $row['description'] ) ? trim( (string) $row['description'] ) : '';
		if ( '' === $title || '' === $answer_html ) {
			continue;
		}

		$questions[] = array(
			'@type'          => 'Question',
			'name'           => $title,
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_kses_post( $answer_html ),
			),
		);
	}

	return $questions;
}

/**
 * Normalised list of team-member rows for the Team page template.
 *
 * Field source: ACF repeater `team_members` on `pages/team.php`
 * with sub-fields `name`, `title`, `photo`, `linkedin`, `bio`.
 *
 * @return array<int,array<string,string>>
 */
function bis_schema_team_page_member_rows() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$cache = array();
	if ( ! function_exists( 'get_field' ) ) {
		return $cache;
	}

	$team_page_id = bis_schema_team_page_id();
	if ( ! $team_page_id ) {
		return $cache;
	}

	$members = get_field( 'team_members', $team_page_id );
	if ( ! is_array( $members ) || empty( $members ) ) {
		return $cache;
	}

	foreach ( $members as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$name = isset( $row['name'] ) ? trim( (string) $row['name'] ) : '';
		if ( '' === $name ) {
			continue;
		}

		$cache[] = array(
			'name'        => $name,
			'jobTitle'    => isset( $row['title'] ) ? (string) $row['title'] : '',
			'image'       => isset( $row['photo'] ) ? (string) $row['photo'] : '',
			'linkedin'    => isset( $row['linkedin'] ) ? (string) $row['linkedin'] : '',
			'description' => isset( $row['bio'] ) ? (string) $row['bio'] : '',
		);
	}

	return $cache;
}

/**
 * Build Person @ids for Team-page ACF rows.
 *
 * @return string[]
 */
function bis_schema_team_page_member_ids() {
	$rows = bis_schema_team_page_member_rows();
	if ( empty( $rows ) ) {
		return array();
	}

	$base = trailingslashit( home_url( '/' ) ) . '#person-';
	$ids  = array();
	foreach ( $rows as $row ) {
		if ( empty( $row['name'] ) ) {
			continue;
		}
		$ids[] = $base . sanitize_title( $row['name'] );
	}
	return $ids;
}

/**
 * Stable @id used for the Industries ItemList cross-references.
 *
 * @return string
 */
function bis_schema_industries_list_id() {
	return trailingslashit( home_url( '/' ) ) . '#industries-list';
}

/**
 * Stable @id used for the Service ItemList / OfferCatalog cross-references.
 * Anchored to the home URL so it survives even if the services page slug
 * changes — the @id is an opaque IRI, not a fetchable URL.
 *
 * @return string
 */
function bis_schema_services_list_id() {
	return trailingslashit( home_url( '/' ) ) . '#services-list';
}

/**
 * Stable @id list for every published `service` CPT post.
 *
 * Mirrors the `@id` format used by BIS_Schema_Service_List so Organization's
 * `hasOfferCatalog` and the ItemList both resolve to the same Service nodes.
 *
 * @return string[]
 */
function bis_schema_service_ids() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$posts = get_posts(
		array(
			'post_type'      => 'service',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		)
	);

	$cache = array();
	foreach ( $posts as $service ) {
		$cache[] = get_permalink( $service ) . '#service';
	}

	return $cache;
}

/**
 * List of service titles used to fill `knowsAbout`.
 *
 * @return string[]
 */
function bis_schema_known_services() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$ids = get_posts(
		array(
			'post_type'      => 'service',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'fields'         => 'ids',
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);

	$cache = array_values(
		array_filter(
			array_map( 'get_the_title', $ids ),
			static function ( $title ) {
				return is_string( $title ) && '' !== trim( $title );
			}
		)
	);

	return $cache;
}

/**
 * Augment Yoast's Organization @graph node.
 *
 * @param array $data    Organization graph data.
 * @param mixed $context Yoast meta-tags context (unused, but Yoast passes it).
 * @return array
 */
function bis_augment_organization_schema( $data, $context = null ) {
	$info = bis_schema_org_data();

	if ( ! empty( $info['email'] ) ) {
		$data['email'] = $info['email'];
	}

	$address = array_filter(
		array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => isset( $info['street'] ) ? $info['street'] : '',
			'addressLocality' => isset( $info['locality'] ) ? $info['locality'] : '',
			'addressRegion'   => isset( $info['region'] ) ? $info['region'] : '',
			'postalCode'      => isset( $info['postal_code'] ) ? $info['postal_code'] : '',
			'addressCountry'  => isset( $info['country'] ) ? $info['country'] : '',
		),
		static function ( $v ) {
			return '' !== $v && null !== $v;
		}
	);
	if ( count( $address ) > 1 ) {
		$data['address'] = $address;
	}

	$contact_point = array_filter(
		array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'customer service',
			'email'             => isset( $info['email'] ) ? $info['email'] : '',
			'telephone'         => isset( $info['telephone'] ) ? $info['telephone'] : '',
			'areaServed'        => isset( $info['area_served'] ) ? $info['area_served'] : '',
			'availableLanguage' => ! empty( $info['languages'] ) ? array_values( (array) $info['languages'] ) : array(),
		),
		static function ( $v ) {
			return ( is_array( $v ) && ! empty( $v ) ) || ( ! is_array( $v ) && '' !== $v && null !== $v );
		}
	);
	if ( count( $contact_point ) > 1 ) {
		$data['contactPoint'] = array( $contact_point );
	}

	if ( ! empty( $info['founding_date'] ) ) {
		$data['foundingDate'] = $info['founding_date'];
	}

	if ( isset( $info['employee_count'] ) && '' !== $info['employee_count'] ) {
		$data['numberOfEmployees'] = array(
			'@type' => 'QuantitativeValue',
			'value' => (int) $info['employee_count'],
		);
	}

	if ( empty( $data['description'] ) && ! empty( $info['description'] ) ) {
		$data['description'] = $info['description'];
	}

	if ( ! empty( $info['area_served'] ) ) {
		$data['areaServed'] = $info['area_served'];
	}

	$known = bis_schema_known_services();
	if ( ! empty( $known ) ) {
		$data['knowsAbout'] = $known;
	}

	$data['founder'] = array( '@id' => bis_schema_founder_id() );

	$about_page_id = bis_schema_about_page_id();
	if ( $about_page_id ) {
		// `aboutPage` is not a valid Organization property in schema.org.
		// Use `subjectOf` to point to the dedicated About page.
		$data['subjectOf'] = get_permalink( $about_page_id );
	}

	// Only emit hasOfferCatalog on pages where the referenced Service nodes
	// are also in the @graph (front page + services), so every Offer.itemOffered
	// @id resolves and crawlers don't see dangling references.
	if ( is_front_page() || bis_is_services_page() ) {
		$service_ids = bis_schema_service_ids();
		if ( ! empty( $service_ids ) ) {
			$offers = array();
			foreach ( $service_ids as $sid ) {
				$offers[] = array(
					'@type'       => 'Offer',
					'itemOffered' => array( '@id' => $sid ),
				);
			}

			$catalog_anchor    = bis_schema_services_page_id() ? get_permalink( bis_schema_services_page_id() ) : trailingslashit( home_url( '/' ) );
			$data['hasOfferCatalog'] = array(
				'@type'           => 'OfferCatalog',
				'@id'             => $catalog_anchor . '#services-catalog',
				'name'            => __( 'BIS Service Catalog', 'bis' ),
				'itemListElement' => $offers,
			);
		}
	}

	// Merge member references from all relevant pages instead of overwriting
	// any existing `member` property Yoast/plugins may already provide.
	$incoming_member_ids = array();
	if ( bis_is_about_page() ) {
		$incoming_member_ids = array_merge( $incoming_member_ids, bis_schema_team_member_ids() );
	}
	if ( bis_is_team_page() ) {
		$incoming_member_ids = array_merge( $incoming_member_ids, bis_schema_team_page_member_ids() );
	}
	if ( ! empty( $incoming_member_ids ) ) {
		$member_map = array();

		// Normalize existing members (single object or list) into an @id map.
		if ( isset( $data['member'] ) && is_array( $data['member'] ) ) {
			$existing = isset( $data['member']['@id'] ) ? array( $data['member'] ) : $data['member'];
			foreach ( $existing as $member_ref ) {
				if ( is_array( $member_ref ) && ! empty( $member_ref['@id'] ) ) {
					$member_map[ (string) $member_ref['@id'] ] = array( '@id' => (string) $member_ref['@id'] );
				}
			}
		}

		// Add incoming references and dedupe by @id.
		foreach ( $incoming_member_ids as $member_id ) {
			$member_id = (string) $member_id;
			if ( '' !== $member_id ) {
				$member_map[ $member_id ] = array( '@id' => $member_id );
			}
		}

		if ( ! empty( $member_map ) ) {
			$data['member'] = array_values( $member_map );
		}
	}

	return $data;
}
add_filter( 'wpseo_schema_organization', 'bis_augment_organization_schema', 10, 2 );

/**
 * Build Person @ids for the team_members ACF rows on the About page.
 *
 * Returns an empty array when ACF or the field is unavailable; consumers
 * must guard for that case. The same logic powers the Person nodes emitted
 * by BIS_Schema_Team_Members so references and nodes always match.
 *
 * @return string[]
 */
function bis_schema_team_member_ids() {
	$rows = bis_schema_team_member_rows();
	if ( empty( $rows ) ) {
		return array();
	}

	$base = trailingslashit( home_url( '/' ) ) . '#person-';
	$ids  = array();
	foreach ( $rows as $row ) {
		if ( empty( $row['name'] ) ) {
			continue;
		}
		$ids[] = $base . sanitize_title( $row['name'] );
	}
	return $ids;
}

/**
 * Normalised list of team-member rows pulled from ACF on the About page.
 *
 * @return array<int,array<string,string>>
 */
function bis_schema_team_member_rows() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$cache = array();
	if ( ! function_exists( 'get_field' ) ) {
		return $cache;
	}

	$about_page_id = bis_schema_about_page_id();
	if ( ! $about_page_id ) {
		return $cache;
	}

	$members = get_field( 'team_members', $about_page_id );
	if ( ! is_array( $members ) || empty( $members ) ) {
		return $cache;
	}

	foreach ( $members as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$name = isset( $row['member_name'] ) ? trim( (string) $row['member_name'] ) : '';
		if ( '' === $name ) {
			continue;
		}
		$cache[] = array(
			'name'        => $name,
			'jobTitle'    => isset( $row['member_title'] ) ? (string) $row['member_title'] : '',
			'department'  => isset( $row['member_department'] ) ? (string) $row['member_department'] : '',
			'linkedin'    => isset( $row['member_linkedin'] ) ? (string) $row['member_linkedin'] : '',
			'image'       => isset( $row['member_image']['url'] ) ? (string) $row['member_image']['url'] : '',
			'description' => isset( $row['member_bio'] ) ? (string) $row['member_bio'] : '',
		);
	}

	return $cache;
}

/**
 * Augment Yoast's WebPage @graph node on the home page.
 *
 * Adds a `speakable` SpeakableSpecification (for voice assistants) and points
 * `mainEntity` at the services ItemList we register below.
 *
 * @param array $data    WebPage graph data.
 * @param mixed $context Yoast meta-tags context (unused).
 * @return array
 */
function bis_augment_webpage_schema( $data, $context = null ) {
	if ( bis_is_blog_page() ) {
		$data['@type']     = 'CollectionPage';
		$data['speakable'] = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1', '#blog-list-heading' ),
		);
		$data['mainEntity'] = array(
			'@id' => bis_schema_blog_list_id(),
		);

		$site_url = isset( $context->site_url ) ? $context->site_url : trailingslashit( home_url( '/' ) );
		$data['about'] = array( '@id' => $site_url . '#organization' );
		return $data;
	}

	if ( bis_is_team_page() ) {
		$data['@type']     = 'CollectionPage';
		$data['speakable'] = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1', '#team-list-heading' ),
		);
		$data['mainEntity'] = array(
			'@id' => bis_schema_team_list_id(),
		);

		$site_url = isset( $context->site_url ) ? $context->site_url : trailingslashit( home_url( '/' ) );
		$data['about'] = array( '@id' => $site_url . '#organization' );
		return $data;
	}

	if ( is_front_page() ) {
		$data['speakable'] = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1', '#why-choose-bis' ),
		);

		$data['mainEntity'] = array(
			'@id' => bis_schema_services_list_id(),
		);

		return $data;
	}

	if ( bis_is_about_page() ) {
		$data['@type']     = 'AboutPage';
		$data['speakable'] = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1', '#mission-heading', '#timeline-heading' ),
		);

		$site_url = isset( $context->site_url ) ? $context->site_url : trailingslashit( home_url( '/' ) );
		$data['about'] = array( '@id' => $site_url . '#organization' );

		return $data;
	}

	if ( bis_is_services_page() ) {
		// CollectionPage is the right schema.org type for a listing index of
		// related items (here: the 8 services).
		$data['@type']     = 'CollectionPage';
		$data['speakable'] = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1', '#services-list-heading' ),
		);

		$data['mainEntity'] = array(
			'@id' => bis_schema_services_list_id(),
		);

		return $data;
	}

	if ( is_singular( 'service' ) ) {
		// ItemPage is schema.org's recommended type for a detail page that
		// represents a single item (here: one service offering).
		$data['@type']      = 'ItemPage';
		$data['mainEntity'] = array(
			'@id' => get_permalink() . '#service',
		);
		$data['speakable']  = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1' ),
		);
		return $data;
	}

	if ( is_singular( 'post' ) ) {
		$data['@type']      = 'ItemPage';
		$data['mainEntity'] = array(
			'@id' => get_permalink() . '#article',
		);
		$data['speakable']  = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1' ),
		);
		return $data;
	}

	if ( bis_is_industries_page() ) {
		$data['@type']      = 'CollectionPage';
		$data['speakable']  = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1', '#industries-list-heading' ),
		);
		$data['mainEntity'] = array(
			'@id' => bis_schema_industries_list_id(),
		);
		return $data;
	}

	if ( is_singular( 'industry' ) ) {
		// Industry detail pages are marketing landing pages describing how
		// BIS serves a vertical. They aren't Service offerings themselves
		// (the catalog of 8 Services lives elsewhere), so we keep the
		// default WebPage type and just add speakable + about.
		$data['speakable'] = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1' ),
		);

		$site_url = isset( $context->site_url ) ? $context->site_url : trailingslashit( home_url( '/' ) );
		$data['about'] = array( '@id' => $site_url . '#organization' );
		return $data;
	}

	if ( bis_is_faq_page() ) {
		$questions = bis_schema_faq_questions();

		// Only upgrade @type to FAQPage when there's at least one well-
		// formed Q/A pair; an FAQPage with no mainEntity is invalid.
		if ( ! empty( $questions ) ) {
			$data['@type']      = 'FAQPage';
			$data['mainEntity'] = $questions;
		}

		$data['speakable'] = array(
			'@type'       => 'SpeakableSpecification',
			'cssSelector' => array( 'h1', '#faq-list-heading' ),
		);

		return $data;
	}

	return $data;
}
add_filter( 'wpseo_schema_webpage', 'bis_augment_webpage_schema', 10, 2 );

/**
 * Augment Yoast's Article node for single blog posts.
 *
 * @param array $data    Article graph data.
 * @param mixed $context Yoast meta-tags context.
 * @return array
 */
function bis_augment_article_schema( $data, $context = null ) {
	if ( ! is_singular( 'post' ) ) {
		return $data;
	}

	// Force blog posts to the more specific type.
	$data['@type'] = 'BlogPosting';

	$categories = get_the_category();
	if ( ! empty( $categories ) && is_array( $categories ) ) {
		$data['articleSection'] = array_values(
			array_filter(
				array_map(
					static function ( $term ) {
						return isset( $term->name ) ? (string) $term->name : '';
					},
					$categories
				)
			)
		);
	}

	$tags = get_the_tags();
	if ( ! empty( $tags ) && is_array( $tags ) ) {
		$data['keywords'] = array_values(
			array_filter(
				array_map(
					static function ( $term ) {
						return isset( $term->name ) ? (string) $term->name : '';
					},
					$tags
				)
			)
		);
	}

	$content = get_post_field( 'post_content', get_the_ID() );
	if ( is_string( $content ) && '' !== $content ) {
		$word_count = str_word_count( wp_strip_all_tags( $content ) );
		if ( $word_count > 0 ) {
			$data['wordCount'] = $word_count;
		}
	}

	return $data;
}
add_filter( 'wpseo_schema_article', 'bis_augment_article_schema', 10, 2 );

/**
 * Patch Yoast's BreadcrumbList so every position has an `item` URL.
 *
 * Recent Yoast versions intentionally omit `item` on the last (current-page)
 * entry — Google accepts that, but Schema.org validators and other crawlers
 * flag it as incomplete. This filter fills it in using the canonical URL
 * from Yoast's own context, falling back to the request URL.
 *
 * @param array $data    BreadcrumbList graph data.
 * @param mixed $context Yoast meta-tags context.
 * @return array
 */
function bis_augment_breadcrumb_schema( $data, $context = null ) {
	if ( empty( $data['itemListElement'] ) || ! is_array( $data['itemListElement'] ) ) {
		return $data;
	}

	$last_index = count( $data['itemListElement'] ) - 1;
	if ( $last_index < 0 ) {
		return $data;
	}

	$last = $data['itemListElement'][ $last_index ];
	if ( isset( $last['item'] ) && ! empty( $last['item'] ) ) {
		return $data;
	}

	$current_url = '';
	if ( is_object( $context ) && isset( $context->canonical ) && $context->canonical ) {
		$current_url = (string) $context->canonical;
	}
	if ( '' === $current_url && isset( $_SERVER['REQUEST_URI'] ) ) {
		$current_url = home_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
	}
	if ( '' === $current_url ) {
		return $data;
	}

	// URL string keeps BreadcrumbList lean and avoids duplicated @type expansion
	// in some validators when they resolve nested node references.
	$data['itemListElement'][ $last_index ]['item'] = $current_url;

	return $data;
}
add_filter( 'wpseo_schema_breadcrumb', 'bis_augment_breadcrumb_schema', 11, 2 );

/**
 * Register custom @graph pieces emitted only on the home page.
 *
 * @param array $pieces  Existing graph pieces.
 * @param mixed $context Yoast meta-tags context.
 * @return array
 */
function bis_register_schema_pieces( $pieces, $context ) {
	if ( ! class_exists( 'Yoast\\WP\\SEO\\Generators\\Schema\\Abstract_Schema_Piece' ) ) {
		return $pieces;
	}

	require_once get_template_directory() . '/inc/schema-pieces.php';

	// Founder Person node is emitted on every page so the Organization's
	// `founder` reference always resolves.
	$pieces[] = new BIS_Schema_Founder_Person( $context );

	if ( is_front_page() ) {
		$pieces[] = new BIS_Schema_Service_List( $context );
		$pieces[] = new BIS_Schema_Industry_List( $context );
	}

	if ( bis_is_blog_page() ) {
		$pieces[] = new BIS_Schema_Blog_Post_List( $context );
	}

	if ( bis_is_team_page() ) {
		$pieces[] = new BIS_Schema_Team_Page_Members( $context );
	}

	if ( bis_is_services_page() ) {
		$pieces[] = new BIS_Schema_Service_List( $context );
	}

	if ( bis_is_industries_page() ) {
		$pieces[] = new BIS_Schema_Industry_List( $context );
	}

	if ( is_singular( 'service' ) ) {
		$pieces[] = new BIS_Schema_Service_Single( $context );
	}

	if ( bis_is_about_page() ) {
		$pieces[] = new BIS_Schema_Team_Members( $context );
	}

	return $pieces;
}
add_filter( 'wpseo_schema_graph_pieces', 'bis_register_schema_pieces', 11, 2 );
