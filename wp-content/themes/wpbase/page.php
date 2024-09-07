<?php
/**
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

// header template
get_header();

while (have_posts()):
    the_post();
    ?>
    <div id="wooTheme" class="wooTheme secSpace">
        <div class="container">
            <div class="wooTheme__inner">
                <?php wp_breadcrumbs(); ?>

                <div class="secHeading">
                    <h2 class="secHeading__title wow">
                        <?php the_title(); ?>
                    </h2>
                </div>

                <?php
                // WooCommerce
                if (class_exists('WooCommerce')) {
                    if (is_cart()) {
                        echo do_shortcode('[woocommerce_cart]');
                    } else if (is_checkout()) {
                        if (is_wc_endpoint_url('order-received')) {
                            the_content();
                        } else {
                            echo do_shortcode('[woocommerce_checkout]');
                        }
                    } else if (is_account_page()) {
                        echo !is_user_logged_in() ? '<div class="row justify-content-center"><div class="col-lg-5">' : '';
                        echo do_shortcode('[woocommerce_my_account]');
                        echo !is_user_logged_in() ? '</div></div>' : '';
                    } else {
                        // shop and category
                        the_content();
                    }
                } else {
                    the_content();
                }
                ?>
            </div>
        </div>
    </div>

    <?php
endwhile;
// footer template
get_footer();