<?php
function rating_html($post_id)
{
    $total_ratings = get_post_meta($post_id, '_total_ratings', true) ?: 0;
    $total_votes = get_post_meta($post_id, '_total_votes', true) ?: 0;
    $average_rating = $total_votes ? round($total_ratings / $total_votes, 1) : 0;
    $user_rating = !empty($_COOKIE["rated_post_{$post_id}"]) ? $_COOKIE["rated_post_{$post_id}"] : 0;
?>
    <!-- Bootstrap Toast thông báo -->
    <div aria-live="polite" aria-atomic="true">
        <div id="rating-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body"></div>
        </div>
    </div>

    <div class="ratingPost">
        <div class="ratingPost__show">
            <div class="ratingPost__showAverage" id="average_rating">
                <?php echo $average_rating; ?>
            </div>
            <div class="ratingPost__showTotal">
                <strong id="total_votes"><?php echo $total_votes; ?></strong><br><span>đánh giá</span>
            </div>
        </div>
        <div class="ratingPost__line">
            <div class="ratingPost__lineItem">
            </div>
            <div class="ratingPost__lineItem">
            </div>
        </div>
        <div class="ratingPost__text">
            Đánh giá bài viết
        </div>
        <div class="ratingPost__star star-rating" data-post-id="<?php echo $post_id; ?>">
            <?php for ($i = 5; $i >= 1; $i--) : // Render từ 5 -> 1 
            ?>
                <span class="star <?php echo ($i <= $user_rating) ? 'selected' : ''; ?>" data-value="<?php echo $i; ?>">★</span>
            <?php endfor; ?>
        </div>
    </div>
<?php
}

function rate_post()
{
    if (!isset($_POST['post_id']) || !isset($_POST['rating'])) {
        wp_send_json_error(array("message" => "Dữ liệu không hợp lệ!"));
    }

    $post_id = intval($_POST['post_id']);
    $rating = intval($_POST['rating']);

    if ($rating < 1 || $rating > 5) {
        wp_send_json_error(array("message" => "Số sao không hợp lệ!"));
    }

    // Kiểm tra xem đã đánh giá hay chưa bằng cookie
    if (!empty($_COOKIE["rated_post_{$post_id}"])) {
        wp_send_json_error(array("message" => "Bạn đã đánh giá bài viết này!"));
    }

    // Lấy dữ liệu hiện tại
    $total_ratings = get_post_meta($post_id, '_total_ratings', true) ?: 0;
    $total_votes = get_post_meta($post_id, '_total_votes', true) ?: 0;
    $total_votes_add = $total_votes + 1;

    // Cập nhật dữ liệu
    update_post_meta($post_id, '_total_ratings', $total_ratings + $rating);
    update_post_meta($post_id, '_total_votes', $total_votes_add);

    // Tính điểm trung bình mới
    $average_rating = round(($total_ratings + $rating) / $total_votes_add, 1);

    // Set cookie từ backend (thời gian 1 năm)
    setcookie("rated_post_{$post_id}", $rating, time() + 365 * 24 * 60 * 60, "/");

    wp_send_json_success(array(
        "message" => "Cảm ơn bạn đã đánh giá!",
        "average_rating" => $average_rating,
        "total_votes" => $total_votes_add
    ));
}

add_action('wp_ajax_rate_post', 'rate_post');
add_action('wp_ajax_nopriv_rate_post', 'rate_post');

// script
add_action('wp_footer', function () {
?>
    <script>
        jQuery(document).ready(function($) {
            function showToast(message, type = "success") {
                let toast = $("#rating-toast");
                toast.find(".toast-body").text(message);
                toast.removeClass("bg-success bg-warning bg-danger").addClass(type === "success" ? "bg-success text-white" : "bg-warning text-white");
                toast.toast({
                    delay: 3000
                });
                toast.toast("show");
            }

            $(".star").on("click", function() {
                let rating = $(this).data("value");
                let postID = $(".star-rating").data("post-id");

                $.ajax({
                    url: custom_ajax.ajax_url,
                    type: "POST",
                    data: {
                        action: "rate_post",
                        post_id: postID,
                        rating: rating,
                    },
                    beforeSend: function() {
                        $("#ajax-loader").show();
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.data.message, "success");

                            $("#average_rating").text(response.data.average_rating);
                            $("#total_votes").text(response.data.total_votes);

                            $(".star").removeClass("selected");
                            $(".star").each(function() {
                                if ($(this).data("value") <= rating) {
                                    $(this).addClass("selected");
                                }
                            });
                        } else {
                            showToast(response.data.message, "warning");
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi gửi dữ liệu.');
                    },
                    complete: function() {
                        $("#ajax-loader").hide();
                    }
                });
            });
        });
    </script>
<?php
}, 99);
