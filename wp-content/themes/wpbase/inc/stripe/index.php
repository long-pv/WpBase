<?php
require_once __DIR__ . '/vendor/autoload.php';

function create_stripe_session()
{
    $page_success = !empty($_POST['page_success']) ? $_POST['page_success'] : home_url();
    $total_payment = !empty($_POST['total_payment']) ? (float) $_POST['total_payment'] : 0;
    $post_id = !empty($_POST['post_id']) ? (int) $_POST['post_id'] : false;

    // khai báo key
    \Stripe\Stripe::setApiKey('sk_test_51Q78biGYyIJ7x0h4s4xbyYTb52yZLTLmkEZmW8mmYhAezfNTHWCMKI2UkeVwEOUjK4rG9J1K0ZBN0WPKjESMafQd00xD8edBG1');

    // Tạo một phiên Checkout Session
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Stripe payment',
                    ],
                    'unit_amount' => $total_payment * 100,
                ],
                'quantity' => 1,
            ]
        ],
        'mode' => 'payment',
        'success_url' => add_query_arg(
            array(
                'session_id' => '{CHECKOUT_SESSION_ID}',
                'post_id' => $post_id,
                'total_payment' => $total_payment,
            ),
            $page_success
        ),
        'cancel_url' => $page_success,
    ]);

    // Trả về JSON chứa sessionId
    if ($checkout_session) {
        wp_send_json_success(['id' => $checkout_session->id]);
    } else {
        wp_send_json_error(['message' => 'Unable to create checkout session']);
    }

    die();
}
add_action('wp_ajax_create_stripe_session', 'create_stripe_session');
add_action('wp_ajax_nopriv_create_stripe_session', 'create_stripe_session');


// dùng trong page-test_stripe.php
function handle_create_payment_intent()
{
    if (isset($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
        $amount = intval($_POST['amount']); // amount from frontend

        // Stripe API secret key
        $stripe_secret_key = get_field('stripe_secret_key', 'option') ?? '';
        \Stripe\Stripe::setApiKey($stripe_secret_key);

        try {
            // Create a PaymentIntent
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount * 100,  // Amount in cents
                'currency' => 'usd',  // Change currency as needed
            ]);

            // Return client secret to frontend
            wp_send_json_success([
                'clientSecret' => $paymentIntent->client_secret
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            wp_send_json_error([
                'message' => $e->getMessage()
            ]);
        }
    } else {
        wp_send_json_error([
            'message' => 'Số tiền không hợp lệ!'
        ]);
    }

    wp_die();
}

add_action('wp_ajax_create_payment_intent', 'handle_create_payment_intent');
add_action('wp_ajax_nopriv_create_payment_intent', 'handle_create_payment_intent');


function create_payment_intent()
{
    // Kiểm tra nếu có giá trị amount
    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];

        // Thiết lập Stripe API Key
        \Stripe\Stripe::setApiKey('sk_test_51QeU87HYQRrr0N522fb9jdKCoUAsRDJIdbLrWiKCzWBQJ3BydJFvbpeaUpI8sdXL4WXpngrCsI2nvvPsxxdNWtLJ00fgoVg1Ru');

        try {
            // Tạo PaymentIntent với số tiền truyền vào
            $payment_intent = \Stripe\PaymentIntent::create([
                'amount' => $amount * 100,  // Số tiền (đơn vị: cent)
                'currency' => 'usd',  // Đơn vị tiền tệ
                'payment_method_types' => ['card'],
            ]);

            // Trả về clientSecret của PaymentIntent
            wp_send_json_success(['clientSecret' => $payment_intent->client_secret]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Nếu có lỗi, trả về thông báo lỗi
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    } else {
        wp_send_json_error(['message' => 'Số tiền không hợp lệ']);
    }

    wp_die();
}
add_action('wp_ajax_create_payment_intent', 'create_payment_intent');
add_action('wp_ajax_nopriv_create_payment_intent', 'create_payment_intent');
