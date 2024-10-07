<?php
/**
 * Plugin Name: Real Estate Plugin
 * Description: Adds a new post type "Property" and a taxonomy "Region".
 * Version: 1.0
 * Author: v.vashchenko
 */

// Register new post type "Property"
function create_property_post_type() {
    $labels = array(
        'name'               => 'Properties',
        'singular_name'      => 'Property',
        'menu_name'          => 'Property',
        'name_admin_bar'     => 'Property',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Property',
        'new_item'           => 'New Property',
        'edit_item'          => 'Edit Property',
        'view_item'          => 'View Property',
        'all_items'          => 'All Properties',
        'search_items'       => 'Search Properties',
        'not_found'          => 'No properties found.',
        'not_found_in_trash' => 'No properties found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'property' ),
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array( 'title', 'custom-fields' ),
        'menu_icon' => 'dashicons-admin-home',
    );

    register_post_type( 'property', $args );
}

// Register new taxonomy "Region"
function create_region_taxonomy() {
    $labels = array(
        'name'              => 'Regions',
        'singular_name'     => 'Region',
        'search_items'      => 'Search Regions',
        'all_items'         => 'All Regions',
        'parent_item'       => 'Parent Region',
        'parent_item_colon' => 'Parent Region:',
        'edit_item'         => 'Edit Region',
        'update_item'       => 'Update Region',
        'add_new_item'      => 'Add New Region',
        'new_item_name'     => 'New Region Name',
        'menu_name'         => 'Regions',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'region' ),
    );

    register_taxonomy( 'region', array( 'property' ), $args );
}

// Hooks to register the post type and taxonomy
add_action( 'init', 'create_property_post_type' );
add_action( 'init', 'create_region_taxonomy' );


// Shortcode for displaying property and premises filter
function property_filter_shortcode() {
    ob_start();

    // Получаем все возможные значения для полей ACF
    $name_field = acf_get_field('re_name');
    $coordinates_field = acf_get_field('re_сoordinates');
    $floors_field = acf_get_field('re_number_of_floors');
    $floors_field = acf_get_field('re_number_of_floors');
    $building_type_field = acf_get_field('re_type_of_building');
    $eco_friendly_field = acf_get_field('re_eco_friendliness');
    
    // Получаем возможные значения для помещений
    $rooms_field = acf_get_field('re_number_of_rooms');
    $balcony_field = acf_get_field('re_balcony');
    $bathroom_field = acf_get_field('re_bathroom');
    $area_field = acf_get_field('re_area');
    ?>

    <div class="form-overlay">
        <div class="form-wrapper">

            <form id="property-filter" class="d-flex flex-row flex-wrap justify-content-center">
                <div class="d-flex flex-row align-items-center form-block1">
                    <!-- Поля для фильтрации объектов -->
                    <div class="filter_h"><?php _e('Properties:') ?></div>
                    <input type="text" name="re_name" placeholder="<?php echo $name_field['label'] ?>">
                    <input type="text" name="re_coordinates" placeholder="<?php echo $coordinates_field['label'] ?>">
                    <select name="re_number_of_floors">
                        <option value=""><?php echo $floors_field['label'] ?></option>
                        <?php if ($floors_field && !empty($floors_field['choices'])): ?>
                            <?php foreach ($floors_field['choices'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <select name="re_type_of_building">
                        <option value=""><?php echo $building_type_field['label'] ?></option>
                        <?php if ($building_type_field && !empty($building_type_field['choices'])): ?>
                            <?php foreach ($building_type_field['choices'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <select name="re_eco_friendliness">
                        <option value=""><?php echo $eco_friendly_field['label'] ?></option>
                        <?php if ($eco_friendly_field && !empty($eco_friendly_field['choices'])): ?>
                            <?php foreach ($eco_friendly_field['choices'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="d-flex flex-row form-block2">


                    <!-- Поля для фильтрации помещений -->
                    <div class="filter_h"><?php _e('Premises:') ?></div>
                    <input type="number" name="re_area" placeholder="<?php echo $area_field['label'] ?>">

                    <select name="re_number_of_rooms">
                        <option value=""><?php echo $rooms_field['label'] ?></option>
                        <?php if ($rooms_field && !empty($rooms_field['choices'])): ?>
                            <?php foreach ($rooms_field['choices'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <select name="re_balcony">
                        <option value=""><?php echo $balcony_field['label'] ?></option>
                        <?php if ($balcony_field && !empty($balcony_field['choices'])): ?>
                            <?php foreach ($balcony_field['choices'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <select name="re_bathroom">
                        <option value=""><?php echo $bathroom_field['label'] ?></option>
                        <?php if ($bathroom_field && !empty($bathroom_field['choices'])): ?>
                            <?php foreach ($bathroom_field['choices'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <button type="submit"><?php _e('Filter') ?></button>
                </div>
            </form>
            </div>
    </div>

    <div id="property-results"></div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        let currentPage = 1;
        $('#property-filter').on('submit', function(e) {
            e.preventDefault();
            $('#loading-overlay').show();
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'GET',
                data: $(this).serialize() + '&action=filter_properties&page=' + currentPage,
                success: function(response) {
                    $('#property-results').html(response);
                },
                complete: function() {
                    $('#loading-overlay').hide();
                }
            });
        });

        $(document).on('click', '.pagination-link', function(e) {
            e.preventDefault();
            currentPage = $(this).data('page'); 
            $('#property-filter').submit(); 
        });
    });

    
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode( 'property_filter', 'property_filter_shortcode' );


function filter_properties() {
    $paged = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $posts_per_page = 5; 
    $premises_to_display = [];

    // Получаем параметры фильтра из запроса
    $property_filter = [];
    $premises_filter = [];

    // Checking and adding conditions for filtering real estate objects
    if (!empty($_GET['re_name'])) {
        $property_filter[] = array(
            'key' => 're_name',
            'value' => sanitize_text_field($_GET['re_name']),
            'compare' => 'LIKE'
        );
    }
    if (!empty($_GET['re_number_of_floors'])) {
        $property_filter[] = array(
            'key' => 're_number_of_floors',
            'value' => sanitize_text_field($_GET['re_number_of_floors']),
            'compare' => '='
        );
    }
    if (!empty($_GET['re_type_of_building'])) {
        $property_filter[] = array(
            'key' => 're_type_of_building',
            'value' => sanitize_text_field($_GET['re_type_of_building']),
            'compare' => '='
        );
    }

    if (!empty($_GET['re_eco_friendliness'])) {
        $property_filter[] = array(
            'key' => 're_eco_friendliness',
            'value' => sanitize_text_field($_GET['re_eco_friendliness']),
            'compare' => '='
        );
    }

    // Checking and adding filter conditions for rooms (repeaters)
    if (!empty($_GET['re_area'])) {
        $premises_filter['re_area'] = sanitize_text_field($_GET['re_area']);
    }
    if (!empty($_GET['re_number_of_rooms'])) {
        $premises_filter['re_number_of_rooms'] = sanitize_text_field($_GET['re_number_of_rooms']);
    }
    if (!empty($_GET['re_balcony'])) {
        $premises_filter['re_balcony'] = sanitize_text_field($_GET['re_balcony']);
    }

    if (!empty($_GET['re_bathroom'])) {
        $premises_filter['re_bathroom'] = sanitize_text_field($_GET['re_bathroom']);
    }

    $property_query = null;
    $premises_query = null;

    // Filtering real estate objects
    if (!empty($property_filter)) {
        $meta_query = array_merge(['relation' => 'AND'], $property_filter);

        $args = array(
            'post_type' => 'property',
            'meta_query' => $meta_query,
            'meta_key' => 're_eco_friendliness',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
        );

        $property_query = new WP_Query($args);
    }

    // Filtration of premises (repeaters)
    if (!empty($premises_filter)) {
        $args = array(
            'post_type' => 'property',
        );

        $premises_query = new WP_Query($args);
    }

    $total_pages = $property_query ? $property_query->max_num_pages : 1;

    // 1. If only object filtering parameters are selected, only objects are displayed
    if (($property_query && $property_query->have_posts()) && (!isset($premises_query))) {
        while ($property_query->have_posts()) {
            $property_query->the_post();

            // Displaying information about an object
            echo '<div class="filter-item d-flex flex-row">';
            echo '<div class="filter-left" style="background-image:url('.get_field('re_image').')"><a href="'. get_permalink() .'"></a></div>';
            echo '<div class="filter-right">';
            echo '<div class="filter-item-title"><a href="'. get_permalink() .'">' . get_field('re_name') . '</a></div>';
            echo '<p><span>Coordinates:</span> ' . get_field('re_сoordinates') . '</p>';
            echo '<p><span>Number of floors:</span> ' . get_field('re_number_of_floors') . '</p>';
            echo '<p><span>Type of building:</span> ' . get_field('re_type_of_building') . '</p>';
            echo '<p><span>Eco friendliness:</span> ' . get_field('re_eco_friendliness') . '</p>';
            echo '</div></div>';
            
        }
        if ($total_pages > 1) {
                echo '<div class="pagination">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="#" class="pagination-link" data-page="' . $i . '">' . $i . '</a>';
                }
                echo '</div>';
            }
        if ($property_query && !$property_query->have_posts()) {
            echo '<p>'. _e('No properties found.') . '</p>';  
        }
    } 
    

    $premises_to_display = []; // Array for storage of suitable premises

    // 2. If only room filtering parameters are selected, only rooms are displayed
    if (($premises_query && $premises_query->have_posts()) && (!isset($property_query))) {
        $found_results = false; // Flag to track the availability of results
        $premises_count = 0;    // Counter of suitable premises

        while ($premises_query->have_posts()) {
            $premises_query->the_post();
            $premises = get_field('re_premises'); // We get a premise repeater

            if (!empty($premises)) {
                foreach ($premises as $premise) {
                    // Checking the compliance of the filter conditions for the premises
                    if (check_premises_filter($premise, $premises_filter)) {
                        $found_results = true;
                        $premises_to_display[] = $premise; // Adding a premise to the array
                    }
                }
            } 
        }

        // We check if there are suitable premises
        if (!$found_results) {
            echo '<p>No properties found!!.</p>';
        } else {
            // Pagination for premises
            $total_premises = count($premises_to_display); // Premises count
            $total_pages = ceil($total_premises / $posts_per_page); // Page count

            // Limiting the premises for the current page
            $offset = ($paged - 1) * $posts_per_page;
            $premises_page = array_slice($premises_to_display, $offset, $posts_per_page);

            // Display premises for current page
            foreach ($premises_page as $premise) {
                echo '<div class="premise filter-item d-flex flex-row">';
                echo '<div class="filter-left" style="background-image:url(' . esc_html($premise['re_premises_image']) . ')"></div>';
                echo '<div class="filter-right">';
                echo '<div class="filter-item-title">' . esc_html($premise['re_area']) . ' sqm, ' . esc_html($premise['re_number_of_rooms']) . ' rooms</div>';
                echo '<p><span>' . __('Balcony: ') . '</span> ' . esc_html($premise['re_balcony']) . '</p>';
                echo '<p><span>' . __('Bathroom: ') . '</span> ' . esc_html($premise['re_bathroom']) . '</p>';
                echo '<a class="premise-btn" href="' . get_permalink(get_the_ID()) . '">' . __('View Property') . '</a>';
                echo '</div></div>';
            }

            // Pagination
            if ($total_pages > 1) {
                echo '<div class="pagination">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="#" class="pagination-link" data-page="' . $i . '">' . $i . '</a>';
                }
                echo '</div>';
            }
        }
    }
    

   // 3. If the filtering parameters for both objects and premises are selected, we display all objects and all premises.
    if ($property_query && $premises_query) {
        $combined_results = []; // Array for combined objects and premises

        // Objects
        if ($property_query->have_posts()) {
            while ($property_query->have_posts()) {
                $property_query->the_post();

                // Adding objects to the merged array
                $combined_results[] = [
                    'type' => 'property',
                    'content' => [
                        'image' => get_field('re_image'),
                        'name' => get_field('re_name'),
                        'coordinates' => get_field('re_сoordinates'),
                        'floors' => get_field('re_number_of_floors'),
                        'building_type' => get_field('re_type_of_building'),
                        'eco_friendliness' => get_field('re_eco_friendliness'),
                        'link' => get_permalink()
                    ]
                ];
            }
        }

        // Premises

        while ($premises_query->have_posts()) {
            $premises_query->the_post();
            $premises = get_field('re_premises'); // We get a premises repeater

            if (!empty($premises)) {
                foreach ($premises as $premise) {
                    // Checking the compliance of the filter conditions for the premises
                    if (check_premises_filter($premise, $premises_filter)) {
                        // Adding premises to the combined array
                        $combined_results[] = [
                            'type' => 'premise',
                            'content' => [
                                'image' => $premise['re_premises_image'],
                                'area' => $premise['re_area'],
                                'rooms' => $premise['re_number_of_rooms'],
                                'balcony' => $premise['re_balcony'],
                                'bathroom' => $premise['re_bathroom'],
                                'link' => get_permalink(get_the_ID())
                            ]
                        ];
                    }
                }
            }
        }

        if (!empty($combined_results)) {
            $total_results = count($combined_results); // Results count
            $total_pages = ceil($total_results / $posts_per_page); // Pages count

            // Limiting results to the current page
            $offset = ($paged - 1) * $posts_per_page;
            $page_results = array_slice($combined_results, $offset, $posts_per_page);

            // Display results for the current page
            foreach ($page_results as $result) {
                if ($result['type'] === 'property') {
                    // Display object
                    echo '<div class="filter-item d-flex flex-row">';
                    echo '<div class="filter-left" style="background-image:url(' . esc_html($result['content']['image']) . ')"><a href="' . esc_html($result['content']['link']) . '"></a></div>';
                    echo '<div class="filter-right">';
                    echo '<div class="filter-item-title"><a href="' . esc_html($result['content']['link']) . '">' . esc_html($result['content']['name']) . '</a></div>';
                    echo '<p><span>Coordinates:</span> ' . esc_html($result['content']['coordinates']) . '</p>';
                    echo '<p><span>Number of floors:</span> ' . esc_html($result['content']['floors']) . '</p>';
                    echo '<p><span>Type of building:</span> ' . esc_html($result['content']['building_type']) . '</p>';
                    echo '<p><span>Eco friendliness:</span> ' . esc_html($result['content']['eco_friendliness']) . '</p>';
                    echo '</div></div>';
                } elseif ($result['type'] === 'premise') {
                    // Dispay premises
                    echo '<div class="premise filter-item d-flex flex-row">';
                    echo '<div class="filter-left" style="background-image:url(' . esc_html($result['content']['image']) . ')"></div>';
                    echo '<div class="filter-right">';
                    echo '<div class="filter-item-title">' . esc_html($result['content']['area']) . ' sqm, ' . esc_html($result['content']['rooms']) . ' rooms</div>';
                    echo '<p><span>' . __('Balcony: ') . '</span> ' . esc_html($result['content']['balcony']) . '</p>';
                    echo '<p><span>' . __('Bathroom: ') . '</span> ' . esc_html($result['content']['bathroom']) . '</p>';
                    echo '<a class="premise-btn" href="' . esc_html($result['content']['link']) . '">' . __('View Property') . '</a>';
                    echo '</div></div>';
                }
            }

            // Pagination
            if ($total_pages > 1) {
                echo '<div class="pagination">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="#" class="pagination-link" data-page="' . $i . '">' . $i . '</a>';
                }
                echo '</div>';
            } 
        } else {            
            echo '<p>' . __('No properties found.2') . '</p>';
        }
    }


    // Reset post data
    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_filter_properties', 'filter_properties');
add_action('wp_ajax_nopriv_filter_properties', 'filter_properties');



// Auxiliary function for filtering premises
function check_premises_filter($premise, $premises_filter) {
    foreach ($premises_filter as $key => $value) {
        if ($premise[$key] != $value) {
            return false;
        }
    }
    return true;
}


class Property_Filter_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'property_filter_widget', 
            'Property Filter', 
            array('description' => 'Filter properties')
        );
    }

    public function widget($args, $instance) {
        echo do_shortcode('[property_filter]');
    }
}

function register_property_filter_widget() {
    register_widget('Property_Filter_Widget');
}
add_action('widgets_init', 'register_property_filter_widget');
