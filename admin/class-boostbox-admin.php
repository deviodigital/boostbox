<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
  */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */
class BoostBox_Admin {

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $_plugin_name - The ID of this plugin.
     */
    private $_plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $_version - The current version of this plugin.
     */
    private $_version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $_plugin_name - The name of this plugin.
     * @param string $_version     - The version of this plugin.
     */
    public function __construct( $_plugin_name, $_version ) {

        $this->plugin_name = $_plugin_name;
        $this->version     = $_version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_styles() {
        // General: Admin CSS.
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boostbox-admin.min.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_scripts() {
        // Args for popups.
        $args = array(
            'hierarchical' => 1,
            'exclude'      => '',
            'include'      => '',
            'meta_key'     => '',
            'meta_value'   => '',
            'authors'      => '',
            'child_of'     => 0,
            'parent'       => -1,
            'exclude_tree' => '',
            'number'       => '',
            'offset'       => 0,
            'post_type'    => 'boostbox_popups',
            'post_status'  => 'publish',
            'orderby'      => 'title',
            'order'        => 'ASC'
        );

        $args = apply_filters( 'boostbox_popup_settings_args', $args );

        // Get all popups.
        $popups = get_posts( $args );

        // Generate empty arrays.
        $popup_conversions = array();
        $popup_impressions = array();
        // Initialize total counters.
        $total_impressions = 0;
        $total_conversions = 0;

        // Loop through popups.
        foreach ( $popups as $popup ) {
            // Popup Conversions.
            $popup_conversions[$popup->ID] = get_post_meta( $popup->ID, 'boostbox_popup_conversions', true );
            // Popup Impressions.
            $popup_impressions[$popup->ID] = get_post_meta( $popup->ID, 'boostbox_popup_impressions', true );
            // Increment total counters.
            $total_impressions += (int)$popup_impressions[$popup->ID];
            $total_conversions += (int)$popup_conversions[$popup->ID];
        }
        // General: Admin JS.
        wp_enqueue_script( $this->plugin_name . '-charts', plugin_dir_url( __FILE__ ) . 'js/charts.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name . '-charts', 'chart_vars', array(
            'total_impressions' => $total_impressions,
            'total_conversions' => $total_conversions,
            'popup_impressions' => $popup_impressions,
            'popup_conversions' => $popup_conversions
        ) );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boostbox-admin.js', array( 'jquery', 'wp-hooks', 'wp-blocks', 'wp-color-picker' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'script_vars', array(
            'stylesheet_url' => get_stylesheet_directory_uri(),
        ) );
    }

}
