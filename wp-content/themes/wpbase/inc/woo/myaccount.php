<?php
function custom_redirect_from_dashboard_to_edit_account()
{
    if (is_user_logged_in() && is_account_page() && !is_wc_endpoint_url() ) {
        wp_redirect(wc_get_account_endpoint_url('edit-account'));
        exit;
    }
}
add_action('template_redirect', 'custom_redirect_from_dashboard_to_edit_account');
