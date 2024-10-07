<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap4' );
$navbar_type       = get_theme_mod( 'understrap_navbar_type', 'collapse' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<header>
		<div class="container d-flex justify-content-between align-items-center">
			<?php the_custom_logo(); ?>
			<div id="navbarNav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                ));
                ?>
            </div>
		</div>
		<div id="burger" class="">
            <span></span>
            <span></span>
            <span></span>
        </div>
		<div class="header-line"></div>
	   

	    <!-- Mobile Menu (overlay) -->
	    <div class="mobile-menu-overlay">
	        <div class="overlay-content">
	            <?php
	            wp_nav_menu(array(
	                'theme_location' => 'primary',
	                'container' => false,
	                'menu_class' => 'nav flex-column',
	                'fallback_cb' => false,
	            ));
	            ?>
	        </div>
	    </div>
	</header>