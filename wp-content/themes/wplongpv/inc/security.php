<?php
/**
 * Plugin Name: Security setup
 * Description: Some basic security settings.
 * Version: 1.0.0
 * Author: Longpv
 * License: GPLv2
 */

// remove wp_version
function vf_remove_wp_version_strings($src)
{
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'vf_remove_wp_version_strings');
add_filter('style_loader_src', 'vf_remove_wp_version_strings');

// Hide WP version strings from generator meta tag
function vf_remove_version()
{
    return '';
}
add_filter('the_generator', 'vf_remove_version');

// Change default login error
function vf_login_errors()
{
    return 'Invalid user!';
}
add_filter('login_errors', 'vf_login_errors');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// hide admin of comments
add_action('admin_init', function () {
    remove_menu_page('edit-comments.php');
});

// change logo, link logo page login
function custom_login_logo()
{
    echo '<style type="text/css">
    h1 a {
      background-image: url(' . get_template_directory_uri() . '/assets/images/logo.png) !important;
      height: 80px !important;
      width: 100% !important;
      background-size: auto !important;
    }
  </style>';
}
add_action('login_head', 'custom_login_logo');

// Change the url on the login page to the home page
function custom_login_url($url)
{
    $link = get_home_url();
    return $link;
}
add_filter('login_headerurl', 'custom_login_url');

// upload size limit 2MB
add_filter('upload_size_limit', 'PBP_increase_upload');
function PBP_increase_upload($bytes)
{
    return 524288 * 4;
}

// Remove wp's default comment function
function disable_comments_and_pings_post_type()
{
    remove_post_type_support('post', 'comments');
    remove_post_type_support('post', 'trackbacks');
}
add_action('init', 'disable_comments_and_pings_post_type');

// Limit the type of files uploaded through the form
function restrict_file_types($mimes)
{
    $allowed_mime_types = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf',
        'mp4' => 'video/mp4',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'csv' => 'text/csv',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    );

    $mimes = array_intersect($allowed_mime_types, $mimes);

    return $mimes;
}
add_filter('upload_mimes', 'restrict_file_types');

/**
 * Add Recommended size image to Featured Image Box    
 */
//add_filter('admin_post_thumbnail_html', 'add_featured_image_instruction');
function add_featured_image_instruction($html)
{
    if (get_post_type() === 'post') {
        $html .= '<p>Recommended size: 300x300</p>';
    }

    // List of other post types
    if (get_post_type() === 'resources') {
        $html .= '<p>Recommended size: 300x300</p>';
    }
    if (get_post_type() === 'project') {
        $html .= '<p>Recommended size: 300x300</p>';
    }

    return $html;
}

// redirect wp-admin and wp-register.php to the homepage
add_action('init', 'custom_login_redirect');
function custom_login_redirect()
{
    if (!is_user_logged_in() && !defined('DOING_AJAX') && (strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== false || strpos($_SERVER['REQUEST_URI'], 'wp-register.php') !== false)) {
        wp_redirect(home_url());
        exit();
    }
}

// Remove check to allow weak passwords
add_action('admin_footer', 'custom_admin_footer_script');
function custom_admin_footer_script()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $(".pw-weak").remove();
        });
    </script>
    <?php
}

// Block CORS in WordPress
add_action('init', 'add_cors_http_header');
function add_cors_http_header()
{
    header("Access-Control-Allow-Origin: *");
    header("X-Powered-By: none");
}

function disable_plugin_updates($value)
{
    if (isset($value->response['advanced-custom-fields-pro/acf.php'])) {
        unset($value->response['advanced-custom-fields-pro/acf.php']);
    }
    return $value;
}
add_filter('site_transient_update_plugins', 'disable_plugin_updates');