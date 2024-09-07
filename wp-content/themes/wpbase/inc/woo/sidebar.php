<?php 
function custom_woocommerce_account_menu_items($items)
{
    $items = array(
        'edit-account' => __('Account detail', 'basetheme'),
        'edit-account?action=change-pass&p=' => __('Password change', 'basetheme'),
        'orders' => __('Orders', 'basetheme'),
        'customer-logout' => __('Logout', 'basetheme'),
    );

    return $items;
}
add_filter('woocommerce_account_menu_items', 'custom_woocommerce_account_menu_items');