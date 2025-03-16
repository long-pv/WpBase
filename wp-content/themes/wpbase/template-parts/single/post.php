<?php
$post_id = get_the_ID();
$thumbnail_id = get_post_thumbnail_id($post_id);
$categories = get_the_category($post_id);
?>
<article id="post-<?php echo $post_id; ?>" class="singlePost">
    <div class="imgGroup">
        <?php echo img_html($thumbnail_id); ?>

        <a class="singlePost__link" href="<?php the_permalink(); ?>"></a>

        <?php
        if (!empty($categories)):
            $first_category = $categories[0];
        ?>
            <a href="<?php echo get_category_link($first_category->term_id) ?>" class="singlePost__cat wow">
                <?php echo $first_category->name; ?>
            </a>
        <?php
        endif;
        ?>

        <?php
        $user_id = get_current_user_id();
        if ($user_id):
            $favorite_posts = get_user_meta($user_id, 'favorite_posts', true) ?: [];
            $active_class = in_array($post_id, $favorite_posts) ? 'active' : '';
        ?>
            <span class="favorite_posts <?php echo $active_class; ?>" data-post_id="<?php echo $post_id; ?>"></span>
        <?php
        endif;
        ?>
    </div>
    <div class="singlePost__content">
        <div class="singlePost__date mb-2 wow">
            <?php echo get_the_date('d/m/Y'); ?>
        </div>
        <h3 class="h4 singlePost__title mb-3 wow" data-mh="title">
            <a class="line-2" href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
        <p class="singlePost__desc line-3 mb-0 wow">
            <?php echo get_the_excerpt(); ?>
        </p>
    </div>
</article>