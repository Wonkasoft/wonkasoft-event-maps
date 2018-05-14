<?php
/**
 * The core plugin class.
 *
 * This is used to build slider and shortcodes.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 * @package    Wonkasoft_Event_Maps
 * @subpackage Wonkasoft_Event_Maps/admin/partials
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function wonkasoft_event_maps_shortcode( $atts ) {

	global $post;
  $selected_post_type = ( get_option('wem_event_post_type') ) ? esc_attr(get_option( 'wem_event_post_type' ) ) : 'no post type selected';
  $selected_post_type_check = false;
  if ( $selected_post_type == 'no post type selected') :
    
    $output = $selected_post_type;
    return $output;

  else :

    $args = array(
      'post_type' => $selected_post_type,
    );
    $grab_events = get_posts( $args );
    foreach ($grab_events as $event) :
      $event_meta_data = get_post_meta( $event->ID );
      if ( get_post_meta($event->ID)['venue_lat'][0] ) {
        $selected_post_type_check = true;
      }
    endforeach;
  endif;

  if ( $selected_post_type_check ) :
	
  $args = array(
		'post_type' => $selected_post_type,
	);
	$post_types = get_post_types();
	$grab_events = get_posts( $args );
	$locations = array();
	foreach ($grab_events as $event) :
		array_push( $locations, array( "event_title" => get_post($event->ID)->post_title, "map_to_link" => get_permalink( $event->ID ), "lat" => get_post_meta($event->ID)['venue_lat'][0], "lng" => get_post_meta($event->ID)['venue_lon'][0] ) );
	endforeach;
	$output = '';
	$atts = shortcode_atts( array(
		'id' => 'wonkasoft-event-maps-main',
		'event_count' => '3',
		'container_class' => 'wonkasoft-event-maps-container',
		'list_class' => 'wonkasoft-event-maps-list',
		'item_class' => 'wonkasoft-event-maps-item',
		'map_class' => 'wonkasoft-event-maps-map',
	), $atts );

		ob_start();
		
		$output .= '<div id="map" class="map-size"></div>';
    $output .= '<script>';
    	$output .= 'var map, infoWindow, eventWindow;';
      $output .= 'function initMap() {';

        $output .= "var map = new google.maps.Map(document.getElementById('map'), {";
        $output .= '  zoom: 4,';
        $output .=   'center: {lat: 38.847621, lng: -99.1631212}';
        $output .= '});';

        // Create an array of alphabetical characters used to label the markers.
        $output .= "var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';";

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
      if ( !empty ( $locations ) ) :
        $output .= 'var markers = locations.map(function(location, i) {';
      		$output .= 'eventWindow = new google.maps.InfoWindow({ maxWidth: 200 });';
          $output .= 'event = new google.maps.Marker({';
          $output .= "position: location['locate'],";
          $output .= 'label: labels[i % labels.length],';
          $output .= 'map: map,';
          $output .= "title: 'Get Event Title'";
          $output .= '});';
        	$output .= 'event.addListener( "click", function() { infoWindow.close(); eventWindow.open(map, this, eventWindow.setContent( "<strong>Event Name</strong>: <br />" + location["e_title"] + "<br /><a href=" + location["link"] + ">Show Event Details</a>") ); });';
        	$output .= '});';

          endif;
          $output .= 'map.addListener( "click", function() { eventWindow.close(); });';
          $output .= 'infoWindow = new google.maps.InfoWindow;';
          
        // Try HTML5 geolocation.
        $output .= 'if (navigator.geolocation) {';
          $output .= 'navigator.geolocation.getCurrentPosition(function(position) {';
            $output .= 'var pos = {';
              $output .= 'lat: position.coords.latitude,';
              $output .= 'lng: position.coords.longitude';
            $output .= '};';

            $output .= 'infoWindow.setPosition(pos);';
            $output .= "infoWindow.setContent('You are here.');";
            $output .= 'infoWindow.open(map);';
            $output .= 'map.setCenter(pos);';
            $output .= 'map.setZoom(9);';
          $output .= '}, function() {';
            $output .= 'handleLocationError(true, infoWindow, map.getCenter());';
          $output .= '});';
        $output .= '} else {';
          // Browser doesn't support Geolocation
          $output .= 'handleLocationError(false, infoWindow, map.getCenter());';
      $output .= '}';
      $output .= '}';
      if ( !empty ( $locations ) ) :
      $output .= 'var locations = [';
      foreach ($locations as $location ):
      	if ( $location == end( $locations ) ) :
      		$output .= '{ e_title: "' . $location["event_title"] . '",';
      		$output .= 'link: "' . $location["map_to_link"] . '",';
      		$output .= 'locate: {lat: ' . $location["lat"] . ', lng: ' . $location["lng"] . '}';
      		$output .= '}';
      	else :
        	$output .= '{ e_title: "' . $location["event_title"] . '",';
        	$output .= 'link: "' . $location["map_to_link"] . '",';
      		$output .= 'locate: {lat: ' . $location["lat"] . ', lng: ' . $location["lng"] . '}';
      		$output .= '},';
      	endif;
      endforeach;
      $output .= '];';
      endif;
      $output .= "function handleLocationError(browserHasGeolocation, infoWindow, pos) {
              infoWindow.setPosition(pos);
              infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
              infoWindow.open(map);
            }";
      
    $output .= '</script>';
    $output .= '<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmfppUilFLzZB_rGxkx29qp3tWroStsq8&callback=initMap">
        </script>';

		$output .= ob_get_clean();

		return $output;
endif;
}
add_shortcode( 'wonkasoft-event-maps', 'wonkasoft_event_maps_shortcode', 30, 1);


function wonkasoft_event_maps_search_shortcode( $atts ) {

  $output = '';
  $atts = shortcode_atts( array(
    'id' => 'wonkasoft-event-maps-search',
    'container_class' => 'wonkasoft-event-search-container',
    'list_class' => 'wonkasoft-event-search-list',
    'item_class' => 'wonkasoft-event-search-item',
  ), $atts );

  ob_start();
    $output .= '<form role="search" method="get" id="wem-search-form" class="searchform" action="' . home_url( '/' ) . '" >';
    $output .= '<div><label class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>';
    $output .= '<input type="text" value="' . get_search_query() . '" name="s" id="s" />';
    $output .= '<input type="hidden" value="'.get_option( 'wem_event_post_type' ).'" name="post_type" id="post_type" />';
    $output .= '<input type="submit" id="wem-search-submit" value="'. esc_attr__( 'Search' ) .'" />';
    $output .= '</div>';
    $output .= '</form>';

  $output .= ob_get_clean();

  return $output;
}

add_shortcode( 'wonkasoft-event-maps-search', 'wonkasoft_event_maps_search_shortcode', 31, 1);
