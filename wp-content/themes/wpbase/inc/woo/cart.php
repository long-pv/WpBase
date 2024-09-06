<?php
/**
 * redirect cart page to login if not logged in
 */
add_action('template_redirect', 'redirect_to_login_if_not_logged_in');

function redirect_to_login_if_not_logged_in()
{
    if (!is_user_logged_in() && is_cart()) {
        wp_redirect(wc_get_page_permalink('myaccount'));
        exit;
    }
}

/**
 * redirect to login before add to cart if not logged in
 */

add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_login_before_add_to_cart');

function redirect_to_login_before_add_to_cart($url)
{
    if (!is_user_logged_in()) {
        $url = wc_get_page_permalink('myaccount');
    }
    return $url;
}

add_filter('woocommerce_return_to_shop_redirect', 'custom_wc_backward_button_url');
function custom_wc_backward_button_url()
{
    $page_pricing = get_field('page_pricing', 'option') ?? '';
    if ($page_pricing) {
        return get_permalink($page_pricing);
    }
    return home_url();
}

add_filter('woocommerce_return_to_shop_text', 'custom_return_to_shop_text');
function custom_return_to_shop_text()
{
    return __('Continue shopping', 'pls');
}

function update_cart_count()
{
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}
add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');