<?php

/**
 * Upload file PDF của ACF field (key = field_69085070003f2)
 * vào thư mục /resources cùng cấp wp-config.php
 */
function custom_upload_dir_for_acf_pdf($upload)
{
    if (isset($_POST['_acfuploader']) && $_POST['_acfuploader'] === 'field_69085070003f2') {

        // Chỉ xử lý file PDF (nếu bạn đã filter trong ACF thì có thể bỏ check này)
        if (isset($_FILES['async-upload']) && $_FILES['async-upload']['type'] === 'application/pdf') {

            $custom_path = ABSPATH . 'resources';
            $custom_url  = home_url('/resources');

            // Nếu thư mục chưa tồn tại -> tạo
            if (!file_exists($custom_path)) {
                wp_mkdir_p($custom_path);
                // Cấp quyền ghi cho webserver (chỉ khi cần thiết)
                @chmod($custom_path, 0755);
            }

            // Đảm bảo thư mục writable
            if (!is_writable($custom_path)) {
                @chmod($custom_path, 0775);
            }

            // Ghi đè đường dẫn upload
            $upload['path'] = $custom_path;
            $upload['basedir'] = $custom_path;
            $upload['url'] = $custom_url;
            $upload['baseurl'] = $custom_url;
            $upload['subdir'] = '';

            // ✅ Bắt buộc WordPress chấp nhận thư mục custom này
            add_filter('upload_mimes', function ($mimes) {
                $mimes['pdf'] = 'application/pdf';
                return $mimes;
            });
        }
    }

    return $upload;
}
add_filter('upload_dir', 'custom_upload_dir_for_acf_pdf');


// Đổi đường dẫn khi upload file PDF (toàn site)
function custom_upload_dir_for_pdfs($upload)
{
    // Chỉ áp dụng nếu là file PDF
    if (isset($_FILES['async-upload']) && $_FILES['async-upload']['type'] === 'application/pdf') {

        // Đường dẫn và URL mới
        $custom_path = ABSPATH . 'uploads/files';
        $custom_url  = home_url('/uploads/files');

        // Tạo thư mục nếu chưa có
        if (!file_exists($custom_path)) {
            wp_mkdir_p($custom_path);
            // Cấp quyền ghi
            @chmod($custom_path, 0755);
        }

        // Đảm bảo thư mục writable
        if (!is_writable($custom_path)) {
            @chmod($custom_path, 0775);
        }

        // Ghi đè thông tin upload
        $upload['path']    = $custom_path;
        $upload['basedir'] = $custom_path;
        $upload['url']     = $custom_url;
        $upload['baseurl'] = $custom_url;
        $upload['subdir']  = '';

        // Cho phép upload PDF trong thư mục custom
        add_filter('upload_mimes', function ($mimes) {
            $mimes['pdf'] = 'application/pdf';
            return $mimes;
        });
    }

    return $upload;
}
add_filter('upload_dir', 'custom_upload_dir_for_pdfs');
