<?php

/**
 * Base theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Base_theme
 */

if (! defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * get currernt lang.
 */
define('LANG', function_exists('pll_current_language') ? pll_current_language('slug') : 'vi');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function basetheme_setup()
{
    /*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Base theme, use a find and replace
		* to change 'basetheme' to the name of your theme in all the template files.
		*/
    load_theme_textdomain('basetheme', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
    add_theme_support('title-tag');

    /*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'basetheme'),
        )
    );

    /*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'basetheme_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'basetheme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function basetheme_content_width()
{
    $GLOBALS['content_width'] = apply_filters('basetheme_content_width', 640);
}
add_action('after_setup_theme', 'basetheme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function basetheme_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'basetheme'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'basetheme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'basetheme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function basetheme_scripts()
{
    wp_enqueue_style('basetheme-style', get_stylesheet_uri(), array(), _S_VERSION);

    // bootstrap js
    wp_enqueue_script('child_theme-script-bootstrap_bundle', get_template_directory_uri() . '/assets/inc/bootstrap/bootstrap.bundle.min.js', array('jquery'), _S_VERSION, true);

    // jquery ui
    wp_enqueue_style('child_theme-style-jquery-ui', get_template_directory_uri() . '/assets/inc/jquery-ui/jquery-ui.css', array(), _S_VERSION);
    wp_enqueue_script('child_theme-script-jquery-ui', get_template_directory_uri() . '/assets/inc/jquery-ui/jquery-ui.js', array('jquery'), _S_VERSION, true);

    // matchHeight
    wp_enqueue_script('child_theme-script-matchHeight', get_template_directory_uri() . '/assets/inc/matchHeight/jquery.matchHeight.js', array('jquery'), _S_VERSION, true);

    // validate
    wp_enqueue_script('basetheme-script-validate', get_template_directory_uri() . '/assets/inc/validate/validate.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('basetheme-script-validate_custom', get_template_directory_uri() . '/assets/js/validate.js', array('jquery'), _S_VERSION, true);

    // scroll smooth hash id element
    wp_enqueue_script('basetheme-script-scroll_smooth', get_template_directory_uri() . '/assets/js/scroll_smooth.js', array('jquery'), _S_VERSION, true);

    // wow - effect
    wp_enqueue_style('basetheme-style-wow', get_template_directory_uri() . '/assets/inc/wow/wow.css', array(), _S_VERSION);
    wp_enqueue_script('basetheme-script-wow', get_template_directory_uri() . '/assets/inc/wow/wow.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('basetheme-script-wow_custom', get_template_directory_uri() . '/assets/inc/wow/index.js', array('jquery'), _S_VERSION, true);
    // end

    // intlTelInput
    wp_enqueue_style('child_theme-style-intlTelInput', get_template_directory_uri() . '/assets/inc/intlTelInput/intlTelInput.css', array(), _S_VERSION);
    wp_enqueue_script('child_theme-script-intlTelInput', get_template_directory_uri() . '/assets/inc/intlTelInput/intlTelInput.js', array('jquery'), _S_VERSION, true);

    // select2
    wp_enqueue_style('child_theme-style-select2', get_template_directory_uri() . '/assets/inc/select2/select2.css', array(), _S_VERSION);
    wp_enqueue_script('child_theme-script-select2', get_template_directory_uri() . '/assets/inc/select2/select2.js', array('jquery'), _S_VERSION, true);

    // fancybox
    wp_enqueue_style('child_theme-style-select2', get_template_directory_uri() . '/assets/inc/fancybox/fancybox.css', array(), _S_VERSION);
    wp_enqueue_script('child_theme-script-select2', get_template_directory_uri() . '/assets/inc/fancybox/fancybox.js', array('jquery'), _S_VERSION, true);

    // slick
    wp_enqueue_style('child_theme-style-slick-theme', get_template_directory_uri() . '/assets/inc/slick/slick-theme.css', array(), _S_VERSION);
    wp_enqueue_style('child_theme-style-slick', get_template_directory_uri() . '/assets/inc/slick/slick.css', array(), _S_VERSION);
    wp_enqueue_script('child_theme-script-slick', get_template_directory_uri() . '/assets/inc/slick/slick.min.js', array('jquery'), _S_VERSION, true);

    // readmore Component
    wp_enqueue_script('basetheme-script-readmore', get_template_directory_uri() . '/assets/js/readmore.js', array('jquery'), _S_VERSION, true);

    //add custom main css/js
    $main_css_file_path = get_template_directory() . '/assets/css/main.css';
    $main_js_file_path = get_template_directory() . '/assets/js/main.js';
    $ver_main_css = file_exists($main_css_file_path) ? filemtime($main_css_file_path) : '1.0.0';
    $ver_main_js = file_exists($main_js_file_path) ? filemtime($main_js_file_path) : '1.0.0';
    wp_enqueue_style('dev_theme-style-main', get_template_directory_uri() . '/assets/css/main.css', array(), $ver_main_css);
    wp_enqueue_script('dev_theme-script-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $ver_main_js, true);

    // ajax admin
    wp_localize_script('dev_theme-script-main', 'custom_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'basetheme_scripts');

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woo/index.php';
}

require get_template_directory() . '/inc/index.php';
