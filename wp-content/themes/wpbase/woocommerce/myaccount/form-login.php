<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$action = $_GET['action'] ?? null;

do_action('woocommerce_before_customer_login_form'); ?>


<div id="customer_login">
	<?php
	if ($action !== 'register'):
		?>
		<form class="woocommerce-form woocommerce-form-login login m-0" method="post">

			<?php do_action('woocommerce_login_form_start'); ?>

			<div class="mb-4">
				<label for="username">
					<?php esc_html_e('Email', 'basetheme'); ?>&nbsp;<span class="required">*</span>
				</label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
					id="username" autocomplete="username"
					value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
			</div>

			<div class="mb-4">
				<label for="password">
					<?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
				</label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password"
					id="password" autocomplete="current-password" />
			</div>

			<?php do_action('woocommerce_login_form'); ?>

			<div id="login_remember" class="mb-4">
				<label>
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" />
					<span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
				</label>
			</div>

			<div class="mb-4">
				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
				<button type="submit"
					class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
					name="login"
					value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
			</div>

			<div class="mb-4">
				<a href="<?php echo esc_url(wp_lostpassword_url()); ?>">
					<?php esc_html_e('Lost your password?', 'woocommerce'); ?>
				</a>
			</div>

			<div>
				<a href="<?php echo wc_get_page_permalink('myaccount') . '?action=register'; ?>">
					<?php _e('Register an account', 'basetheme'); ?>
				</a>
			</div>

			<?php do_action('woocommerce_login_form_end'); ?>

		</form>
	<?php else: ?>
		<form method="post" class="woocommerce-form woocommerce-form-register register m-0" <?php do_action('woocommerce_register_form_tag'); ?>>

			<?php do_action('woocommerce_register_form_start'); ?>

			<?php if ('no' === get_option('woocommerce_registration_generate_username')): ?>
				<div class="mb-4">
					<label for="reg_username">
						<?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
					</label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
						id="reg_username" autocomplete="username"
						value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
				</div>
			<?php endif; ?>

			<div class="mb-4">
				<label for="reg_email">
					<?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
				</label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email"
					autocomplete="email"
					value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" />
			</div>

			<!-- add input form -->
			<div class="mb-4">
				<label for="billing_first_name"><?php _e('First Name', 'basetheme'); ?>&nbsp;<span
						class="required">*</span></label>
				<input type="text" class="input-text" name="billing_first_name" id="billing_first_name" value="<?php if (!empty($_POST['billing_first_name']))
					echo esc_attr($_POST['billing_first_name']); ?>" />
			</div>

			<div class="mb-4">
				<label for="billing_address_1">
					<?php _e('Address', 'basetheme'); ?>&nbsp;<span class="required">*</span>
				</label>
				<input type="text" class="input-text" name="billing_address_1" id="billing_address_1" value="<?php if (!empty($_POST['billing_address_1']))
					echo esc_attr($_POST['billing_address_1']); ?>" />
			</div>

			<div class="mb-4">
				<label for="billing_phone"><?php _e('Phone', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="input-text" name="billing_phone" id="billing_phone" value="<?php if (!empty($_POST['billing_phone']))
					echo esc_attr($_POST['billing_phone']); ?>" />
			</div>
			<!-- end -->

			<?php if ('no' === get_option('woocommerce_registration_generate_password')): ?>
				<div class="mb-4">
					<label for="reg_password">
						<?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
					</label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
						id="reg_password" autocomplete="new-password" value="<?php if (!empty($_POST['password']))
							echo esc_attr($_POST['password']); ?>" />
				</div>

				<div class="mb-4">
					<label for="reg_password2">
						<?php _e('Confirm password', 'basetheme'); ?>&nbsp;<span class="required">*</span>
					</label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password2"
						id="reg_password2" autocomplete="off" value="<?php if (!empty($_POST['password2']))
							echo esc_attr($_POST['password2']); ?>" />
				</div>
			<?php else: ?>
				<div class="mb-4">
					<?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?>
				</div>
			<?php endif; ?>

			<?php do_action('woocommerce_register_form'); ?>

			<div class="mb-4">
				<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
				<button type="submit"
					class="woocommerce-Button woocommerce-button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> woocommerce-form-register__submit"
					name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>">
					<?php esc_html_e('Register', 'woocommerce'); ?>
				</button>
			</div>

			<div>
				<a href="<?php echo wc_get_page_permalink('myaccount') . '?action=login'; ?>">
					<?php _e('Return to login', 'basetheme'); ?>
				</a>
			</div>

			<?php do_action('woocommerce_register_form_end'); ?>

		</form>
	<?php endif; ?>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>