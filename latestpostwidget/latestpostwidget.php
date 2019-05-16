<?php
/**
 * Plugin Name: 	My Latest Post Widget
 * Plugin URI: 		http://lutefisk-development.se
 * Description: 	This plugin adds widget for latest posts.
 * Version: 		0.1
 * Author: 			Per Kristian Svanberg
 * Author URI: 		http://lutefisk-development.se
 * License: 		WTFPL
 * License URI: 	http:// wtfpl.net
 * Text Domain: 	latestpostwidget
 * Domain Path: 	/languages
 */

require("class.LatestPostWidget.php");

function lpw_widget_init() {
	register_widget('LatestPostWidget');
}
add_action('widgets_init', 'lpw_widget_init');