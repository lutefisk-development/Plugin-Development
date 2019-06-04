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

require("inc/swapi.php");
require("inc/class.StarWarsWidget.php");

function wsw_widgets_init() {
	register_widget('StarWarsWidget');
}
add_action('widgets_init', 'wsw_widgets_init');

function wsw_enqueue_styles() {
	wp_enqueue_script('wcms18-starwars', plugin_dir_url(__FILE__) . 'assets/js/wcms18-starwars.js', ['jquery'], false, true);
	wp_localize_script('wcms18-starwars', 'my_ajax_obj', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}
add_action('wp_enqueue_scripts', 'wsw_enqueue_styles');

/**
 * Respond to AJAX for 'get_films'
 */

function wsw_ajax_get_sw_trivia() {

	$trivia = swapi_get($_POST['trivia']);

	if ($trivia) {
		wp_send_json_success($trivia);
	} else {
		wp_send_json_error('Something went wrong.');
	}	
}
add_action('wp_ajax_get_sw_trivia', 'wsw_ajax_get_sw_trivia');
add_action('wp_ajax_nopriv_get_sw_trivia', 'wsw_ajax_get_sw_trivia');
