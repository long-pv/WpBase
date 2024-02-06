<?php
function register_cpt_post_types()
{
    // format post type
    // $post_type = [
    //     'post_type' => [
    //         'labels' => [
    //             'name' => __('Lable', 'wplongpv'),
    //             'singular_name' => __('Lable', 'wplongpv'),
    //             'menu_name' => __('Lable', 'wplongpv'),
    //         ],
    //         'cap' => false,
    //         'hierarchical' => true
    //     ],
    // ];
    $post_type = get_field('lx_post_type', 'option') ?? null;

    if ($post_type && is_array($post_type)) {
        $post_type_arr = [];

        foreach ($post_type as $item) {
            $slug = $item['slug'];

            if ($slug) {
                $post_type_arr[$slug]['labels'] = [
                    'name' => $item['label'],
                    'singular_name' => $item['label'],
                    'menu_name' => $item['label'],
                ];
                $post_type_arr[$slug]['cap'] = $item['capability'] ?? false;
                $post_type_arr[$slug]['hierarchical'] = $item['hierarchical'] ?? false;
            }
        }

        if ($post_type_arr) {
            foreach ($post_type_arr as $post_type => $data) {
                register_cpt($post_type, $data);
            }
        }
    }

    // format custom taxonomy
    // $cpt_tax = [
    //     'taxonomy' => [
    //         'labels' => [
    //             "name" => __('Label', 'wplongpv'),
    //             "singular_name" => __('Label', 'wplongpv'),
    //         ],
    //         'cap' => false,
    //         'post_type' => [
    //             'key_post_type'
    //         ]
    //     ],
    // ];
    $taxonomy = get_field('lx_taxonomy', 'option') ?? null;

    if ($taxonomy && is_array($taxonomy)) {
        $taxonomy_arr = [];

        foreach ($taxonomy as $item) {
            $slug = $item['slug'];

            if ($slug) {
                $taxonomy_arr[$slug]['labels'] = [
                    "name" => $item['label'],
                    "singular_name" => $item['label'],
                ];
                $taxonomy_arr[$slug]['cap'] = $item['capability'] ?? false;

                $arr_post_type = [];
                if ($item['post_type']) {
                    foreach ($item['post_type'] as $post_type_item) {
                        $arr_post_type[] = $post_type_item['slug'];
                    }
                    $taxonomy_arr[$slug]['post_type'] = $arr_post_type;
                }
            }
        }

        if ($taxonomy_arr) {
            foreach ($taxonomy_arr as $ctx => $data) {
                register_ctx($ctx, $data);
            }
        }
    }
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
            'create_posts' => 'create_' . $post_type,
            'delete_others_posts' => 'delete_' . $post_type,
            'delete_posts' => 'delete_' . $post_type,
            'delete_private_posts' => 'delete_private_' . $post_type,
            'delete_published_posts' => 'delete_published_' . $post_type,
            'edit_others_posts' => 'edit_others_' . $post_type,
            'edit_posts' => 'edit_' . $post_type,
            'edit_private_posts' => 'edit_private_' . $post_type,
            'edit_published_posts' => 'edit_published_' . $post_type,
            'publish_posts' => 'publish_' . $post_type,
            'read_private_posts' => 'read_private_' . $post_type,
        ];
        $args['capabilities'] = $capabilities;
    }

    register_post_type($post_type, $args);
}

function register_ctx($ctx, $data)
{
    $args = [
        "label" => $ctx,
        "labels" => $data['labels'],
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => $ctx, 'with_front' => true,],
        "show_admin_column" => true,
        "show_in_rest" => true,
        "rest_base" => "car_model_id",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];

    if (!empty($data['cap'])) {
        $capabilities = [
            'manage_terms' => 'manage_' . $ctx,
            'edit_terms' => 'edit_' . $ctx,
            'delete_terms' => 'delete_' . $ctx,
            'assign_terms' => 'assign_' . $ctx,
        ];
        $args['capabilities'] = $capabilities;
    }

    register_taxonomy($ctx, $data['post_type'], $args);
}