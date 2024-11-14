<?php
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
    if (get_option('thumbnail_size_w') != THUMBNAIL_SIZE) {
        update_option('thumbnail_size_w', THUMBNAIL_SIZE);
        update_option('thumbnail_size_h', THUMBNAIL_SIZE);
    }

    if (get_option('medium_size_w') != MEDIUM_SIZE) {
        update_option('medium_size_w', MEDIUM_SIZE);
        update_option('medium_size_h', MEDIUM_SIZE);
    }

    if (get_option('large_size_w') != LARGE_SIZE) {
        update_option('large_size_w', LARGE_SIZE);
        update_option('large_size_h', LARGE_SIZE);
    }

    // Hide Admin Bar for users with 'subscriber' role
    if (current_user_can('subscriber') && !is_admin()) {
        show_admin_bar(false);
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
    wp_enqueue_style('basetheme-style', get_stylesheet_uri(), array(), _S_VERSION);

    // add vendor js
    wp_enqueue_script('basetheme-script-vendor', get_template_directory_uri() . '/assets/js/vendor.js', array(), _S_VERSION, true);

    // data mh
    // <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight.js"></script>

    // validate
    wp_enqueue_script('basetheme-script-validate', get_template_directory_uri() . '/assets/inc/validate/validate.js', array(), _S_VERSION, true);
    wp_enqueue_script('basetheme-script-validate_custom', get_template_directory_uri() . '/assets/js/validate.js', array(), _S_VERSION, true);

    // scroll smooth hash id element
    wp_enqueue_script('basetheme-script-scroll_smooth', get_template_directory_uri() . '/assets/js/scroll_smooth.js', array(), _S_VERSION, true);

    // wow - effect
    wp_enqueue_style('basetheme-style-wow', get_template_directory_uri() . '/assets/inc/wow/wow.css', array(), _S_VERSION);
    wp_enqueue_script('basetheme-script-wow', get_template_directory_uri() . '/assets/inc/wow/wow.js', array(), _S_VERSION, true);
    wp_enqueue_script('basetheme-script-wow_custom', get_template_directory_uri() . '/assets/inc/wow/index.js', array(), _S_VERSION, true);
    // end

    // readmore Component
    wp_enqueue_script('basetheme-script-readmore', get_template_directory_uri() . '/assets/js/readmore.js', array(), _S_VERSION, true);

    //add custom main css/js
    wp_enqueue_style('basetheme-style-main', get_template_directory_uri() . '/assets/css/main.css', array(), _S_VERSION);
    wp_enqueue_script('basetheme-script-main', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'basetheme_scripts');
