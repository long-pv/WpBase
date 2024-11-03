<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package basetheme
 */

?>
</main>
<!-- end main body -->

<!-- footer -->
<footer id="footer" class="footer secSpace">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-4 mb-3 mb-lg-0">
                <div class="footer__logo">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/logo_white.svg'; ?>" alt="logo">
                </div>
                <?php
                $introduce = get_field('introduce', 'option');
                if ($introduce):
                    ?>
                    <div class="footer__intro">
                        <?php echo $introduce; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <?php
                if (get_field('iframe_google_map', 'option')):
                    ?>
                    <div class="video">
                        <?php echo get_field('iframe_google_map', 'option'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (get_field('copyright', 'option')): ?>
            <div class="copyright mt-4 text-center">
                <?php echo get_field('copyright', 'option'); ?>
            </div>
        <?php endif; ?>
    </div>
</footer>
<!-- end footer -->

<?php wp_footer(); ?>

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

</body>

</html>