<?php
/**
 * Testimonials slider.
 *
 * @package Curry_Leaves_Co
 */

$testimonials = array(
	array( 'name' => 'Sarah Mitchell', 'role' => 'Auckland', 'text' => 'The most beautiful takeaway experience in New Zealand. Every dish feels like a five-star hotel.', 'img' => clc_default_food_images()[0] ),
	array( 'name' => 'James Chen', 'role' => 'Wellington', 'text' => 'Pickup-only perfection. The packaging, the flavours — absolutely cinematic.', 'img' => clc_default_food_images()[1] ),
	array( 'name' => 'Emma Walsh', 'role' => 'Queenstown', 'text' => 'We order every weekend. Luxury without the dining room — and that suits us perfectly.', 'img' => clc_default_food_images()[2] ),
);
?>
<section class="section-luxury testimonials-section" id="testimonials" aria-label="<?php esc_attr_e( 'Testimonials', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Guest Voices', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( __( 'What Our <em>Guests</em> Say', 'curry-leaves-co' ) ); ?></h2>
			<div class="section-divider"></div>
		</div>
		<div class="testimonials-slider reveal">
			<div class="testimonials-track" id="testimonials-track">
				<?php foreach ( $testimonials as $t ) : ?>
					<blockquote class="testimonial-card glass-card">
						<div class="testimonial-image">
							<img src="<?php echo esc_url( $t['img'] ); ?>" alt="" loading="lazy" width="120" height="120">
						</div>
						<div class="testimonial-content">
							<span class="testimonial-quote-icon" aria-hidden="true">"</span>
							<p class="testimonial-text"><?php echo esc_html( $t['text'] ); ?></p>
							<div class="testimonial-stars" aria-label="<?php esc_attr_e( '5 stars', 'curry-leaves-co' ); ?>">
								<?php for ( $i = 0; $i < 5; $i++ ) : ?>
									<svg viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
								<?php endfor; ?>
							</div>
							<cite class="testimonial-author"><?php echo esc_html( $t['name'] ); ?></cite>
							<span class="testimonial-role"><?php echo esc_html( $t['role'] ); ?></span>
						</div>
					</blockquote>
				<?php endforeach; ?>
			</div>
			<div class="testimonials-nav">
				<button type="button" class="carousel-btn testimonial-prev" aria-label="<?php esc_attr_e( 'Previous', 'curry-leaves-co' ); ?>">←</button>
				<button type="button" class="carousel-btn testimonial-next" aria-label="<?php esc_attr_e( 'Next', 'curry-leaves-co' ); ?>">→</button>
			</div>
		</div>
	</div>
</section>
