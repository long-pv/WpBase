<?php
// setting image in content editor
function set_default_image_settings_on_login($user_login, $user)
{
    global $wpdb;

    $user_id = $user->ID;
    $prefix = $wpdb->prefix;
    $meta_key = $prefix . 'user-settings';
    $current_settings = get_user_meta($user_id, $meta_key, true);

    if (strpos($current_settings, '&align=') !== false) {
        $current_settings = preg_replace('/&align=([^"]*)/', '&align=center', $current_settings);
    } else {
        $current_settings .= '&align=center';
    }

    if (strpos($current_settings, '&imgsize=') !== false) {
        $current_settings = preg_replace('/&imgsize=([^"]*)/', '&imgsize=center', $current_settings);
    } else {
        $current_settings .= '&imgsize=center';
    }

    update_user_meta($user_id, $meta_key, $current_settings);
}
add_action('wp_login', 'set_default_image_settings_on_login', 10, 2);
