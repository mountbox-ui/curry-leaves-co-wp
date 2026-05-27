<?php
/**
 * Homepage data helpers and defaults.
 *
 * @package Curry_Leaves_Co
 */

defined( 'ABSPATH' ) || exit;

/**
 * Path to theme logo file.
 *
 * @return string
 */
function clc_logo_path() {
	return get_template_directory() . '/assets/images/logo.png';
}

/**
 * URL to theme logo.
 *
 * @return string
 */
function clc_logo_url() {
	return get_template_directory_uri() . '/assets/images/logo.png';
}

/**
 * Whether logo.png exists in the theme.
 *
 * @return bool
 */
function clc_has_logo() {
	return file_exists( clc_logo_path() );
}

/**
 * Output site logo image (or text fallback).
 *
 * @param array<string, mixed> $args Optional arguments.
 */
function clc_the_logo( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class'       => 'site-logo',
			'height'      => 48,
			'show_tagline' => false,
			'tagline'     => 'Takeaway · NZ',
		)
	);

	if ( clc_has_logo() ) {
		printf(
			'<img src="%1$s" alt="%2$s" class="%3$s" width="auto" height="%4$d" loading="eager" decoding="async" />',
			esc_url( clc_logo_url() ),
			esc_attr( get_bloginfo( 'name' ) ),
			esc_attr( $args['class'] ),
			(int) $args['height']
		);
		if ( $args['show_tagline'] && $args['tagline'] ) {
			printf( '<span class="nav-logo-tag">%s</span>', esc_html( $args['tagline'] ) );
		}
		return;
	}

	printf( '<span class="nav-logo-text">%s</span>', esc_html( get_bloginfo( 'name' ) ) );
	if ( $args['show_tagline'] && $args['tagline'] ) {
		printf( '<span class="nav-logo-tag">%s</span>', esc_html( $args['tagline'] ) );
	}
}

/**
 * Theme mod with default fallback.
 *
 * @param string $key     Theme mod key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function clc_mod( $key, $default = '' ) {
	$value = get_theme_mod( $key, $default );
	return ( '' === $value && '' !== $default ) ? $default : $value;
}

/**
 * Image URL from theme mod or default.
 *
 * @param string $key     Theme mod key.
 * @param string $default Default URL.
 * @return string
 */
function clc_image_url( $key, $default ) {
	$id = absint( get_theme_mod( $key, 0 ) );
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	$direct = clc_mod( $key . '_url', '' );
	return $direct ? $direct : $default;
}

/**
 * Default placeholder food imagery (Unsplash, royalty-free).
 *
 * @return array<int, string>
 */
function clc_default_food_images() {
	return array(
		'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1920&q=80',
		'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1920&q=80',
		'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=1920&q=80',
		'https://images.unsplash.com/photo-1544025162-d76694265947?w=1920&q=80',
		'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1920&q=80',
	);
}

/**
 * Hero slides (3–5 editable via Customizer).
 *
 * @return array<int, array<string, string>>
 */
function clc_get_hero_slides() {
	$defaults = array(
		array(
			'title'    => 'Experience <em>Premium Takeaway</em> in New Zealand',
			'subtitle' => 'Curated Gourmet · Pickup Only',
			'desc'     => 'Chef-crafted dishes prepared fresh for collection. No dining, no delivery — pure luxury takeaway.',
			'cta1'     => 'Order Your Dish',
			'cta1_url' => '#order',
			'cta2'     => 'View Menu',
			'cta2_url' => '#menu',
		),
		array(
			'title'    => 'Where <em>Luxury</em> Meets Flavor',
			'subtitle' => 'New Zealand Inspired Cuisine',
			'desc'     => 'Warm textures, golden accents, and unforgettable taste — ready when you arrive.',
			'cta1'     => 'Order Your Dish',
			'cta1_url' => '#order',
			'cta2'     => 'Our Specials',
			'cta2_url' => '#specials',
		),
		array(
			'title'    => 'Cinematic <em>Food</em> Artistry',
			'subtitle' => 'Takeaway Reimagined',
			'desc'     => 'Every plate composed like fine dining — packaged for your premium pickup experience.',
			'cta1'     => 'Order Your Dish',
			'cta1_url' => '#order',
			'cta2'     => 'Gallery',
			'cta2_url' => '#gallery',
		),
	);

	$images = clc_default_food_images();
	$slides = array();

	for ( $i = 1; $i <= 5; $i++ ) {
		$enabled = clc_mod( "clc_hero_{$i}_enabled", $i <= 3 ? '1' : '0' );
		if ( '0' === $enabled ) {
			continue;
		}

		$def = $defaults[ ( $i - 1 ) % count( $defaults ) ];
		$slides[] = array(
			'title'    => clc_mod( "clc_hero_{$i}_title", $def['title'] ),
			'subtitle' => clc_mod( "clc_hero_{$i}_subtitle", $def['subtitle'] ),
			'desc'     => clc_mod( "clc_hero_{$i}_desc", $def['desc'] ),
			'image'    => clc_image_url( "clc_hero_{$i}_image", $images[ ( $i - 1 ) % count( $images ) ] ),
			'cta1'     => clc_mod( "clc_hero_{$i}_cta1", $def['cta1'] ),
			'cta1_url' => clc_mod( "clc_hero_{$i}_cta1_url", $def['cta1_url'] ),
			'cta2'     => clc_mod( "clc_hero_{$i}_cta2", $def['cta2'] ),
			'cta2_url' => clc_mod( "clc_hero_{$i}_cta2_url", $def['cta2_url'] ),
		);
	}

	return ! empty( $slides ) ? $slides : array_map(
		function ( $def, $idx ) use ( $images ) {
			return array_merge( $def, array( 'image' => $images[ $idx % count( $images ) ] ) );
		},
		$defaults,
		array_keys( $defaults )
	);
}

/**
 * Experience stats.
 *
 * @return array<int, array<string, string>>
 */
function clc_get_stats() {
	return array(
		array(
			'number' => clc_mod( 'clc_stat_1_number', '15+' ),
			'label'  => clc_mod( 'clc_stat_1_label', 'Years Experience' ),
		),
		array(
			'number' => clc_mod( 'clc_stat_2_number', '50+' ),
			'label'  => clc_mod( 'clc_stat_2_label', 'Signature Dishes' ),
		),
		array(
			'number' => clc_mod( 'clc_stat_3_number', '10k+' ),
			'label'  => clc_mod( 'clc_stat_3_label', 'Happy Customers' ),
		),
	);
}

/**
 * Static dish card when no CPT items.
 *
 * @return array<int, array<string, mixed>>
 */
function clc_default_dishes() {
	$img = clc_default_food_images();
	return array(
		array( 'name' => 'Herb-Crusted Lamb Rack', 'desc' => 'Slow-roasted with rosemary jus and seasonal vegetables.', 'price' => '42', 'cat' => 'grill', 'image' => $img[3], 'rating' => '4.9' ),
		array( 'name' => 'Pan-Seared Snapper', 'desc' => 'NZ snapper, citrus butter, micro herbs.', 'price' => '38', 'cat' => 'seafood', 'image' => $img[1], 'rating' => '4.8' ),
		array( 'name' => 'Chef\'s Tasting Box', 'desc' => 'Five-course takeaway selection — chef curated.', 'price' => '65', 'cat' => 'chef-specials', 'image' => $img[2], 'rating' => '5.0' ),
		array( 'name' => 'Dark Chocolate Fondant', 'desc' => 'Valrhona chocolate, gold leaf, berry coulis.', 'price' => '18', 'cat' => 'desserts', 'image' => $img[4], 'rating' => '4.9' ),
		array( 'name' => 'Wagyu Beef Sliders', 'desc' => 'Triple stack, truffle aioli, brioche.', 'price' => '28', 'cat' => 'grill', 'image' => $img[0], 'rating' => '4.7' ),
		array( 'name' => 'Lobster Thermidor', 'desc' => 'Classic preparation, gruyère crust.', 'price' => '52', 'cat' => 'seafood', 'image' => $img[1], 'rating' => '4.9' ),
	);
}

/**
 * Dishes from menu_item CPT or defaults.
 *
 * @param int $limit Max items.
 * @return array<int, array<string, mixed>>
 */
function clc_get_dishes( $limit = 12 ) {
	$query = new WP_Query(
		array(
			'post_type'      => 'menu_item',
			'posts_per_page' => $limit,
			'post_status'    => 'publish',
		)
	);

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return clc_default_dishes();
	}

	$dishes = array();
	$images = clc_default_food_images();
	$i      = 0;

	while ( $query->have_posts() ) {
		$query->the_post();
		$id = get_the_ID();
		$terms = get_the_terms( $id, 'menu_category' );
		$cat = 'chef-specials';
		if ( $terms && ! is_wp_error( $terms ) ) {
			$slugs = wp_list_pluck( $terms, 'slug' );
			$cat = implode( ' ', $slugs );
		}
		$store_terms = get_the_terms( $id, 'store_category' );
		$store_name = '';
		if ( $store_terms && ! is_wp_error( $store_terms ) ) {
			$store_name = implode( ', ', wp_list_pluck( $store_terms, 'name' ) );
		}
		$thumb = get_the_post_thumbnail_url( $id, 'large' );
		$dishes[] = array(
			'name'    => get_the_title(),
			'desc'    => has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 18 ),
			'price'   => get_post_meta( $id, '_menu_item_price', true ) ?: '24',
			'cat'     => $cat,
			'store'   => $store_name,
			'image'   => $thumb ?: $images[ $i % count( $images ) ],
			'rating'  => get_post_meta( $id, '_menu_item_rating', true ) ?: '4.8',
			'link'    => get_permalink(),
		);
		++$i;
	}
	wp_reset_postdata();

	return $dishes;
}

/**
 * Get the store category term used for favourite dishes.
 *
 * @return WP_Term|false
 */
function curry_leaves_co_get_store_term( $slugs = array(), $names = array() ) {
	foreach ( (array) $slugs as $slug ) {
		$term = get_term_by( 'slug', $slug, 'store_category' );
		if ( $term && ! is_wp_error( $term ) ) {
			return $term;
		}
	}

	foreach ( (array) $names as $name ) {
		$term = get_term_by( 'name', $name, 'store_category' );
		if ( $term && ! is_wp_error( $term ) ) {
			return $term;
		}
	}

	return false;
}

/**
 * Dishes from a named store category, or fallback to default dishes.
 *
 * @param string $store_key Store slug or name.
 * @param int    $limit     Max items.
 * @return array<int, array<string, mixed>>
 */
function clc_get_store_dishes( $store_key, $limit = 12 ) {
	$possible_slugs = array( sanitize_title( $store_key ), $store_key );
	$possible_names = array( ucwords( str_replace( array( '-', '_' ), ' ', $store_key ) ), $store_key );
	$term = curry_leaves_co_get_store_term( $possible_slugs, $possible_names );
	if ( ! $term ) {
		return clc_get_dishes( $limit );
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'menu_item',
			'posts_per_page' => $limit,
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'store_category',
					'field'    => 'term_id',
					'terms'    => $term->term_id,
				),
			),
		)
	);

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return clc_get_dishes( $limit );
	}

	$dishes = array();
	$images = clc_default_food_images();
	$i      = 0;

	while ( $query->have_posts() ) {
		$query->the_post();
		$id = get_the_ID();
		$terms = get_the_terms( $id, 'menu_category' );
		$cat = 'chef-specials';
		if ( $terms && ! is_wp_error( $terms ) ) {
			$slugs = wp_list_pluck( $terms, 'slug' );
			$cat = implode( ' ', $slugs );
		}
		$store_terms = get_the_terms( $id, 'store_category' );
		$store_name = '';
		if ( $store_terms && ! is_wp_error( $store_terms ) ) {
			$store_name = implode( ', ', wp_list_pluck( $store_terms, 'name' ) );
		}
		$thumb = get_the_post_thumbnail_url( $id, 'large' );
		$dishes[] = array(
			'name'    => get_the_title(),
			'desc'    => has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 18 ),
			'price'   => get_post_meta( $id, '_menu_item_price', true ) ?: '24',
			'cat'     => $cat,
			'store'   => $store_name,
			'image'   => $thumb ?: $images[ $i % count( $images ) ],
			'rating'  => get_post_meta( $id, '_menu_item_rating', true ) ?: '4.8',
			'link'    => get_permalink(),
		);
		++$i;
	}
	wp_reset_postdata();

	return $dishes;
}

/**
 * Dishes from the store "Favourites" category or fallback to default dishes.
 *
 * @param int $limit Max items.
 * @return array<int, array<string, mixed>>
 */
function clc_get_store_favorite_dishes( $limit = 12 ) {
	return clc_get_store_dishes( 'favourites', $limit );
}

/**
 * Filter dishes by category slug.
 *
 * @param array  $dishes   Dishes array.
 * @param string $category Category slug or 'all'.
 * @return array
 */
function clc_filter_dishes( $dishes, $category ) {
	if ( 'all' === $category ) {
		return $dishes;
	}
	return array_values(
		array_filter(
			$dishes,
			function ( $d ) use ( $category ) {
				return isset( $d['cat'] ) && $d['cat'] === $category;
			}
		)
	);
}

/**
 * Phone number for CTAs.
 *
 * @return string
 */
function clc_phone() {
	return clc_mod( 'clc_phone', '+6491234567' );
}

/**
 * Phone tel: href.
 *
 * @return string
 */
function clc_phone_href() {
	return 'tel:' . preg_replace( '/\s+/', '', clc_phone() );
}

/**
 * Is luxury homepage (front page).
 *
 * @return bool
 */
function clc_is_luxury_home() {
	return is_front_page();
}
