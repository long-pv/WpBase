<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package cltheme
 */

// count view
set_post_views($post->ID);
$post_views = get_field('post_views_count', $post->ID);
get_header();
?>

<div class="container">
    <div class="secSpace">
        <?php wp_breadcrumbs(); ?>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="editor">
                    <h1 class="h2 mb-4"><?php the_title(); ?></h1>
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
    </div>
</div>

<?php
get_footer();
