<?php
require_once plugin_dir_path( __FILE__ ) . 'common.php';

function create_cookie_consent_settings_page() {
    $translates = translate_current_language();

    add_menu_page(
        'Cookie Consent Settings',
        $translates['plugin_name'],
        'manage_options',
        'cookie-consent-settings',
        'render_cookie_consent_settings_page',
        'dashicons-products'
    );
}
add_action('admin_menu', 'create_cookie_consent_settings_page');

// register settings plugin WP smart cookie consent
function register_cookie_consent_settings() {
    global $blocked_page_called;
    global $language_map;
    $count_plugin_active = 0;

    // get languages list when plugin polylang active
    if (function_exists('pll_languages_list')) {
        $selected_languages = pll_languages_list(array('fields' => 'locale'));
        $count_plugin_active++;
    }

    // get languages list when plugin WPML active
    if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
        $languages = apply_filters('wpml_active_languages', NULL);
        if ($languages) {
            foreach ($languages as $language) {
                $short_code = $language['language_code'];
                if (isset($language_map[$short_code])) {
                    $selected_languages[] = $language_map[$short_code];
                }
            }
        }
        $count_plugin_active++;
    }

    // check only accept 1 plugin language active
    if ($count_plugin_active > 1) {
        $blocked_page_called = true;
        blocked_access_page();
    } else {
        // get current language 
        if (empty($selected_languages)) {
            $selected_languages = array(get_locale());
            if (!array_intersect($selected_languages, array_values($language_map))) {
                $selected_languages = array('en_US');
            }
        }
        render_form_with_multiple_languages($selected_languages);
    }
}
add_action('admin_init', 'register_cookie_consent_settings');

// add style with warning plugin this page
function style_with_warning() {
    global $pagenow, $blocked_page_called;

    if($blocked_page_called && $pagenow == 'admin.php' && $_GET['page'] == 'cookie-consent-settings') :
    ?>
        <style>
            /* hide button submit */ 
            .submit {
                display: none;
            }
        </style>
    <?php
    endif;
}
add_action('admin_footer', 'style_with_warning');