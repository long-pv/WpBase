<?php
function extend_search_acf($join)
{
    global $wpdb;
    if (is_search() && !is_admin()) {
        $join .= " LEFT JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)";
    }
    return $join;
}
add_filter('posts_join', 'extend_search_acf');

function extend_search_where($where)
{
    global $wpdb;
    if (is_search() && !is_admin()) {
        $search_term = esc_sql(get_query_var('s'));

        // Chỉ tìm kiếm trong post và product
        $allowed_post_types = ["post", "product"];
        $post_types_sql = "'" . implode("','", $allowed_post_types) . "'";

        // Áp dụng bộ lọc tìm kiếm
        $where .= " AND {$wpdb->posts}.post_type IN ($post_types_sql)";
        $where .= " OR ({$wpdb->posts}.post_type IN ($post_types_sql) AND {$wpdb->postmeta}.meta_value LIKE '%$search_term%')";
    }
    return $where;
}
add_filter('posts_where', 'extend_search_where');

function extend_search_groupby($groupby)
{
    global $wpdb;
    if (is_search() && !is_admin()) {
        $groupby = "{$wpdb->posts}.ID";
    }
    return $groupby;
}
add_filter('posts_groupby', 'extend_search_groupby');
