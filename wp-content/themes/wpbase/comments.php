<?php
if (post_password_required()) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if (have_comments()):
	?>
		<h2 class="comments-title">
			<?php
			$basetheme_comment_count = get_comments_number();
			echo 'Có ' . $basetheme_comment_count . ' bình luận.';
			?>
		</h2><!-- .comments-title -->

		<ul class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style' => 'ol',
					'short_ping' => true,
					'callback' => 'basetheme_comment_callback', // Tùy chỉnh callback
				)
			);
			?>
		</ul><!-- .comment-list -->

		<?php
		the_comments_navigation();

		if (!comments_open()):
		?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'basetheme'); ?></p>
	<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->

<?php
function basetheme_comment_callback($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-author"><?php comment_author(); ?></div>
		<div class="comment-time"><?php echo get_comment_time('d/m/Y H:i'); ?></div>
		<div class="comment-content"><?php comment_text(); ?></div>
	</li>
<?php
}
?>


<style>
	/* Container chính của bình luận */
	.comments-area {
		margin-top: 30px;
		padding: 20px;
		background-color: #f9f9f9;
		border: 1px solid #ddd;
		border-radius: 10px;
	}

	/* Tiêu đề bình luận */
	.comments-title {
		font-size: 1.5em;
		font-weight: bold;
		margin-bottom: 20px;
		color: #333;
	}

	/* Danh sách bình luận */
	.comment-list {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	/* Mỗi bình luận */
	.comment-list li {
		margin-bottom: 20px;
		padding: 15px;
		background-color: #fff;
		border: 1px solid #ddd;
		border-radius: 5px;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
	}

	/* Thông tin tác giả và thời gian */
	.comment-meta {
		font-size: 0.9em;
		color: #777;
		margin-bottom: 10px;
	}

	/* Thời gian bình luận */
	.comment-time {
		color: #333;
		font-weight: bold;
	}

	/* Tên tác giả bình luận */
	.comment-author {
		font-weight: bold;
		color: #0073e6;
	}

	/* Nội dung bình luận */
	.comment-content {
		font-size: 1em;
		color: #555;
	}

	/* Nút reply - Ẩn nút reply */
	.comment-reply-link {
		display: none;
		/* Loại bỏ nút reply */
	}

	/* Nút phản hồi nếu bạn không muốn ẩn nó hoàn toàn */
	.comment-reply-link:hover {
		background-color: #0073e6;
		color: #fff;
	}

	/* Hiển thị phần không có phản hồi */
	.comment-footer {
		margin-top: 20px;
		font-size: 0.9em;
		color: #999;
	}


	/* form */
	/* Container Form Bình luận */
	.comment-respond {
		background-color: #fff;
		padding: 20px;
		border: 1px solid #ddd;
		border-radius: 10px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		margin-top: 30px;
		margin-bottom: 30px;
	}

	/* Tiêu đề của form bình luận */
	#reply-title {
		font-size: 1.5em;
		font-weight: bold;
		margin-bottom: 15px;
		color: #333;
	}

	/* Chữ "Cancel reply" */
	.comment-reply-title small a {
		font-size: 0.9em;
		color: #0073e6;
		text-decoration: none;
	}

	.comment-reply-title small a:hover {
		color: #005bb5;
	}

	/* Trường nhập liệu (Tên, Email, Comment) */
	.comment-form-author,
	.comment-form-email,
	.comment-form-comment {
		margin-bottom: 15px;
	}

	/* Label cho các trường nhập liệu */
	.comment-form-author label,
	.comment-form-email label,
	.comment-form-comment label {
		font-weight: bold;
		display: block;
		margin-bottom: 5px;
		color: #333;
	}

	/* Trường Tên và Email */
	.comment-form-author input,
	.comment-form-email input {
		width: 100%;
		padding: 12px;
		border: 1px solid #ddd;
		border-radius: 5px;
		font-size: 1em;
		background-color: #fafafa;
		transition: all 0.3s ease;
	}

	/* Thay đổi màu sắc khi focus vào trường nhập liệu */
	.comment-form-author input:focus,
	.comment-form-email input:focus {
		border-color: #0073e6;
		background-color: #fff;
	}

	/* Textarea cho bình luận */
	.comment-form-comment textarea {
		width: 100%;
		padding: 12px;
		border: 1px solid #ddd;
		border-radius: 5px;
		font-size: 1em;
		background-color: #fafafa;
		resize: vertical;
		min-height: 150px;
		transition: all 0.3s ease;
	}

	/* Thay đổi màu sắc khi focus vào textarea */
	.comment-form-comment textarea:focus {
		border-color: #0073e6;
		background-color: #fff;
	}

	/* Nút gửi form */
	.form-submit input[type="submit"] {
		padding: 12px 25px;
		background-color: #0073e6;
		color: #fff;
		font-size: 1.1em;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		transition: all 0.3s ease;
		width: 100%;
		text-align: center;
	}

	/* Thay đổi màu sắc khi hover vào nút gửi */
	.form-submit input[type="submit"]:hover {
		background-color: #005bb5;
	}

	/* Thông báo lỗi (nếu có) */
	#commentform .error {
		color: #e74c3c;
		font-size: 0.9em;
		margin-top: -10px;
		margin-bottom: 15px;
	}

	/* Các phần tử yêu cầu (như dấu *) */
	span.required {
		color: #e74c3c;
	}

	/* Thêm khoảng cách cho trường nhập liệu có nhiều nội dung */
	textarea {
		height: 120px;
	}

	/* Ẩn label 'required' cho email, nếu không có trong form */
	.comment-form-email .required {
		display: none;
	}

	/* Tùy chỉnh thẻ input hidden (các giá trị mặc định) */
	input[type="hidden"] {
		display: none;
	}

	/* phân trang */
	/* Container cho phân trang bình luận */
	.nav-links {
		display: flex;
		justify-content: space-between;
		margin-top: 30px;
		padding: 0;
	}

	/* Các nút phân trang */
	.nav-previous,
	.nav-next {
		display: inline-flex;
	}

	/* Liên kết phân trang */
	.nav-previous a,
	.nav-next a {
		padding: 10px 20px;
		background-color: #0073e6;
		color: #fff;
		text-decoration: none;
		border-radius: 5px;
		font-size: 1em;
		transition: background-color 0.3s ease, transform 0.3s ease;
	}

	/* Hover hiệu ứng */
	.nav-previous a:hover,
	.nav-next a:hover {
		background-color: #005bb5;
		transform: translateY(-2px);
	}

	/* Hiệu ứng focus cho liên kết */
	.nav-previous a:focus,
	.nav-next a:focus {
		background-color: #005bb5;
		text-decoration: underline;
	}

	/* Style cho các liên kết phân trang đã được click (active) */
	.nav-previous a:active,
	.nav-next a:active {
		background-color: #003d8b;
	}

	/* Đảm bảo các nút phân trang được căn lề trái và phải */
	.nav-previous {
		margin-right: auto;
	}

	.nav-next {
		margin-left: auto;
	}
</style>