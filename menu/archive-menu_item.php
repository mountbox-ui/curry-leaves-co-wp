<?php
/**
 * The template for displaying all menu item archives
 */

get_header();
?>

<main id="primary" class="site-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative">
    <header class="mb-16 text-center">
        <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight mb-4">Our Food Menu</h1>
        <p class="text-lg text-gray-500">Explore our delicious selection of dishes.</p>
    </header>

    <?php
    // Get all menu categories
    $categories = get_terms( array(
        'taxonomy' => 'menu_category',
        'hide_empty' => true,
    ) );

    $displayed_ids = array();

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        foreach ( $categories as $category ) {
            ?>
            <section class="mb-20">
                <div class="flex items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 pr-6">
                        <?php echo esc_html( $category->name ); ?>
                    </h2>
                    <div class="flex-grow h-px bg-gray-200"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    $menu_items = new WP_Query( array(
                        'post_type' => 'menu_item',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'menu_category',
                                'field'    => 'term_id',
                                'terms'    => $category->term_id,
                            ),
                        ),
                    ) );

                    if ( $menu_items->have_posts() ) {
                        while ( $menu_items->have_posts() ) {
                            $menu_items->the_post();
                            $displayed_ids[] = get_the_ID();
                            curry_leaves_co_render_archive_item();
                        }
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </section>
            <?php
        }
    }

    // Now show any items that weren't in a category
    $other_items = new WP_Query( array(
        'post_type' => 'menu_item',
        'posts_per_page' => -1,
        'post__not_in' => !empty($displayed_ids) ? $displayed_ids : array(),
    ) );

    if ( $other_items->have_posts() ) {
        ?>
        <section class="mb-20">
            <div class="flex items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 pr-6">
                    <?php echo !empty($categories) ? 'Other Specialties' : 'Our Menu'; ?>
                </h2>
                <div class="flex-grow h-px bg-gray-200"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ( $other_items->have_posts() ) {
                    $other_items->the_post();
                    curry_leaves_co_render_archive_item();
                }
                wp_reset_postdata();
                ?>
            </div>
        </section>
        <?php
    } elseif ( empty($categories) ) {
        echo '<p class="text-gray-500 text-lg text-center">No menu items found. Please add them from the dashboard.</p>';
    }

    /**
     * Helper function to render a menu item card
     */
    function curry_leaves_co_render_archive_item() {
        $price = get_post_meta( get_the_ID(), '_menu_item_price', true );
        $discount = get_post_meta( get_the_ID(), '_menu_item_discount_percentage', true );
        $offer_amount = get_post_meta( get_the_ID(), '_menu_item_offer_amount', true );
        $rating = get_post_meta( get_the_ID(), '_menu_item_rating', true ) ?: '0.0';
        $ingredients = get_post_meta( get_the_ID(), '_menu_item_ingredients', true );
        $img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' ) ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80';
        
        $desc_clean = wp_strip_all_tags( get_the_content() );
        ?>
        <div class="relative group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col">
            
            <div class="relative h-56 overflow-hidden bg-gray-100">
                <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <?php if ( $rating && $rating !== '0.0' ) : ?>
                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full text-sm font-bold text-gray-800 flex items-center gap-1 shadow-sm">
                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <?php echo esc_html( $rating ); ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="p-6 flex-grow flex flex-col">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xl font-bold text-gray-900 leading-tight">
                        <a href="<?php the_permalink(); ?>" class="hover:text-orange-600 focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <?php if ( $price ) : ?>
                        <div class="flex flex-col items-end gap-1 ml-4 text-right">
                            <?php if ( $has_discount ) : ?>
                                <span class="text-sm line-through text-gray-400">$<?php echo esc_html( number_format_i18n( floatval( $price ), 2 ) ); ?></span>
                            <?php endif; ?>
                            <span class="text-xl font-extrabold text-orange-600">$<?php echo esc_html( $final_price ); ?></span>
                            <?php if ( $has_discount ) : ?>
                                <span class="text-sm font-semibold text-emerald-700"><?php echo esc_html( $discount ); ?>% off</span>
                                <span class="text-xs text-gray-500">Save $<?php echo esc_html( number_format_i18n( floatval( $offer_amount ), 2 ) ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">
                    <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
                </div>
                <div class="mt-auto flex gap-3 pt-5 border-t border-gray-50 relative z-10">
                    <button onclick="event.stopPropagation();" class="flex-1 bg-white border-2 border-orange-600 text-orange-600 hover:bg-orange-50 font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm text-center">Add to Cart</button>
                    <button onclick="event.stopPropagation();" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm text-center">Order Now</button>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</main>

<?php
get_footer();
?>
