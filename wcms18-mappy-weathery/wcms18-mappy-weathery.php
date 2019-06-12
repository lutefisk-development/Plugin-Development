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
 * @package           Wcms18_Mappy_Weathery
 *
 * @wordpress-plugin
 * Plugin Name:       WCMS18 Mappy Weathery
 * Plugin URI:        kristiansvanberg@gmail.com
 * Description:       Show a map along with the current weather for a location
 * Version:           1.0.0
 * Author:            Per Kristian Svanberg
 * Author URI:        lutefisk-development.se
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wcms18-mappy-weathery
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * plugin directory path and url
 */
define( 'WCMS18_MAPPY_WEATHERY_PLUGIN_DIR_PATH', plugin_dir_path ( __FILE__ ));
define( 'WCMS18_MAPPY_WEATHERY_PLUGIN_DIR_URL', plugin_dir_url ( __FILE__ ));

/**
 * Require credentials
 */
require_once WCMS18_MAPPY_WEATHERY_PLUGIN_DIR_PATH . 'credentials.php';


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WCMS18_MAPPY_WEATHERY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wcms18-mappy-weathery-activator.php
 */
function activate_wcms18_mappy_weathery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcms18-mappy-weathery-activator.php';
	Wcms18_Mappy_Weathery_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wcms18-mappy-weathery-deactivator.php
 */
function deactivate_wcms18_mappy_weathery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcms18-mappy-weathery-deactivator.php';
	Wcms18_Mappy_Weathery_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wcms18_mappy_weathery' );
register_deactivation_hook( __FILE__, 'deactivate_wcms18_mappy_weathery' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wcms18-mappy-weathery.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wcms18_mappy_weathery() {

	$plugin = new Wcms18_Mappy_Weathery();
	$plugin->run();

}
run_wcms18_mappy_weathery();
