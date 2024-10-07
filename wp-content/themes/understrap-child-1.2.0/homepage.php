<?php
/**
* Template Name: Homepage
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

        <div class="home-h">
            <h1><?php the_field('home_h1') ?></h1>
        </div> 

        <?php echo do_shortcode('[property_filter]');?>

        <div class="home-h">
            <h2><?php the_field('home_h2') ?></h2>
        </div> 
        <?php echo do_shortcode('[property_list]');?>

    </div><!-- #content -->

</div><!-- #page-wrapper -->

<div id="loading-overlay">
    <div id="loader">Loading...</div> <!-- Или замените текст на GIF-изображение -->
</div>

<?php

get_footer(); ?>