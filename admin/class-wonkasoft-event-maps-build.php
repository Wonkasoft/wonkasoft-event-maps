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
		'post_type' => 'eventbrite_events',
	);
	$post_types = get_post_types();
	$grab_events = get_posts( $args );
	$locations = array();
	foreach ($grab_events as $event) :
		array_push( $locations, array( "map_to_link" => get_permalink( $event->ID ), "lat" => get_post_meta($event->ID)['venue_lat'][0], "lng" => get_post_meta($event->ID)['venue_lon'][0] ) );
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
    	$output .= 'var map, infoWindow;';
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
          $output .= 'event = new google.maps.Marker({';
            $output .= "position: location['locate'],";
            $output .= 'label: labels[i % labels.length],';
            $output .= 'map: map,';
            $output .= "title: 'Get Event Info'";
          $output .= '});';
        $output .= '});';

        // Add a marker clusterer to manage the markers.
        $output .= 'var markerCluster = new MarkerClusterer(map, markers,';
            $output .= "{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});";
          endif;
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
      		$output .= '{ link: "' . $location["map_to_link"] . '",';
        		$output .= 'locate: {lat: ' . $location["lat"] . ', lng: ' . $location["lng"] . '}';
      		$output .= '}';
      	else :
        	$output .= '{ link: "' . $location["map_to_link"] . '",';
        		$output .= 'locate: {lat: ' . $location["lat"] . ', lng: ' . $location["lng"] . '}';
      		$output .= '},';
      	endif;
      endforeach;
      $output .= '];';
      endif;
      $output .= "function handleLocationError(browserHasGeolocation, infoWindow, pos) {
              infoWindow.setPosition(pos);
              infoWindow.setContent(browserHasGeolocation ?
                                    'Error: The Geolocation service failed.' :
                                    'Error: Your browser doesn\'t support geolocation.');
              infoWindow.open(map);
            }";
      $output .= "var layer = new google.maps.FusionTablesLayer({
                            query: {
                              select: 'address',
                              from: '1d7qpn60tAvG4LEg4jvClZbc1ggp8fIGGvpMGzA',
                              where: 'ridership > 5000'
                            }
                          });
                          layer.setMap(map);";
    $output .= '</script>';
    $output .= '<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">';
    $output .= '</script>';
    $output .= '<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmfppUilFLzZB_rGxkx29qp3tWroStsq8&callback=initMap">
        </script>';

		$output .= ob_get_clean();

		return $output;
}
add_shortcode( 'wonkasoft-event-maps', 'wonkasoft_event_maps_shortcode', 30, 1);