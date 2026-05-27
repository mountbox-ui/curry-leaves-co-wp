<?php
/**
 * Register Custom Post Types and Taxonomies
 */

function curry_leaves_co_register_menu_cpt()
{
    $labels = array(
        'name' => _x('Food Menus', 'Post Type General Name', 'curry-leaves-co'),
        'singular_name' => _x('Menu Item', 'Post Type Singular Name', 'curry-leaves-co'),
        'menu_name' => __('Food Menus', 'curry-leaves-co'),
        'all_items' => __('All Menu Items', 'curry-leaves-co'),
        'add_new_item' => __('Add New Menu Item', 'curry-leaves-co'),
        'add_new' => __('Add New', 'curry-leaves-co'),
        'new_item' => __('New Menu Item', 'curry-leaves-co'),
        'edit_item' => __('Edit Menu Item', 'curry-leaves-co'),
        'update_item' => __('Update Menu Item', 'curry-leaves-co'),
        'view_item' => __('View Menu Item', 'curry-leaves-co'),
        'search_items' => __('Search Menu Items', 'curry-leaves-co'),
    );
    $args = array(
        'label' => __('Menu Item', 'curry-leaves-co'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-food', // Requires WordPress 5.3+ for some icons, dashicons-food is standard
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => false, // Disables Gutenberg editor to stay in classic dashboard
    );
    register_post_type('menu_item', $args);

    // Register Taxonomy for Menu Categories
    $tax_labels = array(
        'name' => _x('Menu Categories', 'Taxonomy General Name', 'curry-leaves-co'),
        'singular_name' => _x('Menu Category', 'Taxonomy Singular Name', 'curry-leaves-co'),
        'menu_name' => __('Categories', 'curry-leaves-co'),
        'all_items' => __('All Categories', 'curry-leaves-co'),
        'new_item_name' => __('New Category Name', 'curry-leaves-co'),
        'add_new_item' => __('Add New Category', 'curry-leaves-co'),
        'edit_item' => __('Edit Category', 'curry-leaves-co'),
        'update_item' => __('Update Category', 'curry-leaves-co'),
    );
    $tax_args = array(
        'labels' => $tax_labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true,
    );
    register_taxonomy('menu_category', array('menu_item'), $tax_args);
}
add_action('init', 'curry_leaves_co_register_menu_cpt', 0);

/**
 * Add Meta Box for Menu Item Price
 */
function curry_leaves_co_add_menu_meta_box()
{
    add_meta_box(
        'menu_item_details',
        __('Menu Item Details', 'curry-leaves-co'),
        'curry_leaves_co_menu_meta_box_callback',
        'menu_item',
        'advanced',
        'high'
    );
}
add_action('add_meta_boxes', 'curry_leaves_co_add_menu_meta_box');

function curry_leaves_co_rename_excerpt_meta_box() {
    remove_meta_box( 'postexcerpt', 'menu_item', 'normal' );
    add_meta_box( 'postexcerpt', __( 'Short Description', 'curry-leaves-co' ), 'curry_leaves_co_short_description_meta_box', 'menu_item', 'advanced', 'high' );
}
add_action( 'add_meta_boxes', 'curry_leaves_co_rename_excerpt_meta_box' );

function curry_leaves_co_short_description_meta_box( $post ) {
    ?>
    <label class="screen-reader-text" for="excerpt"><?php _e( 'Short Description', 'curry-leaves-co' ); ?></label>
    <textarea rows="2" cols="40" name="excerpt" id="excerpt" maxlength="100" style="width: 100%;"><?php echo esc_textarea( $post->post_excerpt ); ?></textarea>
    <p class="description"><?php _e( 'Maximum 100 characters allowed.', 'curry-leaves-co' ); ?></p>
    <?php
}

function curry_leaves_co_menu_meta_box_callback($post)
{
    wp_nonce_field('menu_item_save_meta_box_data', 'menu_item_meta_box_nonce');
    $price = get_post_meta($post->ID, '_menu_item_price', true);
    $discount = get_post_meta($post->ID, '_menu_item_discount_percentage', true);
    $offer_amount = get_post_meta($post->ID, '_menu_item_offer_amount', true);
    $calculated_final_price = '';
    if ($price && $discount && $offer_amount !== '') {
        $numeric_price = floatval(preg_replace('/[^0-9\.]/', '', $price));
        $calculated_final_price = number_format_i18n(max(0, $numeric_price - floatval($offer_amount)), 2);
    }
    ?>
    <p>
        <label
            for="menu_item_price"><strong><?php _e('Price (e.g. 12.99 or $12.99)', 'curry-leaves-co'); ?></strong></label><br>
        <input type="text" id="menu_item_price" name="menu_item_price" value="<?php echo esc_attr($price); ?>"
            size="25" />
    </p>
    <p>
        <label
            for="menu_item_discount"><strong><?php _e('Discount (%)', 'curry-leaves-co'); ?></strong></label><br>
        <input type="number" id="menu_item_discount" name="menu_item_discount" value="<?php echo esc_attr($discount); ?>"
            min="0" max="100" step="0.1" size="25" />
    </p>
    <p>
        <label
            for="menu_item_final_price"><strong><?php _e('Final Price', 'curry-leaves-co'); ?></strong></label><br>
        <input type="text" id="menu_item_final_price" name="menu_item_final_price" value="<?php echo esc_attr($calculated_final_price); ?>"
            size="25" readonly style="background:#f7f7f7;border:1px solid #ddd;" />
    </p>
    <script>
        (function() {
            var priceEl = document.getElementById('menu_item_price');
            var discountEl = document.getElementById('menu_item_discount');
            var finalEl = document.getElementById('menu_item_final_price');

            function formatValue(amount) {
                return amount !== '' ? amount.toFixed(2) : '';
            }

            function calculateFinalPrice() {
                var price = parseFloat(priceEl.value.replace(/[^0-9\.]/g, '')) || 0;
                var discount = parseFloat(discountEl.value) || 0;
                var finalPrice = '';
                if (price > 0) {
                    finalPrice = price - (price * discount / 100);
                }
                finalEl.value = formatValue(finalPrice);
            }

            priceEl.addEventListener('input', calculateFinalPrice);
            discountEl.addEventListener('input', calculateFinalPrice);
            calculateFinalPrice();
        })();
    </script>
    <p>
        <label
            for="menu_item_ingredients"><strong><?php _e('Ingredients (comma separated)', 'curry-leaves-co'); ?></strong></label><br>
        <textarea id="menu_item_ingredients" name="menu_item_ingredients" rows="4"
            style="width:100%;"><?php echo esc_textarea($ingredients); ?></textarea>
    </p>
    <?php
}

function curry_leaves_co_save_menu_meta_box_data($post_id)
{
    if (!isset($_POST['menu_item_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['menu_item_meta_box_nonce'], 'menu_item_save_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['menu_item_price'])) {
        $price_value = sanitize_text_field($_POST['menu_item_price']);
        update_post_meta($post_id, '_menu_item_price', $price_value);
    } else {
        $price_value = get_post_meta($post_id, '_menu_item_price', true);
    }

    $sanitized_price = floatval(preg_replace('/[^0-9\.]/', '', $price_value));
    $discount_percentage = 0;
    if (isset($_POST['menu_item_discount'])) {
        $discount_percentage = floatval(sanitize_text_field($_POST['menu_item_discount']));
        update_post_meta($post_id, '_menu_item_discount_percentage', $discount_percentage);
    }

    if ($sanitized_price > 0 && $discount_percentage > 0) {
        $offer_amount = round($sanitized_price * $discount_percentage / 100, 2);
        update_post_meta($post_id, '_menu_item_offer_amount', $offer_amount);
    } else {
        update_post_meta($post_id, '_menu_item_offer_amount', '');
    }

    if (isset($_POST['menu_item_ingredients'])) {
        update_post_meta($post_id, '_menu_item_ingredients', sanitize_textarea_field($_POST['menu_item_ingredients']));
    }
}
add_action('save_post', 'curry_leaves_co_save_menu_meta_box_data');

/**
 * Change title placeholder text for Menu Items
 */
function curry_leaves_co_change_menu_title_placeholder($title)
{
    $screen = get_current_screen();
    if ($screen && 'menu_item' == $screen->post_type) {
        return __('Dish Name', 'curry-leaves-co');
    }
    return $title;
}
add_filter('enter_title_here', 'curry_leaves_co_change_menu_title_placeholder');

/**
 * Add label above the main description editor
 */
function curry_leaves_co_add_editor_label($post)
{
    if ('menu_item' === $post->post_type) {
        global $wp_meta_boxes;
        do_meta_boxes( get_current_screen(), 'advanced', $post );
        unset( $wp_meta_boxes['menu_item']['advanced'] );
        
        echo '<div style="margin-top:20px; margin-bottom:5px;"><label style="font-size:24px; font-weight:600; color:#1d2327;">' . __('Long Description', 'curry-leaves-co') . '</label></div>';
    }
}
add_action('edit_form_after_title', 'curry_leaves_co_add_editor_label');

/**
 * Add checkbox field to menu category edit/add form
 */
function curry_leaves_co_menu_category_add_form_fields() {
    ?>
    <div class="form-field">
        <label for="show_in_favorites"><?php _e('Show in Favourite Dishes', 'curry-leaves-co'); ?></label>
        <input type="checkbox" name="show_in_favorites" id="show_in_favorites" value="1" />
        <p class="description"><?php _e('Enable this category to appear in the Favourite Dishes section on the homepage.', 'curry-leaves-co'); ?></p>
    </div>
    <?php
}
add_action('menu_category_add_form_fields', 'curry_leaves_co_menu_category_add_form_fields');

/**
 * Add checkbox field to menu category edit form
 */
function curry_leaves_co_menu_category_edit_form_fields($term) {
    $checked = get_term_meta($term->term_id, 'show_in_favorites', true);
    ?>
    <tr class="form-field">
        <th scope="row">
            <label for="show_in_favorites"><?php _e('Show in Favourite Dishes', 'curry-leaves-co'); ?></label>
        </th>
        <td>
            <input type="checkbox" name="show_in_favorites" id="show_in_favorites" value="1" <?php checked($checked, '1'); ?> />
            <p class="description"><?php _e('Enable this category to appear in the Favourite Dishes section on the homepage.', 'curry-leaves-co'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('menu_category_edit_form_fields', 'curry_leaves_co_menu_category_edit_form_fields');

/**
 * Save category meta field
 */
function curry_leaves_co_save_menu_category_meta($term_id) {
    if (isset($_POST['show_in_favorites'])) {
        update_term_meta($term_id, 'show_in_favorites', '1');
    } else {
        delete_term_meta($term_id, 'show_in_favorites');
    }
}
add_action('edit_menu_category', 'curry_leaves_co_save_menu_category_meta');
add_action('create_menu_category', 'curry_leaves_co_save_menu_category_meta');

/**
 * Get menu categories enabled for favourite dishes
 */
function curry_leaves_co_get_favorite_categories() {
    $categories = get_terms(array(
        'taxonomy' => 'menu_category',
        'hide_empty' => false,
        'meta_query' => array(
            array(
                'key' => 'show_in_favorites',
                'value' => '1',
                'compare' => '='
            )
        )
    ));
    return is_wp_error($categories) ? array() : $categories;
}

/**
 * Dish of the Month admin column and selection.
 */
function curry_leaves_co_menu_item_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( 'title' === $key ) {
            $new_columns['dish_of_month'] = __( 'Dish of the Month', 'curry-leaves-co' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_edit-menu_item_columns', 'curry_leaves_co_menu_item_columns' );

function curry_leaves_co_menu_item_custom_column( $column, $post_id ) {
    if ( 'dish_of_month' !== $column ) {
        return;
    }

    $selected_id = absint( get_option( 'clc_dish_of_month', 0 ) );
    $checked = $selected_id === $post_id ? ' checked' : '';
    echo '<label style="display:flex;align-items:center;gap:.5rem;">
        <input type="radio" name="clc_dish_of_month" value="' . esc_attr( $post_id ) . '" data-post-id="' . esc_attr( $post_id ) . '"' . $checked . ' />
        <span>' . ( $checked ? esc_html__( 'Selected', 'curry-leaves-co' ) : '' ) . '</span>
    </label>';
}
add_action( 'manage_menu_item_posts_custom_column', 'curry_leaves_co_menu_item_custom_column', 10, 2 );

function curry_leaves_co_menu_item_admin_script() {
    $screen = get_current_screen();
    if ( ! $screen || 'edit-menu_item' !== $screen->id ) {
        return;
    }

    $nonce = wp_create_nonce( 'clc_dish_of_month_nonce' );
    ?>
    <script>
    (function(){
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="clc_dish_of_month"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    var dishId = this.value;
                    var data = new FormData();
                    data.append('action', 'clc_set_dish_of_month');
                    data.append('dish_id', dishId);
                    data.append('_ajax_nonce', '<?php echo esc_js( $nonce ); ?>');

                    fetch(ajaxurl, {
                        method: 'POST',
                        body: data,
                        credentials: 'same-origin'
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(result) {
                        if (!result.success) {
                            alert(result.data?.message || '<?php echo esc_js( __( 'Unable to save Dish of the Month.', 'curry-leaves-co' ) ); ?>');
                            return;
                        }

                        document.querySelectorAll('input[name="clc_dish_of_month"]').forEach(function(other) {
                            if (other.value !== dishId) {
                                other.checked = false;
                            }
                        });

                        var message = result.data?.message || '<?php echo esc_js( __( 'Dish of the Month updated.', 'curry-leaves-co' ) ); ?>';
                        var notice = document.querySelector('.clc-dish-of-month-notice');
                        if (!notice) {
                            notice = document.createElement('div');
                            notice.className = 'notice notice-success is-dismissible clc-dish-of-month-notice';
                            notice.style.marginTop = '1rem';
                            var wrap = document.querySelector('.wrap');
                            if (wrap) {
                                wrap.insertBefore(notice, wrap.firstChild);
                            }
                        }
                        notice.textContent = message;
                    });
                });
            });
        });
    })();
    </script>
    <?php
}
add_action( 'admin_footer-edit.php', 'curry_leaves_co_menu_item_admin_script' );

function curry_leaves_co_ajax_set_dish_of_month() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => __( 'You do not have permission to update this setting.', 'curry-leaves-co' ) ) );
    }

    check_ajax_referer( 'clc_dish_of_month_nonce' );

    $dish_id = isset( $_POST['dish_id'] ) ? absint( $_POST['dish_id'] ) : 0;
    if ( $dish_id ) {
        $post = get_post( $dish_id );
        if ( ! $post || 'menu_item' !== $post->post_type ) {
            wp_send_json_error( array( 'message' => __( 'Invalid menu item selected.', 'curry-leaves-co' ) ) );
        }
        update_option( 'clc_dish_of_month', $dish_id );
    } else {
        delete_option( 'clc_dish_of_month' );
    }

    wp_send_json_success( array( 'message' => __( 'Dish of the Month updated.', 'curry-leaves-co' ) ) );
}
add_action( 'wp_ajax_clc_set_dish_of_month', 'curry_leaves_co_ajax_set_dish_of_month' );

