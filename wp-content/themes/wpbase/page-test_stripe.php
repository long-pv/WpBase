<?php
/*
Template Name: Test Stripe Payment Page
*/

get_header(); ?>

<div class="stripe-payment-container">
    <h1>Thanh toán qua Stripe</h1>

    <!-- Form để nhập giá -->
    <form id="payment-form">
        <label for="amount">Nhập giá trị thanh toán (đơn vị là cent, ví dụ 5000 cho $50):</label>
        <input type="number" id="amount" name="amount" value="" min="1" required>

        <div id="payment-element">
            <!-- Stripe Payment Element sẽ được hiển thị ở đây -->
        </div>

        <!-- Nút thanh toán Stripe (Sẽ gửi thanh toán khi nhấn) -->
        <button id="pay-stripe" type="button" disabled>Thanh toán</button>

        <!-- Nút Clear để xóa thông tin -->
        <button id="clear-form" type="button">Xóa</button>

        <div id="error-message" style="color: red;"></div>
    </form>
</div>

<?php get_footer(); ?>

<!-- Script được thêm dưới get_footer() để đảm bảo tải sau khi footer -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    jQuery(document).ready(function($) {
        var stripe = Stripe('pk_test_51QeU87HYQRrr0N52DgxXfbEH2Gq0Vb7QXFv7JiYTXsTGbuYXac0jzCImWVgKW3hUgnFra2ygS63agwv3EBM0TcCM00FHhRw4ns');
        var elements;
        var clientSecret = null; // Biến để lưu clientSecret
        var paymentElement = null; // Biến để lưu Stripe Payment Element

        // Khi người dùng thay đổi giá trị amount, cập nhật lại PaymentIntent
        $('#amount').on('change', function() {
            var newAmount = $(this).val(); // Lấy giá trị mới từ input
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                method: 'POST',
                data: {
                    action: 'create_payment_intent',
                    amount: newAmount, // Gửi giá trị amount đến backend
                },
                success: function(response) {
                    if (response.success) {
                        clientSecret = response.data.clientSecret; // Lưu lại clientSecret từ response

                        // Tạo Stripe Elements với clientSecret nhận được
                        elements = stripe.elements({
                            clientSecret: clientSecret
                        });

                        // Nếu có paymentElement trước đó, hủy bỏ trước khi tạo lại
                        if (paymentElement) {
                            paymentElement.destroy();
                        }

                        paymentElement = elements.create('payment');
                        paymentElement.mount('#payment-element');

                        // Kích hoạt nút thanh toán
                        $('#pay-stripe').prop('disabled', false);
                        $('#error-message').text('');
                    } else {
                        $('#error-message').text('Có lỗi xảy ra: ' + response.data.message);
                    }
                },
                error: function(xhr, status, error) {
                    $('#error-message').text('Có lỗi xảy ra trong quá trình gọi AJAX');
                }
            });
        });

        // Thanh toán Stripe (Xử lý thanh toán khi nhấn nút Thanh toán)
        $('#pay-stripe').on('click', function() {
            if (clientSecret) {
                stripe.confirmPayment({
                    elements: elements,
                    confirmParams: {
                        return_url: '<?php echo home_url(); ?>/successful?order_id=222' // Thay URL bằng trang thành công của bạn
                    },
                }).then(function(result) {
                    if (result.error) {
                        // Nếu có lỗi xảy ra, hiển thị thông báo lỗi
                        $('#error-message').text(result.error.message);
                    } else {
                        // Nếu thanh toán thành công, chuyển hướng người dùng đến trang thành công
                        window.location.href = '<?php echo home_url(); ?>/successful?order_id=' + result.paymentIntent.id;
                    }
                });
            } else {
                $('#error-message').text('Chưa cập nhật Stripe. Vui lòng thử lại.');
            }
        });

        // Chức năng Clear (Xóa thông tin và thẻ)
        $('#clear-form').on('click', function() {
            // Xóa giá trị trong input amount
            $('#amount').val('');

            // Hủy bỏ Payment Element nếu có
            if (paymentElement) {
                paymentElement.destroy();
                paymentElement = null;
            }

            // Tắt nút thanh toán
            $('#pay-stripe').prop('disabled', true);

            // Xóa thông báo lỗi
            $('#error-message').text('');
        });
    });
</script>