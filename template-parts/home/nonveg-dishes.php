<?php
/**
 * Non-vegetarian cinematic showcase.
 *
 * @package Curry_Leaves_Co
 */

// Find a non-vegetarian menu_category term by common slugs/names
$possible_slugs = array( 'nonveg', 'non-veg', 'non_veg', 'meat' );
$possible_names = array( 'Non-Veg', 'Non Veg', 'Nonveg', 'Meat' );
$nonveg_term = false;
foreach ( $possible_slugs as $slug ) {
	$t = get_term_by( 'slug', $slug, 'menu_category' );
	if ( $t && ! is_wp_error( $t ) ) {
		$nonveg_term = $t;
		break;
	}
}
if ( ! $nonveg_term ) {
	foreach ( $possible_names as $name ) {
		$t = get_term_by( 'name', $name, 'menu_category' );
		if ( $t && ! is_wp_error( $t ) ) {
			$nonveg_term = $t;
			break;
		}
	}
}
?>
<section class="section-luxury nonveg-section" aria-label="<?php esc_attr_e( 'Non-vegetarian dishes', 'curry-leaves-co' ); ?>">
	<div class="smoke-overlay" aria-hidden="true"></div>
	<div class="section-container">
		<div class="section-header reveal">
			<span class="section-eyebrow"><?php esc_html_e( 'Bold Flavours', 'curry-leaves-co' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( __( 'Non-Veg <em>Showcase</em>', 'curry-leaves-co' ) ); ?></h2>
			<div class="section-divider"></div>
		</div>
		<div class="dishes-grid stagger-children">
			<?php
			if ( $nonveg_term ) :
				$q = new WP_Query( array(
					'post_type'      => 'menu_item',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'tax_query'      => array(
						array(
							'taxonomy' => 'menu_category',
							'field'    => 'term_id',
							'terms'    => $nonveg_term->term_id,
						),
					),
				) );

				if ( $q->have_posts() ) :
					while ( $q->have_posts() ) : $q->the_post();
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
						<article class="dish-card glass-card reveal nonveg-card">
							<div class="dish-card-image">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
								<span class="dish-card-badge"><?php esc_html_e( 'Premium Grill', 'curry-leaves-co' ); ?></span>
							</div>
							<div class="dish-card-body">
								<h3 class="dish-card-name"><?php echo esc_html( get_the_title() ); ?></h3>
								<p class="dish-card-desc"><?php echo esc_html( $desc ); ?></p>
								<div class="dish-card-footer">
									<?php if ( $price ) : ?>
										<div class="carousel-card-price-wrap" style="margin-top: 0; display: flex; flex-direction: column; align-items: flex-start;">
											<?php if ( $has_discount ) : ?>
												<span class="carousel-card-price-original" style="font-size: 0.75rem; text-decoration: line-through; color: #9ca3af; line-height: 1;">$<?php echo esc_html( $price ); ?></span>
											<?php endif; ?>
											<span class="carousel-card-price" style="margin-top: 0; line-height: 1;">$<?php echo esc_html( $final_price ); ?></span>
										</div>
									<?php endif; ?>
									<a href="#order" class="dish-card-btn"><?php esc_html_e( 'Order', 'curry-leaves-co' ); ?></a>
								</div>
							</div>
						</article>
					<?php
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="text-muted">' . esc_html__( 'No non-vegetarian dishes found in the menu category.', 'curry-leaves-co' ) . '</p>';
				endif;
			else :
				echo '<p class="text-muted">' . esc_html__( 'Non-vegetarian category not configured. Please add a "non-veg" or "Non-Veg" menu category in the dashboard.', 'curry-leaves-co' ) . '</p>';
			endif;
			?>
		</div>
	</div>
</section>
