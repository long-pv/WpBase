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

// block info general information
function block_info($data_block = null)
{
    $html = '';

    if ($data_block) {
        $data = [
            'title' => $data_block['title'] ?? null,
            'desc' => $data_block['description'] ?? null,
            'link' => $data_block['link'] ?? null,
        ];

        $layout = $data_block['display_type'] ?? 'left';

        // render html the section
        if ($data['title'] || $data['desc'] || $data['link']) {
            $html .= ($layout == 'center') ? '<div class="row no-gutters justify-content-center"><div class="col-lg-8">' : '';
            $html .= '<div class="secHeading' . (($layout == 'center') ? ' secHeading--center ' : '') . '">';
            $html .= $data['title'] ? '<h2 class="secTitle secHeading__title">' . custom_title($data['title']) . '</h2>' : '';
            $html .= $data['desc'] ? '<div class="editor secHeading__desc">' . $data['desc'] . '</div>' : '';
            $html .= ($layout == 'left') ? custom_btn_link($data['link'], 'secHeading__link', true) : '';
            $html .= '</div>';
            $html .= ($layout == 'center') ? '</div></div>' : '';
        }
    }

    return $html;
}
// end block info

// block editor general
function custom_editor($content = null, $class = null)
{
    return $content ? '<div class="editor ' . ($class ?: '') . '">' . $content . '</div>' : '';
}

// block btn link general
function custom_btn_link($link = null, $class = null, $block = false)
{
    $html = '';

    if ($link) {
        // validate link
        $url = !empty($link['url']) ? $link['url'] : 'javascript:void(0);';
        $title = !empty($link['title']) ? $link['title'] : __('See more', 'wplongpv');
        $target = !empty($link['target']) ? $link['target'] : '_self';
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
function custom_img_link($link = null, $image = null, $class = null, $alt = null)
{
    $html = '';

    if ($image) {
        // validate link
        $url = !empty($link['url']) ? $link['url'] : 'javascript:void(0);';
        $title = !empty($link['title']) ? $link['title'] : __('See more', 'wplongpv');
        $target = !empty($link['target']) ? $link['target'] : '_self';
        $class_img = empty($link['url']) ? ' imgGroup--noEffect cursor-default ' : '';
        $class_img .= $class ?: '';

        // renter html
        $html .= '<a class="imgGroup ' . $class_img . '" href="' . $url . '" target="' . $target . '">';
        $html .= '<img width="300" height="300" src="' . $image . '" alt="' . ($alt ?: $title) . '">';
        $html .= '</a>';
    }

    return $html;
}

// Count the elements that exist in the array to use check
function custom_count_array($array = [], $keys = [], $requireAll = true)
{
    $count = 0;

    foreach ($array as $item) {
        $hasValues = $requireAll;

        foreach ($keys as $key) {
            if ($requireAll) {
                if (empty($item[$key])) {
                    $hasValues = false;
                    break;
                }
            } else {
                if (!empty($item[$key])) {
                    $hasValues = true;
                    break;
                }
            }
        }

        if ($hasValues) {
            $count++;
        }
    }

    return $count;
}

function hexToRgb($hex)
{
    $hex = str_replace("#", "", $hex);

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return $r . ', ' . $g . ', ' . $b;
}

function custom_root_style($fieldKey = null, $variableName = null, $urlType = false)
{
    $fieldValue = get_field($fieldKey, 'option') ?? null;
    $style = '';

    if ($fieldValue) {
        $style .= '<style>:root {';
        $style .= '--' . $variableName . ':';
        $style .= $urlType ? 'url("' : '';
        $style .= $fieldValue;
        $style .= $urlType ? '")' : '';
        $style .= ';}</style>';
    }

    return $style;
}