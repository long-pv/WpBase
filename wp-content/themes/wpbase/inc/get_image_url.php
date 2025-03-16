<?php
function img_html($img = '')
{
    $size = 'full'; // Luôn lấy ảnh full

    if (is_array($img) && !empty($img['ID'])) {
        $html = wp_get_attachment_image($img['ID'], $size);
    } elseif (is_numeric($img)) {
        $html = wp_get_attachment_image($img, $size);
    } elseif (filter_var($img, FILTER_VALIDATE_URL)) {
        $id = attachment_url_to_postid($img);
        $html = $id ? wp_get_attachment_image($id, $size) : '<img src="' . esc_url($img) . '" alt="image" />';
    } else {
        $html = '';
    }
    return $html ?: '';
}
