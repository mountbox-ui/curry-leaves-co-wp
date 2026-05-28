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
				<?php
				$features = array(
					array(
						'title' => __( 'Chef Crafted', 'curry-leaves-co' ),
						'desc'  => __( 'Expertly prepared with precision', 'curry-leaves-co' ),
						'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0"/><path d="M4 10h16"/><path d="M5 10l1 10h12l1-10"/><path d="M10 6V4"/><path d="M14 6V4"/></svg>',
					),
					array(
						'title' => __( 'Signature Dishes', 'curry-leaves-co' ),
						'desc'  => __( 'Curated flavours you’ll love', 'curry-leaves-co' ),
						'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 11h16"/><path d="M6 11c0 5 3 9 6 9s6-4 6-9"/><path d="M8 8c.5 1 1.5 1 2 0s1.5-1 2 0 1.5 1 2 0 1.5-1 2 0"/></svg>',
					),
					array(
						'title' => __( 'Fresh Ingredients', 'curry-leaves-co' ),
						'desc'  => __( 'Locally sourced, premium quality', 'curry-leaves-co' ),
						'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22c4-3 8-8 8-13A7 7 0 0 0 6 9c0 5 4 10 6 13z"/><path d="M12 22V10"/><path d="M12 14c-2-2-5-2-7-1"/></svg>',
					),
				);
				?>
				<div class="experience-stats stagger-children" aria-label="<?php echo esc_attr__( 'Highlights', 'curry-leaves-co' ); ?>">
					<?php
					$allowed_svg = array(
						'svg'      => array(
							'viewBox'           => true,
							'fill'              => true,
							'stroke'            => true,
							'stroke-width'      => true,
							'stroke-linecap'    => true,
							'stroke-linejoin'   => true,
							'aria-hidden'       => true,
							'xmlns'             => true,
							'width'             => true,
							'height'            => true,
							'role'              => true,
							'focusable'         => true,
						),
						'path'     => array( 'd' => true ),
						'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true ),
						'line'     => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ),
						'polyline' => array( 'points' => true ),
					);
					?>
					<?php foreach ( $features as $f ) : ?>
						<div class="stat-item reveal">
							<div class="stat-icon"><?php echo wp_kses( $f['icon'], $allowed_svg ); ?></div>
							<div class="stat-title"><?php echo esc_html( $f['title'] ); ?></div>
							<div class="stat-desc"><?php echo esc_html( $f['desc'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
