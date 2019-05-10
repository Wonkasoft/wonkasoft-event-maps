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
	'Select Custom Post Type', 
	null, 
	'wonkasoft_event_maps_admin_display'
);
/**
 * This creates settings field that is displayed on options page
 */
add_settings_field(
	'wem_event_post_type',
	'Select Post Type',
	'wem_event_post_type',
	'wonkasoft_event_maps_admin_display',
	'wonkasoft_event_maps_selected_posttype'
);

register_setting( 
	'wem_setting_group', 
	'wem_event_post_type' 
);

/**
 * This creates settings area that is displayed on options page
**/
add_settings_section( 
	'wonkasoft_event_maps_google_api', 
	'Add Google API', 
	null, 
	'wonkasoft_event_maps_admin_display'
);
/**
 * This creates settings field that is displayed on options page
 */
add_settings_field(
	'ws_google_api',
	'Add Google API',
	'ws_google_api',
	'wonkasoft_event_maps_admin_display',
	'wonkasoft_event_maps_google_api'
);

register_setting( 
	'wem_setting_group', 
	'wonkasoft_event_maps_google_api' 
);

function ws_google_api() {
	$ws_google_api_option = ( get_option( 'ws_google_api' ) ) ? esc_attr( get_option( 'ws_google_api' ) ) : '';
	$output =  '<label for="GoogleAPI">Google API</label><input type="text" class="form-control" id="google_api" placeholder="GoogleAPI" value="'.$ws_google_api_option.'">';
	echo $output;
}

function wem_event_post_type( $args ) {
	$wem_event_post_type_option = ( get_option( 'wem_event_post_type' ) ) ? esc_attr( get_option( 'wem_event_post_type' ) ) : '';

	$dropdown_args = array(
				'depth' => 0,
				'selected' => $wem_event_post_type_option,
				'name' => 'wem_event_post_type',
				'id' => 'wem_event_post_type',
				'class' => 'wem-post-type-select',
				'show_option_none' => 'Select a custom post type',
				'option_none_value' => '',
			);

	wem_dropdown_post_types( $dropdown_args );
}

function wem_dropdown_post_types( $args = '' ) {
	
	$defaults = array(
		'depth' => 0,
		'selected' => 0,
		'echo' => 1,
		'name' => 'post_type_id',
		'id' => '',
		'class' => '',
		'show_option_none' => '',
		'show_option_no_change' => '',
		'option_none_value' => '',
		'value_field' => 'ID',
	);

	$r = wp_parse_args( $args, $defaults );
	$custom_post_types = get_post_types();

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
		unset( $custom_post_types[$value] );
	}

	$output = '';

	if ( empty( $r['id']) ) {
		$r['id'] = $r['name'];
	}

	if ( ! empty( $custom_post_types ) ) {
		$class = '';
		if ( ! empty( $r['class'] ) ) {
			$class = " class='" . esc_attr( $r['class'] ) . "'";
		}

		$output = "<select name='" . esc_attr( $r['name'] ) . "'" . $class . " id='" . esc_attr( $r['id'] ) . "'>\n";
		if ( $r['show_option_no_change'] ) { 
			$output .= "\t<option value=\"-1\">" . esc_attr( $r["show_option_no_change"] ) . "</option>\n";
		}
		if ( $r["show_option_none"] ) {
			$output .= "\t<option value=\"" . esc_attr( $r["option_none_value"] ) . '">' . $r["show_option_none"] . "</option>\n";
		}
		foreach ($custom_post_types as $name_type => $post_type) {
			$output .= sprintf("\t".'<option value="%s" %s>%s</option>'."\n",
								esc_attr($name_type),
								selected($r['selected'], $name_type, false),
								$post_type
							);
		}
		$output .= "</select>\n";
	}

	$html = apply_filters( 'wem_dropdown_post_types', $output, $r, $custom_post_types );

	if ( $r['echo'] ) {
		echo $html;
	}
	return $html;

}