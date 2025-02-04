<?php
if (post_password_required()) {
	return;
}
?>

<div id="comments" class="comments_area">
	<?php if (have_comments()) : ?>
		<h2><?php echo get_comments_number() . ' Comments'; ?></h2>
		<ul class="comment_list">
			<?php
			wp_list_comments(array(
				'style'       => 'ul', // Chuyển từ 'ol' sang 'ul'
				'short_ping'  => true,
				'callback'    => 'custom_comments_format',
				'avatar_size' => 50,
				'depth'       => 3 // Giới hạn mức phân cấp
			));
			?>
		</ul>

		<!-- Phân trang bình luận -->
		<div class="comment_pagination">
			<?php
			paginate_comments_links(array(
				'prev_text'    => '←',               // Nút quay lại
				'next_text'    => '→',               // Nút tiếp theo
				'type'         => 'plain',           // Hiển thị phân trang dạng số
				'end_size'     => 2,                 // Số trang đầu và cuối luôn hiển thị
				'mid_size'     => 2,                 // Số trang hiển thị xung quanh trang hiện tại
				'show_all'     => false,             // Không hiển thị tất cả các trang nếu có quá nhiều
			));
			?>
		</div>
	<?php endif; ?>

	<?php
	comment_form(array(
		'title_reply'       => 'Bình luận',
		'title_reply_to'    => 'Trả lời cho %s',
		'comment_notes_after' => 'Nhớ lựa chọn captcha',
		'label_submit'      => 'Gửi',
		'cancel_reply_link'   => 'Hủy trả lời',
		'comment_notes_before'   => 'Vui lòng để lại bình luận',
	));
	?>
</div>