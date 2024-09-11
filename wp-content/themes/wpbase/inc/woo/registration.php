<?php
// validate các field nhập từ form đăng ký
function woocommerce_registration_errors_validation($reg_errors)
{
    extract($_POST);

    // Check email validity and uniqueness
    if (!is_email($email) || strlen($email) > 40) {
        return new WP_Error('email_strlen', __('Please enter a valid email address, no more than 40 characters.', 'basetheme'));
    }

    // validate first name
    if (empty($billing_first_name)) {
        return new WP_Error('billing_first_name_error', __('Please enter your first name.', 'basetheme'));
    } elseif (strlen($billing_first_name) > 20) {
        return new WP_Error('billing_first_name_error', __('Please enter a valid first name, no more than 20 characters.', 'basetheme'));
    }

    // validate address
    if (empty($billing_address_1)) {
        return new WP_Error('billing_address_error', __('Please enter your address.', 'basetheme'));
    }

    // validate phone
    if (empty($billing_phone)) {
        return new WP_Error('billing_phone_error', __('Please enter your phone number.', 'basetheme'));
    } elseif (!preg_match('/^0[0-9]{9,14}$/', $billing_phone)) {
        return new WP_Error('billing_phone_format_error', __('Please enter a valid phone number (10-15 digits, starts with 0).', 'basetheme'));
    }

    // validate password
    if (!empty($password)) {
        if (strlen(trim($password)) < 8) {
            return new WP_Error('password_length_error', __('Password must be at least 8 characters long.', 'basetheme'));
        }

        if (preg_match('/\s/', $password)) {
            return new WP_Error('password_spaces_error', __('Password cannot contain spaces.', 'basetheme'));
        }

        if (!preg_match('/^[a-zA-Z0-9!@#$%^&*]+$/', $password)) {
            return new WP_Error('password_invalid_characters_error', __('Password contains invalid characters. Only letters, numbers, and special characters !, @, #, $, %, ^, &, * are allowed.', 'basetheme'));
        }

        if (strcmp($password, $password2) !== 0) {
            return new WP_Error('registration-error', __('Passwords do not match.', 'basetheme'));
        }
    }

    return $reg_errors;
}
add_filter('woocommerce_registration_errors', 'woocommerce_registration_errors_validation');

// Lưu các trường tùy chỉnh vào thông tin khách hàng sau khi đăng ký
add_action('woocommerce_created_customer', 'save_custom_register_fields');
function save_custom_register_fields($customer_id)
{
    if (!empty($_POST['billing_first_name'])) {
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
    }

    if (!empty($_POST['billing_address_1'])) {
        update_user_meta($customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }

    if (!empty($_POST['billing_phone'])) {
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
}

// loại bỏ việc kiểm tra mật khẩu mạnh/yếu
add_action('wp_enqueue_scripts', 'custom_deactivate_pass_strength_meter', 99);
function custom_deactivate_pass_strength_meter()
{
    wp_dequeue_script('wc-password-strength-meter');
}

// loại bỏ mức yêu cầu mật khẩu nhập vào
add_filter('woocommerce_min_password_strength', 'custom_change_password_strength');
function custom_change_password_strength($strength)
{
    return 0;
}