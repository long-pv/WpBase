<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form'); ?>

<form class="woocommerce-EditAccountForm edit-account" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"
	<?php do_action('woocommerce_edit_account_form_tag'); ?> enctype="multipart/form-data">

	<?php do_action('woocommerce_edit_account_form_start'); ?>

	<?php
	if (!empty($_GET['action']) && $_GET['action'] == 'change-pass') {
		$change_pass = true;
	} else {
		$change_pass = false;
	}
	?>

	<div id="edit-account-info" class="<?php echo $change_pass ? 'd-none' : ''; ?>">
		<div class="mb-4">
			<label for="account_first_name">
				<?php _e('Full name', 'basetheme'); ?>&nbsp;<span class="required">*</span>
			</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name"
				id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" />
		</div>

		<div class="mb-4">
			<label for="billing_address_1">
				<?php _e('Address', 'basetheme'); ?>&nbsp;<span class="required">*</span>
			</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1"
				id="billing_address_1" autocomplete="billing_address_1"
				value="<?php echo esc_attr($user->billing_address_1); ?>" />
		</div>

		<div class="mb-4">
			<label for="billing_phone">
				<?php _e('Phone', 'basetheme'); ?>&nbsp;<span class="required">*</span>
			</label>
			<input type="tel" pattern="[0-9]{10,15}" class="woocommerce-Input woocommerce-Input--text input-text"
				name="billing_phone" id="billing_phone" autocomplete="billing_phone"
				value="<?php echo esc_attr($user->billing_phone); ?>" />
		</div>

		<div class="mb-4">
			<label for="account_email">
				<?php _e('Email', 'basetheme'); ?>&nbsp;<span class="required">*</span>
			</label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text " name="account_email"
				id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" />
		</div>
	</div>

	<?php
	/**
	 * Hook where additional fields should be rendered.
	 *
	 * @since 8.7.0
	 */
	do_action('woocommerce_edit_account_form_fields');
	?>

	<?php if ($change_pass): ?>
		<div id="change-pass">
			<div class="mb-4">
				<label for="password_current">
					<?php _e('Current password', 'basetheme'); ?>&nbsp;<span class="required">*</span>
				</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text "
					name="password_current" id="password_current" autocomplete="off" />
			</div>
			<div class="mb-4">
				<label for="password_1">
					<?php _e('New password', 'basetheme'); ?>&nbsp;<span class="required">*</span>
				</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text " name="password_1"
					id="password_1" autocomplete="off" />
			</div>
			<div class="mb-4">
				<label for="password_2">
					<?php _e('Confirm new password', 'basetheme'); ?>&nbsp;<span class="required">*</span>
				</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text " name="password_2"
					id="password_2" autocomplete="off" />
			</div>
		</div>
	<?php endif; ?>

	<?php
	/**
	 * My Account edit account form.
	 *
	 * @since 2.6.0
	 */
	do_action('woocommerce_edit_account_form');
	?>

	<div>
		<?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
		<button type="submit"
			class="woocommerce-Button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
			name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>">
			<?php
			if ($change_pass) {
				_e('Update password', 'basetheme');
			} else {
				_e('Update profile', 'basetheme');
			}
			?>
		</button>
		<input type="hidden" name="action" value="save_account_details" />
	</div>

	<?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>