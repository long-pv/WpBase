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