<?php
/**
 * Template Name: Our Menu Template
 * Template Post Type: page
 */

get_header( 'luxury' );
?>

<main id="primary" class="site-main">
    <section class="section-luxury dishes-section" aria-label="<?php echo esc_attr__( 'Menu', 'curry-leaves-co' ); ?>">
        <div class="section-container">
            <div class="section-header reveal">
                <span class="section-eyebrow"><?php echo esc_html__( 'Pickup Only', 'curry-leaves-co' ); ?></span>
                <?php
                if ( have_posts() ) {
                    the_post();
                }
                ?>
                <h1 class="section-title"><?php echo esc_html( get_the_title() ); ?></h1>
                <div class="section-divider"></div>
                <p class="section-description"><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></p>
            </div>

            <?php
            $categories = get_terms(
                array(
                    'taxonomy'   => 'menu_category',
                    'hide_empty' => false,
                )
            );

            $category_map = array();
            if ( ! is_wp_error( $categories ) ) {
                foreach ( $categories as $term ) {
                    $category_map[ $term->slug ] = $term->name;
                }
            }

            $items = new WP_Query(
                array(
                    'post_type'      => 'menu_item',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                )
            );
            ?>

            <?php if ( ! empty( $category_map ) ) : ?>
                <div class="filter-tabs reveal" role="tablist" aria-label="<?php echo esc_attr__( 'Menu categories', 'curry-leaves-co' ); ?>">
                    <button type="button" class="filter-tab active" data-filter="all" role="tab"><?php echo esc_html__( 'All', 'curry-leaves-co' ); ?></button>
                    <?php foreach ( $category_map as $slug => $name ) : ?>
                        <button type="button" class="filter-tab" data-filter="<?php echo esc_attr( $slug ); ?>" role="tab"><?php echo esc_html( $name ); ?></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( $items->have_posts() ) : ?>
                <div class="dishes-grid stagger-children" id="menu-grid">
                    <?php
                    while ( $items->have_posts() ) :
                        $items->the_post();
                        $id = get_the_ID();

                        $terms = get_the_terms( $id, 'menu_category' );
                        $cat_slug = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->slug : 'other';
                        $cat_name = isset( $category_map[ $cat_slug ] ) ? $category_map[ $cat_slug ] : __( 'Other', 'curry-leaves-co' );

                        $price = get_post_meta( $id, '_menu_item_price', true );
                        $discount = get_post_meta( $id, '_menu_item_discount_percentage', true );
                        $offer_amount = get_post_meta( $id, '_menu_item_offer_amount', true );
                        $has_discount = $price && $discount !== '' && floatval( $discount ) > 0 && $offer_amount !== '';

                        $final_price = '';
                        if ( $price ) {
                            $numeric_price = floatval( preg_replace( '/[^0-9\.]/', '', $price ) );
                            if ( $has_discount ) {
                                $final_price = number_format_i18n( max( 0, $numeric_price - floatval( $offer_amount ) ), 2 );
                            } else {
                                $final_price = number_format_i18n( $numeric_price, 2 );
                            }
                        }

                        $img_url = get_the_post_thumbnail_url( $id, 'large' );
                        if ( ! $img_url ) {
                            $img_url = get_template_directory_uri() . '/assets/images/fallback_img.png';
                        }
                        ?>

                        <article class="dish-card glass-card reveal" data-category="<?php echo esc_attr( $cat_slug ); ?>">
                            <div class="dish-card-image">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" width="480" height="360" />
                                <?php if ( $has_discount ) : ?>
                                    <span class="dish-card-badge"><?php echo esc_html( $discount ); ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            <div class="dish-card-body">
                                <span class="dish-card-category"><?php echo esc_html( $cat_name ); ?></span>
                                <h3 class="dish-card-name">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="dish-card-desc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                                <div class="dish-card-footer">
                                    <div class="dish-card-price-wrap">
                                        <?php if ( $has_discount ) : ?>
                                            <span class="dish-card-price-old">$<?php echo esc_html( number_format_i18n( floatval( preg_replace( '/[^0-9\.]/', '', $price ) ), 2 ) ); ?></span>
                                        <?php endif; ?>
                                        <span class="dish-card-price">$<?php echo esc_html( $final_price ); ?></span>
                                    </div>
                                    <!-- <a href="<?php the_permalink(); ?>" class="dish-card-btn"><?php echo esc_html__( 'View', 'curry-leaves-co' ); ?></a> -->
                                </div>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <p class="paragraph"><?php echo esc_html__( 'No menu items found. Please add them from the dashboard.', 'curry-leaves-co' ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <script>
        (function () {
            var tabs = document.querySelectorAll('.filter-tab');
            var cards = document.querySelectorAll('#menu-grid .dish-card');
            if (!tabs.length || !cards.length) return;

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    tabs.forEach(function (t) { t.classList.remove('active'); });
                    tab.classList.add('active');
                    var filter = tab.getAttribute('data-filter');
                    cards.forEach(function (card) {
                        var show = (filter === 'all') || (card.getAttribute('data-category') === filter);
                        card.style.display = show ? '' : 'none';
                    });
                });
            });
        })();
    </script>
</main>

<?php
get_footer( 'luxury' );
?>