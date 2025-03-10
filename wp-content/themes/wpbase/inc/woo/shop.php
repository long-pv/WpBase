<?php
// Xử lý dịch ordering woocommerce
add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');
function custom_woocommerce_catalog_orderby($sortby)
{
    $sortby = array(
        'menu_order' => 'Thứ tự mặc định',
        'popularity' => 'Bán chạy nhất',
        'rating' => 'Xếp hạng cao',
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
    // Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
    // zoom.
    add_theme_support('wc-product-gallery-zoom');
    // lightbox.
    add_theme_support('wc-product-gallery-lightbox');
    // swipe.
    add_theme_support('wc-product-gallery-slider');
}

// số lượng sản phẩm trong 1 category
add_filter('loop_shop_per_page', 'set_products_per_page', 20);
function set_products_per_page($cols)
{
    return 20;
}


function custom_product_filter_query($query)
{
    if (!is_admin() && $query->is_main_query() && (is_post_type_archive('product') || is_product_category())) {
        // Lọc theo tên sản phẩm với tiêu đề chính xác hơn
        if (!empty($_GET['title'])) {
            $title = sanitize_text_field($_GET['title']);
            $query->set('post_title_like', $title);
        }

        // Lọc theo danh mục sản phẩm
        if (is_post_type_archive('product') && !empty($_GET['product_cat'])) {
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

function load_quick_view()
{
    $product_id = intval($_POST['product_id']);
    $product = wc_get_product($product_id);

    if (!$product) {
        wp_send_json_error();
    }

    // Lấy các thông tin sản phẩm
    $sku = $product->get_sku();
    $stock_status = $product->is_in_stock() ? 'Còn hàng' : 'Hết hàng';
    $categories = wc_get_product_category_list($product_id);
    $add_to_cart_url = wc_get_checkout_url() . '?add-to-cart=' . $product_id;
?>
    <div class="quick-view-product">
        <div class="quick-view-image">
            <?php echo $product->get_image(); ?>
        </div>
        <div class="quick-view-info">
            <h2><?php echo $product->get_name(); ?></h2>
            <p><?php echo $product->get_short_description(); ?></p>
            <div class="quick-view-sku">
                <strong>SKU:</strong> <?php echo $sku ? $sku : 'N/A'; ?>
            </div>
            <div class="quick-view-categories">
                <strong>Danh mục:</strong> <?php echo $categories; ?>
            </div>
            <div class="quick-view-stock-status">
                <strong>Tình trạng:</strong> <?php echo $stock_status; ?>
            </div>
            <div class="quick-view-price">
                <?php echo $product->get_price_html(); ?>
            </div>
            <div class="quick-view-buttons">
                <a href="<?php echo get_permalink($product_id); ?>" class="button view-details">
                    Xem chi tiết
                </a>
                <a href="<?php echo esc_url($add_to_cart_url); ?>" class="button buy-now">
                    Mua ngay
                </a>
            </div>
        </div>
    </div>
<?php
    die();
}
add_action('wp_ajax_load_quick_view', 'load_quick_view');
add_action('wp_ajax_nopriv_load_quick_view', 'load_quick_view');
