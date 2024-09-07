<?php
function update_cart_count()
{
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}
add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');