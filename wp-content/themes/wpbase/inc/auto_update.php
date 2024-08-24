<?php
add_filter('auto_update_plugin', '__return_false');
if (!defined('WP_AUTO_UPDATE_CORE')) {
    define('WP_AUTO_UPDATE_CORE', false);
}
if (!defined('AUTOMATIC_UPDATER_DISABLED')) {
    define('AUTOMATIC_UPDATER_DISABLED', true);
}