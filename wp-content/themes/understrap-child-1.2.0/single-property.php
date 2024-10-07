<?php
get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper single-property" id="page-wrapper">

    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1"> 

    <?php

        $re_name = get_field('re_name');
        $re_сoordinates = get_field('re_сoordinates');
        $re_number_of_floors = get_field('re_number_of_floors');
        $re_type_of_building = get_field('re_type_of_building');
        $re_eco_friendliness = get_field('re_eco_friendliness');
        $premises = get_field('re_premises');

        if (!empty($premises)) {
            foreach ($premises as $premise) {
                $premises_counter++;
            }
           $premises_all = $premises_counter; 
        } else {
            $premises_all = 0;
        }

        $categories = get_the_terms( get_the_ID(), 'region' );
    ?>

    <div class="property-single property-item-wrap d-flex flex-wrap flex-column">
        <div class="property-item-title">
            <h1><?php echo $re_name ?></h1>
        </div>
        <div class="property-item-img" data-fancybox="gallery" href="<?php the_field('re_image') ?>" style="background-image: url('<?php the_field('re_image') ?>');">
         </div>
        <div class="property-item">
            <div class="property-item-content d-flex flew-row flex-wrap">
                <div class="property-item-row d-flex flex-row">
                    <div class="property-item-content-item d-flex flew-row justify-content-start">
                        <span><?php echo _e('Number of floors:') ?></span>
                        <span><?php echo $re_number_of_floors ?></span>
                    </div>
                    <div class="property-item-content-item d-flex flew-row justify-content-start">
                        <span><?php echo _e('Type of building: ') ?> </span>
                        <span><?php echo $re_type_of_building ?></span>
                    </div>
                </div>

                <div class="property-item-row d-flex flex-row">
                    <div class="property-item-content-item d-flex flew-row justify-content-start">
                        <span><?php echo _e('Coordinates: ') ?></span>
                        <span><?php echo $re_сoordinates ?></span>
                    </div>
                    <div class="property-item-content-item d-flex flew-row justify-content-start">
                        <span><?php echo _e('Eco-friendless: ') ?></span>
                        <span><?php echo $re_eco_friendliness ?></span>
                    </div>
                </div>

                <div class="property-item-row d-flex flex-row">
                    <div class="property-item-content-item d-flex flew-row justify-content-start">
                        <span><?php echo _e('Number of premises: ') ?> </span>
                        <span><?php echo $premises_all ?></span>
                    </div>
                    <div class="property-item-content-item d-flex flew-row justify-content-start">
                        <span><?php echo _e('Location: ') ?> </span>
                        <span>

                            <?php

                                if ( $categories && ! is_wp_error( $categories ) ) {
                                    $categories_list = array();

                                    foreach ( $categories as $category ) {
                                        $categories_list[] = $category->name;
                                    }

                                    echo implode( ', ', $categories_list );
                                }

                            ?>

                        </span>
                    </div>
                </div>                
             
            </div>
        </div>
    </div>

    <?php

        if($premises_all>0) { ?>

            <div class="property-item-title">
                <h2><?php echo _e('Premises') ?></h2>

                <?php 
                    foreach ($premises as $premise) { ?>
                    
                        <div class="premise filter-item d-flex flex-row">
                            <div class="filter-left" data-fancybox="gallery" href="<?php echo $premise['re_premises_image'] ?>" style="background-image:url(<?php echo $premise['re_premises_image'] ?>)"></div>
                            <div class="filter-right">
                                <p class="premise-param"><?php _e('Premise parameters') ?></p>
                                <p><span><?php echo _e('Area (sqm): ') ?></span><?php echo $premise['re_area'] ?></p>
                                <p><span><?php echo _e('Number of rooms: ') ?></span><?php echo $premise['re_number_of_rooms'] ?></p>
                                <p><span><?php echo _e('Balcony: ') ?></span><?php echo $premise['re_balcony'] ?></p>
                                <p><span><?php echo _e('Bathroom: ') ?></span><?php echo $premise['re_bathroom'] ?></p>
                            </div>
                        </div>

                <?php }

                ?>

            </div>

        <?php }

    ?>

 </div>

</div>

<?php get_footer();
