<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package basetheme
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
				<div class="col-md-6 col-lg-4 mb-3">
					<?php get_template_part('template-parts/single/post'); ?>
				</div>
				<?php
			endwhile;
			?>
		</div>

		<div class="pagination">
			<?php pagination(); ?>
		</div>
	</div>
</div>
<?php
get_footer();
