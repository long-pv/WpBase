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
        'security',
        'lx_security',
    );

    add_submenu_page(
        'lx-smart-theme',
        'Post Type Image Size',
        'Post Type Image Size',
        'manage_options',
        'post-type-image-size',
        'lx_post_type_image_size',
    );
}

function lx_smart_theme()
{
    ?>
    <div class="alert alert-primary" role="alert">
        A simple primary alert—check it out!
    </div>
    <div class="alert alert-secondary" role="alert">
        A simple secondary alert—check it out!
    </div>
    <div class="alert alert-success" role="alert">
        A simple success alert—check it out!
    </div>
    <div class="alert alert-danger" role="alert">
        A simple danger alert—check it out!
    </div>
    <div class="alert alert-warning" role="alert">
        A simple warning alert—check it out!
    </div>
    <div class="alert alert-info" role="alert">
        A simple info alert—check it out!
    </div>
    <div class="alert alert-light" role="alert">
        A simple light alert—check it out!
    </div>
    <div class="alert alert-dark" role="alert">
        A simple dark alert—check it out!
    </div>
    <?php
}


function lx_post_type_image_size()
{
    echo '<h1>Post Type Image Size Page</h1>';
}

