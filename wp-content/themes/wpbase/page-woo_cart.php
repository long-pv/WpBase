<?php

/**
 * Template name: Woo Cart
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package basetheme
 */

get_header();
?>
<div class="py-section">
    <div class="container">
        <?php echo do_shortcode('[woocommerce_cart]'); ?>
    </div>
</div>
<?php
get_footer();
