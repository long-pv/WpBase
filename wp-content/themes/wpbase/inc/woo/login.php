<?php
function update_woocommerce_registration_option_admin()
{
    // Allow customers to place orders without an account
    update_option('woocommerce_enable_guest_checkout', 'no');
    // Allow customers to log into an existing account during checkout
    update_option('woocommerce_enable_checkout_login_reminder', 'no');
    // Allow customers to create an account during checkout
    update_option('woocommerce_enable_signup_and_login_from_checkout', 'no');

    // Allow customers to create an account on the "My account" page
    update_option('woocommerce_registration_generate_username', 'yes');
    // When creating an account, automatically generate an account username for the customer based on their name, surname or email
    update_option('woocommerce_enable_myaccount_registration', 'yes');
    // When creating an account, send the new user a link to set their password
    update_option('woocommerce_registration_generate_password', 'no');
}
add_action('admin_init', 'update_woocommerce_registration_option_admin');