<?php
// Function kiểm tra reCAPTCHA
function check_recaptcha($recaptcha_response)
{
    // Gửi yêu cầu kiểm tra token reCAPTCHA đến Google
    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
        'body' => array(
            'secret' => RECAPTCHA_SECRET_KEY,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        )
    ));
    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body, true);

    return $result['success'] ? true : false;
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
