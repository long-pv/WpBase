<?php
function woocommerce_registration_errors_validation($reg_errors)
{
    extract($_POST);

    if (!empty($password)) {
        if (strlen(trim($password)) < 8) {
            return new WP_Error('password_length_error', __('Password must be at least 8 characters long.', 'pls'));
        }

        if (preg_match('/\s/', $password)) {
            return new WP_Error('password_spaces_error', __('Password cannot contain spaces.', 'pls'));
        }

        if (!preg_match('/^[a-zA-Z0-9!@#$%^&*]+$/', $password)) {
            return new WP_Error('password_invalid_characters_error', __('Password contains invalid characters. Only letters, numbers, and special characters !, @, #, $, %, ^, &, * are allowed.', 'pls'));
        }

        if (strcmp($password, $password2) !== 0) {
            return new WP_Error('registration-error', __('Passwords do not match.', 'pls'));
        }
    }

    return $reg_errors;
}
add_filter('woocommerce_registration_errors', 'woocommerce_registration_errors_validation');