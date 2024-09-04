<?php
/**
 * Template name: Danh sách bài viết
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package basetheme
 */

// header template
get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_latest_posts = array(
    'post_type' => 'post',
    'posts_per_page' => '15',
    'paged' => $paged,
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        ),
    ),
);
$latest_posts = new WP_Query($args_latest_posts);
if ($latest_posts->have_posts()):
    ?>
    <div class="container">
        <div class="secSpace">
            <?php wp_breadcrumbs(); ?>

            <div class="secHeading">
                <h2 class="secHeading__title">
                    <?php the_title(); ?>
                </h2>
            </div>

            <div class="row">
                <?php
                while ($latest_posts->have_posts()):
                    $latest_posts->the_post();
                    ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <?php get_template_part('template-parts/single/post'); ?>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>

            <?php pagination($latest_posts); ?>
        </div>
    </div>
    <?php
endif;
?>

<?php
// footer template
get_footer();