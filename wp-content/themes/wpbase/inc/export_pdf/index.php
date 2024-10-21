<?php
add_action('wp_ajax_download_pdf', 'download_pdf_function');
add_action('wp_ajax_nopriv_download_pdf', 'download_pdf_function');
function download_pdf_function()
{
    // lấy giá trị
    $post_id = $_POST['post_id'];

    ob_start();
    ?>

    <body class="pdf" style="padding: 0;margin: 0;font-size: 16px;">
        <div style="color:red;">Sample pdf</div>
        <div style="color:red;">ID: <?php echo $post_id; ?></div>
        <div>Long xemer</div>
    </body>

    <?php
    $html = ob_get_clean();

    // include thư viện
    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();

    // lưu file
    $timestamp = date('Ymd_His');
    $file_name = 'Download_PDF_' . $timestamp . '.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($file_name, 'D');
    exit;
}

function add_custom_download_pdf_script()
{
    if (!is_admin()) {
        ?>
        <div id="ajax-loader" style="display: none;">
            <div class="spinner"></div>
        </div>
        <form id="download-pdf-form" method="post">
            <input type="hidden" name="action" value="download_pdf">
            <input type="hidden" name="post_id" value="123">
            <button type="submit">Download PDF</button>
        </form>

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
                $('#download-pdf-form').on('click', function (e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    formData.append('action', 'download_pdf');

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
                            var fileName = 'Download_PDF_' + timestamp + '.pdf';
                            var url = window.URL.createObjectURL(response);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = fileName;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        },
                        error: function () {
                            alert('An error occurred while downloading the PDF.');
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
add_action('wp_footer', 'add_custom_download_pdf_script', 99);