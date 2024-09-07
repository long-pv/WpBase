<?php
function custom_disable_account_last_name_validation($args)
{
    unset($args['billing_last_name']);
    unset($args['account_last_name']);
    unset($args['account_display_name']);
    return $args;
}
add_filter('woocommerce_save_account_details_required_fields', 'custom_disable_account_last_name_validation');

function custom_save_account_details($user_id)
{
    // billing_phone
    if (!empty($_POST['billing_phone'])) {
        update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }

    // billing_phone
    if (!empty($_POST['billing_address_1'])) {
        update_user_meta($user_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }
}
add_action('woocommerce_save_account_details', 'custom_save_account_details');

function custom_woocommerce_after_edit_account_form()
{
    if (!empty($_GET['action']) && $_GET['action'] === 'change-pass'):
        ?>
        <script>
            var editAccountLink = document.querySelector('.woocommerce-MyAccount-navigation-link--edit-account');
            editAccountLink.classList.remove('is-active');

            var passwordChangeLink = document.querySelector('.woocommerce-MyAccount-navigation-link--edit-accountactionchange-passp');
            passwordChangeLink.classList.add('is-active');
        </script>
        <?php
    endif;
}
add_action('woocommerce_after_edit_account_form', 'custom_woocommerce_after_edit_account_form');

function custom_validate_address_and_phone_fields()
{
    if (empty($_POST['account_first_name'])) {
        wc_add_notice(__('<strong>Full name</strong> is a required field.', 'basetheme'), 'error');
    }
    if (empty($_POST['billing_address_1'])) {
        wc_add_notice(__('<strong>Address</strong> is a required field.', 'basetheme'), 'error');
    }
    if (empty($_POST['billing_phone'])) {
        wc_add_notice(__('<strong>Phone</strong> is a required field.', 'basetheme'), 'error');
    }
    if (empty($_POST['account_email'])) {
        wc_add_notice(__('<strong>Email</strong> is a required field.', 'basetheme'), 'error');
    }
}
add_action('woocommerce_save_account_details_errors', 'custom_validate_address_and_phone_fields');

add_filter('woocommerce_add_error', 'custom_remove_default_error_messages', 10, 1);
function custom_remove_default_error_messages($error)
{
    $default_errors = [
        '<strong>First name</strong> is a required field.',
        '<strong>Email address</strong> is a required field.',
    ];

    if (in_array($error, $default_errors)) {
        return '';
    }

    return $error;
}