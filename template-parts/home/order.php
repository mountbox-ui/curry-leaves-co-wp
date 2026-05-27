<?php
/**
 * Pickup order form (takeaway only — no dining/delivery).
 *
 * @package Curry_Leaves_Co
 */
?>
<section class="section-luxury reservation-section" id="order" aria-label="<?php esc_attr_e( 'Order for pickup', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="reservation-grid">
			<div class="reservation-info reveal-left">
				<span class="section-eyebrow"><?php esc_html_e( 'Pickup Only', 'curry-leaves-co' ); ?></span>
				<h3><?php echo wp_kses_post( __( 'Reserve Your <em>Luxury Takeaway</em>', 'curry-leaves-co' ) ); ?></h3>
				<p><?php esc_html_e( 'No dining. No delivery. Pre-order your dishes and collect at your chosen time — prepared fresh with premium presentation.', 'curry-leaves-co' ); ?></p>
				<ul class="reservation-details">
					<li class="reservation-detail-item">
						<span class="reservation-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
						<div class="reservation-detail-text">
							<h4><?php esc_html_e( 'Call to Order', 'curry-leaves-co' ); ?></h4>
							<p><a href="<?php echo esc_url( clc_phone_href() ); ?>"><?php echo esc_html( clc_phone() ); ?></a></p>
						</div>
					</li>
					<li class="reservation-detail-item">
						<span class="reservation-detail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
						<div class="reservation-detail-text">
							<h4><?php esc_html_e( 'Pickup Window', 'curry-leaves-co' ); ?></h4>
							<p><?php esc_html_e( 'Ready in 25–40 minutes', 'curry-leaves-co' ); ?></p>
						</div>
					</li>
				</ul>
			</div>
			<div class="reservation-form-wrapper glass-card reveal-right">
				<form class="reservation-form" id="pickup-order-form" action="#" method="post" onsubmit="return false;">
					<div class="form-group">
						<label for="order-name"><?php esc_html_e( 'Full Name', 'curry-leaves-co' ); ?></label>
						<input type="text" id="order-name" name="name" required placeholder="<?php esc_attr_e( 'Your name', 'curry-leaves-co' ); ?>">
					</div>
					<div class="form-group">
						<label for="order-phone"><?php esc_html_e( 'Phone', 'curry-leaves-co' ); ?></label>
						<input type="tel" id="order-phone" name="phone" required placeholder="<?php esc_attr_e( 'Mobile number', 'curry-leaves-co' ); ?>">
					</div>
					<div class="form-group">
						<label for="order-date"><?php esc_html_e( 'Pickup Date', 'curry-leaves-co' ); ?></label>
						<input type="date" id="order-date" name="date" required>
					</div>
					<div class="form-group">
						<label for="order-time"><?php esc_html_e( 'Pickup Time', 'curry-leaves-co' ); ?></label>
						<select id="order-time" name="time" required>
							<option value=""><?php esc_html_e( 'Select time', 'curry-leaves-co' ); ?></option>
							<option>11:30 AM</option><option>12:00 PM</option><option>12:30 PM</option>
							<option>6:00 PM</option><option>6:30 PM</option><option>7:00 PM</option><option>7:30 PM</option>
						</select>
					</div>
					<div class="form-group full-width">
						<label for="order-notes"><?php esc_html_e( 'Dish requests', 'curry-leaves-co' ); ?></label>
						<textarea id="order-notes" name="notes" rows="3" placeholder="<?php esc_attr_e( 'Which dishes would you like?', 'curry-leaves-co' ); ?>"></textarea>
					</div>
					<button type="submit" class="btn-luxury btn-gold form-submit-btn"><?php esc_html_e( 'Submit Pickup Order', 'curry-leaves-co' ); ?></button>
				</form>
			</div>
		</div>
	</div>
</section>
