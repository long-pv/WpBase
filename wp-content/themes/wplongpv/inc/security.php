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

// hide menu sidebar
add_action('admin_head', 'hide_custom_sidebar');
function hide_custom_sidebar()
{
    echo '<style>
  #wp-admin-bar-comments, #wp-admin-bar-wp-logo, #wp-admin-bar-languages{
    display: none !important;  
  }

  .pw-weak {
    display: none !important;
  }

  #commentstatusdiv, #authordiv, #slugdiv, #commentsdiv, #trackbacksdiv {
    display: none !important;  
  }
</style>';
}

// add css style.css default
function add_custom_css()
{
    wp_add_inline_style('custom-style', '#wp-admin-bar-comments, #wp-admin-bar-customize, #wp-admin-bar-wp-logo, #wp-admin-bar-languages{display: none !important;}');
}
add_action('wp_enqueue_scripts', 'add_custom_css');

// hide seo readability filters
function hide_seo_readability_filters()
{
    echo '<style>
    #wpseo-filter, #wpseo-readability-filter {
        display: none !important;
    }
  </style>';
}
add_action('admin_head-edit.php', 'hide_seo_readability_filters');

// change logo, link logo page login
function custom_login_logo()
{
    echo '<style type="text/css">
    h1 a {
      background-image: url(' . get_template_directory_uri() . '/assets/images/logo.svg) !important;
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

// Set cookie timeout 14 day
add_filter('auth_cookie_expiration', 'cl_expiration_filter', 99, 3);
function cl_expiration_filter($seconds, $user_id, $remember)
{

    if ($remember) {
        $expiration = 14 * 24 * 60 * 60;
    } else {
        $expiration = 30 * 60;
    }

    if (PHP_INT_MAX - time() < $expiration) {
        $expiration = PHP_INT_MAX - time() - 5;
    }

    return $expiration;
}

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
add_filter('admin_post_thumbnail_html', 'add_featured_image_instruction');
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
    if (!is_user_logged_in() && (strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== false || strpos($_SERVER['REQUEST_URI'], 'wp-register.php') !== false || (strpos($_SERVER['REQUEST_URI'], '/wp-json') !== false && strpos($_SERVER['REQUEST_URI'], 'json/wp') === false))) {
        wp_redirect(home_url());
        exit();
    }
}

// Apply a filter to the field value before saving
function custom_modify_text_field($value, $post_id, $field)
{
    if ($field['type'] && in_array($field['type'], ['text', 'url', 'email'])) {
        $value = strip_tags($value);
    } else {
        $value = str_replace(['<script>', '</script>', 'alert', '$(', '&lt;script&gt;', '&lt;/script&gt'], '', $value);
    }

    return $value;
}
add_filter('acf/update_value', 'custom_modify_text_field', 10, 3);

// Apply a filter to the title before saving
add_filter('title_save_pre', 'clear_tag_html_post_title');
function clear_tag_html_post_title($title)
{
    return strip_tags($title);
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