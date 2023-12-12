<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package wplongpv
 */

// Setup theme setting page
if (function_exists('acf_add_options_page')) {
    $name_option = 'Theme Setting';
    acf_add_options_page(
        array(
            'page_title' => $name_option,
            'menu_title' => $name_option,
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => false
        )
    );
}

// The function "write_log" is used to write debug logs to a file in PHP.
function write_log($log = null, $title = 'Debug')
{
    if ($log) {
        if (is_array($log) || is_object($log)) {
            $log = print_r($log, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $text = '[' . $timestamp . '] : ' . $title . ' - Log: ' . $log . "\n";
        $log_file = WP_CONTENT_DIR . '/debug.log';
        $file_handle = fopen($log_file, 'a');
        fwrite($file_handle, $text);
        fclose($file_handle);
    }
}

// Replacing underscores and dashes with spaces, capitalizing the first letter of each word, and removing spaces.
function custom_name_block($input)
{
    $normalized = str_replace(['_', '-'], ' ', $input);
    $ucwords = ucwords($normalized);
    $formatted = str_replace(' ', '', $ucwords);

    return 'section' . $formatted;
}

// remove post type menu
// add_action('admin_menu', 'remove_default_post_type_menu');
// function remove_default_post_type_menu() {
//     remove_menu_page('edit.php');
// }

// function common call api request
// function custom_api_request($path, $method = 'GET', $body_args = null, $headers = [])
// {
//     if (!defined('API_SERVER_URL')) {
//         return false;
//     }

//     $url = API_SERVER_URL . $path;

//     $args = array(
//         'method' => $method,
//     );

//     // Check is has token
//     $token = $_COOKIE['token_login'] ?? '';

//     // Check is $headers
//     if ($headers) {
//         $args['headers'] = $headers;
//     }

//     // Check has $token
//     if ($token) {
//         $args['headers']['Authorization'] = 'Bearer ' . $token;
//     }

//     // Check has body request
//     if ($body_args) {
//         $args['body'] = $body_args;
//     }

//     // Call api request
//     $response = wp_remote_request($url, $args);
//     $body = wp_remote_retrieve_body($response);
//     $response_code = wp_remote_retrieve_response_code($response);

//     if ($response_code == 200) {
//         return json_decode($body);
//     }

//     return false;
// }

// custom text title by character
function custom_title($text = '', $character = true)
{
    if ($character) {
        $text = preg_replace('/\[{(.*?)}\]/', '<span class="character">$1</span>', $text);
    } else {
        $text = str_replace(['[', ']', '{', '}'], '', $text);
    }

    return $text;
}

// retrieves the URL of the featured image of a post
function custom_img($post_id = null, $img_url = null)
{
    if ($post_id && has_post_thumbnail($post_id)) {
        $image = get_the_post_thumbnail_url($post_id);
    } elseif ($img_url) {
        $image = $img_url;
    } else {
        $image = get_template_directory_uri() . '/assets/images/no_image.png';
    }

    echo $image;
}