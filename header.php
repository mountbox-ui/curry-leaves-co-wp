<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header border-b border-gray-200 bg-white" role="banner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-wrap items-center justify-between gap-4">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand flex items-center">
            <?php
            if ( function_exists( 'clc_has_logo' ) && clc_has_logo() ) {
                clc_the_logo( array( 'class' => 'site-logo site-logo--simple', 'height' => 40, 'show_tagline' => false ) );
            } else {
                ?>
                <span class="text-xl font-bold text-gray-900"><?php bloginfo( 'name' ); ?></span>
                <?php
            }
            ?>
        </a>

        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'container'      => 'nav',
                'container_class'  => 'site-nav',
                'menu_class'       => 'flex flex-wrap gap-4 text-sm font-medium text-gray-700',
                'fallback_cb'    => false,
            )
        );
        ?>
    </div>
</header>
