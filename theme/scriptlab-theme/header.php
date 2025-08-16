<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ScriptLab
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'scriptlab' ); ?></a>

	<header id="masthead" class="site-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem 0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
		<div class="site-branding" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title" style="margin: 0; font-size: 2.5rem;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="color: white; text-decoration: none; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title" style="margin: 0; font-size: 2rem;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="color: white; text-decoration: none; font-weight: bold;"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$scriptlab_description = get_bloginfo( 'description', 'display' );
			if ( $scriptlab_description || is_customize_preview() ) :
				?>
				<p class="site-description" style="color: rgba(255, 255, 255, 0.9); margin: 0.5rem 0; font-size: 1.1rem;"><?php echo $scriptlab_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" style="background: rgba(0, 0, 0, 0.1); margin-top: 1rem; padding: 1rem; border-radius: 0.5rem;">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" style="background: white; color: #667eea; padding: 0.5rem 1rem; border: none; border-radius: 0.25rem; font-weight: bold; cursor: pointer;"><?php esc_html_e( 'Primary Menu', 'scriptlab' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">