<?php
/**
 * @wordpress-plugin
 * Plugin Name: Lx Smart Theme
 * Version: 1.0.0
 * Requires PHP: 7.2
 * Plugin URI: https://codluck.com
 * Description: A simple settings theme.
 * Author: Long xemer
 * Author URI: https://codluck.com/
 * Network: false
 * Text Domain: lx-smart-theme
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

$lx_function_file = [
    'tabs-sidebar',
    'security',
    'smart-theme'
];

$lx_arr_sidebar = [
    'lx-smart-theme',
    'lx-security',
    'lx-post-type-image-size',
];

foreach ($lx_function_file as $file) {
    require_once plugin_dir_path(__FILE__) . 'inc/' . $file . '.php';
}

function lx_admin_script()
{
    global $pagenow;
    global $lx_arr_sidebar;

    if ($pagenow == 'admin.php' && !empty($_GET['page']) && in_array($_GET['page'], $lx_arr_sidebar)) {
        wp_enqueue_style('cl-cookie-style-admin', plugin_dir_url(__FILE__) . 'assets/style.css', array(), '1.0.0');
        wp_enqueue_script('cl-cookie-consent-script', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), '1.0.0', true);
    }
}
add_action('admin_enqueue_scripts', 'lx_admin_script');

function lx_add_bootstrap()
{
    global $pagenow;
    global $lx_arr_sidebar;

    if ($pagenow == 'admin.php' && !empty($_GET['page']) && in_array($_GET['page'], $lx_arr_sidebar)) {
        ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
        <?php
    }
}
add_action('admin_head', 'lx_add_bootstrap');