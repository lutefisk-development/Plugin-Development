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

function ws_shortcode($atts = [], $content = null, $tag = '') {

	// normalize attribute keys, lowercase
	$atts = array_change_key_case((array)$atts, CASE_LOWER);
	
	// override default attributes with user attributes
    $ws_atts = shortcode_atts([
		'posts' => 3,
	], $atts, $tag);
	
	$posts = new WP_Query([
		'posts_per_page' => $ws_atts['posts'],
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

			// Loop over all categories and output each linked to a spesific post
			$categories = get_the_category($post->ID);
			foreach ($categories as $category) {
				$output .= "<br>" . $category->name;
			}
			$output .= "<p>By: " . get_the_author() . " - Posted " . get_the_date('F j, Y') . " at " . get_the_time('g:i a') . "</p>";
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
