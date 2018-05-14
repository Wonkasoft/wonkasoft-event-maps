<?php
/**
* The admin-specific functionality of the plugin.
* This is used to build settings.
*
* @link       https://wonkasoft.com
* @since      1.0.0
*
* @package    Wonkasoft_Event_Maps
* @subpackage wonkasoft-event-maps/admin/partials
*/
/**
 * This creates settings area that is displayed on options page
**/
add_settings_section( 
	'wonkasoft_event_maps_selected_posttype', 
	'For Selected Post Type', 
	null, 
	'wonkasoft_event_maps_admin_display'
);
/**
 * This creates settings field that is displayed on options page
 */
add_settings_field(
	'wonkasoft_selected_post_type',
	'Selected Post Type',
	'wem_selected_post_type_selector',
	'wonkasoft_event_maps_admin_display',
	'wonkasoft_event_maps_selected_posttype'
);

register_setting( 'wem_setting_post_type_group', 'wem_event_post_type' );

function wem_selected_post_type_selector() {
	$post_types = get_post_types();
	$core_types_to_remove = array(
		'post',
		'page',
		'attachment',
		'revision',
		'nav_menu_item',
		'custom_css',
		'customize_changeset',
		'oembed_cache' );
	foreach ( $core_types_to_remove as $key => $value) {
		unset( $post_types[$value] );
	}

	if ( $post_types ) {
		echo '<select name="post_type_selector">';
			     echo '<option value="'.selected(get_option('wem_setting_group'), 'qscutter').'">'.get_option("wem_setting_group").'</option>';
		foreach ($post_types as $key => $value) {
			     echo '<option value="'.$value.'">'.$value.'</option>';
		}
			   echo '</select>';
	}
}