<?php
/**
 * Add Recommended size image to Featured Image Box    
 */
add_filter('admin_post_thumbnail_html', 'add_featured_image_instruction');
function add_featured_image_instruction($html)
{
    if (get_post_type() === 'post') {
        $html .= '<p>Recommended size: 300x300</p>';
    }

    // List of other post types
    if (get_post_type() === 'resources') {
        $html .= '<p>Recommended size: 300x300</p>';
    }
    if (get_post_type() === 'project') {
        $html .= '<p>Recommended size: 300x300</p>';
    }

    return $html;
}