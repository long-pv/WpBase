<?php
function send_telegram_message($message)
{
    if (empty($message)) return false;

    // Lấy token và chat_id từ ACF Options
    $token  = get_field('telegram_key', 'option');
    $chatID = get_field('chat_channel_id', 'option');

    if (empty($token) || empty($chatID)) {
        error_log('Telegram: missing token or chat_id');
        return false;
    }

    $url = "https://api.telegram.org/bot{$token}/sendMessage";

    $response = wp_remote_post($url, [
        'body' => [
            'chat_id'    => $chatID,
            'text'       => $message,
            'parse_mode' => 'HTML',
        ],
    ]);

    if (is_wp_error($response)) {
        error_log('Telegram error: ' . $response->get_error_message());
        return false;
    }

    error_log('Telegram sent: ' . wp_remote_retrieve_body($response));
    return true;
}
