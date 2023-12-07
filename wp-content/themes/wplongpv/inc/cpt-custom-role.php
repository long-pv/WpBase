<?php
function register_cpt_post_types()
{
    $post_type_register = [
        'student' => [
            'labels' => [
                'name' => __('Students', 'wplongpv'),
                'singular_name' => __('Students', 'wplongpv'),
                'menu_name' => __('Students', 'wplongpv'),
            ],
            'tax' => [
                'course' => [
                    "name" => __("Course", "wplongpv"),
                    "singular_name" => __("Course", "wplongpv"),
                ],
                'city' => [
                    "name" => __("City", "wplongpv"),
                    "singular_name" => __("City", "wplongpv"),
                ],
            ]
        ]
        // New addition here
    ];

    foreach ($post_type_register as $post_type => $data) {
        register_cpt($post_type, $data);
    }
}
add_action('init', 'register_cpt_post_types');

function register_cpt($post_type, $data = [])
{

    $args = array(
        'labels' => $data['labels'],
        'description' => '',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => '',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'has_archive' => false,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'delete_with_user' => false,
        'exclude_from_search' => false,
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => $post_type, 'with_front' => true),
        'query_var' => true,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => array('title'),
        'capability_type' => 'post',
        // 'capabilities' => array(
        //     'create_posts' => 'create_' . $post_type,
        //     'delete_others_posts' => 'delete_' . $post_type,
        //     'delete_posts' => 'delete_' . $post_type,
        //     'delete_private_posts' => 'delete_private_' . $post_type,
        //     'delete_published_posts' => 'delete_published_' . $post_type,
        //     'edit_others_posts' => 'edit_others_' . $post_type,
        //     'edit_posts' => 'edit_' . $post_type,
        //     'edit_private_posts' => 'edit_private_' . $post_type,
        //     'edit_published_posts' => 'edit_published_' . $post_type,
        //     'publish_posts' => 'publish_' . $post_type,
        //     'read_private_posts' => 'read_private_' . $post_type,
        // ),
    );

    register_post_type($post_type, $args);

    if ($data['tax']) {
        foreach ($data['tax'] as $slug_name => $data_tax) {
            register_cpt_tax($slug_name, $data_tax, $post_type);
        }
    }
}

function register_cpt_tax($slug_name, $data_tax = [], $post_type = 'post')
{

    $args = [
        "label" => $slug_name,
        "labels" => $data_tax,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => $slug_name, 'with_front' => true,],
        "show_admin_column" => true,
        "show_in_rest" => true,
        "rest_base" => "car_model_id",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
        // 'capabilities' => array(
        //     'manage_terms' => 'manage_'.$slug_name,
        //     'edit_terms' => 'edit_'.$slug_name,
        //     'delete_terms' => 'delete_'.$slug_name,
        //     'assign_terms' => 'assign_'.$slug_name,
        // )
    ];
    register_taxonomy($slug_name, array($post_type), $args);
}