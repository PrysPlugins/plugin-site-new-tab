<?php
/**
 * Plugin Name: Open Plugin Site in New Tab
 * Plugin URI: https://github.com/PrysPlugins/plugin-site-new-tab
 * Description: By default, links to a plugin's site open in the same window, which navigates you away from your WordPress Dashboard. This plugin makes all of those links open in a new tab/window.
 * Version: 1.0
 * Author: Jeremy Pry
 * Author URI: http://jeremypry.com/
 * License: GPL2
 */

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
	die( "You can't do anything by accessing this file directly." );
}

add_filter( 'plugin_row_meta', 'jpry_force_plugin_link_new_tab' ), 10, 4 );
/**
 * Ensure that links to plugins always open in a new window/tab.
 *
 * @since 1.0
 *
 * @param array $plugin_meta Array of plugin data to display.
 * @param string $plugin_file Path to the plugin file, relative to plugins directory.
 * @param array  $plugin_data The plugin header data.
 * @param string $status      Status of the plugin (Active, Inactive, etc.).
 * @return array Modified array of plugin data.
 */
function jpry_force_plugin_link_new_tab( $plugin_meta, $plugin_file, $plugin_data, $status ) {

	// Only rebuild meta if the PluginURI is set
	if ( ! empty( $plugin_data['PluginURI'] ) ) {
		$plugin_meta = array();
		if ( ! empty( $plugin_data[ 'Version' ] ) ) {
			$plugin_meta[] = sprintf( __( 'Version %s' ), $plugin_data[ 'Version' ] );
		}
		if ( ! empty( $plugin_data[ 'Author' ] ) ) {
			$author = $plugin_data[ 'Author' ];
			if ( ! empty( $plugin_data[ 'AuthorURI' ] ) ) {
				$author = '<a href="' . $plugin_data[ 'AuthorURI' ] . '" title="' . esc_attr__( 'Visit author homepage' ) . '">' . $plugin_data[ 'Author' ] . '</a>';
			}
			$plugin_meta[] = sprintf( __( 'By %s' ), $author );
		}

		// No need to re-if test this one
		$plugin_meta[] = '<a href="' . $plugin_data['PluginURI'] . '" title="' . esc_attr__( 'Visit plugin site' ) . '" target="_blank">' . __( 'Visit plugin site' ) . '</a>';
	}

	return $plugin_meta;
}
