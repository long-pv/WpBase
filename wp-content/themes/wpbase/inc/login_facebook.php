<?php
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
