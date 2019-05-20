<?php

function wrlp_shortcode($user_atts = [], $content = null, $tag = '') {
	return wrlp_get_latest_posts($user_atts, $content, $tag);
}

function wrlp_init() {
	add_shortcode('related-posts', 'wrlp_shortcode');
}
add_action('init', 'wrlp_init');