 <?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png" sizes="16x16">
<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon32.png" sizes="32x32">
<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon48.png" sizes="48x48">
<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon64.png" sizes="64x64">
<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon128.png" sizes="128x128">
<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon256.png" sizes="256x256">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<style>
footer form#searchform {
  float: left !important;
}

.sticky {
  background: #4f4f4f !important;
}

div#oo-logo, #mastfoot a {
  display: block !important;
  display: none !important;
}

.site-header {
  max-width: 696px !important;
  margin: 0 auto !important;
}

#site-navigation {
  margin-left: 0 !important;
}

.site-header h1 {
  padding-left: 0 !important;
}
</style>
<![endif]-->
<!--[if IE]>
<style>
div.podtrzitko#menu_bottom {
  margin-left: 0 !important;
}
#mastfoot form input[type=text] {
	color: #333 !important;
	background: green;
}
</style>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="abovethefold">
<div id="page" class="hfeed site">
  <header id="masthead" class="site-header" role="banner">

<!-- logo -->

        <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
	<div id="oo-logo" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
	<div id="oo-logotype"><h1><?php bloginfo('name'); ?></a></h1></div>

<?php get_search_form();?>

<!-- primary menu -->
	<nav id="site-navigation" class="main-navigation" role="navigation">
	<div class="podtrzitko" id="menu_top">------------------------------------------------------------------------------------------------------------------------------------</div>
	<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' , 'depth' => 1) ); ?>
	<div class="podtrzitko" id="menu_bottom">---------------------------------------------------------------------------------------------------------------------------------</div>
	</nav>

<!-- secondary menu -->

	<nav id="page-navigation" class="main-navigation" role="navigation">
	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' , 'depth' => 2) ); ?>
	</nav>

  </header><!-- #masthead -->

  <div id="main" class="wrapper">
