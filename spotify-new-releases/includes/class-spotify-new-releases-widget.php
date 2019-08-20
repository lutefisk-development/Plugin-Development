<?php

/**
 * Adds Spotify_New_Releases_Widget widget.
 */

class Spotify_New_Releases_Widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'spotify-new-releases', // Base ID
            'Spotify New Releases', // Name
            [
                'description' => __('A Widget for displaying the latest releases on spotify', 'spotify-new-releases'),
            ]// Args
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
    public function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        // start widget
        echo $before_widget;

        // title
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        ?>

			<div
				class="content">
				<marquee behavior="alternate" direction=""><em><strong>Loading ... </strong></em></marquee>
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
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New Releases', 'spotify-new-releases');
        }

        ?> <!-- /php -->

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:');?>
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
    public function update($new_instance, $old_instance)
    {
        $instance = [];

        $instance['title'] = (!empty($new_instance['title']))
        ? strip_tags($new_instance['title'])
        : '';

        return $instance;
    }

} // class Spotify_New_Releases_Widget
