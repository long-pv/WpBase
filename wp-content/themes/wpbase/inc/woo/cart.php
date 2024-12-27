<?php
function update_cart_count()
{
    $cart_count = WC()->cart->get_cart_contents_count();

    // Bắt đầu buffer để lấy nội dung mini cart
    ob_start();
    cart_collapse();
    $mini_cart = ob_get_clean();

    // Trả về dữ liệu JSON
    wp_send_json([
        'cart_count' => $cart_count,
        'mini_cart' => $mini_cart,
    ]);

    wp_die();
}
add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');
