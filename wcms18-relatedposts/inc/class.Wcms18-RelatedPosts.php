<?php

/**
 * Adds WCMS18 widget.
 */

class WCMS18 extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'wcms18_related_posts', // Base ID
			'Wcms18 - Related Posts', // Name
			[
				'description' => __('A widget for related posts', 'wcms18-relatedposts'),
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

		if(is_single()){
		
			// title
			if (! empty($title)) {
				echo $before_title . $title . $after_title;
			}
			
			// content
			echo wrlp_get_latest_posts([
				'posts' => $instance['num_posts'],
				'categories' => $instance['categories'],
				'show_metadata' => $instance['show_metadata'],
				'title' => false,
			]);

		}

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
			$title = __('Related Posts', 'wcms18-relatedposts');
		}

		// antal poster, om inget är satt blir det 3 som visas
		if (isset($instance['num_posts'])) {
			$num_posts = $instance['num_posts'];
		} else {
			$num_posts = 3;
		}

		// visa vilka kategorier man önskar.
		if (isset($instance['categories'])) {
			$categories = $instance['categories'];
		} else {
			$categories = ''; 
		}

		$show_metadata = isset($instance['show_metadata'])
			? $instance['show_metadata']
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
				for="<?php echo $this->get_field_name('num_posts'); ?>"
			>
				<?php _e('How many posts to show: ', 'wcms18-relatedposts'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('num_posts'); ?>"
				name="<?php echo $this->get_field_name('num_posts'); ?>"
				type="number"
				min="1"
				value="<?php echo esc_attr($num_posts); ?>"
			/>
		 </p>
		 <!-- /content -->

		 <!-- categories -->
		 <p>
			<label
				for="<?php echo $this->get_field_name('categories'); ?>"
			>
				<?php _e('Which categories to show', 'wcms18-relatedposts'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('categories'); ?>"
				name="<?php echo $this->get_field_name('categories'); ?>"
				type="text"
				value="<?php echo esc_attr($categories); ?>"
			/>
		 </p>
		 <!-- /categories -->

		 <!-- show metadata about post -->
		<p>
			<label
				for="<?php echo $this->get_field_name('show_metadata'); ?>"
			>
				<?php _e('Show metadata?'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('show_metadata'); ?>"
				name="<?php echo $this->get_field_name('show_metadata'); ?>"
				type="checkbox"
				value="1"
				<?php echo $show_metadata ? 'checked="checked"' : ''; ?>
			/>
		 </p>
		 <!-- /show metadata about post -->
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
		$instance['num_posts'] = (!empty($new_instance['num_posts']) && $new_instance['num_posts'] > 0)
			? intval($new_instance['num_posts'])
			: 3;
		$instance['categories'] = (!empty($new_instance['categories']))
			? strip_tags($new_instance['categories'])
			: '';
		$instance['show_metadata'] = (!empty($new_instance['show_metadata']));
		return $instance;
	}

} // class MyFirstWidget