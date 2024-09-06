<?php 
function custom_woocommerce_account_menu_items($items)
{
    $items = array(
        'edit-account' => __('Account detail', 'pls'),
        'edit-account?action=change-pass&p=' => __('Password change', 'pls'),
        'orders' => __('Orders', 'pls'),
        'customer-logout' => __('Logout', 'pls'),
    );

    return $items;
}
add_filter('woocommerce_account_menu_items', 'custom_woocommerce_account_menu_items');