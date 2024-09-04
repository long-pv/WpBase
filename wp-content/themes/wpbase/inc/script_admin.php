<?php
add_action('admin_footer', 'custom_script_admin');
function custom_script_admin()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            // Validate post title
            if ($('#post').length > 0) {
                $('#post').submit(function () {
                    var title_post = $('#title').val();
                    if (title_post.trim() === '') {
                        alert('Please enter "Title".');
                        $('#title').focus();
                        return false;
                    }
                });
            }

            // Prevent users from using weak passwords
            $(".pw-weak").remove();
        });
    </script>
    <?php
}