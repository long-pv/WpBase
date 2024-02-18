<?php
/**
 * wplongpv functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wplongpv
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

// Set the maximum number of revisions - Đặt số lượng revision tối đa
if (!defined('WP_POST_REVISIONS')) {
	define('WP_POST_REVISIONS', 5);
}

/**
 * get currernt lang.
 */
define('LANG', function_exists('pll_current_language') ? pll_current_language('slug') : 'en');

// Sets up theme defaults and registers support for various WordPress features.
function wplongpv_setup()
{
	// theme support post
	load_theme_textdomain('wplongpv', get_template_directory() . '/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'wplongpv'),
		)
	);
}
add_action('after_setup_theme', 'wplongpv_setup');

// Set the content width in pixels, based on the theme's design and stylesheet.
function wplongpv_content_width()
{
	$GLOBALS['content_width'] = apply_filters('wplongpv_content_width', 640);
}
add_action('after_setup_theme', 'wplongpv_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function wplongpv_scripts()
{
	wp_enqueue_style('wplongpv-style', get_stylesheet_uri(), array(), _S_VERSION);

	// add vendor js
	wp_enqueue_script('wplongpv-script-vendor', get_template_directory_uri() . '/assets/js/vendor.js', array(), _S_VERSION, true);

	// add select2
	wp_enqueue_style('wplongpv-style-select2', get_template_directory_uri() . '/assets/inc/select2/select2.css', array(), _S_VERSION);
	wp_enqueue_script('wplongpv-script-select2', get_template_directory_uri() . '/assets/inc/select2/select2.js', array(), _S_VERSION, true);

	//add custom main css/js
	wp_enqueue_style('wplongpv-style-main', get_template_directory_uri() . '/assets/css/main.css', array(), _S_VERSION);
	wp_enqueue_script('wplongpv-script-main', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'wplongpv_scripts');

/**
 * Functions security theme by hooking into WordPress.
 */
require get_template_directory() . '/security/index.php';
require get_template_directory() . '/security/role.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Functions block
 */
// require get_template_directory() . '/inc/custom-functions.php';

/**
 * Functions block
 */
// require get_template_directory() . '/inc/cpt-custom-role.php';