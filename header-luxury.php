<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'luxury-home' ); ?>>
<?php wp_body_open(); ?>

<div class="page-loader" aria-hidden="true">
	<div class="loader-content">
		<div class="loader-logo">
			<?php clc_the_logo( array( 'class' => 'site-logo site-logo--loader', 'height' => 72, 'show_tagline' => false ) ); ?>
		</div>
		<div class="loader-bar"></div>
	</div>
</div>

<div class="mouse-glow" aria-hidden="true"></div>

<header class="luxury-nav" id="luxury-nav" role="banner">
	<div class="nav-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo<?php echo clc_has_logo() ? ' nav-logo--image' : ''; ?>" aria-label="<?php bloginfo( 'name' ); ?>">
			<?php clc_the_logo( array( 'height' => 48, 'show_tagline' => ! clc_has_logo(), 'tagline' => 'Takeaway · NZ' ) ); ?>
		</a>

		<nav role="navigation" aria-label="<? esc_attr_e( 'Primary', 'curry-leaves-co' ); ?>">
			<ul class="nav-links">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'curry-leaves-co' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'curry-leaves-co' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/menu-listing' ) ); ?>"><?php esc_html_e( 'Menu', 'curry-leaves-co' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#specials' ) ); ?>"><?php esc_html_e( 'Specials', 'curry-leaves-co' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#gallery' ) ); ?>"><?php esc_html_e( 'Gallery', 'curry-leaves-co' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#testimonials' ) ); ?>"><?php esc_html_e( 'Testimonials', 'curry-leaves-co' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'curry-leaves-co' ); ?></a></li>
			</ul>
		</nav>

		<a href="<?php echo esc_url( clc_phone_href() ); ?>" class="nav-reserve-btn"><?php esc_html_e( 'Call to Order', 'curry-leaves-co' ); ?></a>

		<button type="button" class="hamburger" id="hamburger" aria-label="<? esc_attr_e( 'Toggle menu', 'curry-leaves-co' ); ?>" aria-expanded="false">
			<span></span><span></span><span></span>
		</button>
	</div>
</header>

<nav class="mobile-menu" id="mobile-menu" aria-label="<? esc_attr_e( 'Mobile navigation', 'curry-leaves-co' ); ?>">
	<button type="button" class="mobile-menu-close" aria-label="<?php esc_attr_e( 'Close menu', 'curry-leaves-co' ); ?>">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" aria-hidden="true">
			<line x1="18" y1="6" x2="6" y2="18"></line>
			<line x1="6" y1="6" x2="18" y2="18"></line>
		</svg>
	</button>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'curry-leaves-co' ); ?></a>
	<a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'curry-leaves-co' ); ?></a>
	<a href="<?php echo esc_url( home_url( '/menu-listing' ) ); ?>"><?php esc_html_e( 'Menu', 'curry-leaves-co' ); ?></a>
	<a href="<?php echo esc_url( home_url( '/#specials' ) ); ?>"><?php esc_html_e( 'Specials', 'curry-leaves-co' ); ?></a>
	<a href="<?php echo esc_url( home_url( '/#gallery' ) ); ?>"><?php esc_html_e( 'Gallery', 'curry-leaves-co' ); ?></a>
	<a href="<?php echo esc_url( home_url( '/#testimonials' ) ); ?>"><?php esc_html_e( 'Testimonials', 'curry-leaves-co' ); ?></a>
	<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'curry-leaves-co' ); ?></a>
	<a href="<?php echo esc_url( clc_phone_href() ); ?>" class="nav-reserve-btn"><?php esc_html_e( 'Call to Order', 'curry-leaves-co' ); ?></a>
</nav>

<a href="<?php echo esc_url( clc_phone_href() ); ?>" class="floating-reserve" aria-label="<?php esc_attr_e( 'Call to order', 'curry-leaves-co' ); ?>">
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24" aria-hidden="true">
		<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.86 19.86 0 0 1-8.63-3.07 19.42 19.42 0 0 1-6-6A19.86 19.86 0 0 1 2.11 4.11 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.86.32 1.7.59 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.16a2 2 0 0 1 2.11-.45c.8.27 1.64.47 2.5.59A2 2 0 0 1 22 16.92z"/>
	</svg>
</a>
