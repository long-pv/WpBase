<?php
function remove_checkout_fields($fields)
{
    $fields_to_remove = array(
        'billing_last_name',
        'billing_postcode',
        'billing_state',
        'billing_address_2',
        'billing_company',
        'billing_country',
        'billing_city',
    );

    // billing_first_name
    $fields['billing']['billing_first_name']['label'] = __('Full name', 'pls');
    $fields['billing']['billing_first_name']['placeholder'] = __('Full name', 'pls');

    // billing_address_1
    $fields['billing']['billing_address_1']['label'] = __('Address', 'pls');
    $fields['billing']['billing_address_1']['placeholder'] = __('Address', 'pls');

    // billing_email
    $fields['billing']['billing_email']['label'] = __('Email', 'pls');
    $fields['billing']['billing_email']['placeholder'] = __('Email', 'pls');

    // billing_phone
    $fields['billing']['billing_phone']['label'] = __('Phone', 'pls');
    $fields['billing']['billing_phone']['placeholder'] = __('Phone', 'pls');

    foreach ($fields_to_remove as $field) {
        if (isset($fields['billing'][$field])) {
            unset($fields['billing'][$field]);
        }
    }

    unset($fields['order']['order_comments']);

    return $fields;
}

add_filter('woocommerce_checkout_fields', 'remove_checkout_fields');

add_filter('woocommerce_cart_needs_shipping_address', '__return_false');

remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);

add_filter('woocommerce_get_privacy_policy_text', 'custom_checkout_privacy_policy_text');
function custom_checkout_privacy_policy_text($text)
{
    $text = __('Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.', 'pls');
    return $text;
}

add_filter('woocommerce_order_button_text', 'custom_change_checkout_button_text', 10, 1);
function custom_change_checkout_button_text($button_text)
{
    return __('Payment', 'woocommerce');
}
