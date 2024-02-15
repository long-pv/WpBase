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
    $name_option = 'Common theme';
    acf_add_options_page(
        array(
            'page_title' => $name_option,
            'menu_title' => $name_option,
            'menu_slug' => 'theme-common-settings',
            'capability' => 'manage_options',
            'redirect' => false
        )
    );
}

// remove wp_version
function lx_remove_wp_version_strings($src)
{
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'lx_remove_wp_version_strings');
add_filter('style_loader_src', 'lx_remove_wp_version_strings');

// Hide WP version strings from generator meta tag
function lx_remove_version()
{
    return '';
}
add_filter('the_generator', 'lx_remove_version');

// Change default login error
function lx_login_errors()
{
    return 'Invalid user!';
}
add_filter('login_errors', 'lx_login_errors');

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

    $enable_cerber_hardening = get_field('enable_cerber_hardening', 'option') ?? null;
    if ($enable_cerber_hardening) {
        // cerber-hardening
        $cerber_hardening = get_option('cerber-hardening');

        if ($cerber_hardening) {
            $cerber_hardening['stopenum'] = '1';
            $cerber_hardening['stopenum_oembed'] = '1';
            $cerber_hardening['stopenum_sitemap'] = '1';
            $cerber_hardening['nouserpages_bylogin'] = '1';
            $cerber_hardening['adminphp'] = '1';
            $cerber_hardening['phpnoupl'] = '1';
            $cerber_hardening['xmlrpc'] = '1';
            $cerber_hardening['nofeeds'] = '1';
            $cerber_hardening['norestuser'] = '1';
            $cerber_hardening['nophperr'] = '1';
            $cerber_hardening['norest'] = '1';
            $cerber_hardening['restauth'] = '1';
            update_option('cerber-hardening', $cerber_hardening);
        }

        // cerber main
        $cerber_main = get_option('cerber-main') ?? null;
        if($cerber_main) {
            $cerber_main['limitwhite'] = '1';
            $cerber_main['loginnowp'] = '1';
            $cerber_main['nologinhint'] = '1';
            $cerber_main['nopasshint'] = '1';
            $cerber_main['noredirect'] = '1';
            $cerber_main['nonusers'] = '1';
            $cerber_main['wplogin'] = '1';
            $cerber_main['proxy'] = '1';
            $cerber_main['usefile'] = '1';
            $cerber_main['admin_lang'] = '1';

            if ($cerber_main['loginpath']) {
                $cerber_main['logindeferred'] = '1';
            } else {
                $cerber_main['logindeferred'] = '0';
            }
            update_option('cerber-main', $cerber_main);
        }
    }
}
add_action('admin_init', 'disable_comments_and_pings_post_type');

// change logo, link logo page login
function custom_login_logo()
{
    $logo_page_login = get_field('logo_page_login', 'option') ?? null;
    if ($logo_page_login) {
        $url_login = wp_get_attachment_url($logo_page_login);
        echo '<style type="text/css">h1 a {background-image: url(' . $url_login . ') !important;height: 90px !important;background-position: center center;width: 100% !important;background-size:contain!important;}</style>';
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
        '&lt;/script&gt',
        'document.',
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
        '&lt;/script&gt',
        'document.',
    ];

    $content = preg_replace('/<([^>]+)\bon([^=]*)=[^>]*>/i', '', $content);
    $content = preg_replace('/&lt;([^&]+)\bon([^=]*)=.*?&gt;/i', '', $content);
    $newContent = str_replace($special_characters, '', $content);

    return $newContent;
}
add_filter('content_save_pre', 'custom_content_save');

// Set cookie timeout
add_filter('auth_cookie_expiration', 'cl_expiration_filter', 99, 3);
function cl_expiration_filter($expiration, $user_id, $remember)
{
    $enable_time_out = get_field('enable_time_out', 'option') ?? null;
    if ($enable_time_out) {
        if ($remember) {
            $expiration = 14 * 24 * 60 * 60;
        } else {
            $expiration = 30 * 60;
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
    $json_security = get_template_directory() . '/security/security.json';

    if (file_exists($json_security)) {
        $json_content = file_get_contents($json_security);
        $acf_data = json_decode($json_content, true);

        if ($acf_data) {
            foreach ($acf_data as $group) {
                acf_add_local_field_group($group);
            }
        }
    }

    $json_role = get_template_directory() . '/security/role.json';

    if (file_exists($json_role)) {
        $json_content = file_get_contents($json_role);
        $acf_data = json_decode($json_content, true);

        if ($acf_data) {
            foreach ($acf_data as $group) {
                acf_add_local_field_group($group);
            }
        }
    }
}
add_action('admin_init', 'import_acf_security');