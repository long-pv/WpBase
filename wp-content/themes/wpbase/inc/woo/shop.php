<?php
// redirect shop to home page
add_action('template_redirect', 'redirect_shop_to_homepage');
function redirect_shop_to_homepage()
{
    if (is_shop()) {
        wp_redirect(home_url());
        exit;
    }
}