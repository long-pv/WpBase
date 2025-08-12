<?php
// ===============================
// Shortcode: [shortcode_name]
// ===============================
add_shortcode('shortcode_name', function ($atts) {
    $atts = shortcode_atts([
        'title'       => '', // Tiêu đề tuỳ chỉnh
        'url'       => '', // Link tùy chỉnh
    ], $atts);

    $title = !empty($atts['title']) ? $atts['title'] : '';
    $url = !empty($atts['url']) ? $atts['url'] : '';

    ob_start();
?>
    <div>
        html viết ở đây
    </div>
<?php
    return ob_get_clean();
});
