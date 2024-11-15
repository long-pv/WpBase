<?php
/**
 * version css/js
 */
if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

/**
 * get currernt lang.
 */
if (!defined('LANG')) {
    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'en';
    define('LANG', $lang);
}

/**
 * size image
 */
if (!defined('THUMBNAIL_SIZE')) {
    define('THUMBNAIL_SIZE', 400);
}
if (!defined('MEDIUM_SIZE')) {
    define('MEDIUM_SIZE', 800);
}
if (!defined('LARGE_SIZE')) {
    define('LARGE_SIZE', 1200);
}

/**
 * no image
 */
if (!defined('NO_IMAGE')) {
    define('NO_IMAGE', get_template_directory_uri() . '/assets/images/no_image.jpg');
}


if (!defined('RECAPTCHA_SECRET_KEY')) {
    define('RECAPTCHA_SECRET_KEY', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI');
}

/**
 * contact form
 */
if (!defined('CTF7_LOGIN_ID')) {
    define('CTF7_LOGIN_ID', 282);
}
if (!defined('CTF7_REGISTER_ID')) {
    define('CTF7_REGISTER_ID', 286);
}

// security define
if (!defined('DISABLE_WP_CRON')) {
    define('DISABLE_WP_CRON', true);
}

if (!defined('AUTOMATIC_UPDATER_DISABLED')) {
    define('AUTOMATIC_UPDATER_DISABLED', true);
}

if (!defined('WP_AUTO_UPDATE_CORE')) {
    define('WP_AUTO_UPDATE_CORE', false);
}

// if (!defined('DISALLOW_FILE_MODS')) {
//     define('DISALLOW_FILE_MODS', true);
// }