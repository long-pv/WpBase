<?php
/**
 * define form
 */
if (!defined('CTF7_LOGIN_ID')) {
    define('CTF7_LOGIN_ID', 180);
}

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
                        // remove class block submit
                        $('input[type="submit"]').removeClass("wpcf7-pointer-events");

                        // response ajax
                        var response = event.detail.apiResponse;
                        var contact_form_id = response.contact_form_id;
                        var status = response.status;

                        // logic form login
                        if (contact_form_id == <?php echo CTF7_LOGIN_ID; ?> && status == 'mail_sent') {
                            window.location.href = '<?php echo home_url(); ?>';
                        }
                    },
                    false
                );
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_custom_cf7_script', 99);

// form login
add_action('wpcf7_validate', 'custom_login_user_validation', 20);
function custom_login_user_validation($result)
{
    /*
    [text* username placeholder "Username"]
    [text* password placeholder "Password"]
    [submit "Log In"]
    */

    $contact_form = WPCF7_ContactForm::get_current();
    if ($contact_form && $contact_form->id() == CTF7_LOGIN_ID) {
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $data = $submission->get_posted_data();
            $username = sanitize_text_field($data['username']);
            $password = sanitize_text_field($data['password']);

            // Check if the username exists
            $user = get_user_by('login', $username);
            if (!$user) {
                // If the username does not exist
                $result->invalidate('username', __('Username does not exist. Please check and try again.', 'basetheme'));
            } else {
                // Check the password
                if (!wp_check_password($password, $user->user_pass, $user->ID)) {
                    // If the password is incorrect
                    $result->invalidate('password', __('Incorrect password. Please check and try again.', 'basetheme'));
                } else {
                    // Log the user in
                    $creds = array(
                        'user_login' => $username,
                        'user_password' => $password,
                        'remember' => false
                    );
                    $user_signon = wp_signon($creds, false);

                    if (is_wp_error($user_signon)) {
                        $result->invalidate('username', __('Login failed. Please try again.', 'basetheme'));
                    }
                }
            }
        }
    }

    return $result;
}