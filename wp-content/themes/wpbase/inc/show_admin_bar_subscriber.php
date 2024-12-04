<?php
add_filter('show_admin_bar', function ($show_admin_bar) {
    if (current_user_can('subscriber')) {
        return false;
    }
    return $show_admin_bar;
});
