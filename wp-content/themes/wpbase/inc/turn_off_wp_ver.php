<?php
// remove wp_version
function vf_remove_wp_version_strings($src)
{
    global $wp_version;
    $query_string = parse_url($src, PHP_URL_QUERY);
    if ($query_string) {
        parse_str($query_string, $query);
        if (!empty($query['ver']) && $query['ver'] === $wp_version) {
            $src = remove_query_arg('ver', $src);
        }
    }
    return $src;
}
add_filter('script_loader_src', 'vf_remove_wp_version_strings');
add_filter('style_loader_src', 'vf_remove_wp_version_strings');

// Hide WP version strings from generator meta tag
function vf_remove_version()
{
    return '';
}
add_filter('the_generator', 'vf_remove_version');
