<?php
/**
 * Vegetarian dishes section.
 *
 * @package Curry_Leaves_Co
 */
 
// Find a vegetarian menu_category term by common slugs/names
$possible_slugs = array( 'veg', 'vegetarian' );
$possible_names = array( 'Vegetarian', 'Veg', 'Vegan' );
$veg_term = false;
foreach ( $possible_slugs as $slug ) {
	$t = get_term_by( 'slug', $slug, 'menu_category' );
	if ( $t && ! is_wp_error( $t ) ) {
		$veg_term = $t;
		break;
	}
}
if ( ! $veg_term ) {
	foreach ( $possible_names as $name ) {
		$t = get_term_by( 'name', $name, 'menu_category' );
		if ( $t && ! is_wp_error( $t ) ) {
			$veg_term = $t;
			break;
		}
	}
}
?>

<section class="section-luxury veg-section" aria-label="<?php esc_attr_e( 'Vegetarian dishes', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Plant Forward', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( __( 'Veg <em>Dishes</em>', 'curry-leaves-co' ) ); ?></h2>
			<div class="section-divider"></div>
		</div>

		<div class="carousel-container reveal">
			<?php
			if ( $veg_term ) :
				$q = new WP_Query( array(
					'post_type'      => 'menu_item',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'tax_query'      => array(
						array(
							'taxonomy' => 'menu_category',
							'field'    => 'term_id',
							'terms'    => $veg_term->term_id,
						),
					),
				) );

				if ( $q->have_posts() ) : ?>
					<div class="carousel-track" id="veg-dishes-carousel">
						<?php while ( $q->have_posts() ) : $q->the_post();
							$img = get_the_post_thumbnail_url( get_the_ID(), 'large' );
							$img = $img ? $img : get_template_directory_uri() . '/assets/images/fallback_img.png';
							$price = get_post_meta( get_the_ID(), '_menu_item_price', true ) ?: '';
							$discount = get_post_meta( get_the_ID(), '_menu_item_discount_percentage', true );
							$offer_amount = get_post_meta( get_the_ID(), '_menu_item_offer_amount', true );
							$has_discount = false;
							$final_price = $price;
							if ( $price && $discount && $offer_amount !== '' ) {
								$has_discount = true;
								$numeric_price = floatval(preg_replace('/[^0-9\.]/', '', $price));
								$final_price = number_format_i18n(max(0, $numeric_price - floatval($offer_amount)), 2);
							}
							$desc = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 18 );
							?>
							<article class="carousel-card glass-card">
								<div class="carousel-card-image carousel-card-spotlight">
									<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" width="360" height="280">
									<span class="chef-badge veg-badge"><?php esc_html_e( 'Vegetarian', 'curry-leaves-co' ); ?></span>
								</div>
								<div class="carousel-card-body">
									<h3 class="carousel-card-name"><?php echo esc_html( get_the_title() ); ?></h3>
									<p class="carousel-card-meta"><?php echo esc_html( $desc ); ?></p>
									<div class="dish-card-footer" style="margin-top: auto;">
										<?php if ( $price ) : ?>
											<div class="carousel-card-price-wrap" style="margin-top: 0; display: flex; flex-direction: column; align-items: flex-start;">
												<?php if ( $has_discount ) : ?>
													<span class="carousel-card-price-original" style="font-size: 0.75rem; text-decoration: line-through; color: #9ca3af; line-height: 1;">$<?php echo esc_html( $price ); ?></span>
												<?php endif; ?>
												<span class="carousel-card-price" style="margin-top: 0; line-height: 1;">$<?php echo esc_html( $final_price ); ?></span>
											</div>
										<?php endif; ?>
										<a href="#order" class="dish-card-btn" style="padding: 0.5rem 1rem; font-size: 0.875rem;"><?php esc_html_e( 'Order', 'curry-leaves-co' ); ?></a>
									</div>
								</div>
							</article>
							<?php
						endwhile;
						wp_reset_postdata(); ?>
					</div>
					<?php if ( $q->found_posts > 3 ) : ?>
						<div class="carousel-nav">
							<button type="button" class="carousel-btn carousel-prev" aria-label="<?php esc_attr_e( 'Previous', 'curry-leaves-co' ); ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
							</button>
							<button type="button" class="carousel-btn carousel-next" aria-label="<?php esc_attr_e( 'Next', 'curry-leaves-co' ); ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
							</button>
						</div>
					<?php endif; ?>
				<?php else :
					// no posts in veg term
					echo '<p class="text-muted">' . esc_html__( 'No vegetarian dishes found in the menu category.', 'curry-leaves-co' ) . '</p>';
				endif;
			else :
				// veg term not found
				echo '<p class="text-muted">' . esc_html__( 'Vegetarian category not configured. Please add a "veg" or "Vegetarian" menu category in the dashboard.', 'curry-leaves-co' ) . '</p>';
			endif;
			?>
		</div>
	</div>
</section>
