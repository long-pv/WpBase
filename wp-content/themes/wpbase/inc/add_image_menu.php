<?php
// Thêm field URL icon vào admin menu
add_action('wp_nav_menu_item_custom_fields', function ($item_id, $item) {
    $icon = get_post_meta($item_id, '_menu_item_icon', true);
?>
    <p class="description description-wide">
        <label>
            Icon URL:<br>
            <input type="text"
                name="menu-item-icon[<?php echo $item_id; ?>]"
                value="<?php echo esc_attr($icon); ?>"
                class="widefat code edit-menu-item-icon"
                placeholder="https://domain.com/icon.png" />
        </label>
    </p>
<?php
}, 10, 2);

// Lưu URL icon
add_action('wp_update_nav_menu_item', function ($menu_id, $menu_item_db_id) {
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_icon', esc_url_raw($_POST['menu-item-icon'][$menu_item_db_id]));
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_icon');
    }
}, 10, 2);

// Hiển thị icon ngoài frontend
add_filter('walker_nav_menu_start_el', function ($item_output, $item) {
    $icon = get_post_meta($item->ID, '_menu_item_icon', true);
    if ($icon) {
        $icon_html = '<img src="' . esc_url($icon) . '" alt="" class="menu-icon" />';
        $item_output = $icon_html . $item_output;
    }
    return $item_output;
}, 10, 2);
