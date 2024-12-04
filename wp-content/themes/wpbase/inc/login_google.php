<?php
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
