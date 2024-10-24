<?php
add_action('wp_ajax_download_zip', 'download_zip_handler');
add_action('wp_ajax_nopriv_download_zip', 'download_zip_handler');

function download_zip_handler()
{
    if (isset($_POST['post_id'])) {
        $post_id = sanitize_text_field($_POST['post_id']);
        $thumbnail_id = get_post_thumbnail_id($post_id);

        // Kiểm tra xem bài viết có ảnh đại diện hay không
        if (empty($thumbnail_id)) {
            wp_send_json_error('Bài viết không có featured image.');
            exit;
        }
        $file_path = get_attached_file($thumbnail_id);
        $filename = basename($file_path);

        // Kiểm tra file tồn tại
        if (!file_exists($file_path)) {
            wp_send_json_error('Không tìm thấy file ảnh.');
            exit;
        }

        $zip_file = tempnam(sys_get_temp_dir(), 'pdf_files_') . '.zip';

        $zip = new ZipArchive();
        if ($zip->open($zip_file, ZipArchive::CREATE) !== TRUE) {
            wp_send_json_error('Không thể tạo file ZIP.');
            exit;
        }

        // Thêm ảnh vào ZIP
        $zip->addFile($file_path, $filename);
        $zip->close();

        // Gửi header để tải file ZIP
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="download_all.zip"');
        header('Content-Length: ' . filesize($zip_file));
        readfile($zip_file);
        unlink($zip_file);
        exit;
    } else {
        wp_send_json_error('Post ID not provided');
    }
    wp_die();
}

function add_custom_download_zip_script()
{
    if (!is_admin()) {
        ?>
        <div id="ajax-loader" style="display: none;">
            <div class="spinner"></div>
        </div>

        <style>
            #ajax-loader {
                position: fixed;
                top: 0px;
                left: 0px;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .spinner {
                border: 4px solid #f3f3f3;
                border-top: 4px solid #3498db;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>

        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#download-zip-form').on('submit', function (e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    formData.append('action', 'download_zip');

                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhrFields: {
                            responseType: 'blob'
                        },
                        beforeSend: function () {
                            $("#ajax-loader").show();
                        },
                        success: function (response) {
                            var timestamp = new Date().toISOString().replace(/[-:.]/g, '').slice(0, 15);
                            var fileName = 'Download_ZIP_' + timestamp + '.zip';
                            var url = window.URL.createObjectURL(response);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = fileName;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                        },
                        error: function () {
                            alert('An error occurred while downloading the ZIP.');
                        },
                        complete: function () {
                            $("#ajax-loader").hide();
                        },
                    });
                });
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_custom_download_zip_script', 99);