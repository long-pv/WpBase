<?php
add_action('admin_footer', 'custom_script_admin');
function custom_script_admin()
{
    global $post_type;

    // required to enter images
    if ($post_type == 'post'):
        ?>
        <script>
            jQuery(document).ready(function ($) {
                $('label[for="postimagediv-hide"]').remove();
                $('#post').submit(function () {
                    if ($('#set-post-thumbnail img').length == 0) {
                        let postimagediv = $('#postimagediv');
                        $('html, body').animate({
                            scrollTop: postimagediv.offset().top - 100
                        }, 500);
                        alert('Please enter Featured image.');
                        return false;
                    }
                });
                $('#set-post-thumbnail').on('click', function () {
                    $('#postimagediv').removeClass('error');
                });
            });
        </script>
        <?php
    endif;

    // The function requires entering a category for the article
    if ($post_type == 'post'):
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('label[for="categorydiv-hide"]').remove();
                $('#post').submit(function () {
                    if ($('#categorychecklist input[type="checkbox"]:checked').length === 0) {
                        alert('Please enter category.');
                        $('html, body').animate({
                            scrollTop: $('#categorydiv').offset().top - 100
                        }, 'slow');
                        return false;
                    }
                });

                <?php
                // Remove automatic checking on default category
                if (isset($_GET['post']) && $_GET['post'] == 0):
                    ?>
                    $('#categorychecklist input[type="checkbox"]').prop('checked', false);
                    <?php
                endif;
                ?>
            });
        </script>
        <?php
    endif;

    // Prevent users from using weak passwords
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $(".pw-weak").remove();
        });
    </script>
    <?php
}