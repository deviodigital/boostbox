<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/public
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    BoostBox
 * @subpackage BoostBox/public
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */
class BoostBox_Public {

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
     * @param string $_plugin_name - The name of the plugin.
     * @param string $_version     - The version of this plugin.
     * 
     * @since  1.0.0
     * @return void
     */
    public function __construct( $_plugin_name, $_version ) {

        $this->plugin_name = $_plugin_name;
        $this->version     = $_version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_styles() {
        // Publc CSS.
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boostbox-public.min.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_scripts() {
        // Popup ID.
        $popup_id = get_post_meta( get_the_ID(), 'boostbox_popup_selected', true );
        // Cookie days.
        $settings    = get_option( 'boostbox_general' );
        $cookie_days = 30;
        if ( isset( $settings['boostbox_cookie_days'] ) ) {
            $cookie_days = $settings['boostbox_cookie_days'];
        }
        // Override global cookie days with popup setting.
        if ( get_post_meta( $popup_id, 'boostbox_cookie_days', true ) ) {
            $cookie_days = get_post_meta( $popup_id, 'boostbox_cookie_days', true );
        }
        // Milliseconds.
        $milliseconds = get_post_meta( $popup_id, 'boostbox_display_speed', true );
        if ( ! $milliseconds ) {
            $milliseconds = 0;
        }
        // Scroll distance.
        if ( get_post_meta( $popup_id, 'boostbox_scroll_distance', true ) ) {
            $scroll_distance = get_post_meta( $popup_id, 'boostbox_scroll_distance', true );
        } else {
            $scroll_distance = '32px';
        }
        // Create localize script args.
        $localize_args = array(
            'popup_id'             => $popup_id,
            'milliseconds'         => $milliseconds,
            'cookie_days'          => $cookie_days,
            'scroll_distance'      => $scroll_distance,
            'trigger'              => get_post_meta( $popup_id, 'boostbox_trigger_type', true ),
            'close_icon_placement' => get_post_meta( $popup_id, 'boostbox_close_icon_placement', true ),
            'ajax_url'             => admin_url( 'admin-ajax.php' ),
            'nonce'                => wp_create_nonce( 'boostbox_nonce' ),        
        );
        // Filter the args.
        $localize_args = apply_filters( 'boostbox_localize_scripts_args', $localize_args );
        // Public JS.
        wp_enqueue_script( $this->plugin_name . '-js-cookie', plugin_dir_url( __FILE__ ) . 'js/js.cookie.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boostbox-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'boostbox_settings', $localize_args );
    }

}

/**
 * Increment popup view count callback
 * 
 * @return void
 */
function boostbox_increment_popup_view_count_callback() {
    // Verify nonce.
    $nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
    if ( ! wp_verify_nonce( $nonce, 'boostbox_nonce' ) ) {
        wp_die( 'Invalid nonce' );
    }

    // Get the popup ID from the AJAX request.
    $popup_id = isset( $_POST['popup_id'] ) ? intval( $_POST['popup_id'] ) : 0;

    // Increment view count meta field.
    $current_count = get_post_meta( $popup_id, 'boostbox_popup_impressions', true );
    $new_count     = (int)$current_count + 1;
    update_post_meta( $popup_id, 'boostbox_popup_impressions', $new_count );

    wp_die();
}
add_action( 'wp_ajax_increment_popup_view_count', 'boostbox_increment_popup_view_count_callback' );
add_action( 'wp_ajax_nopriv_increment_popup_view_count', 'boostbox_increment_popup_view_count_callback' );

/**
 * Track popup conversion callback
 * 
 * @return void
 */
function boostbox_track_popup_conversion_callback() {
    // Verify nonce.
    $nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
    if ( ! wp_verify_nonce( $nonce, 'boostbox_nonce' ) ) {
        wp_die( 'Invalid nonce' );
    }

    // Get the popup ID from the AJAX request.
    $popup_id = isset( $_POST['popup_id'] ) ? intval( $_POST['popup_id'] ) : 0;

    // Increment conversion count meta field.
    $current_count = get_post_meta( $popup_id, 'boostbox_popup_conversions', true );
    $new_count     = (int)$current_count + 1;
    update_post_meta( $popup_id, 'boostbox_popup_conversions', $new_count );

    wp_die();
}
add_action( 'wp_ajax_track_popup_conversion', 'boostbox_track_popup_conversion_callback' );
add_action( 'wp_ajax_nopriv_track_popup_conversion', 'boostbox_track_popup_conversion_callback' );
