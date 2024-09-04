<?php
function pagination($query = null)
{
    $max_pages = 0;
    $prev_text = __('Prev', 'basetheme');
    $next_text = __('Next', 'basetheme');

    if ($query) {
        $max_pages = $query->max_num_pages;
    } else {
        global $wp_query;
        $max_pages = $wp_query->max_num_pages;
    }

    echo paginate_links(
        array(
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'total' => $max_pages,
            'current' => max(1, get_query_var('paged')),
            'format' => '?paged=%#%',
            'show_all' => false,
            'type' => 'plain',
            'end_size' => 2,
            'mid_size' => 1,
            'prev_next' => true,
            'prev_text' => $prev_text,
            'next_text' => $next_text,
            'add_args' => false,
            'add_fragment' => '',
        )
    );

    wp_reset_postdata();
}