<?php
/**
 * Custom Yoast SEO @graph pieces.
 *
 * Loaded lazily by inc/schema.php only on the homepage and only when Yoast's
 * abstract piece class is available, so this file can safely assume the parent
 * class exists.
 *
 * @package BIS
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Yoast\\WP\\SEO\\Generators\\Schema\\Abstract_Schema_Piece' ) ) {
	return;
}

/**
 * Build a Service @graph node for a single `service` CPT post.
 *
 * Single source of truth for Service node shape so that the homepage
 * ItemList, the services index page list, and the single-service detail
 * page all emit identical nodes (de-duplicated by @id).
 *
 * @param WP_Post|int $post                Service post or ID.
 * @param string      $organization_id     @id of the Organization node.
 * @param string|null $main_entity_of_page Optional WebPage @id this service is the main entity of.
 * @return array
 */
function bis_schema_build_service_node( $post, $organization_id, $main_entity_of_page = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return array();
	}

	$permalink = get_permalink( $post );

	$description = '';
	if ( function_exists( 'get_field' ) ) {
		$description = (string) get_field( 'introtext', $post->ID );
	}
	if ( '' === $description ) {
		$description = (string) get_the_excerpt( $post );
	}
	$description = wp_strip_all_tags( $description );
	$description = wp_trim_words( $description, 60, '…' );

	$node = array(
		'@type'       => 'Service',
		'@id'         => $permalink . '#service',
		'name'        => get_the_title( $post ),
		'url'         => $permalink,
		'serviceType' => get_the_title( $post ),
		'provider'    => array( '@id' => $organization_id ),
		'areaServed'  => array(
			'@type' => 'Country',
			'name'  => 'United States',
		),
	);

	if ( '' !== $description ) {
		$node['description'] = $description;
	}

	$image_id = get_post_thumbnail_id( $post->ID );
	if ( $image_id ) {
		$image_url = wp_get_attachment_image_url( $image_id, 'full' );
		if ( $image_url ) {
			$node['image'] = $image_url;
		}
	}

	if ( $main_entity_of_page ) {
		$node['mainEntityOfPage'] = array( '@id' => $main_entity_of_page );
	}

	return $node;
}

/**
 * Build a structured Occupation node from a person's job title.
 *
 * @param string $job_title Job title text.
 * @return array
 */
function bis_schema_person_occupation( $job_title ) {
	$job_title = trim( (string) $job_title );
	if ( '' === $job_title ) {
		return array();
	}

	return array(
		'@type' => 'Occupation',
		'name'  => $job_title,
	);
}

/**
 * Extract consistent knowsAbout topics from a person's bio and role.
 *
 * @param string $bio       Biography text.
 * @param string $job_title Job title text.
 * @param string $extra     Optional extra context (department, etc.).
 * @return string[]
 */
function bis_schema_person_knows_about( $bio, $job_title = '', $extra = '' ) {
	$haystack = strtolower(
		wp_strip_all_tags(
			trim( (string) $bio . ' ' . (string) $job_title . ' ' . (string) $extra )
		)
	);
	if ( '' === $haystack ) {
		return array();
	}

	$topic_map = array(
		'American Sign Language (ASL)' => array( ' asl ', 'american sign language', 'sign language' ),
		'Deaf accessibility'           => array( 'deaf access', 'deaf accessibility', 'deaf community', 'hard-of-hearing', 'hoh' ),
		'Accessibility compliance'     => array( 'accessibility', 'ada', 'compliance' ),
		'Video Remote Interpreting (VRI)' => array( 'vri', 'video remote interpreting' ),
		'CART and captioning'          => array( 'cart', 'captioning', 'captions' ),
		'Interpreter services'         => array( 'interpreter', 'interpreting' ),
		'Operations management'        => array( 'operations', 'operational' ),
		'Executive leadership'         => array( 'chief executive', 'ceo', 'executive', 'leadership', 'founder', 'vp' ),
		'Government accessibility services' => array( 'government', 'federal', 'state agencies', 'public sector' ),
		'Healthcare accessibility services' => array( 'healthcare', 'hospital', 'medical' ),
		'Education accessibility services' => array( 'education', 'school', 'university', 'academic' ),
	);

	$topics = array();
	foreach ( $topic_map as $topic => $needles ) {
		foreach ( $needles as $needle ) {
			if ( false !== strpos( $haystack, trim( $needle ) ) ) {
				$topics[] = $topic;
				break;
			}
		}
	}

	return array_values( array_unique( $topics ) );
}

if ( ! class_exists( 'BIS_Schema_Piece_Base' ) ) {
	/**
	 * Thin local base class so we don't repeat boilerplate per piece.
	 */
	abstract class BIS_Schema_Piece_Base extends \Yoast\WP\SEO\Generators\Schema\Abstract_Schema_Piece {

		/**
		 * Always emitted; gating happens in the registrar (homepage only).
		 *
		 * @return bool
		 */
		public function is_needed() {
			return true;
		}

		/**
		 * Helper: resolve the @id Yoast uses for the Organization node.
		 *
		 * @return string
		 */
		protected function organization_id() {
			$site = isset( $this->context->site_url ) ? $this->context->site_url : trailingslashit( home_url( '/' ) );
			return $site . '#organization';
		}

		/**
		 * Helper: resolve the @id Yoast uses for the home WebPage node.
		 *
		 * @return string
		 */
		protected function home_webpage_id() {
			$site = isset( $this->context->site_url ) ? $this->context->site_url : trailingslashit( home_url( '/' ) );
			return $site . '#webpage';
		}
	}
}

/**
 * Emits one Service node per published "service" CPT post plus an ItemList
 * that ties them to the home WebPage as `mainEntity`.
 *
 * Yoast accepts an indexed array from generate() and flattens it into the
 * graph, so we can emit several nodes from a single piece.
 */
class BIS_Schema_Service_List extends BIS_Schema_Piece_Base {

	/**
	 * @return array
	 */
	public function generate() {
		$services = get_posts(
			array(
				'post_type'      => 'service',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
			)
		);

		if ( empty( $services ) ) {
			return array();
		}

		$org_id        = $this->organization_id();
		$service_nodes = array();
		$list_items    = array();
		$position      = 1;

		foreach ( $services as $service ) {
			$node = bis_schema_build_service_node( $service, $org_id );
			if ( empty( $node ) ) {
				continue;
			}

			$service_nodes[] = $node;

			$list_items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'url'      => $node['url'],
				'name'     => $node['name'],
				'item'     => array( '@id' => $node['@id'] ),
			);
			++$position;
		}

		$item_list = array(
			'@type'           => 'ItemList',
			'@id'             => function_exists( 'bis_schema_services_list_id' )
				? bis_schema_services_list_id()
				: trailingslashit( home_url( '/' ) ) . '#services-list',
			'name'            => __( 'Services offered by BIS', 'bis' ),
			'numberOfItems'   => count( $list_items ),
			'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
			'itemListElement' => $list_items,
		);

		// Indexed array → Yoast inlines each entry as a top-level graph node.
		return array_merge( $service_nodes, array( $item_list ) );
	}
}

/**
 * Emits the canonical Service node on a single `service` CPT detail page,
 * with `mainEntityOfPage` pointing back to the WebPage so crawlers know
 * this URL is the service's primary location.
 */
class BIS_Schema_Service_Single extends BIS_Schema_Piece_Base {

	/**
	 * @return array
	 */
	public function generate() {
		if ( ! is_singular( 'service' ) ) {
			return array();
		}

		$post = get_queried_object();
		if ( ! $post || 'service' !== $post->post_type ) {
			return array();
		}

		$webpage_id = get_permalink( $post ) . '#webpage';

		return bis_schema_build_service_node(
			$post,
			$this->organization_id(),
			$webpage_id
		);
	}
}

/**
 * Emits the founder Person node on every page so the Organization's
 * `founder` @id reference always resolves.
 */
class BIS_Schema_Founder_Person extends BIS_Schema_Piece_Base {

	/**
	 * @return array
	 */
	public function generate() {
		$founder = bis_schema_founder_data();
		if ( empty( $founder['name'] ) ) {
			return array();
		}

		$node = array(
			'@type'         => 'Person',
			'@id'           => bis_schema_founder_id(),
			'name'          => $founder['name'],
			'foundedCompany' => array( '@id' => $this->organization_id() ),
		);

		if ( ! empty( $founder['jobTitle'] ) ) {
			$node['jobTitle'] = $founder['jobTitle'];
		}
		if ( ! empty( $founder['description'] ) ) {
			$node['description'] = $founder['description'];
		}
		if ( ! empty( $founder['image'] ) ) {
			$node['image'] = $founder['image'];
		}
		if ( ! empty( $founder['sameAs'] ) && is_array( $founder['sameAs'] ) ) {
			$node['sameAs'] = array_values( array_filter( $founder['sameAs'] ) );
		}

		return $node;
	}
}

/**
 * Emits one Person node per ACF team_members row on the About page.
 *
 * Names, titles, departments, photos, LinkedIn URLs and bios are all sourced
 * from ACF so the structured data stays in sync with the rendered page —
 * no hardcoded staffing.
 */
class BIS_Schema_Team_Members extends BIS_Schema_Piece_Base {

	/**
	 * @return array
	 */
	public function generate() {
		$rows = function_exists( 'bis_schema_team_member_rows' ) ? bis_schema_team_member_rows() : array();
		if ( empty( $rows ) ) {
			return array();
		}

		$base_id = trailingslashit( home_url( '/' ) ) . '#person-';
		$nodes   = array();

		foreach ( $rows as $row ) {
			$slug = sanitize_title( $row['name'] );
			$node = array(
				'@type'    => 'Person',
				'@id'      => $base_id . $slug,
				'name'     => $row['name'],
				'worksFor' => array( '@id' => $this->organization_id() ),
			);

			if ( ! empty( $row['jobTitle'] ) ) {
				$node['jobTitle'] = $row['jobTitle'];
				$occupation = bis_schema_person_occupation( $row['jobTitle'] );
				if ( ! empty( $occupation ) ) {
					$node['hasOccupation'] = $occupation;
				}
			}
			if ( ! empty( $row['department'] ) ) {
				$node['memberOf'] = array(
					'@type' => 'OrganizationRole',
					'roleName' => $row['department'],
				);
			}
			if ( ! empty( $row['image'] ) ) {
				$node['image'] = $row['image'];
			}
			if ( ! empty( $row['linkedin'] ) ) {
				$node['sameAs'] = array( $row['linkedin'] );
			}
			if ( ! empty( $row['description'] ) ) {
				$bio = wp_strip_all_tags( $row['description'] );
				$bio = wp_trim_words( $bio, 80, '…' );
				if ( '' !== $bio ) {
					$node['description'] = $bio;
				}
			}
			$knows_about = bis_schema_person_knows_about(
				isset( $row['description'] ) ? $row['description'] : '',
				isset( $row['jobTitle'] ) ? $row['jobTitle'] : '',
				isset( $row['department'] ) ? $row['department'] : ''
			);
			if ( ! empty( $knows_about ) ) {
				$node['knowsAbout'] = $knows_about;
			}

			$nodes[] = $node;
		}

		return $nodes;
	}
}

/**
 * Emits an ItemList of blog posts for the blog listing page.
 */
class BIS_Schema_Blog_Post_List extends BIS_Schema_Piece_Base {

	/**
	 * @return array
	 */
	public function generate() {
		$posts = get_posts(
			array(
				'post_type'      => 'post',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		if ( empty( $posts ) ) {
			return array();
		}

		$items    = array();
		$position = 1;
		foreach ( $posts as $post ) {
			$item = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'url'      => get_permalink( $post ),
				'name'     => get_the_title( $post ),
			);

			$excerpt = trim( wp_strip_all_tags( (string) get_the_excerpt( $post ) ) );
			if ( '' !== $excerpt ) {
				$item['description'] = wp_trim_words( $excerpt, 35, '…' );
			}

			$published = get_the_date( DATE_W3C, $post );
			if ( $published ) {
				$item['dateCreated'] = $published;
			}

			$image_id = get_post_thumbnail_id( $post->ID );
			if ( $image_id ) {
				$image_url = wp_get_attachment_image_url( $image_id, 'large' );
				if ( $image_url ) {
					$item['image'] = $image_url;
				}
			}

			$items[] = $item;
			++$position;
		}

		return array(
			'@type'           => 'ItemList',
			'@id'             => function_exists( 'bis_schema_blog_list_id' )
				? bis_schema_blog_list_id()
				: trailingslashit( home_url( '/' ) ) . '#blog-posts-list',
			'name'            => __( 'BIS Blog posts', 'bis' ),
			'numberOfItems'   => count( $items ),
			'itemListOrder'   => 'https://schema.org/ItemListOrderDescending',
			'itemListElement' => $items,
		);
	}
}

/**
 * Emits Team-page Person nodes plus an ItemList that points to them.
 */
class BIS_Schema_Team_Page_Members extends BIS_Schema_Piece_Base {

	/**
	 * @return array
	 */
	public function generate() {
		$rows = function_exists( 'bis_schema_team_page_member_rows' ) ? bis_schema_team_page_member_rows() : array();
		if ( empty( $rows ) ) {
			return array();
		}

		$base_id      = trailingslashit( home_url( '/' ) ) . '#person-';
		$person_nodes = array();
		$list_items   = array();
		$position     = 1;

		foreach ( $rows as $row ) {
			$name = isset( $row['name'] ) ? trim( (string) $row['name'] ) : '';
			if ( '' === $name ) {
				continue;
			}

			$person_id = $base_id . sanitize_title( $name );
			$node      = array(
				'@type'    => 'Person',
				'@id'      => $person_id,
				'name'     => $name,
				'worksFor' => array( '@id' => $this->organization_id() ),
			);

			if ( ! empty( $row['jobTitle'] ) ) {
				$node['jobTitle'] = $row['jobTitle'];
				$occupation = bis_schema_person_occupation( $row['jobTitle'] );
				if ( ! empty( $occupation ) ) {
					$node['hasOccupation'] = $occupation;
				}
			}
			if ( ! empty( $row['image'] ) ) {
				$node['image'] = $row['image'];
			}
			if ( ! empty( $row['linkedin'] ) ) {
				$node['sameAs'] = array( $row['linkedin'] );
			}
			if ( ! empty( $row['description'] ) ) {
				$bio = wp_strip_all_tags( $row['description'] );
				$bio = wp_trim_words( $bio, 80, '...' );
				if ( '' !== $bio ) {
					$node['description'] = $bio;
				}
			}
			$knows_about = bis_schema_person_knows_about(
				isset( $row['description'] ) ? $row['description'] : '',
				isset( $row['jobTitle'] ) ? $row['jobTitle'] : ''
			);
			if ( ! empty( $knows_about ) ) {
				$node['knowsAbout'] = $knows_about;
			}

			$person_nodes[] = $node;
			$list_items[]   = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => $name,
				'item'     => array( '@id' => $person_id ),
			);
			++$position;
		}

		if ( empty( $list_items ) ) {
			return array();
		}

		$item_list = array(
			'@type'           => 'ItemList',
			'@id'             => function_exists( 'bis_schema_team_list_id' )
				? bis_schema_team_list_id()
				: trailingslashit( home_url( '/' ) ) . '#team-members-list',
			'name'            => __( 'BIS team members', 'bis' ),
			'numberOfItems'   => count( $list_items ),
			'itemListOrder'   => 'https://schema.org/ItemListUnordered',
			'itemListElement' => $list_items,
		);

		return array_merge( $person_nodes, array( $item_list ) );
	}
}

/**
 * Emits a single ItemList of industry CPT posts shown on the homepage.
 */
class BIS_Schema_Industry_List extends BIS_Schema_Piece_Base {

	/**
	 * @return array
	 */
	public function generate() {
		$industries = get_posts(
			array(
				'post_type'      => 'industry',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
			)
		);

		if ( empty( $industries ) ) {
			return array();
		}

		$items    = array();
		$position = 1;
		foreach ( $industries as $industry ) {
			$item = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'url'      => get_permalink( $industry ),
				'name'     => get_the_title( $industry ),
			);

			$image_id = get_post_thumbnail_id( $industry->ID );
			if ( $image_id ) {
				$image_url = wp_get_attachment_image_url( $image_id, 'large' );
				if ( $image_url ) {
					$item['image'] = $image_url;
				}
			}

			$items[] = $item;
			++$position;
		}

		return array(
			'@type'           => 'ItemList',
			'@id'             => function_exists( 'bis_schema_industries_list_id' )
				? bis_schema_industries_list_id()
				: trailingslashit( home_url( '/' ) ) . '#industries-list',
			'name'            => __( 'Industries served by BIS', 'bis' ),
			'numberOfItems'   => count( $items ),
			'itemListOrder'   => 'https://schema.org/ItemListUnordered',
			'itemListElement' => $items,
		);
	}
}
