<?php
/**
* The Class of custom fields for the custom post types of Gift Recorder.
*
* @link       https://wonkasoft.com
* @since      1.0.0
*
* @package    Gift_Recorder
* @subpackage Gift_Recorder/admin
*/
if ( !class_exists('WONKASOFT_EVENT_MAPS') ) :
	class WONKASOFT_EVENT_MAPS {
/**
* The prefix for these fields.
*
* @since    1.0.0
* @access   private
* @var      string    $wem_prefix    The prefix for these fields.
*/
private $wem_prefix;

/**
* The custom post type of this plugin.
*
* @since    1.0.0
* @access   private
* @var      string    $grec_post_type    The custom post type of this plugin.
*/
private $wem_post_types;

/**
* The version of this plugin.
*
* @since    1.0.0
* @access   private
* @var      string    $grec_post_type    The custom post type of this plugin.
*/
private $wem_fields = array( 
	array(
		"name"          => "post_type_selection",
		"title"         => "Post Type Selection",
		"description"   => "",
		"type"          => "selector",
		"scope"         => array( 'page' ),
		"capability"    => "edit_post",
	)
);

/**
* Initialize the class and set its properties.
*
* @since    1.0.0
*/
public function __construct() {

	$this->wem_prefix = '_wem_';
	$this->wem_post_types = get_post_types();

	add_action( 'admin_menu', array( &$this, 'create_wem_fields') );
	add_action( 'save_post', array( &$this, 'wem_post_type_select_save_data'), 10, 2 );
}

public function create_wem_fields() {
	var_dump('test1');
	if ( function_exists( 'add_meta_box' ) ) :
		var_dump('test inside');
			add_meta_box( 'wem-field', __( 'Wonkasoft Event Maps Selection', 'text_domain' ), array( $this, 'wonkasoft_event_maps_Meta_Box_layouts' ), 'wonkasoft_event_maps_settings_display', 'normal', 'high' );
	endif;
} // end create_wem_fields

public function wonkasoft_event_maps_Meta_Box_layouts() {
	global $post;
	?>
	<div class="form-wrap">
		<?php wp_nonce_field( 'wem-fields', 'wem-fields_wpnonce', false, true );
		foreach ( $this->$wem_fields as $wem_field ) :
			// Check Scope
			$scope = $wem_field['scope'];
			$output = false;
			foreach ( $scope as $scopeItem ) :
				switch ( $scopeItem ) {
					default: {
						if ( $post->post_type == $scopeItem )
							$output = true;
						break;
					}
				}
				if ( $output ) break;
			endforeach;
			// Check capability
			if ( !current_user_can( $wem_field['capability'], $post->ID ) ) :
				$output = false;
			endif;
			// Output if allowed
			if ( $output ) : ?>
				<div class="form-field form-required">
					<?php
					switch ( $wem_field[ 'type' ] ) {
						
							default: {
								$args = array(
									'post_type' => $wem_field[ 'scope' ]
								);
								// Post Type Selection Field
								echo '<label for="' . $this->wem_prefix . $wem_field[ 'name' ] .'"><h3>' . $wem_field[ 'title' ] . '</h3></label>';
								echo wp_dropdown_pages( $args );
								break;
							}
						}
						?>
						<?php if ( $wem_field[ 'description' ] ) echo '<p>' . $wem_field[ 'description' ] . '</p>'; ?>
					</div>
					<?php
				endif;
			endforeach;
			?>	
		</div>
		<?php
		return;
} // end Gift_Rec_Member_Meta_Box_layouts

public function wem_post_type_select_save_data( $post_id, $post ) {
	if ( !isset( $_POST[ 'wem-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'wem-fields_wpnonce' ], 'wem-fields' ) )
		return;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	if ( ! in_array( $post->post_type, $this->grec_post_types ) )
		return;
	foreach ( $this->wem_fields as $wem_field ) :
		if ( current_user_can( $wem_field['capability'], $post_id ) ) :
			if ( isset( $_POST[ $this->wem_prefix . $wem_field['name'] ] ) && trim( $_POST[ $this->wem_prefix . $wem_field['name'] ] ) ) :
				$value = $_POST[ $this->wem_prefix . $wem_field['name'] ];
// Auto-paragraphs for any WYSIWYG
			if ( $wem_field['type'] == "wysiwyg" ) $value = wpautop( $value );

			update_post_meta( $post_id, $this->wem_prefix . $wem_field[ 'name' ], $_POST[ $this->wem_prefix . $wem_field['name'] ] );

			if ( $wem_field[ 'name' ] == 'post_full_name' ) :
				$custom_post_update = array(
					'ID' => $post_id,
					'post_title' => htmlspecialchars( get_post_meta( $post->ID, $this->wem_prefix . $wem_field[ 'name' ], true ) ),
					'post_name' => sanitize_title( htmlspecialchars( get_post_meta( $post->ID, $this->wem_prefix . $wem_field[ 'name' ], true ) ) ),
				);

				remove_action( 'save_post', array( &$this, 'post_type_save_data'), 10, 2 );

				wp_update_post( $custom_post_update );

				add_action( 'save_post', array( &$this, 'post_type_save_data'), 10, 2 );
			endif;

		else :
			delete_post_meta( $post_id, $this->wem_prefix . $wem_field[ 'name' ] );
		endif;
	endif;
endforeach;

return;
} // end post_type_save_data
} // end class GIFT_REC_FIELDS
endif; // End if class exists statement

if ( class_exists( 'WONKASOFT_EVENT_MAPS' ) ) {
	$wem_field_object = new WONKASOFT_EVENT_MAPS();
}