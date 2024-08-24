<?php
/**
 * basetheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package basetheme
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * get currernt lang.
 */
define('LANG', function_exists('pll_current_language') ? pll_current_language('slug') : 'en');

// Sets up theme defaults and registers support for various WordPress features.
function basetheme_setup()
{
	// theme support post
	load_theme_textdomain('basetheme', get_template_directory() . '/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'basetheme'),
		)
	);

	// set size image default
	if (get_option('thumbnail_size_w') != 400) {
		update_option('thumbnail_size_w', 400);
		update_option('thumbnail_size_h', 400);
	}

	if (get_option('medium_size_w') != 800) {
		update_option('medium_size_w', 800);
		update_option('medium_size_h', 800);
	}

	if (get_option('large_size_w') != 1200) {
		update_option('large_size_w', 1200);
		update_option('large_size_h', 1200);
	}
}
add_action('after_setup_theme', 'basetheme_setup');

// Set the content width in pixels, based on the theme's design and stylesheet.
function basetheme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('basetheme_content_width', 640);
}
add_action('after_setup_theme', 'basetheme_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function basetheme_scripts()
{
	if (is_page_template('page-template_cv.php')) {
		return false;
	}
	
	wp_enqueue_style('basetheme-style', get_stylesheet_uri(), array(), _S_VERSION);

	// add vendor js
	wp_enqueue_script('basetheme-script-vendor', get_template_directory_uri() . '/assets/js/vendor.js', array(), _S_VERSION, true);

	// add select2
	// wp_enqueue_style('basetheme-style-select2', get_template_directory_uri() . '/assets/inc/select2/select2.css', array(), _S_VERSION);
	// wp_enqueue_script('basetheme-script-select2', get_template_directory_uri() . '/assets/inc/select2/select2.js', array(), _S_VERSION, true);

	//add custom main css/js
	wp_enqueue_style('basetheme-style-main', get_template_directory_uri() . '/assets/css/main.css', array(), _S_VERSION);
	wp_enqueue_script('basetheme-script-main', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'basetheme_scripts');

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/index.php';