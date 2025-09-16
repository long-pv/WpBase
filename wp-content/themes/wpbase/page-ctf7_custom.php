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
    <div class="lv_row">
        <div class="lv_col_6">
            <label for="full_name" class="form_label">Full Name <span class="req">*</span></label>
            [text* full_name class:form_control placeholder "Your full name"]
        </div>
        <div class="lv_col_6">
            <label for="job_position" class="form_label">Job Apply <span class="req">*</span></label>
            [text* job_position class:form_control placeholder "Your job apply"]
        </div>

        <div class="lv_col_6">
            <label for="email" class="form_label">Email <span class="req">*</span></label>
            [email* email class:form_control placeholder "Your email"]
        </div>
        <div class="lv_col_6">
            <label for="phone_number" class="form_label">Phone Number <span class="req">*</span></label>
            [tel* phone_number class:form_control placeholder "Your phone number"]
        </div>

        <div class="lv_col_12">
            <label for="work_location" class="form_label">Preferred Work Location </label>
            [select work_location class:form_control form_select "Ho Chi Minh City" "Ha Noi City"]
        </div>
        <div class="lv_col_12">
            <label for="start_date" class="form_label">When can you start?</label>
            [date start_date class:form_control placeholder "Choose your start time"]
        </div>

        <div class="lv_col_12">
            <div for="cv_upload" class="form_label">Upload CV/Portfolio <span class="req">*</span></div>
            <label class="form_file_label">
                [file* cv_upload class:form_file filetypes:pdf|doc|docx limit:2mb]
                <span class="form_note">Doc, Docx, PDF (<25MB) <span>Upload file</span></span>

            </label>
        </div>

        <div class="lv_col_12">
            [checkbox* agree_to_terms class:form_checkbox use_label_element "Tôi đồng ý"]
        </div>

        <div class="lv_col_12">
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
    // tắt validate khi dùng checkbox và select submit
    document.addEventListener("DOMContentLoaded", function() {
        document.addEventListener(
            "change",
            function(e) {
                // Áp dụng cho checkbox, select và file input
                if (!e.target.matches('input[type="checkbox"], select, input[type="file"]')) return;

                const form = e.target.closest("form.wpcf7-form");
                if (!form) return;

                // Xử lý tất cả field lỗi
                form.querySelectorAll(".wpcf7-form-control-wrap").forEach(function(wrap) {
                    const control = wrap.querySelector(".wpcf7-form-control");
                    const tip = wrap.querySelector(".wpcf7-not-valid-tip");

                    if (control !== e.target) {
                        // Field khác → xoá lỗi
                        if (control) {
                            control.classList.remove("wpcf7-not-valid");
                            control.removeAttribute("aria-invalid");
                        }
                        if (tip) tip.remove();
                    }
                    // Field hiện tại (e.target) → giữ nguyên lỗi nếu có
                });

                // Xoá message tổng (response-output)
                const resp = form.querySelector(".wpcf7-response-output");
                if (resp) {
                    resp.textContent = "";
                    resp.className = "wpcf7-response-output";
                    resp.style.display = "none";
                }

                // Tắt popup HTML5 lần sau
                form.setAttribute("novalidate", "novalidate");
            },
            false
        );
    });

    // bắt lỗi khi file k đúng định dạng
    document.querySelectorAll(".form_file").forEach(function(input) {
        var noteElement = input.closest(".form_file_label").querySelector(".form_note");
        noteElement.setAttribute("data-default-text", noteElement.innerHTML);

        input.addEventListener("change", function() {
            var file = input.files[0];
            var noteElement = input.closest(".form_file_label").querySelector(".form_note");

            var acceptAttr = input.getAttribute("accept") || "";
            var allowedTypes = acceptAttr.split(",").map((ext) => ext.trim().replace(".", "").toLowerCase());

            if (file) {
                var ext = file.name.split(".").pop().toLowerCase();

                if (!allowedTypes.includes(ext)) {
                    alert("Invalid file format. Only the following are allowed: " + allowedTypes.join(", "));
                    noteElement.innerHTML = noteElement.getAttribute("data-default-text");
                    input.value = "";
                    input.focus(); // focus lại để user chọn file mới
                    return;
                }

                // Valid file → show name
                noteElement.innerHTML = `<span style="color:#fff;font-weight:600;font-size:12px;display:inline-flex;line-height:1.2;">${file.name}</span>`;
            } else {
                // No file selected → reset
                noteElement.innerHTML = noteElement.getAttribute("data-default-text");
            }
        });
    });

    // bắt lỗi khi dung lượng file quá lớn
    document.querySelectorAll(".form_file").forEach(function(input) {
        var noteElement = input.closest(".form_file_label").querySelector(".form_note");
        var defaultText = noteElement.getAttribute("data-default-text") || noteElement.innerHTML;

        // Quan sát khi CF7 thêm tip lỗi
        const observer = new MutationObserver(() => {
            let errorTip = input.closest(".wpcf7-form-control-wrap").querySelector(".wpcf7-not-valid-tip");

            if (errorTip && errorTip.textContent.includes("too large")) {
                // Xóa tên file, reset về mặc định
                noteElement.innerHTML = defaultText;
                input.value = "";
            }
        });

        observer.observe(input.closest(".wpcf7-form-control-wrap"), {
            childList: true,
            subtree: true,
        });
    });

    document.addEventListener("wpcf7mailsent", function(event) {
        const form = event.target; // form đã submit thành công

        form.querySelectorAll(".form_file").forEach(function(input) {
            const noteElement = input.closest(".form_file_label").querySelector(".form_note");
            if (noteElement) {
                noteElement.innerHTML = noteElement.getAttribute("data-default-text") || "Upload attachments";
            }
            input.value = ""; // reset file input
        });
    });

    function setBusy(form, busy) {
        var $btn = $(form).find(".wpcf7-submit");
        if (!$btn.length) return;
        if (busy) {
            $btn.addClass("is-busy").prop("disabled", true);
        } else {
            $btn.removeClass("is-busy").prop("disabled", false);
        }
    }

    /* CF7 sẽ bắn event này ngay TRƯỚC khi submit AJAX */
    document.addEventListener(
        "wpcf7beforesubmit",
        function(e) {
            setBusy(e.target, true);
        },
        false
    );

    /* Sau khi có kết quả (kể cả validate lỗi) → luôn bật lại */
    ["wpcf7invalid", "wpcf7spam", "wpcf7mailfailed", "wpcf7mailsent", "wpcf7submit"].forEach(function(ev) {
        document.addEventListener(
            ev,
            function(e) {
                setBusy(e.target, false);
            },
            false
        );
    });

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector(".wpcf7");
        if (form) {
            form.addEventListener("wpcf7invalid", function() {
                setTimeout(() => {
                    // Lấy tất cả error messages
                    const errors = form.querySelectorAll(".wpcf7-not-valid-tip");

                    errors.forEach((error) => {
                        const inputWrapper = error.parentElement;
                        if (inputWrapper) {
                            const name = inputWrapper.getAttribute("data-name");

                            // Xử lý riêng cho checkbox agree_to_terms
                            if (name === "agree_to_terms") {
                                error.textContent = "Please agree to the terms.";
                            }
                        }
                    });
                }, 100); // Đợi CF7 render error xong
            });
        }
    });
</script>
<?php
get_footer();
