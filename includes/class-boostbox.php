<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package    BoostBox
 * @subpackage BoostBox/includes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    wp_die();
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/includes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */
class BoostBox {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    BoostBox_Loader $loader - Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $plugin_name - The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version - The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since  1.0.0
     * @return void
     */
    public function __construct() {
        $this->plugin_name = 'boostbox';
        $this->version     = '2.1.1';

        if ( defined( 'BOOSTBOX_VERSION' ) ) {
            $this->version = BOOSTBOX_VERSION;
        }

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - BoostBox_Loader. Orchestrates the hooks of the plugin.
     * - BoostBox_i18n. Defines internationalization functionality.
     * - BoostBox_Admin. Defines all hooks for the admin area.
     * - BoostBox_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boostbox-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boostbox-i18n.php';

        /**
         * The file responsible for defining all core helper functions
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/boostbox-helper-functions.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-boostbox-admin.php';

        /**
         * The class responsible for defining all actions that add custom columns 
         * to the boostbox_popups screen.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-boostbox-cpt-columns.php';

        /**
         * The file responsible for defining the popups custom post type
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/boostbox-custom-post-type.php';

        /**
         * The file responsible for defining the popups metaboxes
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/boostbox-metaboxes.php';

        /**
         * The class responsible for defining the admin settings.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-boostbox-admin-settings.php';

        /**
         * The file responsible for defining the plugin settings page
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/boostbox-admin-settings.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boostbox-public.php';

        /**
         * The file responsible for defining the popup HTML
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/boostbox-popups.php';

        $this->loader = new BoostBox_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the BoostBox_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function set_locale() {

        $plugin_i18n = new BoostBox_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function define_admin_hooks() {

        $plugin_admin = new BoostBox_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function define_public_hooks() {

        $plugin_public = new BoostBox_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since  1.0.0
     * @return void
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @return string The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @return BoostBox_Loader Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @return string The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
