<?php
function woo_action_header()
{
    $link_myaccount = wc_get_page_permalink('myaccount');
    ?>
    <div class="header__woo">
        <a href="<?php echo $link_myaccount; ?>" class="header__wooMyaccout">
            <span class="header__wooIcon header__wooIcon--myAccount"></span>
        </a>

        <a href="<?php echo wc_get_cart_url(); ?>" class="header__wooCart">
            <span class="header__wooIcon header__wooIcon--cart"></span>

            <?php
            $count_cart = WC()->cart->get_cart_contents_count() ?? 0;
            if ($count_cart > 0):
                ?>
                <span class="header__wooCartCount">
                    <?php echo $count_cart; ?>
                </span>
            <?php endif; ?>
        </a>
    </div>
    <?php
}