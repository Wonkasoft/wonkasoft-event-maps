<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 *
 * @package    Wonkasoft_Event_Maps
 * @subpackage Wonkasoft_Event_Maps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wonkasoft_Event_Maps
 * @subpackage Wonkasoft_Event_Maps/admin
 * @author     Wonkasoft <support@wonkasoft.com>
 */
class Wonkasoft_Event_Maps_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $page ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wonkasoft_Event_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wonkasoft_Event_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$style = 'bootstrap';
		if( ! wp_style_is( $style, 'enqueued' ) &&  ! wp_style_is( $style, 'done' ) ) {
			// Check page to load bootstrapjs only on settings page
			if ( $page == 'wonkasoft-tools_page_wonkasoft_event_maps_settings_display' ) {
	    	// Enqueue bootstrap CSS
			wp_enqueue_style( $style, str_replace( array( 'http:', 'https:' ), '', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css'), array(), '4.0.0', 'all');
			}
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wonkasoft-event-maps-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $page ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wonkasoft_Event_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wonkasoft_Event_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		// Check to see if bootstrap js is already enqueue before setting the enqueue
		$bootstrapjs = 'bootstrap-js';
		if ( ! wp_script_is( $bootstrapjs, 'enqueued' ) && ! wp_script_is($bootstrapjs, 'done' ) ) {
			// Check page to load bootstrapjs only on settings page
		 	if ( $page == 'wonkasoft-tools_page_wonkasoft_event_maps_settings_display' ) {
			 	// Enqueue bootstrap js
				wp_enqueue_script( $bootstrapjs, str_replace( array( 'http:', 'https:' ), '', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js' ), array( 'jquery' ), '4.0.0', true );
		 	}
		} 

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wonkasoft-event-maps-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Builds the Admin menu for the plugin
	public function wonkasoft_event_maps_admin_menu() {
		include plugin_dir_path( __FILE__ ) . 'partials/wonkasoft-event-maps-admin-menu.php';
	}

	/**
	 * [wonkasoft_event_maps_add_action_links This adds the action links in the plugin area of the dashboard]
	 *
	 * @since 1.0.0 [<Adding of action links>]
	 */
	public function wonkasoft_event_maps_add_action_links() {
		include plugin_dir_path( __FILE__ ) . 'partials/wonkasoft-event-maps-add-action-links.php';
	}

	/**
	 * [wonkasoft_event_maps_admin The adds the admin display page]
	 *
	 * @since 1.0.0 [<Adds the admin page for the plugin settings>]
	 */
	public function wonkasoft_event_maps_admin_display() {
		include plugin_dir_path( __FILE__ ) . 'partials/wonkasoft-event-maps-admin-display.php';
	}

}
