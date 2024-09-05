<?php
function fancybox_scripts()
{
    wp_enqueue_style('basetheme-style-fancybox', get_template_directory_uri() . '/assets/inc/fancybox/fancybox.css', array(), _S_VERSION);
    wp_enqueue_script('basetheme-script-fancybox', get_template_directory_uri() . '/assets/inc/fancybox/fancybox.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'fancybox_scripts');

function add_custom_fancybox_script()
{
    if (!is_admin()) {
        ?>
        <!-- fancybox -->
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                if ($('[data-fancybox="gallery"]').length > 0) {
                    $('[data-fancybox="gallery"]').fancybox({
                        buttons: ["close"],
                        loop: true,
                        protect: true,
                    });
                }
            });
        </script>
        <!-- end -->
        <?php
    }
}
add_action('wp_footer', 'add_custom_fancybox_script', 99);

function fancybox_html($url_img = [])
{
    $html = '';
    $url_list = is_array($url_img) ? $url_img : [$url_img];

    foreach ($url_list as $img) {
        $html .= '<a class="btnFancybox" href="' . $img . '" data-fancybox="gallery"><img src="' . $img . '"></a>';
    }

    return $html;
}
