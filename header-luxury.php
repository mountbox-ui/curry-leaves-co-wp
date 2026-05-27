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
				<li><a href="#home"><?php esc_html_e( 'Home', 'curry-leaves-co' ); ?></a></li>
				<li><a href="#about"><?php esc_html_e( 'About', 'curry-leaves-co' ); ?></a></li>
				<li><a href="#menu"><?php esc_html_e( 'Menu', 'curry-leaves-co' ); ?></a></li>
				<li><a href="#specials"><?php esc_html_e( 'Specials', 'curry-leaves-co' ); ?></a></li>
				<li><a href="#gallery"><?php esc_html_e( 'Gallery', 'curry-leaves-co' ); ?></a></li>
				<li><a href="#testimonials"><?php esc_html_e( 'Testimonials', 'curry-leaves-co' ); ?></a></li>
				<li><a href="#contact"><?php esc_html_e( 'Contact', 'curry-leaves-co' ); ?></a></li>
			</ul>
		</nav>

		<a href="<?php echo esc_url( clc_phone_href() ); ?>" class="nav-reserve-btn"><?php esc_html_e( 'Order Pickup', 'curry-leaves-co' ); ?></a>

		<button type="button" class="hamburger" id="hamburger" aria-label="<? esc_attr_e( 'Toggle menu', 'curry-leaves-co' ); ?>" aria-expanded="false">
			<span></span><span></span><span></span>
		</button>
	</div>
</header>

<nav class="mobile-menu" id="mobile-menu" aria-label="<? esc_attr_e( 'Mobile navigation', 'curry-leaves-co' ); ?>">
	<a href="#home"><?php esc_html_e( 'Home', 'curry-leaves-co' ); ?></a>
	<a href="#about"><?php esc_html_e( 'About', 'curry-leaves-co' ); ?></a>
	<a href="#menu"><?php esc_html_e( 'Menu', 'curry-leaves-co' ); ?></a>
	<a href="#specials"><?php esc_html_e( 'Specials', 'curry-leaves-co' ); ?></a>
	<a href="#gallery"><?php esc_html_e( 'Gallery', 'curry-leaves-co' ); ?></a>
	<a href="#testimonials"><?php esc_html_e( 'Testimonials', 'curry-leaves-co' ); ?></a>
	<a href="#contact"><?php esc_html_e( 'Contact', 'curry-leaves-co' ); ?></a>
	<a href="<?php echo esc_url( clc_phone_href() ); ?>" class="nav-reserve-btn"><?php esc_html_e( 'Order Pickup', 'curry-leaves-co' ); ?></a>
</nav>

<a href="#order" class="floating-reserve" aria-label="<? esc_attr_e( 'Order for pickup', 'curry-leaves-co' ); ?>">
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24" aria-hidden="true">
		<path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/>
	</svg>
</a>
