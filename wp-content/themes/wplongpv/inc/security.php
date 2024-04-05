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

// upload size limit 2MB
add_filter('upload_size_limit', 'PBP_increase_upload');
function PBP_increase_upload($bytes)
{
    return 524288 * 4;
}

// Remove wp's default comment function
function disable_comments_and_pings_post_type()
{
    // Remove comments displayed in posts
    remove_post_type_support('post', 'comments');
    remove_post_type_support('post', 'trackbacks');

    // Automatically update status in admin settings
    update_option('default_ping_status', 'closed');
    update_option('default_comment_status', 'closed');
    update_option('comments_notify', 0);
    update_option('moderation_notify', 1);
    update_option('comment_registration', 1);
    update_option('close_comments_for_old_posts', 1);
    update_option('require_name_email', 1);
    update_option('show_comments_cookies_opt_in', 1);
    update_option('thread_comments', 1);
    update_option('page_comments', 1);
    update_option('close_comments_days_old', 1);
    update_option('default_pingback_flag', 0);
    update_option('comment_moderation', 1);
    update_option('comment_previously_approved', 1);
    update_option('comment_max_links', 1);
}
add_action('admin_init', 'disable_comments_and_pings_post_type');

// Set cookie timeout 14 day
add_filter('auth_cookie_expiration', 'cl_expiration_filter', 99, 3);
function cl_expiration_filter($seconds, $user_id, $remember)
{

    if ($remember) {
        $expiration = 14 * 24 * 60 * 60;
    } else {
        $expiration = 15 * 60;
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
        // 'gif' => 'image/gif',
        // 'doc' => 'application/msword',
        // 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        // 'csv' => 'text/csv',
        // 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    );

    $mimes = array_intersect($allowed_mime_types, $mimes);

    return $mimes;
}
add_filter('upload_mimes', 'restrict_file_types');

// redirect wp-admin and wp-register.php to the homepage
add_action('init', 'custom_login_redirect');
function custom_login_redirect()
{
    if (!is_user_logged_in() && !is_admin() && !defined('DOING_AJAX') && (strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== false || strpos($_SERVER['REQUEST_URI'], 'wp-register.php') !== false)) {
        wp_redirect(home_url());
        exit();
    }
    // Particularly, urls containing xmlrpc.php give status 403
    if (strpos($_SERVER['REQUEST_URI'], 'xmlrpc.php') !== false) {
        status_header(403);
        exit();
    }
}

// Apply a filter to the field value before saving
function custom_modify_text_field($value, $post_id, $field)
{
    if ($field["name"] == 'google_analytics') {
        $value_change = $value;
    } else {
        $value_change = custom_replace_value($value);
    }

    return $value_change;
}
add_filter('acf/update_value', 'custom_modify_text_field', 10, 3);

// Apply a filter to the title before saving
add_filter('title_save_pre', 'clear_tag_html_post_title');
function clear_tag_html_post_title($title)
{
    $title = custom_replace_value($title);
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
add_action('send_headers', 'add_cors_http_header');
function add_cors_http_header()
{
    header("Access-Control-Allow-Origin: *");
    header("X-Powered-By: none");
}

function cl_customize_rest_cors()
{
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function ($value) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Expose-Headers: Link', false);
        return $value;
    });
}
add_action('rest_api_init', 'cl_customize_rest_cors', 15);

// Removed scripts imported from editor in admin
add_filter('content_save_pre', 'custom_content_save');
function custom_content_save($content)
{
    $content = custom_replace_value($content);
    $content = preg_replace('/\b(?:o[nN][eE]?[rR][rR]?[oO][rR]?)\b/i', '', $content);

    return $content;
}

function custom_replace_value($text)
{
    $special_characters = [
        '<script>',
        '</script>',
        'alert(',
        '$(',
        '&lt;script&gt;',
        '&lt;/script&gt',
        'document.',
    ];
    $text = str_replace($special_characters, '', $text);

    return $text;
}

// Disable some endpoints for unauthenticated users
add_filter('rest_endpoints', 'disable_default_endpoints');
function disable_default_endpoints($endpoints)
{
    $endpoints_to_remove = array(
        '/oembed/1.0',
        '/wp/v2',
        '/wp/v2/media',
        '/wp/v2/types',
        '/wp/v2/statuses',
        '/wp/v2/taxonomies',
        '/wp/v2/tags',
        '/wp/v2/users',
        '/wp/v2/comments',
        '/wp/v2/settings',
        '/wp/v2/themes',
        '/wp/v2/blocks',
        '/wp/v2/oembed',
        '/wp/v2/posts',
        '/wp/v2/pages',
        '/wp/v2/block-renderer',
        '/wp/v2/search',
        '/wp/v2/categories'
    );

    if (!is_user_logged_in() && !is_admin()) {
        foreach ($endpoints_to_remove as $rem_endpoint) {
            foreach ($endpoints as $maybe_endpoint => $object) {
                if (stripos($maybe_endpoint, $rem_endpoint) !== false) {
                    unset($endpoints[$maybe_endpoint]);
                }
            }
        }
    }

    return $endpoints;
}

// Change the login logo for the entire site
function custom_login_logo()
{
    echo '<style type="text/css">
    h1 a {
      background-image: url(' . get_template_directory_uri() . '/assets/images/logo_login.svg) !important;
      height: 80px !important;
      width: 100% !important;
      background-size: auto !important;
    }
  </style>';
}
add_action('login_head', 'custom_login_logo');

// prevent access to the author page to get information
add_action('template_redirect', 'redirect_author_pages');
function redirect_author_pages()
{
    if (is_author()) {
        wp_redirect(home_url());
        exit;
    }
}

// Set the maximum number of revisions
if (!defined('WP_POST_REVISIONS')) {
    define('WP_POST_REVISIONS', 3);
}

// allow script iframe tag within posts
function allow_iframe_script_tags($allowedposttags)
{
    $allowedposttags["iframe"] = array(
        "src" => true,
        "width" => true,
        "height" => true,
        "class" => true,
        "frameborder" => true,
        "webkitAllowFullScreen" => true,
        "mozallowfullscreen" => true,
        "allowFullScreen" => true,
        "allow" => true,
    );

    return $allowedposttags;
}
add_filter("wp_kses_allowed_html", "allow_iframe_script_tags", 1);

// Hide Tags
function hide_tags()
{
    register_taxonomy('post_tag', array());
}
add_action('init', 'hide_tags');