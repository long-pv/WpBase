<?php
// thay đổi số cột hiển thị
add_filter('loop_shop_columns', 'custom_loop_shop_columns', 99);
function custom_loop_shop_columns()
{
    return 3;
}

// thay đổi số lượng hiển thị sản phẩm
add_action('pre_get_posts', 'custom_product_query', 99);
function custom_product_query($query)
{
    if (!is_admin() && (is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag())) {
        $query->set('posts_per_page', 9);
    }
}

// Chỉnh sửa các tham số phân trang
add_filter('woocommerce_pagination_args', 'custom_woocommerce_pagination_args', 99);
function custom_woocommerce_pagination_args($args)
{
    $args['prev_text'] = __('Prev', 'basetheme');
    $args['next_text'] = __('Next', 'basetheme');
    $args['type'] = 'plan';
    $args['end_size'] = 2;
    $args['mid_size'] = 1;

    return $args;
}