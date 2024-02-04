<?php
/**
 * @wordpress-plugin
 * Plugin Name: WP Smart Cookie Consent
 * Version: 1.0.0
 * Requires PHP: 7.2
 * Plugin URI: https://codluck.com
 * Description: A simple way to show your website complies compliant with global privacy regulations (GDPR, ePrivacy, and CCPA).
 * Author: CodLUCK
 * Author URI: https://codluck.com/
 * Network: false
 * Text Domain: cl-cookie-consent
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

require_once plugin_dir_path( __FILE__ ) . 'inc/frontend.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-settings.php';

// enqueue plugin WP Smart Cookie Consent styles
function enqueue_plugin_smart_cookie_styles() {
    wp_enqueue_style('cl-cookie-consent-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0.0');
    wp_enqueue_script('cl-jquery-cookie', plugin_dir_url(__FILE__) . 'assets/js/jquery-cookie.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('cl-cookie-consent-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_plugin_smart_cookie_styles');

// enqueue plugin WP Smart Cookie Consent Admin styles
function enqueue_plugin_admin_styles() {
    wp_enqueue_style('cl-cookie-style-admin', plugin_dir_url(__FILE__) . 'assets/css/main.css', array(), '1.0.0');
}
add_action('admin_enqueue_scripts', 'enqueue_plugin_admin_styles');