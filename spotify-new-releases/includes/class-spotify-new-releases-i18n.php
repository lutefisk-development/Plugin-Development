<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       lutefisk-development.se
 * @since      1.0.0
 *
 * @package    Spotify_New_Releases
 * @subpackage Spotify_New_Releases/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Spotify_New_Releases
 * @subpackage Spotify_New_Releases/includes
 * @author     Per Kristian Svanberg <kristiansvanberg@gmil.com>
 */
class Spotify_New_Releases_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'spotify-new-releases',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
