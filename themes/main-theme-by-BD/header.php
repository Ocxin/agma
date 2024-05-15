<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head(); ?>
</head>

<?php
$navbar_scheme   = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.
$search_enabled  = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
?>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'wp_bootstrap_starter'); ?></a>

	<div id="wrapper">
		<header id="header" class="header px-1 px-md-5 d-flex justify-content-evenly flex-column">
			<nav class="navbar navbar-light navbar-expand-md">
				<div class="container-fluid">
					<?php $header_logo = get_theme_mod('header_logo'); // Get custom meta-value.
					?>
					<?php if (!empty($header_logo)) : ?>
						<a class="navbar-brand header__logo" href="/">
							<img src="<?php echo esc_url($header_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
						</a>
					<?php else : ?>
						<a class="navbar-brand header__logo" href="/">MARD<br>ELLO</a>
					<?php endif; ?>
					<?php
					// Loading WordPress Custom Menu (theme_location).
					wp_nav_menu(
						array(
							'theme_location' => 'main-menu',
							'container'      => '',
							'menu_class'     => 'navbar-nav me-auto',
							'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
							'walker'         => new WP_Bootstrap_Navwalker(),
						)
					);

					?>

					<a class="component button primary" href="/contatti">Contattaci</a>
					<a class="component button call" href="/contatti"><i class="fa-regular fa-phone"></i></a>

				</div>
		</header>
		<?php get_template_part('partials/component/pop-up-form'); ?>


		<main id="main" <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' style="padding-top: 100px;"';
						elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' style="padding-bottom: 100px;"';
						endif; ?>>
			<?php
			// If Single or Archive (Category, Tag, Author or a Date based page).
			if (is_single() || is_archive()) :
			?>

			<?php
			endif;
			?>