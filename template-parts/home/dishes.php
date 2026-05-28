<?php
/**
 * Favourite dishes with category filter.
 *
 * @package Curry_Leaves_Co
 */

$dishes = clc_get_store_favorite_dishes( 12 );
$title  = clc_mod( 'clc_menu_title', 'Favourite <em>Dishes</em>' );
?>
<section class="section-luxury dishes-section" id="menu" aria-label="<?php esc_attr_e( 'Menu', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Curated Selection', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( $title ); ?></h2>
			<div class="section-divider"></div>
			<p class="section-description"><?php esc_html_e( 'Premium takeaway favourites — order for pickup.', 'curry-leaves-co' ); ?></p>
		</div>
		<div class="carousel-container reveal">
			<div class="carousel-track stagger-children" id="favorite-dishes-carousel">
				<?php foreach ( $dishes as $dish ) : ?>
					<article class="carousel-card glass-card reveal" data-category="<?php echo esc_attr( $dish['cat'] ); ?>">
					<div class="dish-card-image">
						<img src="<?php echo esc_url( $dish['image'] ); ?>" alt="<?php echo esc_attr( $dish['name'] ); ?>" loading="lazy" width="400" height="300">
						<?php if ( 'chef-specials' === $dish['cat'] ) : ?>
							<span class="dish-card-badge"><?php esc_html_e( 'Chef Pick', 'curry-leaves-co' ); ?></span>
						<?php endif; ?>
					</div>
					<div class="dish-card-body">
						<span class="dish-card-category"><?php echo esc_html( ucwords( str_replace( '-', ' ', $dish['cat'] ) ) ); ?></span>
						<h3 class="dish-card-name"><?php echo esc_html( $dish['name'] ); ?></h3>
						<p class="dish-card-desc"><?php echo esc_html( $dish['desc'] ); ?></p>
						<div class="dish-card-footer">
						<?php if ( ! empty( $dish['has_discount'] ) ) : ?>
						<div class="carousel-card-price-wrap" style="display: flex; flex-direction: column; align-items: flex-start;">
							<span class="carousel-card-price-original" style="font-size: 0.75rem; text-decoration: line-through; color: #9ca3af; line-height: 1;">$<?php echo esc_html( $dish['original_price'] ); ?></span>
							<span class="dish-card-price" style="line-height: 1;">$<?php echo esc_html( $dish['price'] ); ?></span>
						</div>
					<?php else : ?>
						<span class="dish-card-price">$<?php echo esc_html( $dish['price'] ); ?></span>
					<?php endif; ?>
							
						</div>
					</div>
				</article>
			<?php endforeach; ?>
			</div>
			<?php if ( is_countable( $dishes ) && count( $dishes ) > 3 ) : ?>
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

