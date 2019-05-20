<?php

function wrlp_the_content($content) {

	if (is_single() && get_option('wrp_add_to_posts') == 1) {
		if (!has_shortcode($content, 'related-posts')) {
			$related_posts = wrlp_get_related_posts();
			$content = $content . $related_posts;
			// $content .= $related_posts; // more efficient
			// $content .= wrp_get_related_posts(); // such efficient
		}
	}
	return $content;
}
add_filter('the_content', 'wrlp_the_content');