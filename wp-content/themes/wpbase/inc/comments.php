<?php
// Bật lại trạng thái bình luận
add_filter('comments_open', '__return_true');
add_filter('pings_open', '__return_true');

add_filter('comment_form_defaults', function ($defaults) {
    // Tuỳ chỉnh nội dung trước form
    $defaults['title_reply'] = 'Để lại bình luận';
    $defaults['comment_notes_before'] = ''; // Xóa ghi chú mặc định trước form
    $defaults['comment_notes_after'] = '';  // Xóa ghi chú mặc định sau form

    // Tuỳ chỉnh nội dung của nút gửi
    $defaults['label_submit'] = 'Gửi bình luận';

    // Trả về form đã tuỳ chỉnh
    return $defaults;
});

// Loại bỏ phần "Logged in as" trong form bình luận
add_filter('comment_form_logged_in', function ($content) {
    return ''; // Trả về chuỗi rỗng để không hiển thị dòng "Logged in as"
});

add_filter('preprocess_comment', function ($commentdata) {
    if (!is_user_logged_in()) {
        // Kiểm tra nếu chưa nhập tên
        if (empty($commentdata['comment_author'])) {
            wp_die('Tên là trường bắt buộc.');
        }

        // Kiểm tra nếu chưa nhập email
        if (empty($commentdata['comment_author_email'])) {
            wp_die('Email là trường bắt buộc.');
        } elseif (!filter_var($commentdata['comment_author_email'], FILTER_VALIDATE_EMAIL)) {
            wp_die('Email không hợp lệ.');
        }
    }

    // Kiểm tra nếu chưa nhập nội dung bình luận
    if (empty($commentdata['comment_content'])) {
        wp_die('Bình luận không được để trống.');
    }

    return $commentdata;
});

add_filter('comment_form_fields', function ($fields) {
    // Tùy chỉnh trường tên
    $fields['author'] = '<p class="comment-form-author">
        <label for="author">Tên *</label>
        <input id="author" name="author" type="text" value="' . esc_attr(wp_get_current_user()->display_name) . '" size="30" required />
    </p>';

    // Tùy chỉnh trường email
    $fields['email'] = '<p class="comment-form-email">
        <label for="email">Email *</label>
        <input id="email" name="email" type="email" value="' . esc_attr(wp_get_current_user()->user_email) . '" size="30" required />
    </p>';

    // Đảm bảo trường bình luận luôn ở cuối
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    $fields['comment'] = $comment_field;

    return $fields;
});

add_filter('comment_form_default_fields', function ($fields) {
    // Xóa trường URL (Website)
    if (isset($fields['url'])) {
        unset($fields['url']);
    }

    return $fields;
});

add_filter('comment_form_default_fields', function ($fields) {
    // Xóa trường đồng ý cookies
    if (isset($fields['cookies'])) {
        unset($fields['cookies']);
    }

    return $fields;
});
