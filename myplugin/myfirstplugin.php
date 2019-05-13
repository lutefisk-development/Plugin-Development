<?php
/**
 * Plugin Name: 	My First Plugin
 * Plugin URI: 		http://lutefisk-development.se
 * Description: 	This is my first plugin, it does not do much.
 * Version: 		0.1
 * Author: 			Per Kristian Svanberg
 * Author URI: 		http://lutefisk-development.se
 * License: 		WTFPL
 * License URI: 	http:// wtfpl.net
 * Text Domain: 	myfirstplugin
 * Domain Path: 	/languages
 */

function wlp_shortcode() {
	$posts = new WP_Query([
		'posts_per_page' => 3,
	]);

	$output = "<h2>Latest Posts</h2>";
	if ($posts->have_posts()) {
		$output .= "<ul>";
		while ($posts->have_posts()) {
			$posts->the_post();
			$output .= "<li>";
			$output .= "<a href='" . get_the_permalink() . "'>";
			$output .= get_the_title();
			$output .= "</a>";
			$output .= "</li>";
		}
		wp_reset_postdata();
		$output .= "</ul>";
	} else {
		$output .= "No latest posts available.";
	}
	return $output;
}

function wlp_init() {
	add_shortcode('latest-post', 'wlp_shortcode');
}
add_action('init', 'wlp_init');