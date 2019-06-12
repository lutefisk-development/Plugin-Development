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
 * @package    Wcms18_Mappy_Weathery
 * @subpackage Wcms18_Mappy_Weathery/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wcms18_Mappy_Weathery
 * @subpackage Wcms18_Mappy_Weathery/includes
 * @author     Per Kristian Svanberg <kristiansvanberg@gmil.com>
 */
class Wcms18_Mappy_Weathery_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wcms18-mappy-weathery',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
