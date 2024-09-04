<?php
function add_custom_cf7_script()
{
    if (!is_admin() && class_exists('WPCF7')) {
        ?>
        <style>
            .wpcf7-pointer-events {
                pointer-events: none !important;
            }
        </style>

        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".wpcf7-form").on("submit", function () {
                    $('input[type="submit"]').addClass("wpcf7-pointer-events");
                });

                document.addEventListener(
                    "wpcf7submit",
                    function (event) {
                        $('input[type="submit"]').removeClass("wpcf7-pointer-events");
                    },
                    false
                );
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_custom_cf7_script', 99);