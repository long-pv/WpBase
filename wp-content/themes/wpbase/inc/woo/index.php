<?php
function basetheme_woocommerce_setup()
{
    add_theme_support(
        'woocommerce',
        array(
            'thumbnail_image_width' => 150,
            'single_image_width'    => 300,
            'product_grid'          => array(
                'default_rows'    => 3,
                'min_rows'        => 1,
                'default_columns' => 4,
                'min_columns'     => 1,
                'max_columns'     => 6,
            ),
        )
    );
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'basetheme_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function basetheme_woocommerce_scripts()
{
    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

    wp_add_inline_style('basetheme-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'basetheme_woocommerce_scripts');

require get_template_directory() . '/inc/woo/breadcrumb.php';
require get_template_directory() . '/inc/woo/checkout_button_text.php';
require get_template_directory() . '/inc/woo/checkout_change_field.php';
require get_template_directory() . '/inc/woo/checkout_city_vietnam.php';
require get_template_directory() . '/inc/woo/mini_cart.php';
