<?php
/**
 * Curry Leaves Co functions and definitions
 */

function curry_leaves_co_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'curry-leaves-co' ),
    ) );

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'curry_leaves_co_setup' );

/**
 * Enqueue scripts and styles.
 */
function curry_leaves_co_scripts() {
    // Enqueue the main style.css
    wp_enqueue_style( 'curry-leaves-co-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    // Enqueue the Tailwind generated CSS
    wp_enqueue_style( 'curry-leaves-co-tailwind', get_template_directory_uri() . '/assets/css/app.css', array(), filemtime( get_template_directory() . '/assets/css/app.css' ) );

    if ( is_front_page() || is_page_template( 'templates/template-menu.php' ) ) {
        wp_enqueue_script(
            'curry-leaves-co-homepage',
            get_template_directory_uri() . '/assets/js/homepage.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/homepage.js' ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'curry_leaves_co_scripts' );

/**
 * Theme helpers (logo, homepage data) and Customizer.
 */
require_once get_template_directory() . '/inc/homepage-helpers.php';
require_once get_template_directory() . '/inc/homepage-customizer.php';

/**
 * Load Custom Post Types and Taxonomies
 */
require_once get_template_directory() . '/inc/custom-post-types-menu.php';
require_once get_template_directory() . '/inc/custom-store-categories.php';


/**
 * Template Routing for Menu Items
 */
add_filter( 'template_include', function( $template ) {
    if ( is_singular( 'menu_item' ) ) {
        $new_template = get_template_directory() . '/menu/single-menu_item.php';
        if ( file_exists( $new_template ) ) {
            return $new_template;
        }
    }
    if ( is_post_type_archive( 'menu_item' ) ) {
        $new_template = get_template_directory() . '/menu/archive-menu_item.php';
        if ( file_exists( $new_template ) ) {
            return $new_template;
        }
    }
    return $template;
});
