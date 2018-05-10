<?php
/**
 * The core plugin class.
 *
 * This is used to build slider and shortcodes.
 *
 * @since      1.0.1
 * @package    Wonka_Slide
 * @subpackage wonka-slide/inc
 * @author     Wonkasoft <info@wonkasoft.com>
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function wonkasoft_event_maps_shortcode( $atts ) {

	global $post;
	$args = array(
		'post_type' => 'page',
	);
	$post_types = get_post_types();
	// var_dump($post_types);
	// var_dump( get_posts($args) );
	$output = '';
	$atts = shortcode_atts( array(
		'id' => 'wonkasoft-event-maps-main',
		'event_count' => '3',
		'container_class' => 'wonkasoft-event-maps-container',
		'list_class' => 'wonkasoft-event-maps-list',
		'item_class' => 'wonkasoft-event-maps-item',
		'map_class' => 'wonkasoft-event-maps-map',
	), $atts );

		$output .= '<div id="map"></div>';
	
		ob_start();

		$output .= ob_get_clean();

		return $output;

}
add_shortcode( 'wonkasoft-event-maps', 'wonkasoft_event_maps_shortcode', 30, 1);