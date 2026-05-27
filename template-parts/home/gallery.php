<?php
/**
 * Gallery masonry + lightbox.
 *
 * @package Curry_Leaves_Co
 */

$images = clc_default_food_images();
$gallery = array(
	array( 'src' => $images[0], 'alt' => __( 'Restaurant ambiance', 'curry-leaves-co' ) ),
	array( 'src' => $images[1], 'alt' => __( 'Fine plating', 'curry-leaves-co' ) ),
	array( 'src' => $images[2], 'alt' => __( 'Chef at work', 'curry-leaves-co' ) ),
	array( 'src' => $images[3], 'alt' => __( 'Grill station', 'curry-leaves-co' ) ),
	array( 'src' => $images[4], 'alt' => __( 'Dessert artistry', 'curry-leaves-co' ) ),
	array( 'src' => $images[1], 'alt' => __( 'Wine pairing', 'curry-leaves-co' ) ),
	array( 'src' => $images[1], 'alt' => __( 'Wine pairing', 'curry-leaves-co' ) ),
);
?>
<section class="section-luxury gallery-section" id="gallery" aria-label="<?php esc_attr_e( 'Gallery', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Visual Journey', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( __( 'Gallery <em>Experience</em>', 'curry-leaves-co' ) ); ?></h2>
			<div class="section-divider"></div>
		</div>
		<div class="gallery-masonry reveal">
			<?php foreach ( $gallery as $item ) : ?>
				<button type="button" class="gallery-item" data-src="<?php echo esc_url( $item['src'] ); ?>" aria-label="<?php echo esc_attr( $item['alt'] ); ?>">
					<img src="<?php echo esc_url( $item['src'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>" loading="lazy" width="400" height="500">
					<span class="gallery-item-overlay">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
					</span>
				</button>
			<?php endforeach; ?>
		</div>
	</div>
</section>
