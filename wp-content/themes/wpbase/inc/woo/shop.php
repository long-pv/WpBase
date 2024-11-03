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


function custom_product_filter_query($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('product')) {
        // Lọc theo tên sản phẩm với tiêu đề chính xác hơn
        if (!empty($_GET['title'])) {
            $title = sanitize_text_field($_GET['title']);
            $query->set('post_title_like', $title);
        }

        // Lọc theo danh mục sản phẩm
        if (!empty($_GET['product_cat'])) {
            $product_cat = sanitize_text_field($_GET['product_cat']);
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $product_cat,
                ),
            ));
        }

        // Lọc theo tag sản phẩm
        if (!empty($_GET['product_tags'])) {
            $product_tags = array_map('intval', $_GET['product_tags']);
            $query->set('tax_query', array_merge($query->get('tax_query', []), array(
                array(
                    'taxonomy' => 'product_tag',
                    'field' => 'term_id',
                    'terms' => $product_tags,
                ),
            )));
        }

        // Lọc theo khoảng giá
        if (!empty($_GET['min_price']) && !empty($_GET['max_price'])) {
            $min_price = floatval($_GET['min_price']);
            $max_price = floatval($_GET['max_price']);
            $meta_query[] = array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'DECIMAL',
            );
            $query->set('meta_query', $meta_query);
        }

        // Lọc theo thuộc tính sản phẩm
        if (!empty($_GET['product_attributes'])) {
            $product_attributes = array_map('intval', $_GET['product_attributes']);
            $tax_query = $query->get('tax_query', []);

            // Duyệt qua từng term_id đã chọn
            foreach ($product_attributes as $attribute_id) {
                // Lấy term để xác định taxonomy
                $term = get_term($attribute_id);
                if ($term) {
                    // Tạo tax_query cho từng term
                    $tax_query[] = array(
                        'taxonomy' => $term->taxonomy, // Sử dụng taxonomy gốc
                        'field' => 'term_id',
                        'terms' => $attribute_id,
                    );
                }
            }

            $query->set('tax_query', $tax_query);
        }
    }
}
add_action('pre_get_posts', 'custom_product_filter_query');

function title_like_posts_where($where, $query)
{
    global $wpdb;
    if ($title_like = $query->get('post_title_like')) {
        $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like($title_like) . '%');
    }
    return $where;
}
add_filter('posts_where', 'title_like_posts_where', 10, 2);