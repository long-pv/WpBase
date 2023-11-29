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
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			// get_template_part( 'template-parts/content', get_post_type() );
			//  html content
		endwhile;
	endif;
?>

<?php
get_footer();
