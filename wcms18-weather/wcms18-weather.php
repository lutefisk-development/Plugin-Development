<?php
/**
 * Plugin Name: 	WCMS18 Current Weather widget
 * Plugin URI: 		http://lutefisk-development.se
 * Description: 	This plugin displays the current weather for a loction
 * Version: 		0.1
 * Author: 			Per Kristian Svanberg
 * Author URI: 		http://lutefisk-development.se
 * License: 		WTFPL
 * License URI: 	http:// wtfpl.net
 * Text Domain: 	wcms18-weather
 * Domain Path: 	/languages
 */

require("inc/owmapi.php");
require("inc/class.WeatherWidget.php");

function w18ww_widgets_init() {
	register_widget('WeatherWidget');
}
add_action('widgets_init', 'w18ww_widgets_init');

function w18ww_enqueue_styles() {
	wp_enqueue_style('wcms18-weather', plugin_dir_url(__FILE__) . 'assets/css/wcms18-weather.css');

	wp_enqueue_script('wcms18-weather', plugin_dir_url(__FILE__) . 'assets/js/wcms18-weather.js', ['jquery'], false, true);
	wp_localize_script('wcms18-weather', 'my_ajax_obj', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);

}
add_action('wp_enqueue_scripts', 'w18ww_enqueue_styles');

/**
 * Respond to AJAX for 'get_current_weather'
 */

function w18ww_ajax_get_current_weather() {

	wp_send_json(w18ww_owm_get_current_weather($_POST['city'], $_POST['country']));
}
add_action('wp_ajax_get_current_weather', 'w18ww_ajax_get_current_weather');
add_action('wp_ajax_nopriv_get_current_weather', 'w18ww_ajax_get_current_weather');