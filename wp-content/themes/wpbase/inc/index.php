<?php
// includes files core
require get_template_directory() . '/inc/define.php';
require get_template_directory() . '/inc/theme_setup.php';
require get_template_directory() . '/inc/auto_active_plugin.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/cpt_custom.php';
require get_template_directory() . '/inc/view_post.php';
require get_template_directory() . '/inc/security.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/pagination.php';
require get_template_directory() . '/inc/write_log.php';
require get_template_directory() . '/inc/get_image_url.php';
// Other files
require get_template_directory() . '/inc/contact_form_7.php';
require get_template_directory() . '/inc/export_csv.php';
require get_template_directory() . '/inc/load_more_posts.php';
require get_template_directory() . '/inc/video_popup.php';
require get_template_directory() . '/inc/fancybox.php';
require get_template_directory() . '/inc/select_dropdown_by_ul.php';
require get_template_directory() . '/inc/polylang.php';
require get_template_directory() . '/inc/accordion.php';
require get_template_directory() . '/inc/sliders.php';
require get_template_directory() . '/inc/datatable.php';
require get_template_directory() . '/inc/search_ajax.php';
require get_template_directory() . '/inc/pdf_viewer.php';
require get_template_directory() . '/inc/countdown_date.php';
require get_template_directory() . '/inc/intlTelInput.php';
require get_template_directory() . '/inc/export_pdf/index.php';
// woocommerce
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woo/index.php';
}