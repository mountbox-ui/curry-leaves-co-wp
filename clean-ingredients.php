<?php
require_once( __DIR__ . '/../../../../wp-load.php' );

$posts = get_posts(array(
    'post_type' => 'menu_item',
    'posts_per_page' => -1,
));

foreach ($posts as $post) {
    $ingredients = get_post_meta($post->ID, '_menu_item_ingredients', true);
    if (strpos($ingredients, 'Warning: Undefined variable $ingredients') !== false || strpos($ingredients, 'WARNING: UNDEFINED VARIABLE') !== false) {
        update_post_meta($post->ID, '_menu_item_ingredients', '');
        echo "Cleaned ingredients for post ID: " . $post->ID . "\n";
    }
}
echo "Cleanup complete.\n";
