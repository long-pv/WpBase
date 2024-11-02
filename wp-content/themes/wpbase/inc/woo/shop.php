<?php
// Xử lý dịch ordering woocommerce
add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');
function custom_woocommerce_catalog_orderby($sortby)
{
    $sortby = array(
        'menu_order' => 'Thứ tự mặc định',
        // 'popularity' => 'Phổ biến',
        // 'rating' => 'Xếp hạng cao',
        // 'date' => 'Mới nhất',
        'price' => 'Giá: Thấp đến Cao',
        'price-desc' => 'Giá: Cao đến Thấp',
    );

    return $sortby;
}


// kích hoạt template mặc định trong theme
add_action('after_setup_theme', 'yourtheme_woocommerce_support');
function yourtheme_woocommerce_support()
{
    add_theme_support('woocommerce');
}

// số lượng sản phẩm trong 1 category
add_filter('loop_shop_per_page', 'set_products_per_page', 20);
function set_products_per_page($cols)
{
    return 20;
}