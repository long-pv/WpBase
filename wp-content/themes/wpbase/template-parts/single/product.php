<?php
global $product;
$product_id = get_the_ID();
?>

<article class="productItem" data-mh="productItem">
    <a href="<?php the_permalink(); ?>" class="imgGroup productItem__img" aria-label="<?php the_title(); ?>">
        <?php
        $image_id = get_post_thumbnail_id($product_id);
        ?>
        <?php echo img_html($image_id); ?>
    </a>
    <div class="productItem__content">

        <?php
        if ($product->is_on_sale()) :
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();

            if ($regular_price > 0):
                $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        ?>
                <div class="sale_notification">Sale <?php echo $discount_percentage; ?>%</div>
        <?php
            endif;
        endif;
        ?>

        <h3 class="h4 productItem__title" data-mh="title_product">
            <a class="line-3" href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
        <div class="productItem__price">
            <?php
            if ($price_html = $product->get_price_html()) : ?>
                <span class="price"><?php echo $price_html; ?></span>
            <?php endif;  ?>
        </div>

        <div class="my-3">
            <?php echo do_shortcode('[compare_button id="' . $product_id . '"]'); ?>
        </div>

        <?php if (shortcode_exists('woosc')) : ?>
            <div class="my-3">
                <?php echo do_shortcode('[woosc id="' . $product_id . '"]'); ?>
            </div>
        <?php endif; ?>

        <div class="productItem__quick-view">
            <a href="javascript:void(0);" class="quick-view-button" data-product_id="<?php echo esc_attr($product_id); ?>">
                Xem Nhanh
            </a>
        </div>

        <!-- Nút Add to Cart -->
        <div class="productItem__add-to-cart">
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
    </div>
</article>