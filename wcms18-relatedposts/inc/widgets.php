<?php

require("class.Wcms18-RelatedPosts.php");

function wrlp_widget_init() {
	register_widget('WCMS18');
}
add_action('widgets_init', 'wrlp_widget_init');