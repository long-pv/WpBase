<?php
// Sets up theme defaults and registers support for various WordPress features.
function basetheme_setup()
{
    // theme support post
    load_theme_textdomain('basetheme', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
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
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
    // woocommerce
    add_theme_support('woocommerce');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'basetheme'),
        )
    );

    // set size image large default
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
    wp_enqueue_style('basetheme-style-main', get_template_directory_uri() . '/assets/css/main.css', array(), _S_VERSION);
    wp_enqueue_script('basetheme-script-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), _S_VERSION, true);

    // ajax admin
    wp_localize_script('basetheme-script-main', 'custom_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'basetheme_scripts');

function remove_styles_and_scripts_from_content($content)
{
    $content = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $content);
    $content = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $content);

    return $content;
}
add_filter('the_content', 'remove_styles_and_scripts_from_content', 99);

function add_dropdown_arrow_to_menu($items, $args)
{
    if ($args->theme_location) {
        $items = preg_replace('/(<a.*?>)(.*)<\/a>/i', '<span class="dropdown-arrow"></span>$1$2</a>', $items);
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_dropdown_arrow_to_menu', 10, 2);
