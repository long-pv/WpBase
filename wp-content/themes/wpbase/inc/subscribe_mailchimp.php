<?php
function subscribe_email_to_mailchimp($email, $first_name = '', $last_name = '')
{
    $mailchimp = get_field('mailchimp', 'option') ?? [];
    $api_key = $mailchimp['api_key'] ?? ''; // Search keyword: "API key"
    $server = $mailchimp['server_key'] ?? '';
    $list_id = $mailchimp['id'] ?? ''; // Menu > Audience > Audience dashboard > Select: Manage Audience > Settings > Search: "Unique Audience ID"

    if ($api_key && $server && $list_id) {


        // Prepare the data
        $data = array(
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => array(
                'FNAME' => $first_name,
                'LNAME' => $last_name,
            )
        );

        $json_data = json_encode($data);

        // Prepare the request headers
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . base64_encode('user:' . $api_key)
        );

        // Prepare the request URL
        $url = 'https://' . $server . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members';

        // Make the POST request using WordPress' wp_remote_post function
        $response = wp_remote_post($url, array(
            'method'    => 'POST',
            'body'      => $json_data,
            'headers'   => $headers,
            'timeout'   => 30,
            'sslverify' => false, // Disable SSL verification (use true in production)
        ));

        // Handle the response
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            return array('success' => false, 'message' => 'Error: ' . $error_message);
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        if ($status_code === 200) {
            return array('success' => true, 'message' => 'Email added successfully');
        } else {
            return array('success' => false, 'message' => 'Failed to add email: ' . $response_body);
        }
    }
}
