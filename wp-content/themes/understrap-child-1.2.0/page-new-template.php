<?php
/**
* Template Name: New Template
*/

get_header();
$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper page-new-template" id="page-wrapper">

    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

        <div class="hero" style="background-image:url(<?php the_field('page_template_image') ?>)">
            <div class="hero-content">
                <div class="hero-wrap first">
                    <div class="hero-title"><h1><?php the_field('page_template_h1') ?></h1></div>
                </div>
                <div class="hero-wrap">
                    <div class="hero-subtitle">
                        <span><?php the_field('page_template_subtitle') ?></span>
                    </div>
                </div>                
            </div>           
        </div>

        <?php 
            the_content();
        ?>

    </div>

</div>

<?php 
get_footer(); ?>