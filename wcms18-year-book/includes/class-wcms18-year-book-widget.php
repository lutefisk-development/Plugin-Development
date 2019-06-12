<?php

/**
 * Adds Wcms18 Random Dog Widget widget.
 */

class Wcms18_Year_Book_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'wcms18-year-book', // Base ID
			'WCMS18 Year Book', // Name
			[
				'description' => __('A Widget for displaying a year book', 'wcms18-year-book'),
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

		if(!(is_single() && get_post_type() === 'w18yb_student')){
			return;
		}

		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		// start widget
		echo $before_widget;

		// title
		if (! empty($title)) {
			echo $before_title . $title . $after_title;
		}

		// content
		?>

			<div class="w18yb-taxonomies">
				<span><?php _e('Studies: ', 'wcms18-year-book'); ?></span>
				<?php echo get_the_term_list($post->ID, 'studies', '', ', ', ''); ?>
			</div>

			<div class="w18yb-metadata">
				<h1><?php _e('Metadata: ', 'wcms18-year-book'); ?></h1>
				<p>
					<span>
						<?php printf(
							'<span>' . __('Attendance: ', 'wcms18-year-book') . '</span> %s &#37',
							get_field('attendance')
						); ?>
					</span>
				</p>
				<p>
					<span>
						<?php printf(
							'<span>' . __('Detention: ', 'wcms18-year-book') . ' </span>%s' . __(' hours ', 'wcms18-year-book'),
							get_field('detention_hours')
						); ?>
					</span>
				</p>
			</div>

		<?php
		
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
			$title = __('Year Book', 'wcms18-year-book');
		}

		?> <!-- /php -->

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
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

		return $instance;
	}

} // class Wcms18_Year_Book_Widget
