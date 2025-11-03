<?php
// ACF Options Page
add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {
        // Tạo submenu option cho 1 post type bất kì
        acf_add_options_sub_page(array(
            'page_title' => 'Discount Code',
            'menu_title' => 'Discount Code',
            'parent_slug' => 'edit.php?post_type=tour',
            'menu_slug' => 'discount-code-settings',
            'capability' => 'edit_posts',
        ));


        // Tạo danh sách submenu option cho theme settings option
        acf_add_options_page([
            'page_title' => 'Add shortcode setting',
            'menu_title' => 'Add shortcode setting',
            'menu_slug'  => 'add-shortcode-setting',
            'capability' => 'manage_options',
            'redirect'   => false,
            'position'   => 80,
            'autoload'   => true,
        ]);


        // Các trang con
        $sub_pages = [
            'CTA'           => 'cta',
            'FAQs'          => 'faqs',
            'Latest posts'  => 'latest-posts',
            'Menu setting'  => 'menu-setting',
            'Service'       => 'service',
            'Tabs'          => 'tabs',
            'Card category' => 'card-category',
            'Partner'       => 'partner',
            'Testimonial'   => 'testimonial',
            'Sidebar'       => 'sidebar',
            'Award'         => 'award',
            'About us'      => 'about-us',
            'Box content'   => 'box-content',
            'Promo banner'  => 'promo-banner',
            'List image'    => 'list-image',
            'Content image' => 'content-image',
            'Tabs category' => 'tabs-category',
        ];

        foreach ($sub_pages as $title => $slug) {
            acf_add_options_sub_page([
                'page_title'  => $title,
                'menu_title'  => $title,
                'parent_slug' => 'add-shortcode-setting',
                'menu_slug'   => $slug,
                'capability'  => 'manage_options',
                'autoload'    => true,
            ]);
        }
    }
});
