<?php
function woo_title()
{
    if (is_account_page()) {
        if (is_user_logged_in()) {
            if (is_wc_endpoint_url('edit-account')) {
                if (!empty($_GET['action']) && $_GET['action'] == 'change-pass') {
                    echo __('Change password', 'basetheme');
                } else {
                    echo __('Account detail', 'basetheme');
                }
            } else if (is_wc_endpoint_url('orders') || is_wc_endpoint_url('view-order')) {
                echo __('Order', 'basetheme');
            } else if (is_wc_endpoint_url('lost-password')) {
                if (!empty($_GET['show-reset-form']) && $_GET['show-reset-form'] == 'true') {
                    echo __('Reset password', 'basetheme');
                } else {
                    echo __('Lost password', 'basetheme');
                }
            }
        } else {
            if (!empty($_GET['action']) && $_GET['action'] == 'register') {
                echo __('Register', 'basetheme');
            } else {
                echo __('Login', 'basetheme');
            }
        }
    } else if (is_checkout() && is_wc_endpoint_url('order-received')) {
        echo '';
    } else {
        the_title();
    }
}