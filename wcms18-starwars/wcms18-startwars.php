<?php
/**
 * Plugin Name: 	WCMS18 Star Wars widget
 * Plugin URI: 		http://lutefisk-development.se
 * Description: 	This plugin shows some star wars trivia.
 * Version: 		0.1
 * Author: 			Per Kristian Svanberg
 * Author URI: 		http://lutefisk-development.se
 * License: 		WTFPL
 * License URI: 	http:// wtfpl.net
 * Text Domain: 	wcms18-starwars
 * Domain Path: 	/languages
 */

require("swapi.php");
require("class.StarWarsWidget.php");

function wsw_widgets_init() {
	register_widget('StarWarsWidget');
}
add_action('widgets_init', 'wsw_widgets_init');
