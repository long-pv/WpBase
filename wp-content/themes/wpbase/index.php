<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package basetheme
 */

get_header();
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

        <div class="row" id="post-list">
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

        <div class="text-center mt-5">
            <button class="load_more btn btn-primary" data-page="1" data-posts_per_page="2" data-post_type="post">
                <?php _e('Read More', 'basetheme'); ?>
            </button>
        </div>
    </div>
</div>
<?php
get_footer();