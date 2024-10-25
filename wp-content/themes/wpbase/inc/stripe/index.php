<?php
function create_stripe_session()
{
    require_once __DIR__ . '/vendor/autoload.php';

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