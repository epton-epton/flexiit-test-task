<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	//wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_enqueue_style('fancybox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css');
    wp_enqueue_script('fancybox-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array('jquery'), null, true);

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );


// Properties shortcode
function property_shortcode() {
    ob_start();

    // Display first 6 posts
    $args = array(
        'post_type' => 'property',
        'posts_per_page' => 6,
        'paged' => 1, // Start page
    );

    $property_query = new WP_Query($args);

    if ($property_query->have_posts()) {
        echo '<div id="property-results-full"  class="d-flex flex-row flex-wrap">';
        while ($property_query->have_posts()) {
            $property_query->the_post();
            $re_name = get_field('re_name');
            $re_number_of_floors = get_field('re_number_of_floors');
            $re_type_of_building = get_field('re_type_of_building');
            $re_eco_friendliness = get_field('re_eco_friendliness');
            $premises = get_field('re_premises');

            echo '<div class="property-item-wrap d-flex flex-wrap flex-column">';
            echo '<div class="property-item-img" style="background-image:url('.get_field('re_image').')"><a href="'. get_permalink() .'"></a></div>';
            echo '<div class="property-item">';            
            echo '<div class="property-item-title-box">';
            echo '<div class="property-item-title"><a href="'. get_permalink() .'">' . esc_html($re_name) . '</a></div>';
            echo '</div>';
            echo '<div class="property-item-content d-flex flew-row flex-wrap">';
            echo '<div class="property-item-content-item d-flex flew-row justify-content-start">';
            echo '<span>Number of floors: </span><span>' . esc_html($re_number_of_floors) . '</span>';
            echo '</div>';
            echo '<div class="property-item-content-item d-flex flew-row justify-content-start">';
            echo '<span>Type of building: </span><span>' . esc_html($re_type_of_building) . '</span>';
            echo '</div>';
            echo '<div class="property-item-content-item d-flex flew-row justify-content-start">';
            echo '<span>Eco-friendliness: </span><span>' . esc_html($re_eco_friendliness) . '</span>';
            echo '</div>';
            $premises_counter = 0;
            if (!empty($premises)) {
                foreach ($premises as $premise) {
                    $premises_counter++;
                }
               $premises_all = $premises_counter; 
            } else {
                $premises_all = 0;
            }
            echo '<div class="property-item-content-item d-flex flew-row justify-content-start">';
            echo '<span>Premisess: </span><span>' . $premises_all . '</span>';
            echo '</div>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
        echo '</div>'; 
    } else {
        echo '<p>No properties found.</p>';
    }

    echo '<button id="load-more" data-page="2">Load More</button>';

    wp_reset_postdata();
    
    ?>

    <?php

    return ob_get_clean();
}
add_shortcode('property_list', 'property_shortcode');


function load_properties() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    $args = array(
        'post_type' => 'property',
        'posts_per_page' => 6,
        'paged' => $paged,
        'meta_key' => 're_eco_friendliness',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    );

    $property_query = new WP_Query($args);

    if ($property_query->have_posts()) {
        while ($property_query->have_posts()) {
            $property_query->the_post();
            $re_name = get_field('re_name');
            $re_number_of_floors = get_field('re_number_of_floors');
            $re_type_of_building = get_field('re_type_of_building');
            $re_eco_friendliness = get_field('re_eco_friendliness');
            $premises = get_field('re_premises');

            echo '<div class="property-item-wrap d-flex flex-wrap flex-column">';
            echo '<div class="property-item-img" style="background-image:url('.get_field('re_image').')"><a href="'. get_permalink() .'"></a></div>';
            echo '<div class="property-item">';            
            echo '<div class="property-item-title-box">';
            echo '<div class="property-item-title"><a href="'. get_permalink() .'">' . esc_html($re_name) . '</a></div>';
            echo '</div>';
            echo '<div class="property-item-content d-flex flew-row flex-wrap">';
            echo '<div class="property-item-content-item d-flex flew-row justify-content-start">';
            echo '<span>Number of floors: </span><span>' . esc_html($re_number_of_floors) . '</span>';
            echo '</div>';
            echo '<div class="property-item-content-item d-flex flew-row justify-content-start">';
            echo '<span>Type of building: </span><span>' . esc_html($re_type_of_building) . '</span>';
            echo '</div>';
            echo '<div class="property-item-content-item d-flex flew-row justify-content-start">';
            echo '<span>Eco-friendliness: </span><span>' . esc_html($re_eco_friendliness) . '</span>';
            echo '</div>';
            $premises_counter = 0;
            if (!empty($premises)) {
                foreach ($premises as $premise) {
                    $premises_counter++;
                }
               $premises_all = $premises_counter; 
            } else {
                $premises_all = 0;
            }
            echo '<div class="property-item-content-item d-flex flew-row justify-content-start">';
            echo '<span>Premisess: </span><span>' . $premises_all . '</span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo ''; 
    }

    wp_reset_postdata();
    wp_die(); 
}
add_action('wp_ajax_load_properties', 'load_properties');
add_action('wp_ajax_nopriv_load_properties', 'load_properties');

function enqueue_property_filter_scripts() {
    wp_enqueue_script('property-filter', get_stylesheet_directory_uri() . '/js/child-theme.js', array('jquery'), null, true);

    // Передаем AJAX URL в JavaScript через глобальную переменную
    wp_localize_script('property-filter', 'propertyAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_property_filter_scripts');


class Property_Sorting_By_Eco {
    
    public function __construct() {
        add_action('pre_get_posts', [$this, 'modify_property_query']);
    }

    public function modify_property_query($query) {
    if (!is_admin() ) {
        if ($query->get('post_type') === 'property') {
            $query->set('meta_key', 're_eco_friendliness');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'DESC');
        }
    }
}

}

new Property_Sorting_By_Eco();

