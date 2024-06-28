<?php
function activate_my_plugins()
{
    $plugins = [
        'advanced-custom-fields-pro\acf.php',
        'classic-editor\classic-editor.php',
        'duplicator\duplicator.php',
        'duplicate-post\duplicate-post.php',
        'wp-cerber\wp-cerber.php',
    ];

    foreach ($plugins as $plugin) {
        $plugin_path = WP_PLUGIN_DIR . '/' . $plugin;

        if (file_exists($plugin_path) && !is_plugin_active($plugin)) {
            activate_plugin($plugin);
        }
    }

    // plugin cerber
    if (is_plugin_active('wp-cerber/wp-cerber.php')) {
        // form spam
        $cerber_antispam_value = get_option('cerber-antispam') ?? [];
        $cerber_antispam_value['botsreg'] = 1;
        $cerber_antispam_value['botscomm'] = 1;
        $cerber_antispam_value['botsipwhite'] = 0;
        $cerber_antispam_value['spamcomm'] = 1;
        $cerber_antispam_value['trashafter-enabled'] = 1;
        $cerber_antispam_value['trashafter'] = 3;
        update_option('cerber-antispam', $cerber_antispam_value);

        // Hardening
        $cerber_hardening_value = get_option('cerber-hardening') ?? [];
        $cerber_hardening_value['stopenum'] = 1;
        $cerber_hardening_value['stopenum_oembed'] = 1;
        $cerber_hardening_value['stopenum_sitemap'] = 1;
        $cerber_hardening_value['nouserpages_bylogin'] = 1;
        $cerber_hardening_value['adminphp'] = 1;
        $cerber_hardening_value['phpnoupl'] = 1;
        $cerber_hardening_value['nophperr'] = 1;
        $cerber_hardening_value['xmlrpc'] = 1;
        $cerber_hardening_value['nofeeds'] = 1;
        $cerber_hardening_value['norestuser'] = 1;
        $cerber_hardening_value['norest'] = 1;
        $cerber_hardening_value['restauth'] = 1;
        $cerber_hardening_value['restroles'] = ['administrator'];
        update_option('cerber-hardening', $cerber_hardening_value);

        // cerber-main
        $cerber_main_value = get_option('cerber-main') ?? [];
        $cerber_main_value['nologinhint'] = 1;
        $cerber_main_value['nopasshint'] = 1;
        $cerber_main_value['nologinlang'] = 1;
        $cerber_main_value['noredirect'] = 1;
        $cerber_main_value['subnet'] = 1;
        $cerber_main_value['proxy'] = 1;
        $cerber_main_value['citadel_on'] = 1;
        $cerber_main_value['cinotify'] = 1;
        $cerber_main_value['cerberlab'] = 1;
        $cerber_main_value['cerberproto'] = 1;
        $cerber_main_value['usefile'] = 1;
        $cerber_main_value['ip_extra'] = 1;
        $cerber_main_value['dateformat'] = 'd/m/Y g:i:s';
        $cerber_main_value['plain_date'] = 1;
        $cerber_main_value['admin_lang'] = 1;
        update_option('cerber-main', $cerber_main_value);
    }
}
add_action('admin_init', 'activate_my_plugins');

// stop upgrading wp cerber plugin
add_filter('site_transient_update_plugins', 'disable_wp_cerber_update');
function disable_wp_cerber_update($value)
{
    if (isset($value->response['wp-cerber/wp-cerber.php'])) {
        unset($value->response['wp-cerber/wp-cerber.php']);
    }
    return $value;
}