<?php
function add_custom_woo_script()
{
    if (!is_admin()):
        ?>
        <!-- custom woocommerce -->
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                // tự động cập nhật giỏ hàng khi có thay đổi
                var btn_update_cart = $('button[name="update_cart"]');
                btn_update_cart.css('visibility', 'hidden'); // ẩn nút update cart
                $(document).on("change", "input.input-text.qty", function () {
                    $('button[name="update_cart"]').click();
                });

                // tăng số lượng của giỏ hàng
                $(document).on("wc_fragment_refresh updated_wc_div added_to_cart", function () {
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: "POST",
                        data: {
                            action: "update_cart_count",
                        },
                        beforeSend: function () {
                            $("#ajax-loader").show();
                        },
                        success: function (response) {
                            $(".header__wooCartCount").text(response);
                        },
                        error: function (error) {
                            alert('Something went wrong.');
                        },
                        complete: function () {
                            $("#ajax-loader").hide();
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

function add_quick_view_popup()
{
    ?>
    <!-- Popup Quick View -->
    <div id="quick-view-popup" class="quick-view-popup" style="display: none;">
        <div class="quick-view-content">
            <span class="close-popup">×</span>
            <div id="quick-view-product-content"></div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            $('.quick-view-button').on('click', function (e) {
                e.preventDefault();

                var productId = $(this).data('product_id');

                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: 'POST',
                    data: {
                        action: 'load_quick_view',
                        product_id: productId
                    },
                    beforeSend: function () {
                        $("#ajax-loader").show();
                    },
                    success: function (response) {
                        $('#quick-view-product-content').html(response);
                        $('#quick-view-popup').fadeIn();
                    },
                    error: function (error) {
                        alert('Something went wrong.');
                    },
                    complete: function () {
                        $("#ajax-loader").hide();
                    },
                });
            });

            // Đóng popup
            $('.close-popup, #quick-view-popup').on('click', function () {
                $('#quick-view-popup').fadeOut();
            });

            // Ngăn không đóng khi nhấp vào nội dung popup
            $('.quick-view-content').on('click', function (e) {
                e.stopPropagation();
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'add_quick_view_popup', 99);