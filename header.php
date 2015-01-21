<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package UWEX-Media
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="parallax-bg"></div>
<div id="page" class="hfeed site">
	<?php do_action( 'uwex_media_before' ); ?>
	<div id="header-top">
		<header id="masthead" class="site-header container" role="banner">

    		<div class="row">

        		<div class="site-branding col-xs-12 col-sm-4">
    			<?php if((of_get_option('logo', true) != "") && (of_get_option('logo', true) != 1) ) { ?>
    				<h1 class="site-title logo-container"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
    				<?php
    				echo "<img class='main_logo' src='".of_get_option('logo', true)."' width=\"161px\" height=\"80px\" title='".esc_attr(get_bloginfo( 'name','display' ) )."'></a></h1>";
    				}
    			else { ?>
    				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
    			<?php
    			}
    			?>
    			</div>

                <div class="default-nav-wrapper col-xs-12 col-sm-8">
        			<nav id="site-navigation" class="main-navigation" role="navigation">
        	         <div id="nav-container">
        				<h1 class="menu-toggle">MENU
            				<div class="menu-toggle-btn">
                				<span class="icon-bar"></span>
                				<span class="icon-bar"></span>
                				<span class="icon-bar"></span>
            				</div>
        				</h1>
        				<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'uwex-media' ); ?>"><?php _e( 'Skip to content', 'uwex-media' ); ?></a></div>

        				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
        	          </div>
        			</nav><!-- #site-navigation -->
                </div>

    			<!-- <?php get_template_part('social', 'fa'); ?> -->

    		</div>

		</header><!-- #masthead -->
	</div>

		<div id="content" class="site-content row clearfix clear">
		<div class="container">
