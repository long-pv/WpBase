<?php
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
        jQuery(document).ready(function($) {
            $('.quick-view-button').on('click', function(e) {
                e.preventDefault();

                var productId = $(this).data('product_id');

                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: 'POST',
                    data: {
                        action: 'load_quick_view',
                        product_id: productId
                    },
                    beforeSend: function() {
                        $("#ajax-loader").show();
                    },
                    success: function(response) {
                        $('#quick-view-product-content').html(response);
                        $('#quick-view-popup').fadeIn();
                    },
                    error: function(error) {
                        alert('Something went wrong.');
                    },
                    complete: function() {
                        $("#ajax-loader").hide();
                    },
                });
            });

            // Đóng popup
            $('.close-popup, #quick-view-popup').on('click', function() {
                $('#quick-view-popup').fadeOut();
            });

            // Ngăn không đóng khi nhấp vào nội dung popup
            $('.quick-view-content').on('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
<?php
}
add_action('wp_footer', 'add_quick_view_popup', 99);
