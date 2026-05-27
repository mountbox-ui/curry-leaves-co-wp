	<footer class="luxury-footer" id="footer" role="contentinfo">
		<div class="section-container">
			<div class="footer-main">
				<div class="footer-brand">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo<?php echo clc_has_logo() ? ' nav-logo--image' : ''; ?>">
						<?php clc_the_logo( array( 'height' => 56, 'show_tagline' => ! clc_has_logo(), 'tagline' => __( 'Premium Takeaway · New Zealand', 'curry-leaves-co' ) ) ); ?>
					</a>
					<p><?php echo esc_html( clc_mod( 'clc_footer_text', 'Pickup-only gourmet takeaway. No dining, no delivery — exceptional flavours crafted for collection.' ) ); ?></p>
					<div class="contact-social">
						<a href="#" class="social-icon" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
						<a href="#" class="social-icon" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
					</div>
				</div>
				<div class="footer-column">
					<h4 class="footer-heading"><?php esc_html_e( 'Explore', 'curry-leaves-co' ); ?></h4>
					<ul class="footer-links">
						<li><a href="#home"><?php esc_html_e( 'Home', 'curry-leaves-co' ); ?></a></li>
						<li><a href="#about"><?php esc_html_e( 'Our Story', 'curry-leaves-co' ); ?></a></li>
						<li><a href="#menu"><?php esc_html_e( 'Menu', 'curry-leaves-co' ); ?></a></li>
						<li><a href="#order"><?php esc_html_e( 'Order Pickup', 'curry-leaves-co' ); ?></a></li>
					</ul>
				</div>
				<div class="footer-column">
					<h4 class="footer-heading"><?php esc_html_e( 'Hours', 'curry-leaves-co' ); ?></h4>
					<ul class="footer-links">
						<?php
						$hours = explode( "\n", clc_mod( 'clc_hours', "Mon–Fri: 11am – 9pm\nSat–Sun: 10am – 10pm" ) );
						foreach ( $hours as $line ) {
							$line = trim( $line );
							if ( $line ) {
								echo '<li>' . esc_html( $line ) . '</li>';
							}
						}
						?>
					</ul>
				</div>
				<div class="footer-column footer-newsletter">
					<h4 class="footer-heading"><?php esc_html_e( 'Newsletter', 'curry-leaves-co' ); ?></h4>
					<p><?php esc_html_e( 'Exclusive offers and seasonal menus — pickup specials only.', 'curry-leaves-co' ); ?></p>
					<form class="newsletter-form" action="#" method="post" onsubmit="return false;">
						<input type="email" placeholder="<? esc_attr_e( 'Your email', 'curry-leaves-co' ); ?>" required aria-label="<? esc_attr_e( 'Email', 'curry-leaves-co' ); ?>">
						<button type="submit" aria-label="<? esc_attr_e( 'Subscribe', 'curry-leaves-co' ); ?>">→</button>
					</form>
					<a href="<?php echo esc_url( clc_phone_href() ); ?>" class="btn-luxury btn-outline btn-sm"><?php esc_html_e( 'Call to Order', 'curry-leaves-co' ); ?></a>
				</div>
			</div>
			<div class="footer-bottom">
				<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'curry-leaves-co' ); ?></p>
				<button type="button" class="back-to-top" aria-label="<? esc_attr_e( 'Back to top', 'curry-leaves-co' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
				</button>
			</div>
		</div>
	</footer>

	<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="<? esc_attr_e( 'Image lightbox', 'curry-leaves-co' ); ?>">
		<button type="button" class="lightbox-close" aria-label="<? esc_attr_e( 'Close', 'curry-leaves-co' ); ?>">&times;</button>
		<img src="" alt="" loading="lazy">
	</div>

	<?php wp_footer(); ?>
</body>
</html>

<!-- Fallback: ensure page-loader is removed if homepage.js fails to run -->
<script>(function(){try{if(!document.querySelector('.page-loader'))return;document.addEventListener('DOMContentLoaded',function(){setTimeout(function(){var l=document.querySelector('.page-loader');if(l)l.classList.add('loaded');},5000);});}catch(e){/* noop */}})();</script>
