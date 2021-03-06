<?php

/**
 * Adds MyFirstWidget widget.
 */

class MyFirstWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'my_first_widget', // Base ID
			'My First Widget', // Name
			[
				'description' => __('A Sample Widget', 'myfirstwidget'),
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
		echo $instance['content'];

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
			$title = __('New title', 'myfirstwidget');
		}

		/*
		if (isset($instance['content'])) {
			$content = $instance['content'];
		} else {
			$content = '';
		}
		*/
		$content = isset($instance['content'])
			? $instance['content']
			: '';

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
				<?php _e('Content:'); ?>
			</label>

			<textarea
				class="widefat"
				id="<?php echo $this->get_field_id('content'); ?>"
				name="<?php echo $this->get_field_name('content'); ?>"
				rows="10"
			><?php echo $content; ?></textarea>
		 </p>
		 <!-- /content -->
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
		$instance['content'] = !empty($new_instance['content'])
			? $new_instance['content']
			: '';

		return $instance;
	}

} // class MyFirstWidget