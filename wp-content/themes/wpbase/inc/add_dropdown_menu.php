<?php
function add_dropdown_arrow_to_menu($items, $args)
{
    if ($args->theme_location) {
        $items = preg_replace('/(<a.*?>)(.*)<\/a>/i', '<span class="dropdown-arrow"></span>$1$2</a>', $items);
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_dropdown_arrow_to_menu', 10, 2);
