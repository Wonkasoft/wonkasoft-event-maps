<?php

/**
 * The file that builds the plugin menu
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 *
 * @package    Wonkasoft_Event_Maps
 * @subpackage Wonkasoft_Event_Maps/includes
 */

/**
* This will check for Wonkasoft Tools Menu, if not found it will make it.
*/
if ( empty ( $GLOBALS['admin_page_hooks']['wonkasoft_menu'] ) ) {

global $wonkasoft_event_maps_page;
$wonkasoft_event_maps_page = 'wonkasoft_menu';
add_menu_page(
'Wonkasoft',
'Wonkasoft Tools',
'manage_options',
'wonkasoft_menu',
array( $this,'wonkasoft_event_maps_admin' ),
plugins_url( "/img/wonka-logo-2.svg", __FILE__ ),
100
);

add_submenu_page(
'wonkasoft_menu',
'Wonkasoft Event Maps',
'Wonkasoft Event Maps',
'manage_options',
'wonkasoft_menu',
array( $this,'wonkasoft_event_maps_admin' )
);

} else {

/**
* This creates option page in the settings tab of admin menu
*/
global $wonkasoft_event_maps_page;
$wonkasoft_event_maps_page = 'wonkasoft_event_maps_settings_display';
add_submenu_page(
'wonkasoft_menu',
'Wonkasoft Event Maps',
'Wonkasoft Event Maps',
'manage_options',
'wonkasoft_event_maps_settings_display',
array( $this,'wonkasoft_event_maps_admin' )
);

}