<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package basetheme
 */

// count view
$post_id = get_the_ID();
set_post_views($post_id);
$post_views = get_field('post_views_count', $post_id);
$arrPost = [];
array_push($arrPost, $post_id);

// header
get_header();
?>

<div class="container">
    <div class="secSpace">
        <?php wp_breadcrumbs(); ?>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="editor">
                    <?php
                    if (has_post_thumbnail()):
                        $caption = get_the_post_thumbnail_caption(get_the_ID());
                    ?>
                        <div class="imgWrap wp-caption mb-4">
                            <img class="m-auto" src="<?php echo get_the_post_thumbnail_url(); ?>"
                                alt="<?php the_title(); ?>">
                            <?php if ($caption): ?>
                                <p class="wp-caption-text">
                                    <?php echo $caption; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php
                    endif;
                    ?>

                    <h1 class="h2 text-center mb-2">
                        <?php the_title(); ?>
                    </h1>

                    <div class="text-center mb-3">
                        <?php echo get_the_date('d/m/Y'); ?>
                    </div>

                    <?php the_content(); ?>
                </div>

                <?php
                // handle next, previos links   
                $post_prev = get_adjacent_post(true, 'news', false);
                $post_next = get_adjacent_post(true, 'news', true);
                if ($post_prev || $post_next):
                ?>
                    <div class="post-single-navigation d-flex align-items-stretch mt-5">
                        <?php
                        if ($post_prev):
                        ?>
                            <a href="<?php echo get_permalink($post_prev->ID); ?>" class="mr-auto w-50 h-100 pr-4">
                                <?php echo get_the_title($post_prev->ID); ?>
                            </a>
                        <?php endif; ?>

                        <?php
                        if ($post_next):
                        ?>
                            <a href="<?php echo get_permalink($post_next->ID); ?>" class="ml-auto w-50 h-100 text-right pl-4">
                                <?php echo get_the_title($post_next->ID); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="comments_open">
            <?php
            // Kiểm tra nếu bài viết có bình luận và bình luận chưa đóng
            if (comments_open() || get_comments_number()) :
                comments_template(); // Bao gồm phần bình luận
            endif;
            ?>
        </div>
    </div>
</div>

<?php

$args_latest_posts = array(
    'post_type' => 'post',
    'posts_per_page' => '3',
    'post__not_in' => $arrPost,
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
    <section class="secSpace homePage__latest bg-light">
        <div class="container">
            <div class="secHeading">
                <h2 class="secHeading__title">
                    Bài viết liên quan
                </h2>

                <?php
                $categories = get_the_category();
                if (!empty($categories) && $categories[0]):
                    $category_link = get_category_link($categories[0]);
                ?>
                    <a class="secHeading__link" href="<?php echo $category_link; ?>">Xem thêm</a>
                <?php
                endif;
                ?>
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
get_footer();
