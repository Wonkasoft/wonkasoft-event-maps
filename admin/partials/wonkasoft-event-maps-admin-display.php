<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 * @package    Wonkasoft_Event_Maps
 * @subpackage Wonkasoft_Event_Maps/admin/partials
 */
?>

<div class="wem-settings-wrap">
	<div class="container-fluid">
		<div class="row">
			<div class="col-8 panel">
				<div class="row headings">
					<div class="col-2 logo-area">
						<img src="<?php echo plugins_url( "../img/WEM-logo.svg", __FILE__ ); ?>">
					</div> <!-- /col-4 -->
					<div class="col-6 title-area">
						<h1 class="title-text"><?php echo WONKASOFT_EVENT_MAPS_NAME; ?></h1>
					</div> <!-- /col-4 -->
				</div> <!-- /row -->
				<hr />
				<div class="row content-area">
					<div class="col-8">
						<h2>Documentation for Wonkasoft Event Maps</h2>
						<p>Shortcode Information - Instructions on how to use the Wonkasoft Event Maps plugin</p>
						<h2>Default Shortcodes</h2>
							<p><h6>This is the map shortcode</h6>
							<input name="wem-map-shortcode-input" size="30" id="wem-map-shortcode-input" type="text" readonly="yes" value="[wonkasoft-event-maps]" /><button id="copy-map" onclick="copyToClipboard( this )"><i id="shortcode-map-copy" class="fas fa-copy"></i></button><span class="copyMessage" style="display: none;">Copied</span></p>
							<h6>This is the post type search shortcode</h6>
							<input name="wem-search-shortcode-input" size="30" id="wem-search-shortcode-input" type="text" readonly="yes" value="[wonkasoft-event-maps-search]" /><button id="copy-search" onclick="copyToClipboard( this )"><i id="shortcode-search-copy" class="fas fa-copy"></i></button><span class="copyMessage" style="display: none;">Copied</span></p>
							<form method="post" action="options.php">
								<?php settings_fields( 'wem_setting_group' ); ?>
								<?php do_settings_sections( 'wonkasoft_event_maps_admin_display' ); ?>
								<?php submit_button(); ?>
							</form>
							<h2>Here is the map that the shorcode will display</h2>
							<?php echo do_shortcode('[wonkasoft-event-maps]'); ?>
							<p></p>
							<h2>Description</h2>
							<p>Wonkasoft Event Maps was build to add a map using your event post types. You can add a map of all your post types anywhere that you uses shortcode on your site such as widgets, post, pages etc.</p>
							<p>If you have any questions, comments, or suggestions please send all inquiries to <a href="mail:support@wonkasoft.com">support@wonkasoft.com</a>. If you would like to <a href="https://paypal.me/Wonkasoft" target="_blank">donate</a> to support us please use this <a href="https://paypal.me/Wonkasoft" target="_blank">link</a></p>
						</div> <!-- /col-4 -->
					</div> <!-- /row -->
				</div> <!-- /col-8 -->
			</div> <!-- /row -->
		</div> <!-- /container-fluid -->
</div> <!-- /wem-settings-wrap -->