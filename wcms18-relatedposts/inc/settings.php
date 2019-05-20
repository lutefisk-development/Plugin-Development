<?php

// Add our settings page to the WP admin menu.
function wrp_add_settings_page_to_menu() {
	add_submenu_page(
		'options-general.php', 				//parent page
		'WCMS18 Related Post Settings', 	//page title
		'Related Posts', 					//menu title
		'manage_options', 					//minimum capability
		'relatedposts', 					//slug for our page
		'wrp_settings_page'					//callback to render the page
	);
}
add_action('admin_menu', 'wrp_add_settings_page_to_menu');

// Render settings page
function wrp_settings_page() {
	?>

		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

			<form method="post" action="options.php">
				<?php
					//output security fields for the registered section.
					settings_fields("wrp_general_options");

					//output setting sections and theme fields
					do_settings_sections("relatedposts");

					//output save settings button
					submit_button();
				?>
			</form>
		</div>

	<?php
}

//register all options for our settings page.
function wrp_settings_init() {
	add_settings_section(
		'wrp_general_options', 
		'General Options', 
		'wrp_general_options_section', 
		'relatedposts'
	);

	/**
	 * Add settings field to settings section "General Options"
	 */

	//
	add_settings_field(
		'wrp_add_to_posts', 
		'Add Related Posts to all posts', 
		'wrp_add_to_posts_cb', 
		'relatedposts', 
		'wrp_general_options' 
	);

	register_setting('wrp_general_options', 'wrp_add_to_posts');

	//default title
	add_settings_field(
		'wrp_default_title', 
		'Default Title', 
		'wrp_add_to_title_cb', 
		'relatedposts', 
		'wrp_general_options' 
	);

	register_setting('wrp_general_options', 'wrp_default_title');
}
add_action('admin_init', 'wrp_settings_init');

function wrp_general_options_section() {
	?>
		<p>This is a very nice settingspage, the bestest one!</p>
	<?php
}

function wrp_add_to_posts_cb() {
	?>
		<input 
			type="checkbox" 
			name="wrp_add_to_posts" 
			id="wrp_add_to_posts"
			value="1"
			<?php 
				checked(1, get_option('wrp_add_to_posts')); 
			?>
		>
	<?php
}

function wrp_add_to_title_cb() {
	?>
		<input 
			type="text" 
			name="wrp_default_title" 
			id="wrp_default_title"
			value="<?php echo get_option('wrp_default_title', 'Related Posts'); ?>"
		>
	<?php
}