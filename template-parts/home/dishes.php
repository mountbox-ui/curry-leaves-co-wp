<?php
/**
 * Favourite dishes with category filter.
 *
 * @package Curry_Leaves_Co
 */

$dishes = clc_get_store_favorite_dishes( 12 );
$title  = clc_mod( 'clc_menu_title', 'Favourite <em>Dishes</em>' );

// Build categories array from database
$cats = array( 'all' => __( 'All', 'curry-leaves-co' ) );
$favorite_categories = curry_leaves_co_get_favorite_categories();
foreach ( $favorite_categories as $cat ) {
    $cats[ $cat->slug ] = $cat->name;
}
?>
<section class="section-luxury dishes-section" id="menu" aria-label="<?php esc_attr_e( 'Menu', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Curated Selection', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( $title ); ?></h2>
			<div class="section-divider"></div>
			<p class="section-description"><?php esc_html_e( 'Premium takeaway favourites — order for pickup.', 'curry-leaves-co' ); ?></p>
		</div>
		<div class="filter-tabs reveal" role="tablist">
			<?php $first = true; foreach ( $cats as $slug => $label ) : ?>
				<button type="button" class="filter-tab<?php echo $first ? ' active' : ''; ?>" data-filter="<?php echo esc_attr( $slug ); ?>" role="tab"><?php echo esc_html( $label ); ?></button>
			<?php $first = false; endforeach; ?>
		</div>
		<div class="dishes-grid stagger-children" id="dishes-grid">
			<?php foreach ( $dishes as $dish ) : ?>
				<article class="dish-card glass-card reveal" data-category="<?php echo esc_attr( $dish['cat'] ); ?>">
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
							<span class="dish-card-price">$<?php echo esc_html( $dish['price'] ); ?></span>
							<span class="dish-card-rating">
								<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
								<?php echo esc_html( $dish['rating'] ); ?>
							</span>
							<a href="<?php echo esc_url( isset( $dish['link'] ) ? $dish['link'] : '#order' ); ?>" class="dish-card-btn"><?php esc_html_e( 'Order', 'curry-leaves-co' ); ?></a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
