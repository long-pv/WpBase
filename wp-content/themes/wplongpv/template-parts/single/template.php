<div class="post">
    <a href="<?php the_permalink(); ?>">
        <img src="<?php custom_post_image(get_the_ID()); ?>" alt="<?php the_title(); ?>">
        <h3>
            <?php the_title(); ?>
        </h3>
    </a>
</div>