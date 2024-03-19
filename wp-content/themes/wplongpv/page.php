<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wplongpv
 */

// header template
get_header();

wp_breadcrumbs();

// list post
while (have_posts()):
    the_post();
    echo '<br> Post : ' . get_the_title();
endwhile;

// footer template
get_footer();