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
