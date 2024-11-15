<?php
function lpv_datepicker_start_date()
{
?>
    <script type="text/javascript">
        (function($) {
            acf.add_filter('date_picker_args', function(args, $field) {
                var key = $field.data('key');
                if (key == 'field_6719e939598ea' || key == 'field_6719e958598eb') {
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    args['minDate'] = today;
                }
                return args;
            });
        })(jQuery);
    </script>
<?php
}
add_action('acf/input/admin_footer', 'lpv_datepicker_start_date');

function my_acf_load_repeater_end_date($valid, $value, $field, $input_name)
{
    if ($field['key'] === 'field_6719e920598e9') {
        $index = 1;

        foreach ($value as $row) {
            $start_date = isset($row['field_6719e939598ea']) ? $row['field_6719e939598ea'] : '';
            $end_date = isset($row['field_6719e958598eb']) ? $row['field_6719e958598eb'] : '';

            if ($start_date && $end_date) {
                $end_timestamp = strtotime($end_date);
                $start_timestamp = strtotime($start_date);

                if ($end_timestamp < $start_timestamp) {
                    $valid = 'End date must be greater than or equal to start date (Row ' . $index . ').';
                    break;
                }
            }
            $index++;
        }
    }
    return $valid;
}
add_filter('acf/validate_value/key=field_6719e920598e9', 'my_acf_load_repeater_end_date', 10, 4);

function send_demo_mail()
{
    $to = 'emailcuaban@gmail.com';
    $subject = 'Thư demo từ WordPress';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    ob_start();
?>
    <html>

    <body>
        <h1 style="color: #007bff;">Xin chào!</h1>
        <p>Đây là một email được gửi từ WordPress.</p>
        <p style="font-weight: bold;">Chúc bạn một ngày vui vẻ!</p>
    </body>

    </html>
<?php
    $message = ob_get_clean();

    if (wp_mail($to, $subject, $message, $headers)) {
        wp_send_json_success('Mail đã được gửi thành công.');
    } else {
        wp_send_json_error('Gửi mail thất bại.');
    }

    wp_die();
}
add_action('wp_ajax_send_demo_mail', 'send_demo_mail');
add_action('wp_ajax_nopriv_send_demo_mail', 'send_demo_mail');


function currency_format($price)
{
    $price = floatval($price);
    if (strpos($price, '.') !== false) {
        list($integer_part, $decimal_part) = explode('.', $price);
        $integer_part = number_format($integer_part);
        $price_added = $integer_part . '.' . $decimal_part;
    } else {
        $price_added = number_format($price);
    }

    return $price_added;
}

function favorite_posts()
{
    $user_id = get_current_user_id();
    if (!$user_id) {
        wp_send_json_error(['message' => 'User not logged in.']);
    }

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    $favorite_posts = get_user_meta($user_id, 'favorite_posts', true);
    if (!is_array($favorite_posts)) {
        $favorite_posts = [];
    }

    $index = array_search($post_id, $favorite_posts);
    if ($index === false) {
        $favorite_posts[] = $post_id;
        $status = 'added';
    } else {
        unset($favorite_posts[$index]);
        $favorite_posts = array_values($favorite_posts);
        $status = 'removed';
    }

    update_user_meta($user_id, 'favorite_posts', $favorite_posts);

    wp_send_json_success([
        'message' => "Save successfully.",
        'status' => $status,
        'post_id' => $post_id,
    ]);

    wp_die();
}

add_action('wp_ajax_favorite_posts', 'favorite_posts');
add_action('wp_ajax_nopriv_favorite_posts', 'favorite_posts');

// đăng nhập bằng facebook
function handle_facebook_login()
{
    if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/facebook-login') !== false) {
        $user_id = get_current_user_id();
        $app_id = get_field('facebook_app_id', 'option');
        $app_secret = get_field('facebook_app_secret', 'option');
        $redirect_uri = home_url('/facebook-login');

        if (!$user_id) {
            if (isset($_GET['code'])) {
                $code = $_GET['code'];

                $token_url = 'https://graph.facebook.com/v16.0/oauth/access_token?' . http_build_query([
                    'client_id' => $app_id,
                    'client_secret' => $app_secret,
                    'redirect_uri' => $redirect_uri,
                    'code' => $code
                ]);

                $response = wp_remote_get($token_url);
                $body = wp_remote_retrieve_body($response);
                $data = json_decode($body);

                if (isset($data->access_token)) {
                    $user_info = wp_remote_get('https://graph.facebook.com/me?fields=id,name,email&access_token=' . $data->access_token);
                    $user_info = json_decode(wp_remote_retrieve_body($user_info));

                    if (isset($user_info->email)) {
                        $user = get_user_by('email', $user_info->email);
                        $user_id = 0;

                        if ($user) {
                            $user_id = $user->ID;
                        } else {
                            $user_new_id = wp_create_user($user_info->name, wp_generate_password(), $user_info->email);
                            $user_id = $user_new_id;
                        }

                        update_user_meta($user_id, 'sign_in_with', 'facebook');
                        wp_set_current_user($user_id);
                        wp_set_auth_cookie($user_id);
                        wp_redirect(home_url());
                        exit;
                    }
                }
            } else {
                $fb_login_url = 'https://www.facebook.com/v16.0/dialog/oauth?client_id=' . $app_id . '&redirect_uri=' . $redirect_uri . '&scope=email';
                wp_redirect($fb_login_url);
                exit;
            }
        }
    }
}
add_action('init', 'handle_facebook_login');

// đăng nhập bằng google
function handle_google_login()
{
    if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/google-login') !== false) {
        $user_id = get_current_user_id();
        $client_id = get_field('google_client_id', 'option');
        $client_secret = get_field('google_client_secret', 'option');
        $redirect_uri = home_url('/google-login');

        if (!$user_id) {
            if (isset($_GET['code'])) {
                $code = $_GET['code'];

                $response = wp_remote_post('https://oauth2.googleapis.com/token', array(
                    'body' => array(
                        'code' => $code,
                        'client_id' => $client_id,
                        'client_secret' => $client_secret,
                        'redirect_uri' => $redirect_uri,
                        'grant_type' => 'authorization_code'
                    )
                ));

                $body = wp_remote_retrieve_body($response);
                $json = json_decode($body);

                if (isset($json->access_token)) {
                    $user_info = wp_remote_get('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $json->access_token);
                    $user_info = json_decode(wp_remote_retrieve_body($user_info));

                    if (isset($user_info->email)) {
                        $user = get_user_by('email', $user_info->email);
                        $user_id = 0;

                        if ($user) {
                            $user_id = $user->ID;
                        } else {
                            $user_new_id = wp_create_user($user_info->name, wp_generate_password(), $user_info->email);
                            $user_id = $user_new_id;
                        }

                        update_user_meta($user_id, 'sign_in_with', 'google');
                        wp_set_current_user($user_id);
                        wp_set_auth_cookie($user_id);
                        wp_redirect(home_url());
                        exit;
                    }
                }
            } else {
                $google_login_url = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=" . $client_id . "&redirect_uri=" . $redirect_uri . "&scope=email profile&access_type=offline";
                wp_redirect($google_login_url);
                exit;
            }
        }
    }
}
add_action('init', 'handle_google_login');

function add_wow_class_to_headings($content)
{
    $content = preg_replace('/<(h[1-6])(.*?)>/', '<$1$2 class="wow">', $content);
    return $content;
}
add_filter('the_content', 'add_wow_class_to_headings');

// Function kiểm tra reCAPTCHA
function check_recaptcha($recaptcha_response)
{
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $remoteIp = $_SERVER['REMOTE_ADDR'];
    $recaptchaResponse = file_get_contents($recaptchaUrl . '?secret=' . RECAPTCHA_SECRET_KEY . '&response=' . $recaptcha_response . '&remoteip=' . $remoteIp);
    $result = json_decode($recaptchaResponse);

    return $result->success ? true : false;
}

function send_email_ajax()
{
    if (isset($_POST['g-recaptcha-response'])) {
        $is_valid_recaptcha = check_recaptcha($_POST['g-recaptcha-response']);

        if ($is_valid_recaptcha) {
            if (isset($_POST['email']) && is_email($_POST['email'])) {
                $to = sanitize_email($_POST['email']);
                $subject = 'Test Email';
                $message = 'This is a test email sent from AJAX.';
                $headers = array('Content-Type: text/html; charset=UTF-8');

                // Gửi email
                if (wp_mail($to, $subject, $message, $headers)) {
                    wp_send_json_success(array('message' => 'Email đã được gửi thành công!'));
                } else {
                    wp_send_json_error(array('message' => 'Gửi email thất bại.'));
                }
            } else {
                wp_send_json_error(array('message' => 'Email không hợp lệ.'));
            }
        } else {
            wp_send_json_error(array('message' => 'Xác thực reCAPTCHA thất bại. Vui lòng thử lại.'));
        }
    } else {
        wp_send_json_error(array('message' => 'reCAPTCHA không được xác nhận.'));
    }

    wp_die();
}
add_action('wp_ajax_send_email', 'send_email_ajax');
add_action('wp_ajax_nopriv_send_email', 'send_email_ajax');
