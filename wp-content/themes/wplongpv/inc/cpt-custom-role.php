<?php
function register_cpt_post_types()
{
    $post_type_register = [
        'academic' => [
            'labels' => [
                'name' => __('Academic', 'clvinuni'),
                'singular_name' => __('Academic', 'clvinuni'),
                'menu_name' => __('Academic', 'clvinuni'),
            ],
            'cap' => false,
            'hierarchical' => true
        ],
    ];

    // $ctx_arr = [
    //     'area' => [
    //         'data' => [
    //             "name" => __("Area", "clvinuni"),
    //             "singular_name" => __("Area", "clvinuni"),
    //         ],
    //         'post_type' => [
    //             'daily_tours',
    //             'package_tours'
    //         ]
    //     ],
    // ];

    foreach ($post_type_register as $post_type => $data) {
        register_cpt($post_type, $data);
    }

    // foreach ($ctx_arr as $ctx => $data) {
    //     register_ctx($ctx, $data);
    // }
}
add_action('init', 'register_cpt_post_types');

function register_cpt($post_type, $data = [])
{
    $hierarchical = $data['hierarchical'] ?: false;
    $attributes = $hierarchical ? 'page-attributes' : '';

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
        'hierarchical' => $data['labels'] ?: false,
        'rewrite' => array('slug' => $post_type, 'with_front' => true),
        'query_var' => $hierarchical,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => array('title', 'editor', 'thumbnail', $attributes),
        'capability_type' => 'post',
    );

    if (!empty($data['cap'])) {
        $capabilities = [
            'manage_terms' => 'manage_' . $post_type,
            'edit_terms' => 'edit_' . $post_type,
            'delete_terms' => 'delete_' . $post_type,
            'assign_terms' => 'assign_' . $post_type,
        ];
        $args['capabilities'] = $capabilities;
    }

    register_post_type($post_type, $args);
}

function register_ctx($slug_name, $data)
{
    $args = [
        "label" => $slug_name,
        "labels" => $data['data'],
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
    ];
    register_taxonomy($slug_name, $data['post_type'], $args);
}