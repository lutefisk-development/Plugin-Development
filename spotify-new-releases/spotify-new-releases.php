<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              lutefisk-development.se
 * @since             1.0.0
 * @package           Spotify_New_Releases
 *
 * @wordpress-plugin
 * Plugin Name:       Spotify New Releases
 * Plugin URI:        http://localhost
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Per Kristian Svanberg
 * Author URI:        lutefisk-development.se
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spotify-new-releases
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SPOTIFY_NEW_RELEASES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-spotify-new-releases-activator.php
 */
function activate_spotify_new_releases() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spotify-new-releases-activator.php';
	Spotify_New_Releases_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-spotify-new-releases-deactivator.php
 */
function deactivate_spotify_new_releases() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spotify-new-releases-deactivator.php';
	Spotify_New_Releases_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_spotify_new_releases' );
register_deactivation_hook( __FILE__, 'deactivate_spotify_new_releases' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-spotify-new-releases.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_spotify_new_releases() {

	$plugin = new Spotify_New_Releases();
	$plugin->run();

}
run_spotify_new_releases();
