<?php
/**
 * Plugin Name: 	My First Widget
 * Plugin URI: 		http://lutefisk-development.se
 * Description: 	THis plugin adds my first widget
 * Version: 		0.1
 * Author: 			Per Kristian Svanberg
 * Author URI: 		http://lutefisk-development.se
 * License: 		WTFPL
 * License URI: 	http:// wtfpl.net
 * Text Domain: 	myfirstwidget
 * Domain Path: 	/languages
 */

require("class.MyFirstWidget.php");

function mfw_widget_init() {
	register_widget('MyFirstWidget');
}
add_action('widgets_init', 'mfw_widget_init');
