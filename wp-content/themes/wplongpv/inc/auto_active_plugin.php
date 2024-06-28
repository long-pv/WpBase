<?php
function activate_my_plugins()
{
    $plugins = [
        'advanced-custom-fields-pro\acf.php',
        'classic-editor\classic-editor.php',
        'duplicator\duplicator.php',
        'duplicate-post\duplicate-post.php',
    ];

    foreach ($plugins as $plugin) {
        if (!is_plugin_active($plugin)) {
            activate_plugin($plugin);
        }
    }
}
add_action('admin_init', 'activate_my_plugins');