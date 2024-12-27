<?php

add_action('wp_ajax_update_review_product', 'update_review_product');
add_action('wp_ajax_nopriv_update_review_product', 'update_review_product');

function update_review_product()
{
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $comment = isset($_POST['comment']) ? sanitize_text_field($_POST['comment']) : '';
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $user_id = get_current_user_id(); // ID người dùng
    $check['status'] = 200;
    $check['message'] = 'You cannot rate this product.';
    if ($user_id > 0 && $comment != '' && $product_id > 0 && $order_id > 0) {

        $check_review = get_user_meta($user_id, 'review_' . $order_id . '_' . $product_id, true);
        if (empty($check_review)) {
            $review_data = array(
                'comment_post_ID' => $product_id,
                'comment_author' => 'User ' . $user_id, // Tên người đánh giá
                'comment_author_email' => get_the_author_meta('user_email', $user_id), // Email người đánh giá
                'comment_content' => $comment, // Nội dung đánh giá
                'comment_type' => 'review', // Loại đánh giá
                'comment_parent' => 0, // Đánh giá gốc
                'user_id' => $user_id, // ID người dùng
                'comment_approved' => 1, // Duyệt đánh giá
            );
            $comment_id = wp_insert_comment($review_data);
            update_comment_meta($comment_id, 'rating', $rating); // Gán điểm đánh giá
            update_user_meta($user_id, 'review_' . $order_id . '_' . $product_id, 1);
            $check['status'] = 400;
            $check['message'] = 'Ok';
        }
    }
    wp_send_json($check);
    wp_die();
}



