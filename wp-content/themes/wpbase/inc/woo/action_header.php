<?php
function woo_action_header()
{
    $link_myaccount = wc_get_page_permalink('myaccount');
    $link_cart = wc_get_cart_url();
    ?>
    <div class="header__woo">
        <a href="<?php echo $link_myaccount; ?>" class="header__wooMyaccout">
            <?php if (is_user_logged_in()): ?>
                <span class="header__wooIcon header__wooIcon--myAccount"></span>
            <?php else: ?>
                <span class="header__wooIcon header__wooIcon--login"></span>
            <?php endif; ?>
        </a>

        <?php if (is_user_logged_in()): ?>
            <a href="<?php echo $link_cart; ?>" class="header__wooCart">
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

            <a href="<?php echo wp_logout_url(home_url()); ?>" class="header__wooLogout">
                <span class="header__wooIcon header__wooIcon--logout"></span>
            </a>
        <?php endif; ?>
    </div>
    <?php
}