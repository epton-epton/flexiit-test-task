<?php
/**
* Template Name: Properties
*/

get_header();
$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

        <div class="page-title">
            <h1><?php the_field('properties_h1') ?></h1>
        </div>

        <?php 
            the_content();
            echo do_shortcode('[property_list]');
        ?>

    </div>

</div>

<?php 
get_footer(); ?>