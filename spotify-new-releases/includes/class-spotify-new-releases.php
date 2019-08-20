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
 * @package    Spotify_New_Releases
 * @subpackage Spotify_New_Releases/includes
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
 * @package    Spotify_New_Releases
 * @subpackage Spotify_New_Releases/includes
 * @author     Per Kristian Svanberg <kristiansvanberg@gmil.com>
 */
class Spotify_New_Releases
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Spotify_New_Releases_Loader    $loader    Maintains and registers all hooks for the plugin.
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
    public function __construct()
    {
        if (defined('SPOTIFY_NEW_RELEASES_VERSION')) {
            $this->version = SPOTIFY_NEW_RELEASES_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'spotify-new-releases';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

        $this->register_widget();

        $this->register_ajax_actions();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Spotify_New_Releases_Loader. Orchestrates the hooks of the plugin.
     * - Spotify_New_Releases_i18n. Defines internationalization functionality.
     * - Spotify_New_Releases_Admin. Defines all hooks for the admin area.
     * - Spotify_New_Releases_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-spotify-new-releases-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-spotify-new-releases-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-spotify-new-releases-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-spotify-new-releases-public.php';

        /**
         * The class responsible for the widget.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-spotify-new-releases-widget.php';

        /**
         * The class responsible for communicating with the spotify API.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-spotify-api.php';

        $this->loader = new Spotify_New_Releases_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Spotify_New_Releases_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Spotify_New_Releases_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Spotify_New_Releases_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Spotify_New_Releases_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    }

    /**
     * Register the widget for the plugin
     *
     * @since    1.0.0
     */
    public function register_widget()
    {
        add_action('widgets_init', function () {
            register_widget('Spotify_New_Releases_Widget');
        });
    }

    /**
     * Register the ajax actions
     * @since    1.0.0
     */
    public function register_ajax_actions()
    {
        // register action 'spotify_new_releases__get'
        add_action('wp_ajax_spotify_new_releases__get', [
            $this,
            'ajax_spotify_new_releases__get',
        ]);
        add_action('wp_ajax_nopriv_spotify_new_releases__get', [
            $this,
            'ajax_spotify_new_releases__get',
        ]);
    }

    /**
     * Respond to ajax action 'spotify_new_releases__get'
     */
    public function ajax_spotify_new_releases__get()
    {

        $response = new SpotifyAPI(
            SPOTIFY_NEW_RELEASES_CLIENT_ID,
            SPOTIFY_NEW_RELEASES_CLIENT_SECRET
        );

        $body = $response->getNewReleases();

        wp_send_json_success([
            'release_one_artist' => $body->albums->items[0]->artists[0]->name,
            'release_one_album_type' => $body->albums->items[0]->album_type,
            'release_one_album_name' => $body->albums->items[0]->name,
            'release_one_url' => $body->albums->items[0]->external_urls->spotify,
            'release_one_image' => $body->albums->items[0]->images[1]->url,
            'release_two_artist' => $body->albums->items[1]->artists[0]->name,
            'release_two_album_type' => $body->albums->items[1]->album_type,
            'release_two_album_name' => $body->albums->items[1]->name,
            'release_two_url' => $body->albums->items[1]->external_urls->spotify,
            'release_two_image' => $body->albums->items[1]->images[1]->url,
            'release_three_artist' => $body->albums->items[2]->artists[0]->name,
            'release_three_album_type' => $body->albums->items[2]->album_type,
            'release_three_album_name' => $body->albums->items[2]->name,
            'release_three_url' => $body->albums->items[2]->external_urls->spotify,
            'release_three_image' => $body->albums->items[2]->images[1]->url,
        ]);

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Spotify_New_Releases_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}
