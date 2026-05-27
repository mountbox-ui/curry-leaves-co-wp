<?php
/**
 * Signature experience section.
 *
 * @package Curry_Leaves_Co
 */

$images = clc_default_food_images();
$title  = clc_mod( 'clc_about_title', 'A Signature <em>Takeaway</em> Experience' );
?>
<section class="section-luxury experience-section" id="about" aria-label="<?php esc_attr_e( 'About', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="experience-grid">
			<div class="experience-image-grid reveal-left">
				<div class="experience-img-wrapper parallax-img" data-speed="0.04">
					<img src="<?php echo esc_url( clc_image_url( 'clc_about_image_1', $images[0] ) ); ?>" alt="" loading="lazy" width="600" height="800">
				</div>
				<div class="experience-img-wrapper">
					<img src="<?php echo esc_url( clc_image_url( 'clc_about_image_2', $images[1] ) ); ?>" alt="" loading="lazy" width="400" height="300">
				</div>
				<div class="experience-img-wrapper">
					<img src="<?php echo esc_url( clc_image_url( 'clc_about_image_3', $images[2] ) ); ?>" alt="" loading="lazy" width="400" height="300">
				</div>
			</div>
			<div class="experience-text reveal-right">
				<span class="section-eyebrow"><?php esc_html_e( 'Our Story', 'curry-leaves-co' ); ?></span>
				<h2 class="section-title"><?php echo wp_kses_post( $title ); ?></h2>
				<div class="section-divider"></div>
				<p><?php echo esc_html( clc_mod( 'clc_about_text', 'Born in New Zealand with a passion for premium hospitality, we reimagined takeaway as an art form — cinematic plating, warm golden ambience, and flavours worthy of fine dining. Pick up only. No tables, no delivery — just excellence to go.' ) ); ?></p>
				<p><?php esc_html_e( 'Our chefs craft every dish with the precision of a luxury kitchen, using local produce and world-class technique.', 'curry-leaves-co' ); ?></p>
				<div class="experience-stats stagger-children">
					<?php foreach ( clc_get_stats() as $stat ) : ?>
						<div class="stat-item reveal">
							<span class="stat-number" data-count="<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $stat['number'] ) ); ?>"><?php echo esc_html( $stat['number'] ); ?></span>
							<span class="stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
