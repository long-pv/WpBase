<?php
get_header();
?>
<div class="secSpace">
    <div class="product_cat_wrap">
        <div class="container">
            <?php wp_breadcrumbs(); ?>

            <h1 class="h2 product_cat_title">
                <?php woocommerce_page_title(); ?>
            </h1>

            <div class="catalog_ordering">
                <?php
                $total_products = wc_get_loop_prop('total');
                ?>
                <div class="woocommerce-result-count">
                    <span><?php echo esc_html($total_products); ?> </span> kết quả
                </div>

                <?php woocommerce_catalog_ordering(); ?>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <?php get_template_part('template-parts/sidebar-product'); ?>
                </div>
                <div class="col-lg-9">
                    <?php if ($total_products): ?>
                        <div class="list-product-cat row list_product">
                            <?php while (have_posts()):
                                the_post(); ?>
                                <div class="col-lg-4 col-md-6">
                                    <?php get_template_part('template-parts/single/product'); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php pagination(); ?>
                        <?php
                    else:
                        ?>
                        <h3>Không có kết quả nào.</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    jQuery(document).ready(function ($) {
        var minPrice = parseFloat($("#slider-range").data("min"));
        var maxPrice = parseFloat($("#slider-range").data("max"));

        var minVal = $("#min-price").val() ? parseFloat($("#min-price").val()) : minPrice;
        var maxVal = $("#max-price").val() ? parseFloat($("#max-price").val()) : maxPrice;

        $("#slider-range").slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [minVal, maxVal],
            slide: function (event, ui) {
                $("#min-price").val(ui.values[0]);
                $("#max-price").val(ui.values[1]);
                $("#min-label").text("$" + ui.values[0]);
                $("#max-label").text("$" + ui.values[1]);
            }
        });

        $("#min-label").text("$" + minVal);
        $("#max-label").text("$" + maxVal);
    });
</script>