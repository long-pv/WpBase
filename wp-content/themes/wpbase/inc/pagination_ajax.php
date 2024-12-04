<?php
add_action('wp_ajax_ajax_pagination_load_post', 'ajax_pagination_load_post');
add_action('wp_ajax_nopriv_ajax_pagination_load_post', 'ajax_pagination_load_post');
function ajax_pagination_load_post()
{
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'paged' => $paged,
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()):
            $query->the_post();
?>
            <li>
                <?php the_title(); ?>
            </li>
<?php
        endwhile;
    endif;
    wp_die();
}

add_action('wp_ajax_ajax_pagination', 'ajax_pagination_handler');
add_action('wp_ajax_nopriv_ajax_pagination', 'ajax_pagination_handler');
function ajax_pagination_handler()
{
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'paged' => $paged,
    );
    $query = new WP_Query($args);

    echo paginate_links(
        array(
            'total'     => $query->max_num_pages,
            'current'   => $paged,
            'end_size' => 2,
            'mid_size' => 1,
            'prev_text' => __('Trước', 'basetheme'),
            'next_text' => __('Sau', 'basetheme'),
        )
    );
    wp_die();
}
