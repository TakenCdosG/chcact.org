<?php
/*
 * Plugin Name: ET Shortcodes
 * Plugin URI: http://elegantthemes.com
 * Description: ET Shortcodes plugin.
 * Version: 1.2
 * Author: Elegant Themes
 * Author URI: http://elegantthemes.com
 * License: GPLv2 or later
 */
  
define( 'ET_SHORTCODES_PLUGIN_DIR', trailingslashit( dirname(__FILE__) ) );
define( 'ET_SHORTCODES_PLUGIN_URI', plugins_url('', __FILE__) );

add_action( 'init', 'et_shortcodes_main_load', 12 );
function et_shortcodes_main_load(){
	if ( function_exists( 'et_setup_theme' ) ) return;
	
	require_once( ET_SHORTCODES_PLUGIN_DIR . '/shortcodes.php' );
}

add_action( 'admin_menu', 'et_shortcodes_options_add_page' );
function et_shortcodes_options_add_page() {
	$plugin_settings_page = add_management_page( __( 'ET Shortcodes' ), __( 'ET Shortcodes' ), 'manage_options', 'et_shortcodes_plugin_options', 'et_shortcodes_options_render_page' );
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'et_shortcodes_plugin_add_settings_link', 10, 2 );
function et_shortcodes_plugin_add_settings_link( $links ){
	$settings = '<a href="' . esc_url( admin_url( 'tools.php?page=et_shortcodes_plugin_options' ) ) . '">' . __( 'Settings' ) . '</a>';
	array_push( $links, $settings );
	return $links;
}

add_action( 'admin_init', 'et_shortcodes_plugin_settings_init' );
function et_shortcodes_plugin_settings_init() {
	register_setting( 'et_shortcodes_options', 'et_shortcodes_plugin_settings', 'et_shortcodes_plugin_settings_validate' );

	add_settings_section( 'general', '', '__return_false', 'et_shortcodes_plugin_options' );

	add_settings_field( 'responsive_layout', __( 'Responsive layout' ), 'et_shortcodes_field_responsive_layout_html', 'et_shortcodes_plugin_options', 'general' );
}

function et_shortcodes_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php esc_html_e( 'ET Shortcodes Plugin Options' ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'et_shortcodes_options' );
				do_settings_sections( 'et_shortcodes_plugin_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

function et_shortcodes_get_plugin_options() {
	$saved_options = (array) get_option( 'et_shortcodes_plugin_settings' );
	$default_settings = array(
		'responsive_layout' => 'on'
	);

	$default_settings = apply_filters( 'et_shortcodes_default_settings', $default_settings );

	$options = wp_parse_args( $saved_options, $default_settings );
	$options = array_intersect_key( $options, $default_settings );

	return $options;
}

function et_shortcodes_plugin_settings_validate( $input ) {
	$output = array();

	$output['responsive_layout'] = isset( $input['responsive_layout'] ) ? 'on' : 'off';

	return apply_filters( 'et_shortcodes_plugin_settings_validate', $output, $input );
}

function et_shortcodes_field_responsive_layout_html() {
	$options = et_shortcodes_get_plugin_options();
	?>
	<label for="responsive-layout">
		<input type="checkbox" name="et_shortcodes_plugin_settings[responsive_layout]" id="responsive-layout" <?php checked( 'on', $options['responsive_layout'] ); ?> />
		<?php _e( 'Allow shortcodes to adapt to various screen sizes' ); ?>
	</label>
	<?php
}