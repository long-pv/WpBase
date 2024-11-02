<?php
// Loại bỏ Related products mặc định
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// thêm tiêu đề của sản phẩm
add_action('woocommerce_single_product_summary', 'custom_add_title_to_entry_summary', 5);
function custom_add_title_to_entry_summary()
{
    the_title('<h1 class="product-title">', '</h1>');
}

// nếu người dùng chưa đăng nhập sẽ thay đổi link add to cart thành link đăng nhập
add_filter('woocommerce_loop_add_to_cart_link', 'modify_add_to_cart_url_if_not_logged_in', 10, 2);
function modify_add_to_cart_url_if_not_logged_in($html, $product)
{
    if (!is_user_logged_in()) {
        $html = str_replace(
            $product->add_to_cart_url(),
            wc_get_page_permalink('myaccount'),
            $html
        );
    }

    return $html;
}

// loại bỏ chức năng zoom ảnh ở trang chi tiết
function disable_woocommerce_zoom_script()
{
    remove_theme_support('wc-product-gallery-zoom');
}
add_action('wp_enqueue_scripts', 'disable_woocommerce_zoom_script', 20);

add_action('admin_menu', 'remove_product_reviews_menu');
function remove_product_reviews_menu()
{
    remove_submenu_page('edit.php?post_type=product', 'product-reviews');
}

add_filter('woocommerce_admin_features', function ($features) {
    return array_values(
        array_filter($features, function ($feature) {
            return !in_array($feature, ['marketing', 'analytics', 'analytics-dashboard', 'wcpay']);
        })
    );
});

// Tắt chức năng Coupons
add_filter('woocommerce_coupons_enabled', '__return_false');