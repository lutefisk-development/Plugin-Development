<?php
/**
 * Plugin Name: 	Workshop _Day 01
 * Plugin URI: 		http://lutefisk-development.se
 * Description: 	This is the first workshop of this course.
 * Version: 		0.1
 * Author: 			Per Kristian Svanberg
 * Author URI: 		http://lutefisk-development.se
 * License: 		WTFPL
 * License URI: 	http:// wtfpl.net
 * Text Domain: 	workshop_day01
 * Domain Path: 	/languages
 */

function ws_shortcode() {
	

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

function ws_init() {
	add_shortcode('my-latest-posts', 'ws_shortcode');
}
add_action('init', 'ws_init');
