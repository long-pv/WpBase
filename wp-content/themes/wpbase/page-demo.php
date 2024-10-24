<?php
/**
 * Template name: Page Demo
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package basetheme
 */

// header template
get_header();
?>
<div class="container py-5">
    <div class="pb-5">
        <h2>Form validate</h2>
        <form id="personal-info-form">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            </div>

            <!-- Nút submit -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php
get_footer();
?>
<script>
    jQuery(document).ready(function ($) {
        var url_ajax = '<?php echo admin_url('admin-ajax.php'); ?>';

        $("#personal-info-form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                address: {
                    required: true
                },
                avatar: {
                    required: true,
                    extension: "jpg,jpeg,png,gif"
                }
            },
            messages: {
                name: {
                    required: "Please enter your full name",
                    minlength: "Your name must be at least 2 characters long"
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                address: {
                    required: "Please enter your address"
                },
                avatar: {
                    required: "Please upload an avatar",
                    extension: "Only jpg, jpeg, png, or gif files are allowed"
                }
            },
            submitHandler: function (form) {
                var formData = new FormData(form); // lấy data
                formData.append("action", "ajax_action"); // gọi tới hook action

                // ngăn không submit
                return false;
            }
        });
    });
</script>