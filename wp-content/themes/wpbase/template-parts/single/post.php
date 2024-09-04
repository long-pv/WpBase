<?php
$post_id = get_the_ID();
$thumbnail_id = get_post_thumbnail_id($post_id);
$categories = get_the_category($post_id);
?>
<article id="post-<?php echo $post_id; ?>" class="singlePost">
    <div class="imgGroup">
        <picture>
            <source media="(min-width:992px)" srcset="<?php echo img_url($thumbnail_id, 'medium'); ?>">
            <img src="<?php echo img_url($thumbnail_id, 'thumbnail'); ?>" alt="<?php the_title(); ?>">
        </picture>

        <a class="singlePost__link" href="<?php the_permalink(); ?>"></a>

        <?php
        if (!empty($categories)):
            $first_category = $categories[0];
            ?>
            <a href="<?php echo get_category_link($first_category->term_id) ?>" class="singlePost__cat">
                <?php echo $first_category->name; ?>
            </a>
            <?php
        endif;
        ?>
    </div>
    <div class="singlePost__content">
        <div class="singlePost__date mb-2">
            <?php echo get_the_date('d/m/Y'); ?>
        </div>
        <h3 class="h4 singlePost__title mb-3" data-mh="title">
            <a class="line-2" href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
        <p class="singlePost__desc line-3 mb-0">
            <?php echo get_the_excerpt(); ?>
        </p>
    </div>
</article>