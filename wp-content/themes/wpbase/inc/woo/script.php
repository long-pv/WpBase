<?php
function add_custom_woo_script()
{
    if (!is_admin()):
        ?>
        <!-- custom woocommerce -->
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                var woo_url_ajax = '<?php echo admin_url('admin-ajax.php'); ?>';

                // tự động cập nhật giỏ hàng khi có thay đổi
                var btn_update_cart = $('button[name="update_cart"]');
                btn_update_cart.css('visibility', 'hidden'); // ẩn nút update cart
                $(document).on("change", "input.input-text.qty", function () {
                    $('button[name="update_cart"]').click();
                });

                // tăng số lượng của giỏ hàng
                $(document).on("wc_fragment_refresh updated_wc_div, added_to_cart", function () {
                    $.ajax({
                        url: woo_url_ajax,
                        type: "POST",
                        data: {
                            action: "update_cart_count",
                        },
                        success: function (response) {
                            $(".header__wooCartCount").text(response);
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