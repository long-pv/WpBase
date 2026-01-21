<?php
add_action('add_meta_boxes', function () {

    // QR cho CPT love_wish
    add_meta_box(
        'love_wish_qr_code',
        'QR Lời Chúc',
        'tomee_render_qr_metabox',
        'love_wish',
        'side',
        'high'
    );

    // QR cho Page dùng template page-love-form.php
    add_meta_box(
        'page_love_form_qr',
        'QR Trang Form',
        'tomee_render_qr_metabox',
        'page',
        'side',
        'high'
    );
});

function tomee_render_qr_metabox($post)
{

    $permalink = get_permalink($post->ID);
    if (!$permalink) return;

    // QuickChart QR – FREE – ỔN ĐỊNH
    $qr_url = 'https://quickchart.io/qr?size=300&text=' . urlencode($permalink);

    echo '<div style="text-align:center">';
    echo '<img src="' . esc_url($qr_url) . '" width="100%" height="auto" />';
    echo '</div>';
}
