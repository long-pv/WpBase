<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cltheme
 */

get_header();
$current_category = get_queried_object();
?>

<div class="container">
	<div class="secSpace">
		<?php wp_breadcrumbs(); ?>

		<div class="secHeading">
			<h2 class="secHeading__title">
				<?php echo $current_category->name; ?>
			</h2>
			<a class="secHeading__link" href="<?php echo home_url('/danh-sach-bai-viet'); ?>">Xem thêm</a>
		</div>

		<div class="row">
			<?php
			// list post
			while (have_posts()):
				the_post();
				?>
				<div class="col-md-6 col-lg-3 mb-3">
					<?php get_template_part('template-parts/single/post'); ?>
				</div>
				<?php
			endwhile;
			?>
		</div>

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
					'prev_text' => 'Trước',
					'next_text' => 'Sau',
					'add_args' => false,
					'add_fragment' => '',
				)
			);
			wp_reset_postdata();
			?>
		</div>
	</div>
</div>
<?php
get_footer();
