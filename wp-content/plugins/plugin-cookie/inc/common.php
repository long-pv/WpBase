<?php
// convert language
$language_map = [
    'en' => 'en_US',
    'vi' => 'vi',
    'ja' => 'ja'
];

// render input text
function render_input_text_field($option_name) {
    $value = get_option($option_name);
    echo '<input type="text" name="' . $option_name . '" value="' . esc_attr($value) . '" />';
}

// render radio button
function render_radio_field($option_name) {
    $value = get_option($option_name[0]);
    $checked_option1 = ($value == 1) ? 'checked' : '';
    $checked_option2 = ($value == 2) ? 'checked' : '';

    echo '
        <label class="radio-option">
            <input type="radio" name="' . $option_name[0] . '" value="1" ' . $checked_option1 . '> 
            '.$option_name[1].'
        </label>
        <label class="radio-option">
            <input type="radio" name="' . $option_name[0] . '" value="2" ' . $checked_option2 . '>
            '.$option_name[2].'
        </label>
    ';
}

// render editor
function render_editor_field($option_name) {
    $content = get_option($option_name);
    wp_editor($content, $option_name);
}

// render toggle
function render_toggle_field($option_name) {
    $checkbox = get_option($option_name);
    $checked  = ($checkbox == 1) ? 'checked' : '';
    echo '<label class="toggle"><input class="toggle-checkbox" type="checkbox" name="' . $option_name . '" value="1"' . $checked . '><div class="toggle-switch"></div></label>';
}

// get translate current language
function translate_current_language() {
    global $language_map;
    $current_language = function_exists('get_locale') ? get_locale() : 'en_US';

    if (!in_array($current_language, array_values($language_map))) {
        $current_language = 'en_US';
    }
    return list_text_translate($current_language);
}

// get text translate
function list_text_translate($language) {
    load_textdomain('cl-cookie-consent', plugin_dir_path(dirname(__FILE__)) . 'languages/smartcookie-' . $language . '.mo');
 
    return [
        'plugin_name'     => __('plugin_name', 'cl-cookie-consent'),
        'form_name'       => __('form_name', 'cl-cookie-consent'),
        'title'           => __('title', 'cl-cookie-consent'),
        'message'         => __('message', 'cl-cookie-consent'),
        'accept'          => __('accept', 'cl-cookie-consent'),
        'reject'          => __('reject', 'cl-cookie-consent'),
        'policy'          => __('policy', 'cl-cookie-consent'),
        'policy_label'    => __('policy_label', 'cl-cookie-consent'),
        'policy_url'      => __('policy_url', 'cl-cookie-consent'),
        'close'           => __('close', 'cl-cookie-consent'),
        'layout'          => __('layout', 'cl-cookie-consent'),
        'layout-40'       => __('layout-40', 'cl-cookie-consent'),
        'layout-100'      => __('layout-100', 'cl-cookie-consent'),
        'warning-message' => __('warning-message', 'cl-cookie-consent'),
    ];
}

 // render form cookie consent settings with multiple languages
function render_form_with_multiple_languages($languages) {
    foreach ($languages as $language) {
        $translates = list_text_translate($language);

        // register settings for cookie consent options
        register_setting('cookie_consent_options', 'cookie_consent_title' . $language);
        register_setting('cookie_consent_options', 'cookie_consent_message' . $language);
        register_setting('cookie_consent_options', 'cookie_consent_accept' . $language);
        register_setting('cookie_consent_options', 'cookie_consent_reject' . $language);
        register_setting('cookie_consent_options', 'cookie_consent_policy' . $language);
        register_setting('cookie_consent_options', 'cookie_consent_policy_label' . $language);
        register_setting('cookie_consent_options', 'cookie_consent_policy_url' . $language);
        register_setting('cookie_consent_options', 'cookie_consent_close' . $language);
        register_setting('cookie_consent_options', 'cookie_consent_layout' . $language);
        
        // add all fields with multiple language
        add_settings_section('cookie_consent_section' . $language, $translates['form_name'] . ' - ' . $language, null, 'cookie-concent-settings');
        add_settings_field('cookie_consent_title' . $language, $translates['title'] . ' - ' . $language, 'render_input_text_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, 'cookie_consent_title' . $language);
        add_settings_field('cookie_consent_message' . $language, $translates['message'] . ' - ' . $language, 'render_editor_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, 'cookie_consent_message' . $language);
        add_settings_field('cookie_consent_accept' . $language, $translates['accept'] . ' - ' . $language, 'render_toggle_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, 'cookie_consent_accept' . $language);
        add_settings_field('cookie_consent_reject' . $language, $translates['reject'] . ' - ' . $language, 'render_toggle_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, 'cookie_consent_reject' . $language);
        add_settings_field('cookie_consent_policy' . $language, $translates['policy'] . ' - ' . $language, 'render_toggle_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, 'cookie_consent_policy' . $language);
        add_settings_field('cookie_consent_policy_label' . $language, $translates['policy_label'] . ' - ' . $language, 'render_input_text_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, 'cookie_consent_policy_label' . $language);
        add_settings_field('cookie_consent_policy_url' . $language, $translates['policy_url'] . ' - ' . $language, 'render_input_text_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, 'cookie_consent_policy_url' . $language);
        add_settings_field('cookie_consent_close' . $language, $translates['close'] . ' - ' . $language, 'render_toggle_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, 'cookie_consent_close' . $language);   
        add_settings_field('cookie_consent_layout' . $language, $translates['layout'] . ' - ' . $language, 'render_radio_field', 'cookie-concent-settings', 'cookie_consent_section' . $language, ['cookie_consent_layout' . $language, $translates['layout-40'], $translates['layout-100']]);   
    }
}

// add section blocked access page
function blocked_access_page() {
    $translates = translate_current_language();

    add_settings_section('cookie_warning_section', $translates['warning-message'], null, 'cookie-concent-settings');
}