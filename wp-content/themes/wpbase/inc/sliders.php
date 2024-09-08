<?php
function add_custom_slick_sliders_script()
{
    if (!is_admin()) {
        ?>
        <!-- slick sliders -->
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('.sliders[data-slick]').each(function () {
                    var $slider = $(this);
                    var settings = $slider.data('slick') || {};
                    $slider.slick(settings);
                });
            });
        </script>
        <!-- end -->
        <?php
    }
}
add_action('wp_footer', 'add_custom_slick_sliders_script', 99);

function render_sliders($slides = [], $options = [], $selector = '')
{
    if ($slides && $options):
        echo '<section id="' . $selector . '" class="sliders ' . $selector . '" data-slick=\'' . json_encode($options) . '\'>';
        foreach ($slides as $index => $slide):
            if ($slide) {
                echo '<div>';
                echo '<div class="sliders__item" data-mh="sliders__item">';
                if ($options['type'] == 'image'):
                    ?>
                    <div class="imgGroup <?php echo $selector ? $selector . '__imgWrap' : ''; ?>">
                        <img class="<?php echo $selector ? $selector . '__img' : ''; ?>" src="<?php echo $slide; ?>"
                            alt="<?php echo 'image item ' . ($index + 1); ?>">
                    </div>
                    <?php
                elseif ($options['type'] == 'content' || empty($options['type'])):
                    ?>
                    <div class="<?php echo $selector ? $selector . '__content' : ''; ?> editor">
                        <?php echo $slide; ?>
                    </div>
                    <?php
                else:
                    if (is_numeric($slide) || ($slide instanceof WP_Post)) {
                        global $post;
                        $post = get_post($slide);
                        if ($post) {
                            setup_postdata($post);
                            get_template_part('template-parts/single/' . $options['type']);
                            wp_reset_postdata();
                        }
                    } else {
                        $args['data'] = $slide;
                        get_template_part('template-parts/single/' . $options['type'], null, $args);
                    }
                endif;

                echo '</div>';
                echo '</div>';
            }
        endforeach;
        echo '</section>';
    endif;
}