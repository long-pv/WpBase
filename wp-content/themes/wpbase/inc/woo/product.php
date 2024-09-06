<?php
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('woocommerce_single_product_summary', 'custom_add_title_to_entry_summary', 5);
function custom_add_title_to_entry_summary()
{
    the_title('<h1 class="product-title">', '</h1>');
}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

add_filter('woocommerce_loop_add_to_cart_link', 'modify_add_to_cart_url_if_not_logged_in', 10, 2);
function modify_add_to_cart_url_if_not_logged_in($html, $product)
{
    if (!is_user_logged_in()) {
        $html = str_replace(
            $product->add_to_cart_url(),
            wc_get_page_permalink('myaccount'),
            $html
        );
    }

    return $html;
}

add_action('woocommerce_after_add_to_cart_form', 'custom_hide_add_to_cart_form_for_guests');
function custom_hide_add_to_cart_form_for_guests()
{
    if (!is_user_logged_in()) {
        ?>
        <style>
            .single-product form.cart {
                display: none !important;
            }
        </style>
        <?php
    }
}

function disable_woocommerce_zoom_script()
{
    remove_theme_support('wc-product-gallery-zoom');
}
add_action('wp_enqueue_scripts', 'disable_woocommerce_zoom_script', 20);