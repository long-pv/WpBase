<?php
function change_my_account_orders_limit($args)
{
    $args['posts_per_page'] = 10;
    return $args;
}
add_filter('woocommerce_my_account_my_orders_query', 'change_my_account_orders_limit');