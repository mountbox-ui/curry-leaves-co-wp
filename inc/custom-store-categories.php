<?php
/**
 * Register Store Categories taxonomy for menu items
 */
function curry_leaves_co_register_store_category_taxonomy()
{
    $labels = array(
        'name' => _x('Store Categories', 'taxonomy general name', 'curry-leaves-co'),
        'singular_name' => _x('Store Category', 'taxonomy singular name', 'curry-leaves-co'),
        'search_items' => __('Search Store Categories', 'curry-leaves-co'),
        'all_items' => __('All Store Categories', 'curry-leaves-co'),
        'parent_item' => __('Parent Store Category', 'curry-leaves-co'),
        'parent_item_colon' => __('Parent Store Category:', 'curry-leaves-co'),
        'edit_item' => __('Edit Store Category', 'curry-leaves-co'),
        'update_item' => __('Update Store Category', 'curry-leaves-co'),
        'add_new_item' => __('Add New Store Category', 'curry-leaves-co'),
        'new_item_name' => __('New Store Category Name', 'curry-leaves-co'),
        'menu_name' => __('Store Categories', 'curry-leaves-co'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_menu' => false,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'store-category'),
        'show_in_rest' => true,
    );

    register_taxonomy('store_category', array('menu_item'), $args);
}

// Hide Store Categories taxonomy from the Menu Item (food) edit screen
add_action('add_meta_boxes', function() {
    remove_meta_box('store_categorydiv', 'menu_item', 'side');
});

// Remove Store Categories column from the Menu Item list table
add_filter('manage_edit-menu_item_columns', function($columns) {
    if (isset($columns['store_category'])) {
        unset($columns['store_category']);
    }
    return $columns;
});

add_action('init', 'curry_leaves_co_register_store_category_taxonomy');

/**
 * Add a top‑level admin menu "Store" with a submenu for Store Categories.
 */
function curry_leaves_co_register_store_admin_menu() {
    // Top level menu
    add_menu_page(
        __('Store', 'curry-leaves-co'),          // Page title
        __('Store', 'curry-leaves-co'),          // Menu title
        'manage_options',                         // Capability
        'curry-leaves-store',
        'curry_leaves_co_store_overview_page',
        'dashicons-store',
        6
    );

    // Submenu – Store Categories list (uses built‑in taxonomy UI)
    add_submenu_page(
        'curry-leaves-store',
        __('Store Categories', 'curry-leaves-co'),
        __('Categories', 'curry-leaves-co'),
        'manage_options',
        'edit-tags.php?taxonomy=store_category&post_type=menu_item',
        ''
    );

    // Dynamically add a submenu for each Store Category
    $store_terms = get_terms(array(
        'taxonomy' => 'store_category',
        'hide_empty' => false,
    ));
    if (!is_wp_error($store_terms)) {
        foreach ($store_terms as $term) {
            // Register a submenu for each store category to manage dishes.
            $slug = 'store_category_' . $term->term_id; // unique slug
            add_submenu_page(
                'curry-leaves-store',
                $term->name,
                $term->name,
                'manage_options',
                $slug,
                'curry_leaves_co_render_store_category_page'
            );
        }
    }
}
add_action('admin_menu', 'curry_leaves_co_register_store_admin_menu');

// Fix the active menu highlighting when viewing the Store Categories (taxonomy) page
add_filter('parent_file', function($parent_file) {
    global $current_screen;
    if (isset($current_screen->taxonomy) && $current_screen->taxonomy == 'store_category') {
        return 'curry-leaves-store';
    }
    return $parent_file;
});

add_filter('submenu_file', function($submenu_file) {
    global $current_screen;
    if (isset($current_screen->taxonomy) && $current_screen->taxonomy == 'store_category') {
        return 'edit-tags.php?taxonomy=store_category&post_type=menu_item';
    }
    return $submenu_file;
});

function curry_leaves_co_store_overview_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'curry-leaves-co'));
    }

    // Handle delete store action
    if (isset($_GET['action']) && $_GET['action'] == 'delete_store' && isset($_GET['store_id']) && isset($_GET['_wpnonce'])) {
        $delete_term_id = intval($_GET['store_id']);
        if (wp_verify_nonce($_GET['_wpnonce'], 'delete_store_' . $delete_term_id)) {
            wp_delete_term($delete_term_id, 'store_category');
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Store deleted successfully.', 'curry-leaves-co') . '</p></div>';
        }
    }

    // Fetch all Store Categories, even empty ones.
    $terms = get_terms(array(
        'taxonomy' => 'store_category',
        'hide_empty' => false,
    ));
    
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">' . esc_html__('Store Overview', 'curry-leaves-co') . '</h1>';
    echo '<a href="edit-tags.php?taxonomy=store_category&post_type=menu_item" class="page-title-action">' . esc_html__('Add New Store', 'curry-leaves-co') . '</a>';
    echo '<hr class="wp-header-end">';
    
    if (!is_wp_error($terms) && !empty($terms)) {
        echo '<table class="wp-list-table widefat fixed striped" style="margin-top:20px;">';
        echo '<thead><tr>';
        echo '<th>' . esc_html__('Store Name', 'curry-leaves-co') . '</th>';
        echo '<th>' . esc_html__('Number of Menus', 'curry-leaves-co') . '</th>';
        echo '<th>' . esc_html__('Actions', 'curry-leaves-co') . '</th>';
        echo '</tr></thead><tbody>';
        
        foreach ($terms as $term) {
            $manage_link = admin_url('admin.php?page=store_category_' . $term->term_id);
            $edit_link = admin_url('term.php?taxonomy=store_category&tag_ID=' . $term->term_id . '&post_type=menu_item');
            $delete_nonce = wp_create_nonce('delete_store_' . $term->term_id);
            $delete_link = admin_url('admin.php?page=curry-leaves-store&action=delete_store&store_id=' . $term->term_id . '&_wpnonce=' . $delete_nonce);
            
            echo '<tr>';
            echo '<td><strong><a href="' . esc_url($manage_link) . '">' . esc_html($term->name) . '</a></strong></td>';
            echo '<td>' . intval($term->count) . ' ' . esc_html__('items', 'curry-leaves-co') . '</td>';
            echo '<td>';
            echo '<a href="' . esc_url($manage_link) . '" class="button button-small button-primary" style="margin-right:5px;">' . esc_html__('Manage Menus', 'curry-leaves-co') . '</a>';
            echo '<a href="' . esc_url($edit_link) . '" class="button button-small" style="margin-right:5px;">' . esc_html__('Edit Name', 'curry-leaves-co') . '</a>';
            echo '<a href="' . esc_url($delete_link) . '" class="button button-small button-link-delete" style="color:#b32d2e;" onclick="return confirm(\'' . esc_js(__('Are you sure you want to delete this store?', 'curry-leaves-co')) . '\');">' . esc_html__('Delete', 'curry-leaves-co') . '</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<div class="notice notice-warning" style="margin-top:20px;"><p>' . esc_html__('No Stores found. Click "Add New Store" to create one.', 'curry-leaves-co') . '</p></div>';
    }
    echo '</div>'; // .wrap
}

// Render page for a single store category to manage dishes.
function curry_leaves_co_render_store_category_page() {
    // Determine the store term ID from the page slug
    $page = isset($_GET['page']) ? sanitize_key($_GET['page']) : '';
    $term_id = 0;
    if (preg_match('/store_category_(\d+)/', $page, $matches)) {
        $term_id = intval($matches[1]);
    }
    if (!$term_id) {
        echo '<div class="wrap"><h2>' . esc_html__('Invalid Store', 'curry-leaves-co') . '</h2></div>';
        return;
    }
    $term = get_term($term_id, 'store_category');
    if (is_wp_error($term) || !$term) {
        echo '<div class="wrap"><h2>' . esc_html__('Store not found', 'curry-leaves-co') . '</h2></div>';
        return;
    }

    // Handle removal
    if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['dish_id'])) {
        $remove_dish_id = intval($_GET['dish_id']);
        delete_post_meta($remove_dish_id, '_curry_store_amount_' . $term_id );
        wp_remove_object_terms($remove_dish_id, $term_id, 'store_category');
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Dish removed from store.', 'curry-leaves-co') . '</p></div>';
    }

    // Handle form submission — assign dish to store (uses menu item base price).
    if (isset($_POST['curry_store_dish_id']) && check_admin_referer('curry_add_store_dish_' . $term_id)) {
        $dish_id = intval($_POST['curry_store_dish_id']);
        if ( $dish_id && get_post_type( $dish_id ) === 'menu_item' ) {
            wp_set_object_terms($dish_id, intval($term_id), 'store_category', true);
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Dish added to store.', 'curry-leaves-co') . '</p></div>';
        }
    }

    // Get all dishes (menu_item posts) for the dropdown
    $dishes = get_posts(array(
        'post_type'      => 'menu_item',
        'posts_per_page' => -1,
    ));
    
    // Get dishes assigned to THIS store for the overview table
    $store_dishes = get_posts(array(
        'post_type'      => 'menu_item',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'store_category',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
    ));

    echo '<div class="wrap">';
    echo '<h1>' . esc_html($term->name) . ' - ' . esc_html__('Menu Management', 'curry-leaves-co') . '</h1>';
    
    // The form
    echo '<div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); margin-top: 20px;">';
    echo '<h2>' . esc_html__('Add Dish to Store', 'curry-leaves-co') . '</h2>';
    echo '<p class="description" style="margin-bottom: 1em;">' . esc_html__('Pricing is set on each menu item under Food Menus. Assign dishes to this store below.', 'curry-leaves-co') . '</p>';
    echo '<form method="post" action="?page=' . esc_attr($_GET['page']) . '" style="display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap;">';
    wp_nonce_field('curry_add_store_dish_' . $term_id);

    echo '<div>';
    echo '<label for="curry_store_dish_id" style="display:block; font-weight:bold; margin-bottom:5px;">' . esc_html__('Select Dish', 'curry-leaves-co') . '</label>';
    echo '<select name="curry_store_dish_id" id="curry_store_dish_id" required style="min-width: 280px;">';
    echo '<option value="">' . esc_html__('Select a dish', 'curry-leaves-co') . '</option>';
    foreach ($dishes as $dish) {
        $base_price = get_post_meta($dish->ID, '_menu_item_price', true);
        $label      = $dish->post_title;
        if ($base_price) {
            $label .= ' — $' . $base_price;
        }
        echo '<option value="' . esc_attr($dish->ID) . '">' . esc_html($label) . '</option>';
    }
    echo '</select>';
    echo '</div>';

    echo '<div>';
    submit_button(__('Add to Store', 'curry-leaves-co'), 'primary', 'submit', false);
    echo '</div>';

    echo '</form>';
    echo '</div>';

    // The overview table
    echo '<div style="margin-top: 40px;">';
    echo '<h2>' . esc_html__('Dishes in this Store', 'curry-leaves-co') . '</h2>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr>';
    echo '<th>' . esc_html__('Dish Name', 'curry-leaves-co') . '</th>';
    echo '<th>' . esc_html__('Price', 'curry-leaves-co') . '</th>';
    echo '<th>' . esc_html__('Actions', 'curry-leaves-co') . '</th>';
    echo '</tr></thead><tbody>';
    
    if (empty($store_dishes)) {
        echo '<tr><td colspan="3">' . esc_html__('No dishes have been added to this store yet.', 'curry-leaves-co') . '</td></tr>';
    } else {
        foreach ($store_dishes as $dish) {
            $price = get_post_meta($dish->ID, '_menu_item_price', true);

            echo '<tr>';
            echo '<td><strong>' . esc_html($dish->post_title) . '</strong></td>';
            echo '<td>' . ( $price ? '$' . esc_html($price) : '<span style="color:#999;">' . esc_html__('Not set', 'curry-leaves-co') . '</span>' ) . '</td>';

            $remove_url = admin_url('admin.php?page=' . esc_attr($_GET['page']) . '&action=remove&dish_id=' . $dish->ID);
            echo '<td><a href="' . esc_url($remove_url) . '" class="button button-small" onclick="return confirm(\'' . esc_js(__('Are you sure you want to remove this dish from the store?', 'curry-leaves-co')) . '\');">' . esc_html__('Remove', 'curry-leaves-co') . '</a></td>';

            echo '</tr>';
        }
    }

    echo '</tbody></table>';
    echo '</div>';
    echo '</div>'; // .wrap
}
