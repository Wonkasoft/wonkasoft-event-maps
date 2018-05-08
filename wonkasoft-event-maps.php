<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wonkasoft.com
 * @since             1.0.0
 * @package           Wonkasoft_Event_Maps
 *
 * @wordpress-plugin
 * Plugin Name:       Wonkasoft Event Maps
 * Plugin URI:        https://wonkasoft.com/wonkasoft-event-maps
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Wonkasoft
 * Author URI:        https://wonkasoft.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wonkasoft-event-maps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WONKASOFT_EVENT_MAPS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WONKASOFT_EVENT_MAPS_NAME', plugin_basename( dirname( __FILE__ ) ) );
define( 'WONKASOFT_EVENT_MAPS_BASENAME', plugin_basename( __FILE__ ) );
define( 'WONKASOFT_EVENT_MAPS_IMG_PATH', plugins_url( WONKASOFT_EVENT_MAPS_NAME . '/admin/img' ) );
define( 'WONKASOFT_EVENT_MAPS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wonkasoft-event-maps-activator.php
 */
function activate_wonkasoft_event_maps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wonkasoft-event-maps-activator.php';
	Wonkasoft_Event_Maps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wonkasoft-event-maps-deactivator.php
 */
function deactivate_wonkasoft_event_maps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wonkasoft-event-maps-deactivator.php';
	Wonkasoft_Event_Maps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wonkasoft_event_maps' );
register_deactivation_hook( __FILE__, 'deactivate_wonkasoft_event_maps' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wonkasoft-event-maps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wonkasoft_event_maps() {

	$plugin = new Wonkasoft_Event_Maps();
	$plugin->run();

}
run_wonkasoft_event_maps();
