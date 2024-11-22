<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dev_theme
 */

get_header();

$current_cat = get_queried_object();
?>

<div class="container secSpace">
	<?php if (have_posts()) : ?>
		<h1>
			<?php echo $current_cat->name; ?>
		</h1>
	<?php
		while (have_posts()) :
			the_post();
			the_title();
		endwhile;

		pagination();
	else:
		echo '<p>Không tìm thấy bài viết nào.</p>';
	endif;
	?>
</div>

<?php
get_footer();
