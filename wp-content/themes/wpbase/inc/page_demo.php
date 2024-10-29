<?php
function lpv_datepicker_start_date()
{
    ?>
    <script type="text/javascript">
        (function ($) {
            acf.add_filter('date_picker_args', function (args, $field) {
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