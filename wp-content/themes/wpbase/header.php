<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package basetheme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	// hook body content
	wp_body_open();
	?>

	<header id="header" class="header">
		<div class="container">
			<div class="header__navInner">
				<a href="<?php echo home_url(); ?>" class="header__logo">
					<?php $logo_url = get_template_directory_uri() . '/assets/images/logo.svg'; ?>
					<img src="<?php echo $logo_url; ?>" alt="logo">
				</a>

				<!-- menu PC -->
				<div class="header__nav header__menupc">
					<?php
					if (has_nav_menu('menu-1')) {
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'container' => 'nav',
								'container_class' => '',
								'depth' => 1,
							)
						);
					}
					?>
				</div>

				<?php
				if (function_exists('woo_action_header')) {
					woo_action_header();
				}
				?>

				<!-- button toggle menu mobile -->
				<div class="header__toggle">
					<span class="header__toggleItem header__toggleItem--open">
						<svg width="21" height="14" viewBox="0 0 21 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.875 1.07812H19.4723" stroke="#333333" stroke-width="2" stroke-linecap="round" />
							<path d="M1.875 6.74219H19.4723" stroke="#333333" stroke-width="2" stroke-linecap="round" />
							<path d="M1.875 12.4023H19.4723" stroke="#333333" stroke-width="2" stroke-linecap="round" />
						</svg>
					</span>
					<span class="header__toggleItem header__toggleItem--close">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M18 6L6 18" stroke="#333333" stroke-width="1.5" stroke-linecap="round"
								stroke-linejoin="round" />
							<path d="M6 6L18 18" stroke="#333333" stroke-width="1.5" stroke-linecap="round"
								stroke-linejoin="round" />
						</svg>
					</span>
				</div>

				<?php switch_lang() ?>
			</div>
		</div>

		<!-- menu Mobile -->
		<div class="header__menusp">
			<?php
			if (has_nav_menu('menu-1')) {
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'container' => 'nav',
						'container_class' => 'header__menuspInner',
						'depth' => 1,
					)
				);
			}
			?>
		</div>
	</header>

	<main class="mainBodyContent">