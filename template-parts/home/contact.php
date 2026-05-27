<?php
/**
 * Contact section.
 *
 * @package Curry_Leaves_Co
 */
?>
<section class="section-luxury contact-section" id="contact" aria-label="<?php esc_attr_e( 'Contact', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Get in Touch', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( __( 'Contact <em>Us</em>', 'curry-leaves-co' ) ); ?></h2>
			<div class="section-divider"></div>
		</div>
		<div class="contact-grid">
			<div class="reveal-left">
				<ul class="contact-info-list">
					<li class="contact-info-item">
						<span class="contact-info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907-.339 1.85-.573 2.81-.7A2 2 0 0 1 22 16.92z"/></svg></span>
						<div class="contact-info-text">
							<h4><?php esc_html_e( 'Phone', 'curry-leaves-co' ); ?></h4>
							<p><a href="<?php echo esc_url( clc_phone_href() ); ?>"><?php echo esc_html( clc_phone() ); ?></a></p>
						</div>
					</li>
					<li class="contact-info-item">
						<span class="contact-info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
						<div class="contact-info-text">
							<h4><?php esc_html_e( 'Email', 'curry-leaves-co' ); ?></h4>
							<p><a href="mailto:<?php echo esc_attr( clc_mod( 'clc_email', 'hello@curryleaves.co.nz' ) ); ?>"><?php echo esc_html( clc_mod( 'clc_email', 'hello@curryleaves.co.nz' ) ); ?></a></p>
						</div>
					</li>
					<li class="contact-info-item">
						<span class="contact-info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
						<div class="contact-info-text">
							<h4><?php esc_html_e( 'Location', 'curry-leaves-co' ); ?></h4>
							<p><?php echo esc_html( clc_mod( 'clc_address', '123 Queen Street, Auckland, New Zealand' ) ); ?></p>
						</div>
					</li>
				</ul>
				<div class="contact-social">
					<a href="#" class="social-icon" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/></svg></a>
					<a href="#" class="social-icon" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
				</div>
				<form class="reservation-form contact-form-mini" action="#" method="post" onsubmit="return false;">
					<div class="form-group full-width">
						<label for="contact-message"><?php esc_html_e( 'Message', 'curry-leaves-co' ); ?></label>
						<textarea id="contact-message" name="message" rows="3"></textarea>
					</div>
					<button type="submit" class="btn-luxury btn-outline btn-sm"><?php esc_html_e( 'Send Message', 'curry-leaves-co' ); ?></button>
				</form>
			</div>
			<div class="contact-map reveal-right">
				<iframe title="<?php esc_attr_e( 'Map', 'curry-leaves-co' ); ?>" src="https://maps.google.com/maps?q=Auckland%20New%20Zealand&amp;z=12&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>
