<?php
// Định nghĩa số lượng sản phẩm so sánh tối đa
if (!defined('MAX_COMPARE_PRODUCTS')) {
    define('MAX_COMPARE_PRODUCTS', 5); // Bạn có thể thay đổi số 3 thành số lượng mong muốn
}

// Shortcode: [compare_button id="123"]
add_shortcode('compare_button', 'render_compare_button');

function render_compare_button($atts)
{
    $atts = shortcode_atts([
        'id' => 0
    ], $atts);

    $product_id = intval($atts['id']);
    if (!$product_id) {
        return '<p>Vui lòng cung cấp ID sản phẩm.</p>';
    }

    return '<a href="javascript:void(0);" class="btn_compare" data-product_id="' . esc_attr($product_id) . '">So sánh</a>';
}

add_action('wp_footer', 'compare_products_script');
function compare_products_script()
{
?>
    <!-- Thanh bar so sánh -->
    <div id="compare_bar" style="display: none;">
        <div class="compare_products"></div>

        <div class="compare_list_btn">
            <button id="compare_now">So sánh</button>
            <button id="clear_all_compare">Xóa Tất Cả</button>
        </div>
    </div>

    <!-- Popup so sánh -->
    <div id="compare_popup" style="display: none;">
        <div class="popup_content">
            <button id="close_compare_popup">×</button>
            <h2>So sánh sản phẩm</h2>
            <div class="compare_table"></div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            var ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';

            function loadCompareBar() {
                var compareList = JSON.parse(Cookies.get('compare_list') || '[]');

                if (compareList.length > 0) {
                    $('#compare_bar').show();
                    $('.compare_products').html('');

                    $.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        data: {
                            action: 'get_product_html',
                            product_ids: compareList // Gửi mảng ID lên server
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.compare_products').html(response.data.html); // Append toàn bộ HTML cùng lúc
                            }
                        }
                    });
                } else {
                    $('#compare_bar').hide();
                }
            }


            // Thêm sản phẩm vào danh sách
            $(document).on('click', '.btn_compare', function(e) {
                e.preventDefault();
                var product_id = $(this).data('product_id');

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'add_to_compare',
                        product_id: product_id
                    },
                    success: function(response) {
                        if (response.success) {
                            loadCompareBar();
                        } else {
                            alert(response.data.message); // Thông báo nếu sản phẩm đã tồn tại
                        }
                    }
                });
            });

            // Xóa sản phẩm khỏi danh sách
            $(document).on('click', '.remove_compare', function() {
                var product_id = $(this).data('product_id');
                var this_el = $(this);

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'remove_from_compare',
                        product_id: product_id
                    },
                    success: function(response) {
                        if (response.success) {
                            this_el.closest('td').remove();
                            loadCompareBar();
                        }
                    }
                });
            });

            // Xử lý sự kiện khi bấm nút "Xóa Tất Cả"
            $(document).on('click', '#clear_all_compare', function() {
                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'clear_compare_list'
                    },
                    success: function(response) {
                        if (response.success) {
                            loadCompareBar(); // Cập nhật lại giao diện sau khi xóa
                        }
                    }
                });
            });


            // Mở popup khi nhấn "So sánh"
            $('#compare_now').on('click', function() {
                var compareList = JSON.parse(Cookies.get('compare_list') || '[]');

                if (compareList.length > 0) {
                    $('.compare_table').html('Đang tải dữ liệu...');

                    $.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        data: {
                            action: 'get_compare_data_table',
                            product_ids: compareList
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.compare_table').html(response.data.html);
                                $('#compare_popup').fadeIn();
                            }
                        }
                    });
                }
            });

            // Đóng popup
            $('#close_compare_popup').on('click', function() {
                $('#compare_popup').fadeOut();
            });

            // load lại sidebar bottom khi tải lại trang
            loadCompareBar();
        });
    </script>
    <?php
}

add_action('wp_ajax_get_compare_data_table', 'get_compare_data_table');
add_action('wp_ajax_nopriv_get_compare_data_table', 'get_compare_data_table');

function get_compare_data_table()
{
    $product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];

    if (empty($product_ids)) {
        wp_send_json_error();
    }

    $html = '<table class="compare_table_inner">';
    $html .= '<tr>';

    foreach ($product_ids as $product_id) {
        $product = wc_get_product($product_id);
        if ($product) {
            $html .= '<td>';
            $html .= '<img src="' . get_the_post_thumbnail_url($product_id, 'thumbnail') . '" alt="' . esc_attr($product->get_name()) . '">';
            $html .= '<h3>' . esc_html($product->get_name()) . '</h3>';
            $html .= '<p>Giá: ' . $product->get_price_html() . '</p>';
            $html .= '<p>' . wp_trim_words($product->get_short_description(), 15) . '</p>';
            $html .= '<button class="remove_compare" data-product_id="' . $product_id . '">Xóa</button>';
            $html .= '</td>';
        }
    }

    $html .= '</tr>';
    $html .= '</table>';

    wp_send_json_success(['html' => $html]);
}


// thêm sản phẩm vào danh sách so sánh
add_action('wp_ajax_add_to_compare', 'add_to_compare');
add_action('wp_ajax_nopriv_add_to_compare', 'add_to_compare');
function add_to_compare()
{
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if (!$product_id || !wc_get_product($product_id)) {
        wp_send_json_error(['message' => 'Sản phẩm không tồn tại.']);
    }

    // Lấy danh sách hiện tại từ cookie
    $compare_list = isset($_COOKIE['compare_list']) ? json_decode(stripslashes($_COOKIE['compare_list']), true) : [];

    // Kiểm tra xem sản phẩm đã tồn tại trong danh sách chưa
    if (in_array($product_id, $compare_list)) {
        wp_send_json_error(['message' => 'Sản phẩm đã có trong danh sách so sánh.']);
    }

    // Nếu đã có đủ MAX_COMPARE_PRODUCTS sản phẩm, xóa sản phẩm đầu tiên
    if (count($compare_list) >= MAX_COMPARE_PRODUCTS) {
        array_shift($compare_list);
    }

    // Thêm sản phẩm mới vào cuối danh sách
    $compare_list[] = $product_id;

    // Lưu lại vào cookie (30 ngày)
    setcookie('compare_list', json_encode($compare_list), time() + (30 * DAY_IN_SECONDS), '/');

    wp_send_json_success(['compare_list' => $compare_list]);
}


// Xử lý xóa sản phẩm khỏi danh sách
add_action('wp_ajax_remove_from_compare', 'remove_from_compare');
add_action('wp_ajax_nopriv_remove_from_compare', 'remove_from_compare');

function remove_from_compare()
{
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if (!$product_id || !wc_get_product($product_id)) {
        wp_send_json_error(['message' => 'Sản phẩm không tồn tại.']);
    }

    // Lấy danh sách hiện tại từ cookie
    $compare_list = isset($_COOKIE['compare_list']) ? json_decode(stripslashes($_COOKIE['compare_list']), true) : [];

    // Xóa sản phẩm khỏi danh sách
    $compare_list = array_filter($compare_list, function ($id) use ($product_id) {
        return $id != $product_id;
    });

    // Lưu lại danh sách sau khi xóa vào cookie (30 ngày)
    setcookie('compare_list', json_encode(array_values($compare_list)), time() + (30 * DAY_IN_SECONDS), '/');

    wp_send_json_success();
}

add_action('wp_ajax_get_product_html', 'get_product_html');
add_action('wp_ajax_nopriv_get_product_html', 'get_product_html');
function get_product_html()
{
    $product_ids = isset($_POST['product_ids']) ? array_map('intval', $_POST['product_ids']) : [];

    if (empty($product_ids)) {
        wp_send_json_error(['message' => 'Không có sản phẩm nào để hiển thị.']);
    }

    ob_start(); // Bắt đầu lưu HTML vào bộ nhớ đệm

    foreach ($product_ids as $product_id) {
        $product = wc_get_product($product_id);
        if ($product) {
    ?>
            <div class="compare_item" data-product_id="<?php echo esc_attr($product_id); ?>">
                <img src="<?php echo get_the_post_thumbnail_url($product_id, 'thumbnail'); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" />
                <button class="remove_compare" data-product_id="<?php echo esc_attr($product_id); ?>">×</button>
                <p class="product_name"><?php echo esc_html($product->get_name()); ?></p>
            </div>
<?php
        }
    }

    $html = ob_get_clean(); // Lấy toàn bộ HTML

    wp_send_json_success(['html' => $html]);
}

// Xóa cookie chứa danh sách sản phẩm so sánh
add_action('wp_ajax_clear_compare_list', 'clear_compare_list');
add_action('wp_ajax_nopriv_clear_compare_list', 'clear_compare_list');
function clear_compare_list()
{

    setcookie('compare_list', '', time() - 3600, '/'); // Đặt thời gian hết hạn trong quá khứ để xóa cookie

    wp_send_json_success(); // Trả về thành công
}
