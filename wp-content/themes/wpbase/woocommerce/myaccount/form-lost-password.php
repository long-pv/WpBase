<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_form');
?>

<form method="post"
	class="woocommerce-form woocommerce-form-login login woocommerce-ResetPassword lost_reset_password m-0">

	<div class="mb-4">
		<label for="user_login">
			<?php esc_html_e('Email', 'basetheme'); ?>&nbsp;<span class="required">*</span>
		</label>
		<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login"
			id="user_login" autocomplete="username" aria-required="true" />
	</div>

	<?php do_action('woocommerce_lostpassword_form'); ?>

	<div class="mb-4">
		<input type="hidden" name="wc_reset_password" value="true" />
		<button type="submit"
			class="woocommerce-Button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> btnLink"
			value="<?php esc_attr_e('Reset password', 'woocommerce'); ?>"><?php esc_html_e('Reset password', 'woocommerce'); ?></button>
	</div>

	<div>
		<a href="<?php echo wc_get_page_permalink('myaccount') . '?action=login'; ?>">
			<?php _e('Return to login', 'basetheme'); ?>
		</a>
	</div>

	<?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>

</form>

<?php
do_action('woocommerce_after_lost_password_form');
