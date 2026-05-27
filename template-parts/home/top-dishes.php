<?php
/**
 * Top dishes carousel.
 *
 * @package Curry_Leaves_Co
 */

$featured = clc_get_store_dishes( 'top-dishes', 6 );
$carousel_items = array(
	array( 'name' => 'Chef\'s Degustation Box', 'style' => 'Multi-course', 'ingredients' => array( 'Lamb', 'Snapper', 'Seasonal veg' ), 'price' => '85', 'badge' => true, 'image' => clc_default_food_images()[2] ),
	array( 'name' => 'Gold Leaf Dessert Trio', 'style' => 'Pastry', 'ingredients' => array( 'Valrhona', 'Berries', 'Gold leaf' ), 'price' => '32', 'badge' => true, 'image' => clc_default_food_images()[4] ),
);
if ( ! empty( $featured ) ) {
	$items = array_slice( $featured, 0, min( 5, count( $featured ) ) );
} else {
	$items = array_slice( array_merge( $featured, $carousel_items ), 0, 5 );
}
?>
<section class="section-luxury top-dishes-section" aria-label="<?php esc_attr_e( 'Top dishes', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Spotlight', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( __( 'Top <em>Dishes</em>', 'curry-leaves-co' ) ); ?></h2>
			<div class="section-divider"></div>
		</div>
		<div class="carousel-container reveal">
			<div class="carousel-track" id="top-dishes-carousel">
				<?php foreach ( $items as $item ) : ?>
					<article class="carousel-card glass-card">
						<div class="carousel-card-image carousel-card-spotlight">
							<img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" width="360" height="280">
							<?php if ( ! empty( $item['badge'] ) ) : ?>
								<span class="chef-badge"><?php esc_html_e( 'Chef Recommended', 'curry-leaves-co' ); ?></span>
							<?php endif; ?>
						</div>
						<div class="carousel-card-body">
							<h3 class="carousel-card-name"><?php echo esc_html( $item['name'] ); ?></h3>
					<p class="carousel-card-meta"><?php echo esc_html( $item['store'] ?? ( $item['style'] ?? __( 'Customer favourite', 'curry-leaves-co' ) ) ); ?></p>
							<?php if ( ! empty( $item['ingredients'] ) ) : ?>
								<div class="carousel-card-ingredients">
									<?php foreach ( (array) $item['ingredients'] as $ing ) : ?>
										<span class="ingredient-tag"><?php echo esc_html( $ing ); ?></span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<span class="carousel-card-price">$<?php echo esc_html( $item['price'] ); ?></span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<?php if ( count( $items ) > 3 ) : ?>
				<div class="carousel-nav">
				<button type="button" class="carousel-btn carousel-prev" aria-label="<?php esc_attr_e( 'Previous', 'curry-leaves-co' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
				</button>
				<button type="button" class="carousel-btn carousel-next" aria-label="<?php esc_attr_e( 'Next', 'curry-leaves-co' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
				</button>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>


