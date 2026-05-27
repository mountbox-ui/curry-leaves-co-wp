<?php
/**
 * Store Categories admin page and submenu registration
 */

// Register the admin menu
function curry_leaves_co_register_store_categories_menu() {
    // Top-level menu
    add_menu_page(
        __('Store Categories', 'curry-leaves-co'), // Page title
        __('Store Categories', 'curry-leaves-co'), // Menu title
        'manage_options',                         // Capability
        'store-categories',                       // Menu slug
        'curry_leaves_co_store_categories_page',   // Callback function
        'dashicons-category',                     // Icon (dashicons-category)
        25                                         // Position
    );

    // Submenu: Add New Category
    add_submenu_page(
        'store-categories',
        __('Add New Category', 'curry-leaves-co'),
        __('Add New', 'curry-leaves-co'),
        'manage_options',
        'store-categories-add',
        'curry_leaves_co_store_categories_page'
    );
}
add_action('admin_menu', 'curry_leaves_co_register_store_categories_menu');

/**
 * Render the Store Categories admin page.
 * Handles both listing and adding new categories based on the current screen.
 */
function curry_leaves_co_store_categories_page() {
    // Determine if we're on the Add New screen
    $is_add = (isset($_GET['page']) && $_GET['page'] === 'store-categories-add');
    // Process form submission for adding a new category
    if ($is_add && !empty($_POST['category_name'])) {
        $name = sanitize_text_field($_POST['category_name']);
        $parent = isset($_POST['parent_category']) ? absint($_POST['parent_category']) : 0;
        wp_insert_term(
            $name,
            'menu_category',
            array(
                'parent' => $parent,
                'description' => '',
            )
        );
        // Redirect to avoid resubmission
        echo '<script>window.location.href="admin.php?page=store-categories";</script>';
        return;
    }

    // Output page markup
    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('Store Categories', 'curry-leaves-co') . '</h1>';

    if ($is_add) {
        // Add New Category Form
        echo '<h2>' . esc_html__('Add New Category', 'curry-leaves-co') . '</h2>';
        echo '<form method="post">';
        echo '<table class="form-table"><tbody>';
        echo '<tr><th scope="row"><label for="category_name">' . esc_html__('Category Name', 'curry-leaves-co') . '</label></th>';
        echo '<td><input name="category_name" id="category_name" type="text" class="regular-text" required></td></tr>';
        // Parent dropdown
        $terms = get_terms(array('taxonomy' => 'menu_category', 'hide_empty' => false));
        echo '<tr><th scope="row"><label for="parent_category">' . esc_html__('Parent Category (optional)', 'curry-leaves-co') . '</label></th>'; 
        echo '<td><select name="parent_category" id="parent_category"><option value="0">' . esc_html__('None', 'curry-leaves-co') . '</option>';
        foreach ($terms as $term) {
            echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
        }
        echo '</select></td></tr>';
        echo '</tbody></table>';
        submit_button(esc_html__('Add Category', 'curry-leaves-co'));
        echo '</form>';
        echo '<p><a href="admin.php?page=store-categories">&larr; ' . esc_html__('Back to categories list', 'curry-leaves-co') . '</a></p>';
    } else {
        // List existing categories
        echo '<p><a href="admin.php?page=store-categories-add" class="page-title-action">' . esc_html__('Add New', 'curry-leaves-co') . '</a></p>';
        $terms = get_terms(array('taxonomy' => 'menu_category', 'hide_empty' => false, 'parent' => 0));
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<table class="wp-list-table widefat fixed striped table-view-list"><thead><tr><th>' . esc_html__('Category', 'curry-leaves-co') . '</th><th>' . esc_html__('Subcategories', 'curry-leaves-co') . '</th></tr></thead><tbody>';
            foreach ($terms as $term) {
                $subterms = get_terms(array('taxonomy' => 'menu_category', 'hide_empty' => false, 'parent' => $term->term_id));
                $sub_list = [];
                foreach ($subterms as $sub) {
                    $sub_list[] = esc_html($sub->name);
                }
                echo '<tr><td>' . esc_html($term->name) . '</td><td>' . (empty($sub_list) ? '&ndash;' : implode(', ', $sub_list)) . '</td></tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p>' . esc_html__('No categories found.', 'curry-leaves-co') . '</p>';
        }
    }
    echo '</div>';
}
?>
