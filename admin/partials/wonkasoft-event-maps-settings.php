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

function wem_event_post_type( $args ) {
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

	if ( $post_types ) :
		$wem_event_post_type_option = ( get_option( 'wem_event_post_type' ) ) ? esc_attr( get_option( 'wem_event_post_type' ) ) : 'Select a custom post type';
		?>
			<select name="wem_event_post_type" id="wem_event_post_type">
		<?php
		if ( $wem_event_post_type_option !== 'Select a custom post type' ) :
			?>
				<option value="">Disable</option>
				<option value="<?php echo $wem_event_post_type_option; ?>" selected><?php echo $wem_event_post_type_option; ?></option>
			<?php
		elseif ( $post_types ) : 
			?>
				<option value="<?php echo $wem_event_post_type_option; ?>"><?php echo $wem_event_post_type_option; ?></option>
			<?php
			/**
			 * [$key all custom post types]
			 * @var [custom post types]
			 */
			foreach ( $post_types as $key => $value ) {
				echo '<option value="'.$value.'">'.$value.'</option>';
			}
		endif;
	else :
		?>
			<option value="no-custom-post-types">No Custom Post Types</option>
	    <?php
	endif;
	?>
	    </select>
	<?php
}