<?php
add_action('rest_api_init', function () {
    register_rest_route('zns/v1', '/callback', [
        'methods' => ['GET', 'POST'],
        'callback' => 'handle_zalo_zns_callback',
        'permission_callback' => '__return_true',
    ]);
});

function handle_zalo_zns_callback(WP_REST_Request $request)
{
    // --- Xác minh qua GET ---
    if ($request->get_method() === 'GET') {
        $code = $request->get_param('code');
        $oa_id = $request->get_param('oa_id');
        return new WP_REST_Response([
            'message' => 'verify ok',
            'oa_id' => $oa_id,
            'code' => $code,
        ], 200);
    }

    // --- Xử lý callback qua POST ---
    if ($request->get_method() === 'POST') {
        // Gửi phản hồi 200 OK NGAY để tránh timeout
        ignore_user_abort(true);
        header("Connection: close");
        ob_start();
        echo json_encode(['status' => 'ok']);
        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush();
        flush();

        // Xử lý dữ liệu phía sau (log, DB, ...)
        $raw = file_get_contents('php://input');
        $body = json_decode($raw, true);
        file_put_contents(__DIR__ . '/zns_log.txt', date('c') . " CALLBACK: " . $raw . "\n", FILE_APPEND);

        // Không cần return nữa, vì đã gửi response
        exit;
    }

    return new WP_REST_Response(['error' => 'Method not allowed'], 405);
}

function get_zalo_access_token()
{
    $token_data = get_option('zalo_access_token_data');

    // Nếu có token còn hạn thì dùng lại
    if (!empty($token_data['access_token']) && time() < $token_data['expires_at']) {
        return $token_data['access_token'];
    }

    $app_id = get_field('app_id_zalo', 'option');
    $secret_key = get_field('secret_key_zalo', 'option');

    // Nếu đã có refresh_token thì dùng để làm mới token
    if (!empty($token_data['refresh_token'])) {
        $response = wp_remote_post('https://oauth.zaloapp.com/v4/oa/access_token', [
            'headers' => [
                'secret_key' => $secret_key,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'app_id' => $app_id,
                'grant_type' => 'refresh_token',
                'refresh_token' => $token_data['refresh_token'],
            ],
        ]);
    } else {
        // Nếu chưa có refresh_token, gọi bằng code (chỉ lần đầu)
        $code = get_field('code_zalo', 'option');
        $response = wp_remote_post('https://oauth.zaloapp.com/v4/oa/access_token', [
            'headers' => [
                'secret_key' => $secret_key,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'app_id' => $app_id,
                'grant_type' => 'authorization_code',
                'code' => $code,
            ],
        ]);
    }

    if (is_wp_error($response)) {
        write_log('❌ Lỗi khi gọi API Zalo Access Token: ' . $response->get_error_message());
        return false;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    write_log($body);

    if (empty($body['access_token'])) {
        write_log('⚠️ Không nhận được access_token từ Zalo: ' . print_r($body, true));
        return false;
    }

    // Lưu lại cả refresh_token để dùng về sau
    $token_data = [
        'access_token' => $body['access_token'],
        'refresh_token' => $body['refresh_token'] ?? $token_data['refresh_token'] ?? '',
        'expires_at' => time() + intval($body['expires_in'] ?? 600) - 60, // trừ 1 phút để an toàn
    ];

    update_option('zalo_access_token_data', $token_data);
    write_log($token_data);

    return $body['access_token'];
}

/**
 * Hàm gửi tin nhắn ZNS
 */
function send_zns_message($phone, $template_id, $template_data, $tracking_id)
{
    $payload = [
        'phone' => $phone,
        'template_id' => $template_id,
        'template_data' => $template_data,
        'tracking_id' => $tracking_id,
    ];

    $access_token = get_zalo_access_token();

    $response = wp_remote_post('https://business.openapi.zalo.me/message/template', [
        'headers' => [
            'Content-Type' => 'application/json',
            'access_token' => $access_token,
        ],
        'body' => json_encode($payload),
        'timeout' => 15,
    ]);

    // Ghi log
    write_log('[ZNS] Payload: ' . print_r($payload, true));

    if (is_wp_error($response)) {
        write_log('[ZNS] Error: ' . $response->get_error_message());
    } else {
        write_log('[ZNS] Response: ' . wp_remote_retrieve_body($response));
    }
}

// 1. Hàm gửi ZNS sau khi tạo đơn, chặn giờ cấm và lưu queue
add_action('woocommerce_thankyou', 'send_zns_after_order_created', 10, 1);
function send_zns_after_order_created($order_id)
{
    if (!$order_id) return;
    $order = wc_get_order($order_id);
    if (!$order) return;

    // Lấy thông tin đơn hàng
    $name = trim($order->get_billing_first_name());
    $order_code = $order->get_order_number();
    $phone_number = $order->get_billing_phone();
    $price = (float)$order->get_total();
    $status = 'Đặt hàng thành công';
    $date = $order->get_date_created()->date('d/m/Y');

    // Chuẩn hóa số điện thoại
    if (strpos($phone_number, '0') === 0) {
        $phone_number = '84' . substr($phone_number, 1);
    }

    $template_id = get_field('template_id_zalo', 'option');
    $admin_phone = get_field('phone_numer_admin', 'option');
    if (strpos($admin_phone, '0') === 0) {
        $admin_phone = '84' . substr($admin_phone, 1);
    }

    $template_data = array(
        'name' => $name,
        'order_code' => $order_code,
        'phone_number' => $phone_number,
        'price' => $price,
        'status' => $status,
        'date' => $date
    );

    // Lấy giờ Việt Nam
    $dt = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
    $hour_vn = (int)$dt->format('H');

    // Nếu giờ cấm (22h -> 6h sáng)
    if ($hour_vn >= 22 || $hour_vn < 6) {
        add_to_zns_queue($phone_number, $template_id, $template_data, 'order_' . $order_code);
        add_to_zns_queue($admin_phone, $template_id, $template_data, 'admin_notify_' . $order_code);
        //        write_log("[ZNS] Giờ cấm, lưu vào queue: ");
        //        write_log($template_data);
        return;
    }

    // Nếu giờ cho phép, gửi ngay
    send_zns_message($phone_number, $template_id, $template_data, 'order_' . $order_code);
    send_zns_message($admin_phone, $template_id, $template_data, 'admin_notify_' . $order_code);

    //    write_log("[ZNS] Gửi data đặt hàng");
    //    write_log($template_data);


}

// 2. Hàm helper thêm tin nhắn vào queue
function add_to_zns_queue($phone, $template_id, $template_data, $tracking_id)
{
    $queue = get_option('zns_message_queue', array());
    $queue[] = array(
        'phone' => $phone,
        'template_id' => $template_id,
        'template_data' => $template_data,
        'tracking_id' => $tracking_id
    );
    update_option('zns_message_queue', $queue);
}

// 3. Hàm xử lý gửi queue
function process_zns_message_queue()
{
    $queue = get_option('zns_message_queue', array());
    if (empty($queue)) {
        //        write_log("[ZNS] Queue trống, không gửi gì cả.");
        return;
    }

    $processed_ids = array(); // lưu tracking_id đã xử lý
    foreach ($queue as $item) {
        // nếu trùng tracking_id -> bỏ qua
        if (in_array($item['tracking_id'], $processed_ids)) {
            write_log("[ZNS] Bỏ qua do tracking_id trùng: " . $item['tracking_id']);
            continue;
        }
        // chưa trùng -> thêm vào danh sách đã xử lý
        $processed_ids[] = $item['tracking_id'];

        send_zns_message(
            $item['phone'],
            $item['template_id'],
            $item['template_data'],
            $item['tracking_id']
        );
    }

    update_option('zns_message_queue', array());
    write_log("[ZNS] Đã gửi queue lúc 7h sáng: ");
    write_log($queue);
}

// 4. Đăng ký cron gửi queue lúc 7h sáng (giờ Việt Nam)
add_action('wp', function () {
    if (!wp_next_scheduled('zns_send_queued_messages')) {
        // Lấy timestamp hiện tại giờ Việt Nam
        $dt_now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $timestamp_now = $dt_now->getTimestamp();

        // Timestamp 7h sáng hôm nay giờ Việt Nam
        $dt_7am = new DateTime('07:00:00', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $timestamp_7am = $dt_7am->getTimestamp();

        // Nếu đã qua 7h sáng hôm nay, đặt cron 7h sáng ngày mai
        if ($timestamp_7am < $timestamp_now) {
            $dt_7am->modify('+1 day');
            $timestamp_7am = $dt_7am->getTimestamp();
        }

        wp_schedule_event($timestamp_7am, 'daily', 'zns_send_queued_messages');
        //        write_log("[ZNS] Đã lên lịch cron 7h sáng giờ VN lần đầu: " . $dt_7am->format('Y-m-d H:i:s'));
    }
});

// 5. Hook cron
add_action('zns_send_queued_messages', 'process_zns_message_queue');
