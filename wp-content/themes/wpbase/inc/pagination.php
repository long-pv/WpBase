<?php
function pagination($query = null)
{
    global $wp_query;
    $max_pages = $query ? $query->max_num_pages : $wp_query->max_num_pages;

    echo '<div class="pagination">';
    echo paginate_links(
        array(
            'total' => $max_pages,
            'current' => max(1, get_query_var('paged')),
            'end_size' => 2,
            'mid_size' => 1,
            'prev_text' => __('Prev', 'basetheme'),
            'next_text' => __('Next', 'basetheme'),
        )
    );
    echo '</div>';

    wp_reset_postdata();
}