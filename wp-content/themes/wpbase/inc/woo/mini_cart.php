<?php
function woo_action_header()
{
    $link_myaccount = wc_get_page_permalink('myaccount');
    $link_cart = wc_get_cart_url();
?>
    <div class="header__woo">
        <a href="<?php echo $link_myaccount; ?>" class="header__wooMyaccout">
            <?php if (is_user_logged_in()): ?>
                <span class="header__wooIcon header__wooIcon--myAccount"></span>
            <?php else: ?>
                <span class="header__wooIcon header__wooIcon--login"></span>
            <?php endif; ?>
        </a>

        <?php if (is_user_logged_in()): ?>
            <div class="header_woo_cart">
                <a href="<?php echo $link_cart; ?>" class="header__wooCart">
                    <span class="header__wooIcon header__wooIcon--cart"></span>

                    <?php
                    $count_cart = WC()->cart->get_cart_contents_count() ?? 0;
                    if ($count_cart > 0):
                    ?>
                        <span class="header__wooCartCount">
                            <?php echo $count_cart; ?>
                        </span>

                        <div class="cart_collapse cart_collapse_html">
                            <?php cart_collapse(); ?>
                        </div>
                    <?php endif; ?>
                </a>
            </div>

            <a href="<?php echo wp_logout_url(home_url()); ?>" class="header__wooLogout">
                <span class="header__wooIcon header__wooIcon--logout"></span>
            </a>
        <?php endif; ?>
    </div>
<?php
}

function cart_collapse()
{
?>
    <div class="cart-sidebar__content">
        <h2>Giỏ hàng của bạn</h2>

        <!-- Hiển thị tổng số lượng sản phẩm -->
        <div class="cart-sidebar__total-items">
            <strong>Tổng số lượng: <?php echo WC()->cart->get_cart_contents_count(); ?></strong>
        </div>

        <ul class="cart-sidebar__items">
            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                $product = $cart_item['data'];
                $product_name = $product->get_name();
                $product_price = wc_price($product->get_price());
                $product_qty = $cart_item['quantity'];
                $product_url = get_permalink($product->get_id());
                $thumbnail = $product->get_image();
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $price_display = $product->is_on_sale() ? wc_price($sale_price) : wc_price($regular_price);
                $remove_url = wc_get_cart_remove_url($cart_item_key);
            ?>
                <li class="cart-sidebar__item">
                    <a href="<?php echo esc_url($product_url); ?>">
                        <?php echo $thumbnail; ?>
                        <span class="cart-sidebar__item-name">
                            <?php echo $product_name . ' x ' . $product_qty; ?>
                        </span>
                    </a>
                    <span class="cart-sidebar__item-price">
                        <?php echo $price_display; ?>
                    </span>
                    <a href="<?php echo esc_url($remove_url); ?>">
                        Xóa
                    </a>
                </li>
            <?php
            endforeach;
            ?>
        </ul>

        <!-- Hiển thị Subtotal -->
        <div class="cart-sidebar__subtotal">
            <strong>Subtotal: <?php echo WC()->cart->get_cart_subtotal(); ?></strong>
        </div>

        <div class="cart-sidebar__footer">
            <a href="<?php echo wc_get_cart_url(); ?>" class="button">
                Xem giỏ hàng
            </a>
            <a href="<?php echo wc_get_checkout_url(); ?>" class="button">
                Thanh toán
            </a>
        </div>
    </div>

    <?php
}

function update_cart_count()
{
    $cart_count = WC()->cart->get_cart_contents_count();

    // Bắt đầu buffer để lấy nội dung mini cart
    ob_start();
    cart_collapse();
    $mini_cart = ob_get_clean();

    // Trả về dữ liệu JSON
    wp_send_json([
        'cart_count' => $cart_count,
        'mini_cart' => $mini_cart,
    ]);

    wp_die();
}
add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');

function add_custom_woo_script()
{
    if (!is_admin()):
    ?>
        <!-- custom woocommerce -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // tự động cập nhật giỏ hàng khi có thay đổi
                var btn_update_cart = $('button[name="update_cart"]');
                btn_update_cart.css('visibility', 'hidden'); // ẩn nút update cart
                $(document).on("change", "input.input-text.qty", function() {
                    $('button[name="update_cart"]').click();
                });

                // tăng số lượng của giỏ hàng
                $(document).on("wc_fragment_refresh updated_wc_div added_to_cart", function() {
                    $.ajax({
                        url: custom_ajax.ajax_url,
                        type: "POST",
                        data: {
                            action: "update_cart_count",
                        },
                        success: function(response) {
                            $(".header__wooCartCount").text(response.cart_count);
                            // Cập nhật chi tiết mini cart
                            $(".cart_collapse_html").html(response.mini_cart);
                        },
                        error: function(error) {
                            alert('Something went wrong.');
                        },
                    });
                });
            });
        </script>
        <!-- end -->
<?php
    endif;
}
add_action('wp_footer', 'add_custom_woo_script', 99);
