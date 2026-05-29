<?php
/**
 * Chef special / dish of the month.
 *
 * @package Curry_Leaves_Co
 */

$images = clc_default_food_images();
$dish_of_month_id = absint( get_option( 'clc_dish_of_month', 0 ) );
$dish_of_month    = $dish_of_month_id ? get_post( $dish_of_month_id ) : null;

if ( $dish_of_month && 'menu_item' === $dish_of_month->post_type && 'publish' === $dish_of_month->post_status ) {
    $img = get_the_post_thumbnail_url( $dish_of_month, 'large' );
    $img = $img ? $img : get_template_directory_uri() . '/assets/images/fallback_img.png';
    $special_title = wp_kses_post( get_the_title( $dish_of_month ) );
    $special_story = $dish_of_month->post_excerpt;
    if ( ! $special_story ) {
        $special_story = wp_trim_words( wp_strip_all_tags( $dish_of_month->post_content ), 24 );
    }
    $special_price = get_post_meta( $dish_of_month_id, '_menu_item_price', true );
    $special_discount = get_post_meta( $dish_of_month_id, '_menu_item_discount_percentage', true );
    $special_offer_amount = get_post_meta( $dish_of_month_id, '_menu_item_offer_amount', true );
    $special_has_discount = false;
    $special_final_price = $special_price;
    if ( $special_price && $special_discount && $special_offer_amount !== '' ) {
        $special_has_discount = true;
        $numeric = floatval( preg_replace( '/[^0-9\.]/', '', $special_price ) );
        $special_final_price = number_format_i18n( max( 0, $numeric - floatval( $special_offer_amount ) ), 2 );
    }
    $special_ingredients = get_post_meta( $dish_of_month_id, '_menu_item_ingredients', true );
    if ( strpos( $special_ingredients, 'Warning:' ) !== false || strpos( $special_ingredients, 'WARNING:' ) !== false ) {
        $special_ingredients = '';
    }
    $special_ingredients = array_filter( array_map( 'trim', explode( ',', $special_ingredients ) ) );
} else {
    $img = clc_image_url( 'clc_special_image', $images[3] );
    $special_title = wp_kses_post( clc_mod( 'clc_special_heading', 'Truffle-Infused <em>Beef Wellington</em>' ) );
    $special_story = clc_mod( 'clc_special_story', 'Our executive chef layers buttery pastry with premium grass-fed beef, black truffle, and a red wine reduction â€” composed for takeaway and finished moments before you collect.' );
    $special_price = clc_mod( 'clc_special_price', '58' );
    $special_has_discount = false;
    $special_final_price = $special_price;
    $special_discount = '';
    $special_offer_amount = '';
    $special_ingredients = array( 'Grass-fed beef', 'Black truffle', 'Puff pastry', 'Red wine jus' );
}
?>
<section class="section-luxury specials-section" id="specials" aria-label="<?php esc_attr_e( 'Specials', 'curry-leaves-co' ); ?>">
	<div class="section-container">
		<div class="special-feature">
			<div class="special-image reveal-left">
				<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( clc_mod( 'clc_special_month_title', 'Dish of the Month' ) ); ?>" loading="lazy" width="640" height="800">
				<span class="special-month-badge"><?php echo esc_html( clc_mod( 'clc_special_month_title', 'Dish of the Month' ) ); ?></span>
				<div class="chef-image-credit">
					<span class="chef-name"><?php echo esc_html( clc_mod( 'clc_chef_name', 'Chef Arjun Mehta' ) ); ?></span>
					<span class="chef-title"><?php echo esc_html( clc_mod( 'clc_chef_title', 'Executive Chef' ) ); ?></span>
				</div>
			</div>
			<div class="special-content reveal-right">
				<span class="section-eyebrow"><?php esc_html_e( 'Chef\'s Selection', 'curry-leaves-co' ); ?></span>
					<h3><?php echo $special_title; ?></h3>
				<div class="chef-credit">
					<span class="chef-name"><?php echo esc_html( clc_mod( 'clc_chef_name', 'Chef Arjun Mehta' ) ); ?></span>
					<span class="chef-title"><?php echo esc_html( clc_mod( 'clc_chef_title', 'Executive Chef' ) ); ?></span>
				</div>
				<p class="chef-story"><?php echo esc_html( $special_story ); ?></p>
				<?php if ( ! empty( $special_ingredients ) ) : ?>
					<div class="special-ingredients-list">
						<?php foreach ( $special_ingredients as $ing ) : ?>
							<span class="ingredient-tag"><?php echo esc_html( $ing ); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="special-price-row">
					<?php if ( $special_price ) : ?>
						<?php if ( $special_has_discount ) : ?>
							<div style="display: flex; flex-direction: column; align-items: flex-start; gap: 0.15rem;">
								<span style="font-size: 0.85rem; text-decoration: line-through; color: #9ca3af;">$<?php echo esc_html( $special_price ); ?></span>
								<span class="special-price">$<?php echo esc_html( $special_final_price ); ?></span>
								<span style="font-size: 0.8rem; font-weight: 600; color: #10b981;"><?php echo esc_html( $special_discount ); ?>% off</span>
							</div>
						<?php else : ?>
							<span class="special-price">$<?php echo esc_html( $special_price ); ?></span>
						<?php endif; ?>
					<?php endif; ?>
					<a href="#order" class="btn-luxury btn-gold"><?php esc_html_e( 'Order Your Dish', 'curry-leaves-co' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>

