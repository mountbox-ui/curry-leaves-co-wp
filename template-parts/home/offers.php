<?php
/**
 * Offers & promotions.
 *
 * @package Curry_Leaves_Co
 */

$offers = array(
	array( 'icon' => '🥂', 'title' => 'Weekend Special', 'desc' => '15% off premium mains — Fri to Sun pickup.', 'discount' => '15% OFF' ),
	array( 'icon' => '👨‍👩‍👧‍👦', 'title' => 'Family Combo', 'desc' => 'Feeds four with sides and dessert.', 'discount' => '$99' ),
	array( 'icon' => '🍷', 'title' => 'Wine Pairing Night', 'desc' => 'Curated bottle + chef selection box.', 'discount' => 'Bundle' ),
	array( 'icon' => '🍂', 'title' => 'Seasonal Menu', 'desc' => 'Autumn harvest tasting — limited release.', 'discount' => 'New' ),
);
?>
<section class="section-luxury offers-section" aria-label="<?php esc_attr_e( 'Offers', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Limited Time', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( __( 'Offers & <em>Promotions</em>', 'curry-leaves-co' ) ); ?></h2>
			<div class="section-divider"></div>
		</div>
		<div class="countdown reveal" id="offer-countdown" aria-label="<?php esc_attr_e( 'Offer ends in', 'curry-leaves-co' ); ?>">
			<div class="countdown-item"><span class="countdown-value" data-unit="days">00</span><span class="countdown-label"><?php esc_html_e( 'Days', 'curry-leaves-co' ); ?></span></div>
			<div class="countdown-item"><span class="countdown-value" data-unit="hours">00</span><span class="countdown-label"><?php esc_html_e( 'Hours', 'curry-leaves-co' ); ?></span></div>
			<div class="countdown-item"><span class="countdown-value" data-unit="mins">00</span><span class="countdown-label"><?php esc_html_e( 'Mins', 'curry-leaves-co' ); ?></span></div>
			<div class="countdown-item"><span class="countdown-value" data-unit="secs">00</span><span class="countdown-label"><?php esc_html_e( 'Secs', 'curry-leaves-co' ); ?></span></div>
		</div>
		<div class="offers-grid stagger-children">
			<?php foreach ( $offers as $offer ) : ?>
				<article class="offer-card glass-card reveal">
					<div class="offer-card-inner">
						<span class="offer-icon" aria-hidden="true"><?php echo esc_html( $offer['icon'] ); ?></span>
						<span class="offer-discount"><?php echo esc_html( $offer['discount'] ); ?></span>
						<h3 class="offer-title"><?php echo esc_html( $offer['title'] ); ?></h3>
						<p class="offer-desc"><?php echo esc_html( $offer['desc'] ); ?></p>
						<a href="#order" class="btn-luxury btn-gold btn-sm"><?php esc_html_e( 'Order Pickup', 'curry-leaves-co' ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
