<?php

/**
 * Template name: Contact form 7
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package basetheme
 */

get_header();
?>

<!-- 
<div class="form_group">
    <div class="row">
        <div class="col-md-6">
            <label for="full_name" class="form_label">Full Name <span class="req">*</span></label>
            [text* full_name class:form_control placeholder "Your full name"]
        </div>
        <div class="col-md-6">
            <label for="job_position" class="form_label">Job Apply <span class="req">*</span></label>
            [text* job_position class:form_control placeholder "Your job apply"]
        </div>

        <div class="col-md-6">
            <label for="email" class="form_label">Email <span class="req">*</span></label>
            [email* email class:form_control placeholder "Your email"]
        </div>
        <div class="col-md-6">
            <label for="phone_number" class="form_label">Phone Number <span class="req">*</span></label>
            [tel* phone_number class:form_control placeholder "Your phone number"]
        </div>

        <div class="col-md-12">
            <label for="work_location" class="form_label">Preferred Work Location </label>
            [select work_location class:form_control form_select "Ho Chi Minh City" "Ha Noi City"]
        </div>
        <div class="col-md-12">
            <label for="start_date" class="form_label">When can you start?</label>
            [date start_date class:form_control placeholder "Choose your start time"]
        </div>

        <div class="col-12">
            <div for="cv_upload" class="form_label">Upload CV/Portfolio <span class="req">*</span></div>
            <label class="form_file_label">
                [file* cv_upload class:form_file filetypes:pdf|doc|docx limit:2mb]
                <span class="form_note">Doc, Docx, PDF (<25MB) <span>Upload file</span></span>

            </label>
        </div>

        <div class="col-12">
            [checkbox* agree_to_terms class:form_checkbox use_label_element "Tôi đồng ý"]
        </div>

        <div class="col-12">
            <div class="form_btn_block">
                [submit class:btn class:form_btn "APPLY NOW"]
            </div>
        </div>
    </div>
</div> 
-->


<div class="py-section">
    <div class="container">
        <div class="editor">
            <?php the_content(); ?>
        </div>
    </div>
</div>

<script>
    // style cho file upload
    document.querySelectorAll('.form_file').forEach(function(input) {
        var noteElement = input.closest('.form_file_label').querySelector('.form_note');
        noteElement.setAttribute('data-default-text', noteElement.innerHTML); // Lưu nội dung gốc
    });

    document.querySelectorAll('.form_file').forEach(function(input) {
        input.addEventListener('change', function() {
            var fileName = input.value.split("\\").pop(); // Lấy tên file
            var noteElement = input.closest('.form_file_label').querySelector('.form_note');

            if (fileName) {
                noteElement.innerHTML = `<span style="color: green; font-weight: bold;">${fileName}</span>`;
            } else {
                noteElement.innerHTML = noteElement.getAttribute('data-default-text'); // Trả về nội dung gốc
            }
        });
    });

    // tắt validate khi dùng checkbox và select submit
    document.addEventListener("DOMContentLoaded", function() {
        document.addEventListener(
            "change",
            function(e) {
                // Áp dụng cho tất cả checkbox và select
                if (!e.target.matches('input[type="checkbox"], select')) return;

                const form = e.target.closest("form.wpcf7-form");
                if (!form) return;

                // 1) Gỡ trạng thái "not valid" trên các field khác
                form.querySelectorAll(".wpcf7-not-valid").forEach(function(el) {
                    el.classList.remove("wpcf7-not-valid");
                    el.removeAttribute("aria-invalid");
                });

                // 2) Xoá tooltip lỗi từng field
                form.querySelectorAll(".wpcf7-form-control-wrap .wpcf7-not-valid-tip").forEach(function(tip) {
                    tip.remove();
                });

                // 3) Xoá message tổng (response-output)
                const resp = form.querySelector(".wpcf7-response-output");
                if (resp) {
                    resp.textContent = "";
                    resp.className = "wpcf7-response-output";
                    resp.style.display = "none";
                }

                // 4) (tuỳ chọn) tắt popup HTML5 lần sau
                form.setAttribute("novalidate", "novalidate");
            },
            false
        );
    });
</script>
<?php
get_footer();
