<?php
add_filter('woocommerce_order_button_text', 'custom_change_checkout_button_text', 10, 1);
function custom_change_checkout_button_text($button_text)
{
    return __('Payment', 'woocommerce');
}
