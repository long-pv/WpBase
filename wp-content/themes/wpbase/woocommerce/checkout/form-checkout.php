<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	wp_redirect(wc_get_page_permalink('myaccount'));
	exit;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
	action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

	<div class="row">
		<div class="col-lg-7 mb-4 mb-lg-0">
			<?php if ($checkout->get_checkout_fields()): ?>

				<?php do_action('woocommerce_checkout_before_customer_details'); ?>

				<div id="customer_details">
					<div id="checkout_billing">
						<?php do_action('woocommerce_checkout_billing'); ?>
					</div>

					<div id="checkout_shipping" class="d-none">
						<?php do_action('woocommerce_checkout_shipping'); ?>
					</div>
				</div>

				<?php do_action('woocommerce_checkout_after_customer_details'); ?>

			<?php endif; ?>

		</div>
		<div class="col-lg-5">
			<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

			<h3 id="order_review_heading">
				<?php esc_html_e('Your order', 'woocommerce'); ?>
			</h3>

			<?php do_action('woocommerce_checkout_before_order_review'); ?>

			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action('woocommerce_checkout_order_review'); ?>
			</div>

			<?php do_action('woocommerce_checkout_after_order_review'); ?>
		</div>
	</div>


</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>