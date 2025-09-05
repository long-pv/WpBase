<?php
function add_custom_cf7_script()
{
    if (!is_admin() && class_exists('WPCF7')) {
?>

        <!-- contact form 7 custom -->
        <style>
            .wpcf7-pointer-events {
                pointer-events: none !important;
            }
        </style>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(".wpcf7-form").on("submit", function() {
                    $('input[type="submit"]').addClass("wpcf7-pointer-events");
                });

                document.addEventListener(
                    "wpcf7submit",
                    function(event) {
                        // remove class block submit
                        $('input[type="submit"]').removeClass("wpcf7-pointer-events");

                        // response ajax
                        var response = event.detail.apiResponse;
                        var contact_form_id = response.contact_form_id;
                        var status = response.status;
                        var home_url = '<?php echo home_url(); ?>';

                        // logic form login
                        if (contact_form_id == <?php echo CTF7_LOGIN_ID; ?> && status == 'mail_sent') {
                            window.location.href = home_url;
                        }
                        // logic form register
                        if (contact_form_id == <?php echo CTF7_REGISTER_ID; ?> && status == 'mail_sent') {
                            window.location.href = home_url;
                        }
                    },
                    false
                );
            });
        </script>
        <!-- end -->
<?php
    }
}
add_action('wp_footer', 'add_custom_cf7_script', 99);

// form login
add_action('wpcf7_validate', 'custom_login_user_validation', 20);
function custom_login_user_validation($result)
{
    /*
    Tabs: Form
    [email* username placeholder "Eamil"]
    [text* password placeholder "Password"]
    [submit "Log In"]

    Tabs: Additional Settings
    skip_mail: on
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

// Form Register
add_action('wpcf7_validate', 'custom_registration_user_validation', 20);
function custom_registration_user_validation($result)
{
    /*
    Tabs: Form
    [email* email_user placeholder "Email"]
    [text* password placeholder "Password"]
    [text* confirm_password placeholder "Confirm Password"]
    [submit "Register"]

    Tabs: Mail 
    Setup mail + body

    If Error send Mail -> Setup Mail SMTP
    */

    $contact_form = WPCF7_ContactForm::get_current();
    if ($contact_form && $contact_form->id() == CTF7_REGISTER_ID) {
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $data = $submission->get_posted_data();
            $email = sanitize_email($data['email_user']);
            $password = sanitize_text_field($data['password']);
            $confirm_password = sanitize_text_field($data['confirm_password']);

            // Check email validity and uniqueness
            if (!is_email($email) || strlen($email) > 40) {
                $result->invalidate('email_user', __('Please enter a valid email address, no more than 40 characters.', 'basetheme'));
            } elseif (email_exists($email)) {
                $result->invalidate('email_user', __('This email is already registered. Please use a different email.', 'basetheme'));
            }

            // Check password length
            if (strlen(trim($password)) < 8) {
                $result->invalidate('password', __('Password must be at least 8 characters long.', 'basetheme'));
            } elseif (preg_match('/\s/', $password)) {
                $result->invalidate('password', __('Password cannot contain spaces.', 'basetheme'));
            } elseif (!preg_match('/^[a-zA-Z0-9@#$%^&*]+$/', $password)) {
                $result->invalidate('password', __('Password contains invalid characters. Only letters, numbers, and special characters @, #, $, %, ^, &, * are allowed.', 'basetheme'));
            }

            // Check confirm password
            if ($password !== $confirm_password) {
                $result->invalidate('confirm_password', __('Passwords do not match. Please check and try again.', 'basetheme'));
            }
        }
    }

    return $result;
}

// Register user
add_action('wpcf7_mail_sent', 'custom_registration_user_after_mail_sent');
function custom_registration_user_after_mail_sent($cf7)
{
    if ($cf7->id() == CTF7_REGISTER_ID) {
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $data = $submission->get_posted_data();
            $email = sanitize_email($data['email_user']);
            $password = sanitize_text_field($data['password']);
            $username = sanitize_user(strstr($email, '@', true));
            $user_id = wp_create_user($username, $password, $email);

            if (!is_wp_error($user_id)) {
                wp_update_user(array('ID' => $user_id, 'role' => 'subscriber'));
                // login user after register
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);
            } else {
                error_log('Error creating user: ' . $user_id->get_error_message());
            }
        }
    }
}


// CF7: bắt buộc plate_number nếu own_plate = Yes
add_filter('wpcf7_validate_text*', 'cf7_conditional_plate_required', 20, 2);
add_filter('wpcf7_validate_text',  'cf7_conditional_plate_required', 20, 2);
function cf7_conditional_plate_required($result, $tag)
{
    // Lấy tên field an toàn cho mọi version CF7
    $tag_name = '';
    if (is_object($tag)) {
        if (isset($tag->name)) {
            $tag_name = $tag->name;
        } elseif (method_exists($tag, 'get_name')) {
            $tag_name = $tag->get_name();
        }
    }

    // Chỉ xử lý field plate_number
    if ($tag_name !== 'plate_number') {
        return $result;
    }

    // Lấy dữ liệu submit
    $submission = WPCF7_Submission::get_instance();
    if (! $submission) {
        return $result;
    }

    $data = $submission->get_posted_data();

    // Giá trị select own_plate có thể là string hoặc array (nếu multiple)
    $own_plate = $data['own_plate'] ?? '';
    if (is_array($own_plate)) {
        $own_plate = reset($own_plate);
    }
    $own_plate = strtolower(trim((string) $own_plate));

    // Giá trị plate_number
    $plate_number = $data['plate_number'] ?? '';
    if (is_array($plate_number)) {
        $plate_number = implode(' ', $plate_number);
    }
    $plate_number = trim((string) $plate_number);

    // Nếu chọn Yes mà không nhập plate_number -> báo lỗi tại field
    if ($own_plate === 'yes' && $plate_number === '') {
        $result->invalidate($tag, 'Please fill out this field.');
    }

    return $result;
}


add_filter('wpcf7_form_elements', function ($content) {
    // Tìm và thay thế text gốc
    $content = str_replace(
        '<span class="wpcf7-list-item-label">accept_term',
        '<span class="wpcf7-list-item-label">I accept the terms and conditions <a href="#">Read our T&Cs</a>',
        $content
    );
    return $content;
});
