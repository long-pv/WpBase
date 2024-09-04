<?php
function img_url($img = '', $size = 'medium')
{
    $size = strtolower($size);

    if (empty($size) || !in_array($size, ['thumbnail', 'medium', 'large', 'full'])) {
        $size = 'medium';
    }

    if (is_array($img) && !empty($img['ID'])) {
        $url = wp_get_attachment_image_url($img['ID'], $size);
    } elseif (is_numeric($img)) {
        $url = wp_get_attachment_image_url($img, $size);
    } elseif (filter_var($img, FILTER_VALIDATE_URL)) {
        $id = attachment_url_to_postid($img);
        $url = $id ? wp_get_attachment_image_url($id, $size) : $img;
    } else {
        $url = '';
    }
    return $url ?: NO_IMAGE;
}