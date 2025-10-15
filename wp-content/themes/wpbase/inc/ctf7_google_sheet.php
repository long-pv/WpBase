<?php
add_action('wpcf7_mail_sent', 'cf7_send_to_google_sheet');
function cf7_send_to_google_sheet($contact_form)
{
    // 🔹 Lấy ID form & URL Google Sheet (có thể set thẳng nếu demo)
    $form_thu_lead_id = get_field('form_thu_lead', 'option') ?? '';
    $google_sheet_url = get_field('google_sheet_url', 'option') ?? '';

    // 👉 Demo: set thẳng URL nếu chưa cấu hình ACF
    // $google_sheet_url = 'https://script.google.com/macros/s/XXXXXXXX/exec';

    if (empty($google_sheet_url) || empty($form_thu_lead_id)) return;

    $form_id = $contact_form->id();
    if ($form_id != $form_thu_lead_id) return;

    $submission = WPCF7_Submission::get_instance();
    if (!$submission) return;

    $data = $submission->get_posted_data();

    // 🔹 Payload gửi lên Google Sheet

    $payload = [
        'full_name' => $data['full_name'] ?? '',
        'email'     => $data['email'] ?? '',
        'phone'     => '"' . ($data['phone'] ?? ''),
    ];

    $args = [
        'body'        => $payload,
        'timeout'     => 15,
        'redirection' => 5,
        'blocking'    => true,
    ];

    $response = wp_remote_post($google_sheet_url, $args);

    // 🔹 Log để debug nếu cần
    if (is_wp_error($response)) {
        error_log('Google Sheet error: ' . $response->get_error_message());
    } else {
        error_log('Google Sheet response: ' . wp_remote_retrieve_body($response));
    }
}

/*
Form demo:

<label>Full Name
[text* full_name placeholder "Your full name"]
</label>

<label>Email
[email* email placeholder "Your email address"]
</label>

<label>Phone
[tel* phone placeholder "Your phone number"]
</label>

[submit "Send to Google Sheet"]
*/

/*
Sheet script: 
full_name | email | phone | time

function doPost(e) {
  try {
    // 🔹 Lấy dữ liệu từ POST
    var data = e.parameter;

    // 🔹 Mở Sheet
    var sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('Sheet1');

    // 🔹 Lấy thời gian hiện tại (theo timezone của Google Sheet)
    var now = new Date();

    // 🔹 Chuẩn bị dữ liệu
    var newRow = [
      data.full_name || '',
      data.email || '',
      data.phone || '',
      now,
    ];

    // 🔹 Ghi vào Sheet
    sheet.appendRow(newRow);

    // 🔹 Trả về JSON response
    return ContentService
      .createTextOutput(JSON.stringify({ result: "success" }))
      .setMimeType(ContentService.MimeType.JSON);

  } catch (error) {
    return ContentService
      .createTextOutput(JSON.stringify({ result: "error", message: error.toString() }))
      .setMimeType(ContentService.MimeType.JSON);
  }
}

*/