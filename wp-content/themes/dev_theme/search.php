<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package dev_theme
 */

get_header();
?>

<div class="container secSpace">
	<?php
	if (have_posts()) :
	?>
		<h1>
			<?php printf(esc_html__('Search Results for: %s', 'dev_theme'), '<span>' . get_search_query() . '</span>'); ?>
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
