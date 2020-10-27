<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php wp_head(); ?>
</head>


<body <?php body_class("kibum"); ?>>

	<?php if ( get_theme_mod( 'wpt_mobile_menu_layout' ) === 'offcanvas' ) : ?>
		<?php get_template_part( 'template-parts/mobile-off-canvas' ); ?>
	<?php endif; ?>

<div class="row kibum-outer-row kibum-top">
	<div class="columns">
		<div class="kibum-white-inside">
			<div class="row">
			<div class="columns medium-3">
				<?php 	if ( function_exists( 'the_custom_logo' ) && has_custom_logo()) {
							the_custom_logo();
						} else {
							echo '
								<a href="'. esc_url( home_url( '/' ) ) .'" rel="home">
								<img class="kibum-logo-img" src="'. 
								 get_theme_root_uri()."/".get_template() .'/dist/assets/images/corporate/kibum_logo.png" alt="kibum logo" height="50px" /></a>
								';
						} ?>
			
			</div>
			<div class="columns medium-4 medium-offset-5 kibum-description">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo html_entity_decode(get_bloginfo( 'description' )); ?></a>
			</div>
			</div>
		</div>
		<div class="site-title-bar title-bar" <?php foundationpress_title_bar_responsive_toggle(); ?>>
			<div class="title-bar-left">
				<button aria-label="<?php _e( 'Main Menu', 'foundationpress' ); ?>" class="menu-icon" type="button" data-toggle="<?php foundationpress_mobile_menu_id(); ?>"></button>
			</div>
			
		</div>
		<div class="site-navigation kibum-mobile-nav show-for-small-only " role="navigation">
			<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) === 'topbar' ) : ?>
				<?php get_template_part( 'template-parts/mobile-top-bar' ); ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="row kibum-motiv">
	<div class="kibum-motiv-column" style="background-image: url(<?php echo get_header_image(); ?>) ;">
	</div>
</div>

<!-- BEGINN: kibum-main div -->
<div class="row kibum-outer-row kibum-main">
	
		<nav class="site-navigation columns kibum-margin-bottom show-for-medium " role="navigation">
				<div class="kibum-white-inside">
				<?php foundationpress_top_bar_r(); ?>

				</div>
		</nav>
