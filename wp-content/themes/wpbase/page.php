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
    <div class="pageMain secSpace">
        <div class="container">
            <div class="pageMain__inner">
                <?php wp_breadcrumbs(); ?>

                <div class="secHeading text-center">
                    <h2 class="secHeading__title wow">
                        <?php the_title(); ?>
                    </h2>
                </div>

                <?php
                // WooCommerce
                if (function_exists('is_woocommerce') && is_woocommerce()):
                    echo '<div id="wooTheme" class="wooTheme">';

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

                    echo '</div>';
                else:
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="editor">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>

    <?php
endwhile;
// footer template
get_footer();