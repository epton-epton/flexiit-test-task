<?php
/**
* Template Name: Test
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

get_header();

echo '000';

// Получаем объект поля ACF
$type_of_building_field = acf_get_field('re_type_of_building');

if ($type_of_building_field) {
    echo '<pre>';
    print_r($type_of_building_field); // Выводим объект поля для просмотра
    echo '</pre>';
} else {
    echo 'Поле не найдено.';
}




get_footer(); ?>