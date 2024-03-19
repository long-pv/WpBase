<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wplongpv
 */

get_header();

wp_breadcrumbs();

// list post
while (have_posts()):
    the_post();
    echo '<br> Post : ' . get_the_title();
endwhile;

get_footer();
