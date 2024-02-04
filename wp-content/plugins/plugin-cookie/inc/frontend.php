<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

function render_cookie_consent_settings_page() {
    ?>
        <div class="wrap">
            <form method="post" action="options.php">
                <?php
                settings_fields('cookie_consent_options');
                do_settings_sections('cookie-concent-settings');
                submit_button('Save Settings');
                ?>
            </form>
        </div>
    <?php
}

// display plugin WP Smart Cookie Consent
function display_plugin_smart_cookie_content() {
    $count_plugins_active = 0;

    // get current language with plugin polylang active
    if (is_plugin_active('polylang/polylang.php')) {
        $current_language = pll_current_language();
        $count_plugins_active++;
    }

    // get current language with plugin WPML active
    if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
        $current_language = apply_filters('wpml_current_language', NULL);
        $count_plugins_active++;
    }

    if ($count_plugins_active <= 1) {
        if (empty($current_language) || $current_language == 'en') {
            $current_language = 'en_US';
        }
        // get data field
        $title       = get_option('cookie_consent_title' . $current_language);
        $close       = get_option('cookie_consent_close' . $current_language);
        $message     = get_option('cookie_consent_message' . $current_language);
        $policy      = get_option('cookie_consent_policy' . $current_language);
        $rejectAll   = get_option('cookie_consent_reject' . $current_language);
        $acceptAll   = get_option('cookie_consent_accept' . $current_language);
        $policyUrl   = get_option('cookie_consent_policy_url' . $current_language);
        $policyLabel = get_option('cookie_consent_policy_label' . $current_language);
        $layout      = get_option('cookie_consent_layout' . $current_language);
    
        if ($title || $message) :
        ?>
            <!--effect overlay -->
            <!-- <div class="overlay"></div> -->
            <!-- cookie consent content -->
            <div class="sticky-banner <?php echo $layout == 2 ? 'cookie-fluid' : '' ?>">
                <div class="<?php echo $layout == 2 ? 'container' : '' ?>">
                    <div class="sticky-banner__header">
                        <h2 class="title">
                            <?php echo $title; ?>
                        </h2>
        
                        <?php if ($close): ?>
                            <span class="close">x</span>
                        <?php endif; ?>
                    </div>
        
                    <?php if($message) : ?>
                        <div class="sticky-banner__content">
                            <?php echo $message; ?>
                            <?php if ($policy): ?>
                                <a href="<?php echo $policyUrl; ?>">
                                    <?php echo $policyLabel; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
        
                    <div class="sticky-banner__actions">
                        <?php if ($rejectAll): ?>
                            <button type="button" class="btn" id="rejectAllButton">
                                <?php _e('Reject All'); ?>
                            </button>
                        <?php endif; ?>
        
                        <?php if ($acceptAll): ?>
                            <button type="button" class="btn" id="acceptAllButton">
                                <?php _e('Accept All'); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
    }
}
add_action('wp_footer', 'display_plugin_smart_cookie_content');