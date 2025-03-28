<?php
// Load plugin.php to use is_plugin_active() if not loaded yet
if (!function_exists('is_plugin_active')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// Create a menu in WordPress Admin if WP Cerber is active
function cerber_add_admin_menu()
{
    // Check if WP Cerber is active
    if (is_plugin_active('wp-cerber/wp-cerber.php')) {
        add_menu_page(
            'WP Cerber Cleanup',
            'Delete WP Cerber Logs',
            'manage_options',
            'cerber_cleanup',
            'cerber_cleanup_page',
            'dashicons-trash',
            100
        );
    }
}
add_action('admin_menu', 'cerber_add_admin_menu');

// Function to display the cleanup interface
function cerber_cleanup_page()
{
?>
    <div class="wrap">
        <h1>Delete WP Cerber Logs</h1>
        <p>Click the button below to delete logs older than 7 days.</p>
        <form method="post">
            <input type="hidden" name="cerber_cleanup_action" value="1">
            <?php submit_button('Delete Logs Now', 'delete'); ?>
        </form>
    </div>
<?php
    if (isset($_POST['cerber_cleanup_action']) && $_POST['cerber_cleanup_action'] == '1') {
        cerber_delete_old_logs();
        echo '<div class="updated"><p><strong>Logs successfully deleted!</strong></p></div>';
    }
}

// Function to delete WP Cerber logs older than 7 days
function cerber_delete_old_logs()
{
    global $wpdb;
    $days = 7;
    $cutoff_time = time() - ($days * DAY_IN_SECONDS);

    $wpdb->query("DELETE FROM cerber_log WHERE stamp < $cutoff_time");
    $wpdb->query("DELETE FROM cerber_traffic WHERE stamp < $cutoff_time");

    // Optimize database
    $wpdb->query("OPTIMIZE TABLE cerber_log");
    $wpdb->query("OPTIMIZE TABLE cerber_traffic");
}
