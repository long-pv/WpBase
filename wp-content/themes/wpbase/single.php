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

                <?php echo rating_html($post_id); ?>

                <div class="py-5">
                    <h2>Share post</h2>

                    <?php
                    $share_link = get_permalink();
                    ?>
                    <div class="social_share_post">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_link; ?>" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_facebook">
                            <span class="social_share_post_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64h98.2V334.2H109.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H255V480H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"></path>
                                </svg>
                            </span>
                        </a>

                        <a href="https://twitter.com/home?status=<?php echo $share_link; ?>" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_twitter">
                            <span class="social_share_post_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM351.3 199.3v0c0 86.7-66 186.6-186.6 186.6c-37.2 0-71.7-10.8-100.7-29.4c5.3 .6 10.4 .8 15.8 .8c30.7 0 58.9-10.4 81.4-28c-28.8-.6-53-19.5-61.3-45.5c10.1 1.5 19.2 1.5 29.6-1.2c-30-6.1-52.5-32.5-52.5-64.4v-.8c8.7 4.9 18.9 7.9 29.6 8.3c-9-6-16.4-14.1-21.5-23.6s-7.8-20.2-7.7-31c0-12.2 3.2-23.4 8.9-33.1c32.3 39.8 80.8 65.8 135.2 68.6c-9.3-44.5 24-80.6 64-80.6c18.9 0 35.9 7.9 47.9 20.7c14.8-2.8 29-8.3 41.6-15.8c-4.9 15.2-15.2 28-28.8 36.1c13.2-1.4 26-5.1 37.8-10.2c-8.9 13.1-20.1 24.7-32.9 34c.2 2.8 .2 5.7 .2 8.5z"></path>
                                </svg>
                            </span>
                        </a>

                        <a href="https://pinterest.com/pin/create/button/?url=<?php echo $share_link; ?>&media=&description=text" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_pinterest">
                            <span class="social_share_post_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M384 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64h72.6l-2.2-.8c-5.4-48.1-3.1-57.5 15.7-134.7c3.9-16 8.5-35 13.9-57.9c0 0-7.3-14.8-7.3-36.5c0-70.7 75.5-78 75.5-25c0 13.5-5.4 31.1-11.2 49.8c-3.3 10.6-6.6 21.5-9.1 32c-5.7 24.5 12.3 44.4 36.4 44.4c43.7 0 77.2-46 77.2-112.4c0-58.8-42.3-99.9-102.6-99.9C153 139 112 191.4 112 245.6c0 21.1 8.2 43.7 18.3 56c2 2.4 2.3 4.5 1.7 7c-1.1 4.7-3.1 12.9-4.7 19.2c-1 4-1.8 7.3-2.1 8.6c-1.1 4.5-3.5 5.5-8.2 3.3c-30.6-14.3-49.8-59.1-49.8-95.1C67.2 167.1 123.4 96 229.4 96c85.2 0 151.4 60.7 151.4 141.8c0 84.6-53.3 152.7-127.4 152.7c-24.9 0-48.3-12.9-56.3-28.2c0 0-12.3 46.9-15.3 58.4c-5 19.3-17.6 42.9-27.4 59.3H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64z"></path>
                                </svg>
                            </span>
                        </a>

                        <a href="https://www.instagram.com/?url=<?php echo $share_link; ?>" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_instagram">
                            <span class="social_share_post_icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_4399_11130)">
                                        <path d="M17.625 4.26562H6.375C5.21191 4.26562 4.26562 5.21191 4.26562 6.375V17.625C4.26562 18.7881 5.21191 19.7344 6.375 19.7344H17.625C18.7881 19.7344 19.7344 18.7881 19.7344 17.625V6.375C19.7344 5.21191 18.7881 4.26562 17.625 4.26562ZM12 16.9219C9.28638 16.9219 7.07812 14.7136 7.07812 12C7.07812 9.28638 9.28638 7.07812 12 7.07812C14.7136 7.07812 16.9219 9.28638 16.9219 12C16.9219 14.7136 14.7136 16.9219 12 16.9219ZM16.9219 8.48438C16.1466 8.48438 15.5156 7.85339 15.5156 7.07812C15.5156 6.30286 16.1466 5.67188 16.9219 5.67188C17.6971 5.67188 18.3281 6.30286 18.3281 7.07812C18.3281 7.85339 17.6971 8.48438 16.9219 8.48438Z" fill="#CE3727" />
                                        <path d="M12 8.48438C10.0616 8.48438 8.48438 10.0616 8.48438 12C8.48438 13.9384 10.0616 15.5156 12 15.5156C13.9384 15.5156 15.5156 13.9384 15.5156 12C15.5156 10.0616 13.9384 8.48438 12 8.48438Z" fill="#CE3727" />
                                        <path d="M20.4375 0H3.5625C1.62415 0 0 1.62415 0 3.5625V20.4375C0 22.3759 1.62415 24 3.5625 24H20.4375C22.3759 24 24 22.3759 24 20.4375V3.5625C24 1.62415 22.3759 0 20.4375 0ZM21.1406 17.625C21.1406 19.5634 19.5634 21.1406 17.625 21.1406H6.375C4.43665 21.1406 2.85938 19.5634 2.85938 17.625V6.375C2.85938 4.43665 4.43665 2.85938 6.375 2.85938H17.625C19.5634 2.85938 21.1406 4.43665 21.1406 6.375V17.625Z" fill="#CE3727" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_4399_11130">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                        </a>

                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_link; ?>&title=text" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_linkedin">
                            <span class="social_share_post_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path>
                                </svg>
                            </span>
                        </a>

                        <a href="mailto:?subject=ChongthamTaiko&body=<?php echo $share_link; ?>" onclick="window.location = this.href" class="social_share_post_email">
                            <span class="social_share_post_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zM218 271.7L64.2 172.4C66 156.4 79.5 144 96 144l256 0c16.5 0 30 12.4 31.8 28.4L230 271.7c-1.8 1.2-3.9 1.8-6 1.8s-4.2-.6-6-1.8zm29.4 26.9L384 210.4 384 336c0 17.7-14.3 32-32 32L96 368c-17.7 0-32-14.3-32-32l0-125.6 136.6 88.2c7 4.5 15.1 6.9 23.4 6.9s16.4-2.4 23.4-6.9z"></path>
                                </svg>
                            </span>
                        </a>

                        <a href="javascript:void(0);" onclick="copyToClipboard('#copy2')" class="social_share_post_copy">
                            <span id="copy2" style="display:none"><?php echo $share_link; ?></span>
                            <span class="social_share_post_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M208 0L332.1 0c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9L448 336c0 26.5-21.5 48-48 48l-192 0c-26.5 0-48-21.5-48-48l0-288c0-26.5 21.5-48 48-48zM48 128l80 0 0 64-64 0 0 256 192 0 0-32 64 0 0 48c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 176c0-26.5 21.5-48 48-48z" />
                                </svg>
                            </span>
                            <script>
                                function copyToClipboard(selector) {
                                    var textElement = document.querySelector(selector);
                                    if (textElement) {
                                        var tempInput = document.createElement('input');
                                        tempInput.value = textElement.textContent;
                                        document.body.appendChild(tempInput);
                                        tempInput.select();

                                        try {
                                            var successful = document.execCommand('copy');
                                            var msg = successful ? 'Copy thành công!' : 'Copy không thành công, vui lòng thử lại.';
                                            alert(msg);
                                        } catch (err) {
                                            console.error('Oops, unable to copy', err);
                                            alert('Copy không thành công, vui lòng thử lại.');
                                        }

                                        document.body.removeChild(tempInput);
                                    }
                                }
                            </script>
                        </a>
                    </div>
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
            // Kiểm tra xem bài viết có cho phép bình luận không
            if (comments_open() || get_comments_number()) {
                comments_template(); // Gọi file comments.php
            }
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
