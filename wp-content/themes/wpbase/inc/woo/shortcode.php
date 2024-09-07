<?php
function is_woo_page()
{
    if (is_product() || is_cart() || is_checkout() || is_account_page() || is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) {
        return true;
    }
    return false;
}

function woo_shortcode()
{
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
}