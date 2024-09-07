<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package basetheme
 */

get_header();
?>

<div id="wooSingleProduct" class="wooSingleProduct secSpace">
    <div class="container">
        <div class="wooSingleProduct__inner">
            <?php wp_breadcrumbs(); ?>
            <?php
            while (have_posts()):
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</div>

<?php
get_footer();