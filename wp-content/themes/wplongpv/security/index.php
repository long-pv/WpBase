<?php
/**
 * Plugin Name: Security setup
 * Description: Some basic security settings.
 * Version: 1.0.0
 * Author: Longpv
 * License: GPLv2
 */

// Sidebar setting wp admin
if (function_exists('acf_add_options_page')) {
    $name_option = 'Security Setting';
    acf_add_options_page(
        array(
            'page_title' => $name_option,
            'menu_title' => $name_option,
            'menu_slug' => 'theme-security-settings',
            'capability' => 'manage_options',
            'redirect' => false
        )
    );
}

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
    $hide_comment = get_field('hide_comment', 'option') ?? null;
    if ($hide_comment) {
        remove_menu_page('edit-comments.php');
    }
});

// Remove wp's default comment function
function disable_comments_and_pings_post_type()
{
    $hide_comment = get_field('hide_comment', 'option') ?? null;
    if ($hide_comment) {
        remove_post_type_support('post', 'comments');
        remove_post_type_support('post', 'trackbacks');
    }
}
add_action('init', 'disable_comments_and_pings_post_type');

// change logo, link logo page login
function custom_login_logo()
{
    $logo_page_login = get_field('logo_page_login', 'option') ?? null;
    if ($logo_page_login) {
        echo '<style type="text/css">h1 a {background-image: url(' . $logo_page_login . ') !important;height: 90px !important;background-position: center center;width: 100% !important;background-size:contain!important;}</style>';
    }
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
    $upload_size_limit = get_field('upload_size_limit', 'option') ?? null;
    if ($upload_size_limit && intval($upload_size_limit) > 0) {
        $upload_size_limit = intval($upload_size_limit);
        $bytes = $upload_size_limit * 1024 * 1024;
    } else {
        $bytes = 2 * 1024 * 1024;
    }
    return $bytes;
}

// Limit the type of files uploaded through the form
function restrict_file_types($mimes)
{
    $allowed_mime_types = [
        'jpg|jpeg|jpe' => 'image/jpeg',
        'png' => 'image/png',
    ];

    $file_uploads_allowed = get_field('file_uploads_allowed', 'option') ?? null;
    if ($file_uploads_allowed) {
        if (in_array('pdf', $file_uploads_allowed)) {
            $allowed_mime_types['pdf'] = 'application/pdf';
        }
        if (in_array('mp4', $file_uploads_allowed)) {
            $allowed_mime_types['mp4'] = 'video/mp4';
        }
        if (in_array('word', $file_uploads_allowed)) {
            $allowed_mime_types['doc'] = 'application/msword';
            $allowed_mime_types['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        }
        if (in_array('excel', $file_uploads_allowed)) {
            $allowed_mime_types['csv'] = 'text/csv';
            $allowed_mime_types['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        }
    }

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
    $size_image_post_type = get_field('size_image_post_type', 'option') ?? null;
    $post_type = get_post_type();
    if ($size_image_post_type) {
        foreach ($size_image_post_type as $item) {
            if ($item['slug_post_type'] === $post_type) {
                $html .= '<p>Recommended size: ' . $item['width'] . ' x ' . $item['height'] . '</p>';
            }
        }
    }
    return $html;
}

// redirect wp-admin and wp-register.php to the homepage
add_action('init', 'custom_login_redirect');
function custom_login_redirect()
{
    if (!is_admin() && !defined('DOING_AJAX') && (strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== false || strpos($_SERVER['REQUEST_URI'], 'wp-register.php') !== false)) {
        wp_redirect(home_url());
        exit();
    }
    // Particularly, urls containing xmlrpc.php give status 403 
    if (strpos($_SERVER['REQUEST_URI'], 'xmlrpc.php') !== false) {
        status_header(403);
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

// Apply a filter to the field value before saving
function custom_modify_text_field($value, $post_id, $field)
{
    $special_characters = [
        '<script>',
        '</script>',
        'alert(',
        '$(',
        '&lt;script&gt;',
        '&lt;/script&gt'
    ];
    $value = str_replace($special_characters, '', $value);

    return $value;
}
add_filter('acf/update_value', 'custom_modify_text_field', 10, 3);

// Apply a filter to the title before saving
add_filter('title_save_pre', 'clear_tag_html_post_title');
function clear_tag_html_post_title($title)
{
    return strip_tags($title);
}

// Removed scripts imported from editor in admin
function custom_content_save($content)
{
    $special_characters = [
        '<script>',
        '</script>',
        'alert(',
        '$(',
        '&lt;script&gt;',
        '&lt;/script&gt'
    ];
    $newContent = str_replace($special_characters, '', $content);

    return $newContent;
}

// Set cookie timeout
add_filter('auth_cookie_expiration', 'cl_expiration_filter', 99, 3);
function cl_expiration_filter($expiration, $user_id, $remember)
{
    $enable_time_out = get_field('enable_time_out', 'option') ?? null;
    if ($enable_time_out) {
        if ($remember) {
            $expiration = 14 * 24 * 60 * 60;
        } else {
            $expiration = 1 * 60;
        }

        if (PHP_INT_MAX - time() < $expiration) {
            $expiration = PHP_INT_MAX - time() - 5;
        }
    }

    return $expiration;
}

// Load security field when entering the admin screen
function import_acf_security()
{
    $json_file_path = get_template_directory() . '/security/security.json';

    if (file_exists($json_file_path)) {
        $json_content = file_get_contents($json_file_path);
        $acf_data = json_decode($json_content, true);

        if ($acf_data) {
            foreach ($acf_data as $group) {
                acf_add_local_field_group($group);
            }
        }
    }
}
add_action('admin_init', 'import_acf_security');