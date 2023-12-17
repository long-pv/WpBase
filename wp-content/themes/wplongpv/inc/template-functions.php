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

// block info general information
function block_info($data_block = [])
{
    $html = '';

    if ($data_block) {
        $data = [
            'title' => $data_block['title'] ?? null,
            'desc' => $data_block['description'] ?? null,
            'link' => $data_block['link'] ?? [],
            'layout' => $data_block['display_type'] ?? 'default',
        ];

        // render html the section
        $html = '<div class="secHeading' . (($data['layout'] == 'center') ? ' secHeading--center ' : '') . '">';
        $html .= $data['layout'] == 'center' ? '<div class="container"><div class="row no-gutters justify-content-center"><div class="col-lg-8">' : '';
        $html .= $data['title'] ? '<h2 class="secTitle secHeading__title">' . custom_title($data['title']) . '</h2>' : '';
        $html .= $data['desc'] ? '<p class="secHeading__desc">' . $data['desc'] . '</p>' : '';
        $html .= custom_btn_link($data['link'], 'secHeading__link', true);
        $html .= $data['layout'] == 'center' ? '</div></div></div>' : '';
        $html .= '</div>';
    }

    return $html;
}
// end block info

// validate list data
function validate_data($data = [], $comparison = 'OR')
{
    $validate = '';
    $comparison = strtoupper($comparison);

    if ($data) {
        foreach ($data as $field) {
            $validate .= $field ? '-true' : '-false';
        }
    }

    $check = strpos($validate, $comparison === "AND" ? 'false' : 'true');

    return $check ? (($comparison === "AND") ? false : true) : (($comparison === "AND") ? true : false);
}

// block editor general
function custom_editor($content = null, $class = null)
{
    return $content ? '<div class="editor ' . ($class ?: '') . '">' . $content . '</div>' : '';
}

// block btn link general
function custom_btn_link($link = [], $class = null, $block = false)
{
    $html = '';

    if ($link) {
        // validate link
        $url = ($link && $link['url']) ? $link['url'] : 'javascript:void(0);';
        $title = ($link && $link['title']) ? $link['title'] : __('See more', 'clvinuni');
        $target = ($link && $link['target']) ? $link['target'] : '_self';
        $class_link = !$block ? ($class ? $class : '') : '';

        // renter html
        $html .= $block ? '<div class="' . $class . '">' : '';
        $html .= '<a href="' . $url . '" target="' . $target . '" class="btnSeeMore ' . $class_link . '">';
        $html .= $title;
        $html .= '</a>';
        $html .= $block ? '</div>' : '';
    }

    return $html;
}

// block image link general
function custom_img_link($link = [], $image = null, $class = null, $alt = null)
{
    $html = '';

    // validate link
    $url = ($link && $link['url']) ? $link['url'] : 'javascript:void(0);';
    $title = ($link && $link['title']) ? $link['title'] : __('See more', 'clvinuni');
    $target = ($link && $link['target']) ? $link['target'] : '_self';
    $class_block = ($link && $link['url']) ? ($class ? $class : '') : 'cursor-default';

    // renter html
    $html .= '<a class="imgGroup ' . $class_block . '" href="' . $url . '" target="' . $target . '">';
    $html .= '<img width="300" height="300" src="' . custom_img(null, $image) . '" alt="' . ($alt ?: $title) . '">';
    $html .= '</a>';

    return $html;
}