<?php

/**
 * Adds LatestPostWidget widget.
 */

class LatestPostWidget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	
	public function __construct() {
		parent::__construct(
			'latest_post_widget', // Base ID
			'Latest Post Widget', // Name
			[
				'description' => __('Widget To Show Latest Posts', 'latestpostwidget'),
			] // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		
		// start widget
		echo $before_widget;
		
		// title
		if (! empty($title)) {
			echo $before_title . $title . $after_title;
		}
		
		// content
		$posts = new WP_Query([
			'posts_per_page' => $instance['content'],
		]);

		if ($posts->have_posts()) {
			$output .= "<ul>";
			while ($posts->have_posts()) {
				$posts->the_post();
				$output .= "<li>";
				$output .= "<a href='" . get_the_permalink() . "'>";
				$output .= get_the_title();
				$output .= "</a>";

				if($instance['show_author']) {
					$output .= " by " . get_the_author() . " ";
					$output .= human_time_diff(get_the_time('U')) . ' ago';
					$output .= "</li>";
				}
			}
			wp_reset_postdata();
			$output .= "</ul>";
		} else {
			$output .= "No latest posts available.";
		}
		echo $output;
	
		// close widget
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Senaste Nytt', 'latestpostwidget');
		}

		// antal poster, om inget är satt blir det 3 som visas
		if (isset($instance['content'])) {
			$content = $instance['content'];
		} else {
			$content = 3;
		}

		$show_author = isset($instance['show_author'])
			? $instance['show_author']
			: false;
		?>

		<!-- title -->
		<p>
			<label 
				for="<?php echo $this->get_field_name('title'); ?>">
					<?php _e('Title:'); ?>
			</label>

			<input 
				class="widefat" 
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>" 
				type="text" 
				value="<?php echo esc_attr($title); ?>" 
			/>
		 </p>
		 <!-- /title -->

		 <!-- content -->
		 <p>
			<label
				for="<?php echo $this->get_field_name('content'); ?>"
			>
				<?php _e('How many posts to show: ', 'latestpostwidget'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('content'); ?>"
				name="<?php echo $this->get_field_name('content'); ?>"
				type="number"
				min="1"
				value="<?php echo esc_attr($content); ?>"
			/>
		 </p>
		 <!-- /content -->

		 <!-- checkbox -->
		 <p>
		 	<label 
				for="<?php echo $this->get_field_name('show_author'); ?>"
			>
				<?php _e('Show the Author?', 'latestpostwidget'); ?>
			</label>

			<input 
				class="widefat" 
				id="<?php echo $this->get_field_id('show_author'); ?>"
				name="<?php echo $this->get_field_name('show_author'); ?>"
				type="checkbox" 
				value="1"
				<?php echo $show_author ? 'checked="checked"' : ''; ?>
			/>
		 </p>
		 <!-- /checkbox -->
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = [];
		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
			: '';
		
			$instance['content'] = (!empty($new_instance['content']) && $new_instance['content'] > 0)
			? intval($new_instance['content'])
			: 3;

			$instance['show_author'] = (!empty($new_instance['show_author']))
			? true
			: false;

		return $instance;
	}

}// class LatestPostWidget