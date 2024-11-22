<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dev_theme
 */

get_header();
?>

<div class="container secSpace">
	<h1>
		<?php the_title(); ?>
	</h1>

	<div class="editor">
		<?php the_content(); ?>
	</div>
</div>

<?php
get_footer();
