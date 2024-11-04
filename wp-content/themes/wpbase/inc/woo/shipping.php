<?php
function disable_shipping_calculator($show_shipping)
{
    return false;
}
add_filter('woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calculator', 99);