<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package wplongpv
 */

/**
 * Setup theme setting page
 */
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

// Replacing underscores and dashes with spaces, capitalizing the first letter of each word, and removing spaces.
function custom_name_block($input)
{
    $normalized = str_replace(['_', '-'], ' ', $input);
    $ucwords = ucwords($normalized);
    $formatted = str_replace(' ', '', $ucwords);

    return 'section' . $formatted;
}

// retrieves the URL of the featured image of a post
function custom_post_image($post_id)
{
    $image = get_template_directory_uri() . '/assets/images/no_image.png';

    if (has_post_thumbnail($post_id)) {
        $image = get_the_post_thumbnail_url($post_id);
    }

    echo $image;
}