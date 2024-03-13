<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wplongpv
 */

get_header();
?>

<?php
// list post
while (have_posts()):
	the_post();
	echo 'Post : ' . get_the_title();
endwhile;
?>

<div class="pagination">
	<?php
	echo paginate_links(
		array(
			'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
			'total' => $wp_query->max_num_pages,
			'current' => max(1, get_query_var('paged')),
			'format' => '?paged=%#%',
			'show_all' => false,
			'type' => 'plain',
			'end_size' => 2,
			'mid_size' => 1,
			'prev_next' => true,
			'prev_text' => '',
			'next_text' => '',
			'add_args' => false,
			'add_fragment' => '',
		)
	);
	wp_reset_postdata();
	?>
</div>

<?php
get_footer();
