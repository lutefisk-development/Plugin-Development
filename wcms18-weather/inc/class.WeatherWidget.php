<?php

/**
 * Adds WeatherWidget widget.
 */

class WeatherWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'wcms18-weather-widget', // Base ID
			'WCMS18 Weather Widget', // Name
			[
				'description' => __('A Widget for displaying weather for a location', 'wcms18-weather'),
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
		$city = $instance['city'];
		$country = $instance['country'];

		?>
			<div class="current-weather">
				<small>Loading .... </small>
			</div>

			<script>
				jQuery(document).ready(function(){
					w18ww_get_current_weather(
						'<?php echo $widget_id ?>', 
						'<?php echo $city ?>', 
						'<?php echo $country ?>',
					);
				});
			</script>
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
			$title = __('Current Weather', 'wcms18-starwars-widget');
		}

		$city = isset($instance['city']) ? $instance['city'] : 'Malmoe';

		$country = isset($instance['country']) ? $instance['country'] : 'SE';

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

		<!-- city -->
		<p>
			<label
				for="<?php echo $this->get_field_name('city'); ?>"
			>
				<?php _e('City:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('city'); ?>"
				name="<?php echo $this->get_field_name('city'); ?>"
				type="text"
				value="<?php echo $city; ?>"
			/>
		</p>
		<!-- /city -->

		<!-- country -->
		<p>
			<label
				for="<?php echo $this->get_field_name('country'); ?>"
			>
				<?php _e('Country:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('country'); ?>"
				name="<?php echo $this->get_field_name('country'); ?>"
				type="text"
				value="<?php echo $country; ?>"
			/>
		</p>
		<!-- /country -->

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

		$instance['city'] = (!empty($new_instance['city']))
			? strip_tags($new_instance['city'])
			: '';

		$instance['country'] = (!empty($new_instance['country']))
			? strip_tags($new_instance['country'])
			: '';

		return $instance;
	}

} // class StarWarsWidget
