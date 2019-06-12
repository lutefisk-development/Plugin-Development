<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       lutefisk-development.se
 * @since      1.0.0
 *
 * @package    Wcms18_Mappy_Weathery
 * @subpackage Wcms18_Mappy_Weathery/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wcms18_Mappy_Weathery
 * @subpackage Wcms18_Mappy_Weathery/public
 * @author     Per Kristian Svanberg <kristiansvanberg@gmil.com>
 */
class Wcms18_Mappy_Weathery_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->define_shortcodes();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wcms18_Mappy_Weathery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wcms18_Mappy_Weathery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wcms18-mappy-weathery-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wcms18-mappy-weathery-public.js', ['jquery'], $this->version, true );

		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key='. WCMS18_MAPPY_WEATHERY_GOOGLE_MAPS_API_KEY .'&callback=initMap', [], false, true);
	}

	/**
	 * Register our plugin's shortcodes.
	 * 
	 * @since 1.0.0.
	 */
	public function define_shortcodes(){
		add_shortcode('mappy', [$this, 'do_shortcode_mappy']);
	}
	
	public function do_shortcode_mappy($user_atts) {
		
		// fallback if no $user_atts is set
		$default_atts = [
			'address' => false,
	
		];

		$atts = shortcode_atts($default_atts, $user_atts, 'mappy');

		//verify that city and country is set
		if($atts['address'] == false){
			return '<div id="wcms18-mappy-weather"><div class="error"><strong>Please add city and country to show map for.</strong></div></div>';

		}

		//do stuff

		//return stuffsies
		return '<div id="wcms18-mappy-weather" data-address="'. $atts['address'] .'"><div id="map"></div></div>';
	}
}
