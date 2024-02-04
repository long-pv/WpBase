<?php
add_action('admin_menu', 'lx_admin_menu');
function lx_admin_menu()
{
    // Primary menu
    add_menu_page(
        'Smart Theme',
        'Smart Theme',
        'manage_options',
        'lx-smart-theme',
        'lx_smart_theme',
        'dashicons-image-filter'
    );

    add_submenu_page(
        'lx-smart-theme',
        'Security',
        'Security',
        'manage_options',
        'lx-security',
        'lx_security',
    );

    add_submenu_page(
        'lx-smart-theme',
        'Post Type Image Size',
        'Post Type Image Size',
        'manage_options',
        'lx-post-type-image-size',
        'lx_post_type_image_size',
    );
}

function lx_post_type_image_size()
{
    echo '<h1>Post Type Image Size Page</h1>';
}

