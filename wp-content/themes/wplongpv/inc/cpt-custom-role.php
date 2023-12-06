<?php
function cpt_student() {
    $labels = array(
        'name' => __('Student', 'labtechco'),
        'singular_name' => __('Student', 'labtechco'),
        'menu_name' => __('Student', 'labtechco'),
    );

    $slug_name = 'student';

    $args = array(
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => $slug_name, "with_front" => true],
        "query_var" => true,
        "menu_icon" => "dashicons-admin-post",
        "supports" => ["title"],
        "capability_type" => "post",
        'capabilities' => array(
            'create_posts' => 'create_'.$slug_name,
            'delete_others_posts' => 'delete_'.$slug_name,
            'delete_posts' => 'delete_'.$slug_name,
            'delete_private_posts' => 'delete_private_'.$slug_name,
            'delete_published_posts' => 'delete_published_'.$slug_name,
            'edit_others_posts' => 'edit_others_'.$slug_name,
            'edit_posts' => 'edit_'.$slug_name,
            'edit_private_posts' => 'edit_private_'.$slug_name,
            'edit_published_posts' => 'edit_published_'.$slug_name,
            'publish_posts' => 'publish_'.$slug_name,
            'read_private_posts' => 'read_private_'.$slug_name,
        ),
    );

    register_post_type($slug_name, $args);
}

add_action('init', 'cpt_student');

function tax_course_of_cpt_student() {

    $labels = [
        "name" => __("Course", "labtechco"),
        "singular_name" => __("Course", "labtechco"),
    ];

    $slug_name = 'course';

    $args = [
        "label" => __("Course", "labtechco"),
        "labels" => $labels,
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
        'capabilities' => array(
            'manage_terms' => 'manage_'.$slug_name,
            'edit_terms' => 'edit_'.$slug_name,
            'delete_terms' => 'delete_'.$slug_name,
            'assign_terms' => 'assign_'.$slug_name,
        )
    ];
    register_taxonomy($slug_name, ["student"], $args);
}
add_action('init', 'tax_course_of_cpt_student');