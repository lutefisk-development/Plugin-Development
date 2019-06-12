<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       lutefisk-development.se
 * @since      1.0.0
 *
 * @package    Wcms18_Year_Book
 * @subpackage Wcms18_Year_Book/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wcms18_Year_Book
 * @subpackage Wcms18_Year_Book/includes
 * @author     Per Kristian Svanberg <kristiansvanberg@gmil.com>
 */
class Wcms18_Year_Book {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wcms18_Year_Book_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WCMS18_YEAR_BOOK_VERSION' ) ) {
			$this->version = WCMS18_YEAR_BOOK_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wcms18-year-book';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		//register widget
		$this->register_widget();

		$this->register_filter_the_content();
		$this->add_action_init();
		
		// following line either shows or hides the ACF meny option in dashboard:
		// $this->add_acf_init();


	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wcms18_Year_Book_Loader. Orchestrates the hooks of the plugin.
	 * - Wcms18_Year_Book_i18n. Defines internationalization functionality.
	 * - Wcms18_Year_Book_Admin. Defines all hooks for the admin area.
	 * - Wcms18_Year_Book_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-year-book-loader.php';

				/**
		 * The class responsible for the widget of the plugin 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-year-book-widget.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-year-book-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wcms18-year-book-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcms18-year-book-public.php';

		/**
		 * Includes ACF plugin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/acf/acf.php';


		$this->loader = new Wcms18_Year_Book_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wcms18_Year_Book_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wcms18_Year_Book_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wcms18_Year_Book_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wcms18_Year_Book_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register the widget
	 * @since    1.0.0
	 */
	public function register_widget() {
		add_action('widgets_init', function(){
			register_widget('Wcms18_Year_Book_Widget');
		});
	}

	/**
	 * Add functions to be run during 
	 *
	 * @since    1.0.0
	 */
	public function add_action_init() {
		add_action('init', [$this, 'register_cpts']);
		add_action('init', [$this, 'register_cts']);
	}

	public function register_cts(){
		
		/**
		 * Taxonomy: Studies.
		 */
		
		$labels = array(
			"name" => __( "Studies", "hestia" ),
			"singular_name" => __( "Study", "hestia" ),
		);
		
		$args = array(
			"label" => __( "Studies", "hestia" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => true,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'studies', 'with_front' => true, ),
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "studies",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			);
		register_taxonomy( "studies", array( "w18yb_student" ), $args );
		
	}

	/**
	 * 
	 *
	 * @since    1.0.0
	 */
	public function register_cpts() {
		
		/**
		 * Post Type: Students.
		 */
		
		$labels = array(
			"name" => __( "Students", "hestia" ),
			"singular_name" => __( "Student", "hestia" ),
		);
		
		$args = array(
			"label" => __( "Students", "hestia" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"delete_with_user" => false,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "students", "with_front" => true ),
			"query_var" => true,
			"menu_icon" => "dashicons-welcome-learn-more",
			"supports" => array( "title", "editor", "thumbnail", "excerpt" ),
			"taxonomies" => array( "studies" ),
		);
		
		register_post_type( "w18yb_student", $args );

	}

	/**
	 * Adds filter to "the_content"
	 *
	 * @since    1.0.0
	 */
	public function register_filter_the_content() {
		add_filter('the_content', [$this, 'filter_the_content']);
	}

	/**
	 * manipulates "the_content" based on cpt
	 * 
	 * @since    1.0.0
	 */

	public function filter_the_content($content){
		// metadata array:
		$metadata = [];
		
		// only alter "the_content" if a it's certain post type:
		if(get_post_type() == 'w18yb_student'){

			// adds the taxonomies for that post type:
			$taxonomies = get_the_term_list($post->ID, 'studies', '<div class="w18yb-taxonomies"><span>' . __('Studies: ', 'wcms18-year-book') . '</span>', ', ', '</div>');
			array_push($metadata, $taxonomies);
			
			// adds html and content from a spesific custom field:
			if(get_field('attendance') || get_field('detention_hours')){
				$output = '<div class="w18yb-metadata">';
				$output .= '<h1>'. __('Metadata: ', 'wcms18-year-book') .'</h1>';
				
				if(get_field('attendance')){
					$output .= sprintf(
						'<p><span>' . __('Attendance: ', 'wcms18-year-book') . '</span> %s &#37</p>',
						get_field('attendance')
					);
				}

				if(get_field('detention_hours')){
					$output .= sprintf(
						'<p><span>' . __('Detention: ', 'wcms18-year-book') . ' </span>%s' . __(' hours </p>', 'wcms18-year-book'),
						get_field('detention_hours')
					);
				}
				$output .= '</div>';
				array_push($metadata, $output);
				
			}
			$content .= implode("", $metadata);
		}
		return $content;
	}

	/**
	 * show/hide the dashboard option
	 *
	 * @since    1.0.0
	 */
	public function add_acf_init() {
		// (Optional) Hide the ACF admin menu item.
		add_filter('acf/settings/show_admin', function(){
			return false;
		});			
	}
	

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wcms18_Year_Book_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
