<?php

function wrlp_get_latest_posts($user_atts = [], $content = null, $tag = '') {
	
	$default_title = get_option('wrp_default_title', __('Related Posts', 'wcms18-relatedposts'));
	$current_post_id = get_the_ID();
	$current_post_categories = get_the_category();

	$category_ids = [];
	foreach ($current_post_categories as $current_post_category) {
		array_push($category_ids, $current_post_category->term_id);
	}

	$default_atts = [
		'posts' => 3,
		'title' => $default_title,
		'categories' => null,
		'post' => get_the_ID(),
		'show_metadata' => true,
	];

	$atts = shortcode_atts($default_atts, $user_atts, $tag);

	$posts = new WP_Query([
		'posts_per_page' => $atts['posts'],
		'post__not_in' => [$current_post_id],
		'category__in' => (!empty($atts['categories'])) ? explode(',', $atts['categories']) : $category_ids,
	]);

	$output = "";
	if ($atts['title']) {
		$output .= "<h2>" . esc_html($atts['title']) . "</h2>";
	}
	if ($posts->have_posts()) {
		$output = "<ul>";
		while ($posts->have_posts()) {
			$posts->the_post();
			$output .= "<li>";
			$output .= "<a href='" . get_the_permalink() . "'>";
			$output .= get_the_title();
			$output .= "</a>";
			
			if($atts['show_metadata']) {
				$output .= "<small>";
				$output .= " in ";
				$output .= get_the_category_list(', ');
				$output .= " by ";
				$output .= get_the_author();
				$output .= " ";
				$output .= human_time_diff(get_the_time('U')) . ' ago';
				$output .= "</small>";
			}
			
			$output .= "</li>";
		}
		wp_reset_postdata();
		$output .= "</ul>";
	} else {
		$output .= "No related posts available.";
	}
	return $output;
}