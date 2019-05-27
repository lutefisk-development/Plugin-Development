<?php

/**
 * Adds StarWarsWidget widget.
 */

class StarWarsWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'wcms18-starwars-widget', // Base ID
			'WCMS18 StarWars', // Name
			[
				'description' => __('A Widget for displaying some StarWars trivia', 'wcms18-starwars-widget'),
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
		
		if($instance['show_vehicles']) {
			$vehicles = swapi_get_vehicles();
			if ($vehicles) {
				echo "<p>Total number of vehicles: " . count($vehicles) . "</p>";
				echo "<ul>";
				foreach ($vehicles as $vehicle) {
					?>
						<li>
							<?php echo $vehicle->name; ?><br>
							<small>
								Manufacturer: <?php echo $vehicle->manufacturer; ?><br>
								Model: <?php echo $vehicle->model; ?><br>
							</small>
						</li>
						<br>
					<?php
				}
				echo "</ul>";
			} else {
				echo "Something went wrong. Try again?";
			}
		}
		
		if($instance['show_films']) {
			$films = swapi_get_films();
			if ($films) {
				echo "<p>Total number of films: " . count($films) . "</p>";
				echo "<ul>";
				foreach ($films as $film) {
					?>
						<li>
							<?php echo $film->title; ?><br>
							<small>
								Release date: <?php echo $film->release_date; ?><br>
								Episode: <?php echo $film->episode_id; ?><br>
								Species: <?php echo count($film->species); ?><br>
								Vehicles: <?php echo count($film->vehicles); ?><br>
								Planets visited: <?php echo count($film->planets); ?>
							</small>
						</li>
						<br>
					<?php
				}
				echo "</ul>";
			} else {
				echo "Something went wrong. Try again?";
			}
		}
		
		if($instance['show_characters']) {
			$characters = swapi_get_characters();
			if ($characters) {
				echo "<p>Total number of characters: " . count($characters) . "</p>";
				echo "<ul>";
				foreach ($characters as $character) {
					?>
						<li>
							<?php echo $character->name; ?><br>
							<small>
								Birth year: <?php echo $character->birth_year; ?><br>
								Height: <?php echo $character->height; ?> cm<br>
								Mass: <?php echo $character->mass; ?> kg<br>
							</small>
						</li>
						<br>
					<?php
				}
				echo "</ul>";
			} else {
				echo "Something went wrong. Try again?";
			}
		}

		if($instance['show_starships']) {
			$starships = swapi_get_starships();
			if($starships) {
				echo "<p>Total number of starships: " . count($starships) . "</p>";
				echo "<ul>";
				foreach ($starships as $starship) {
					?>
						<li>
							<?php echo $starship->name; ?><br>
							<small>
								Starship class: <?php echo $starship->starship_class; ?><br>
								Cost: <?php echo $starship->cost_in_credits; ?> credits<br>
								Hyperdrive rating: <?php echo $starship->hyperdrive_rating; ?><br>
							</small>
						</li>
						<br>
					<?php
				}
				echo "</ul>";
			} else {
				echo "Something went wrong. Try again?";
			}
		}

		if($instance['show_planets']) {
			$planets = swapi_get_planets();
			if($planets) {
				echo "<p>Total number of planets: " . count($planets) . "</p>";
				echo "<ul>";
				foreach ($planets as $planet) {
					?>
						<li>
							<?php echo $planet->name; ?><br>
							<small>
								Population: <?php echo $planet->population; ?><br>
								Orbital period <?php echo $planet->orbital_period; ?> days<br>
								Terrain: <?php echo $planet->terrain; ?><br>
								Climate: <?php echo $planet->climate; ?><br>
							</small>
						</li>
						<br>
					<?php
				}
				echo "</ul>";
			} else {
				echo "Something went wrong. Try again?";
			}
		}

		if($instance['show_species']) {
			$species = swapi_get_species();
			if($species) {
				echo "<p>Total number of species: " . count($species) . "</p>";
				echo "<ul>";
				foreach ($species as $specie) {
					?>
						<li>
							<?php echo $specie->name; ?><br>
							<small>
								Classification: <?php echo $specie->classification; ?><br>
								Average height: <?php echo $specie->average_height; ?> cm<br>
								Average lifespan: <?php echo $specie->average_lifespan; ?> years<br>
								Language: <?php echo $specie->language; ?><br>
							</small>
						</li>
						<br>
					<?php
				}
				echo "</ul>";
			} else {
				echo "Something went wrong. Try again?";
			}
		}

		/*
		$luke = swapi_get_character(1);
		echo "Luke is {$luke->height} cm tall.<br>";

		$someone = swapi_get_character(2);
		echo "{$someone->name} is {$someone->height} cm tall.<br>";

		$someone = swapi_get_character(42);
		echo "{$someone->name} is {$someone->height} cm tall.<br>";
		


		$id = 4;
		$a_vehicle = swapi_get_vehicle($id);
		echo "Vehicle {$id}'s name is <strong>{$a_vehicle->name}</strong> and manufactured by {$a_vehicle->manufacturer} of model {$a_vehicle->model}. Say hi!<br>";
		*/
		
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
			$title = __('StarWars Trivia', 'wcms18-starwars-widget');
		}

		$show_films = isset($instance['show_films'])
			? $instance['show_films']
			: false;

		$show_starships = isset($instance['show_starships'])
			? $instance['show_starships']
			: false;

		$show_planets = isset($instance['show_planets'])
			? $instance['show_planets']
			: false;

		$show_vehicles = isset($instance['show_vehicles'])
			? $instance['show_vehicles']
			: false;

		$show_characters = isset($instance['show_characters'])
			? $instance['show_characters']
			: false;

		$show_species = isset($instance['show_species'])
			? $instance['show_species']
			: false;

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

		<!-- show films -->
		<p>
			<label
				for="<?php echo $this->get_field_name('show_films'); ?>"
			>
				<?php _e('List all Star Wars movies?'); ?>
			</label>
			&nbsp;
			&nbsp;
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('show_films'); ?>"
				name="<?php echo $this->get_field_name('show_films'); ?>"
				type="checkbox"
				value="1"
				<?php echo $show_films ? 'checked="checked"' : ''; ?>
			/>
		 </p>
		 <!-- /show films -->

		 <!-- show starships -->
		<p>
			<label
				for="<?php echo $this->get_field_name('show_starships'); ?>"
			>
				<?php _e('List all Star Wars starships?'); ?>
			</label>
			&nbsp;
			&nbsp;
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('show_starships'); ?>"
				name="<?php echo $this->get_field_name('show_starships'); ?>"
				type="checkbox"
				value="1"
				<?php echo $show_starships ? 'checked="checked"' : ''; ?>
			/>
		 </p>
		 <!-- /show starships -->

		 <!-- show planets -->
		<p>
			<label
				for="<?php echo $this->get_field_name('show_planets'); ?>"
			>
				<?php _e('List all Star Wars planets?'); ?>
			</label>
			&nbsp;
			&nbsp;
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('show_planets'); ?>"
				name="<?php echo $this->get_field_name('show_planets'); ?>"
				type="checkbox"
				value="1"
				<?php echo $show_planets ? 'checked="checked"' : ''; ?>
			/>
		 </p>
		 <!-- /show planets -->

		 <!-- show vehicles -->
		<p>
			<label
				for="<?php echo $this->get_field_name('show_vehicles'); ?>"
			>
				<?php _e('List all Star Wars vehicles?'); ?>
			</label>
			&nbsp;
			&nbsp;
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('show_vehicles'); ?>"
				name="<?php echo $this->get_field_name('show_vehicles'); ?>"
				type="checkbox"
				value="1"
				<?php echo $show_vehicles ? 'checked="checked"' : ''; ?>
			/>
		 </p>
		 <!-- /show vehicles -->

		 <!-- show characters -->
		<p>
			<label
				for="<?php echo $this->get_field_name('show_characters'); ?>"
			>
				<?php _e('List all Star Wars characters?'); ?>
			</label>
			&nbsp;
			&nbsp;
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('show_characters'); ?>"
				name="<?php echo $this->get_field_name('show_characters'); ?>"
				type="checkbox"
				value="1"
				<?php echo $show_characters ? 'checked="checked"' : ''; ?>
			/>
		 </p>
		 <!-- /show characters -->

		 <!-- show species -->
		<p>
			<label
				for="<?php echo $this->get_field_name('show_species'); ?>"
			>
				<?php _e('List all Star Wars species?'); ?>
			</label>
			&nbsp;
			&nbsp;
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('show_species'); ?>"
				name="<?php echo $this->get_field_name('show_species'); ?>"
				type="checkbox"
				value="1"
				<?php echo $show_species ? 'checked="checked"' : ''; ?>
			/>
		 </p>
		 <!-- /show species -->
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

		$instance['show_films'] = (!empty($new_instance['show_films']));
		
		$instance['show_starships'] = (!empty($new_instance['show_starships']));
		
		$instance['show_planets'] = (!empty($new_instance['show_planets']));
		
		$instance['show_vehicles'] = (!empty($new_instance['show_vehicles']));
		
		$instance['show_characters'] = (!empty($new_instance['show_characters']));
		
		$instance['show_species'] = (!empty($new_instance['show_species']));

		return $instance;
	}

} // class StarWarsWidget
