<?php
/**
 * Template name: Trang chủ
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cltheme
 */

// header template
get_header();
?>

<?php
$args_news_top = array(
    'post_type' => 'post',
    'posts_per_page' => '8',
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        ),
    ),
);
$news_top = new WP_Query($args_news_top);
if ($news_top->have_posts()):
    ?>
    <section class="secSpace homePage__top">
        <div class="homePage__topSlider">
            <?php
            while ($news_top->have_posts()):
                $news_top->the_post();
                ?>
                <div>
                    <?php get_template_part('template-parts/single/post'); ?>
                </div>
                <?php
            endwhile;
            ?>
        </div>
    </section>
    <?php
endif;
wp_reset_postdata();
?>

<?php
$args_top_cat = array(
    'taxonomy' => 'category',
    'orderby' => 'count',
    'order' => 'DESC',
);
$top_cat = get_terms($args_top_cat);

if (!empty($top_cat)):
    ?>
    <section class="secSpace homePage__cats bg-light">
        <div class="container">
            <div class="secHeading">
                <h2 class="secHeading__title">
                    Danh mục
                </h2>
            </div>
            <div class="row">
                <?php
                foreach ($top_cat as $category):
                    ?>
                    <div class="col-md-6 mb-3">
                        <h3 class="h5 homePage__catsLink">
                            <a href="<?php echo get_category_link($category->term_id) ?>">
                                <?php echo $category->name . ' (' . $category->count . ')'; ?>
                            </a>
                        </h3>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </section>
    <?php
endif;
wp_reset_query();
?>

<?php
$args_latest_posts = array(
    'post_type' => 'post',
    'posts_per_page' => '6',
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
    <section class="secSpace homePage__latest">
        <div class="container">
            <div class="secHeading">
                <h2 class="secHeading__title">
                    Bài viết mới nhất
                </h2>
                <a class="secHeading__link" href="<?php echo home_url('/danh-sach-bai-viet'); ?>">Xem thêm</a>
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
        </div>
    </section>
    <?php
endif;
wp_reset_postdata();
?>

<?php
$args_view_top = array(
    'post_type' => 'post',
    'posts_per_page' => '3',
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        ),
    ),
);
$view_top = new WP_Query($args_view_top);
if ($view_top->have_posts()):
    ?>
    <section class="secSpace homePage__view bg-light">
        <div class="container">
            <div class="secHeading">
                <h2 class="secHeading__title">
                    Xem nhiều nhất
                </h2>
            </div>
            <div class="row">
                <?php
                while ($view_top->have_posts()):
                    $view_top->the_post();
                    ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <?php get_template_part('template-parts/single/post'); ?>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
        </div>
    </section>
    <?php
endif;
wp_reset_postdata();
?>

<?php
// footer template
get_footer();