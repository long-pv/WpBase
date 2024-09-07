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
                        <?php
                        if (function_exists('is_woo_page') && is_woo_page()):
                            woo_title();
                        else:
                            the_title();
                        endif;
                        ?>
                    </h2>
                </div>

                <?php
                // WooCommerce
                if (function_exists('is_woo_page') && is_woo_page()):
                    woo_shortcode();
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