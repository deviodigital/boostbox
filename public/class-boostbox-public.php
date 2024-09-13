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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    wp_die();
}

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
     * @var    string  $plugin_name - The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $version - The current version of this plugin.
     */
    private $version;

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
        // Check popups for post ID's.
        $popup_check = boostbox_popup_post_check( get_the_ID() );    
        // Ensure that there are popups to process.
        if ( $popup_check && is_array( $popup_check ) ) {
            // Publc CSS.
            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boostbox-public.min.css', [], $this->version, 'all' );
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_scripts() {
        // Check popups for post ID's.
        $popup_check = boostbox_popup_post_check( get_the_ID() );
    
        // Initialize an array to hold all popup data.
        $all_popups_data = [];
    
        // Ensure that there are popups to process.
        if ( $popup_check && is_array( $popup_check ) ) {
            // Loop through popup checks.
            foreach ( $popup_check as $popup_id ) {
                // Milliseconds.
                $milliseconds = get_post_meta( $popup_id, 'boostbox_display_speed', true );
                if ( ! $milliseconds ) {
                    $milliseconds = 0;
                }
    
                // Scroll distance.
                $scroll_distance = '32px';
                if ( get_post_meta( $popup_id, 'boostbox_scroll_distance', true ) ) {
                    $scroll_distance = get_post_meta( $popup_id, 'boostbox_scroll_distance', true );
                }
    
                // Create localized script args for this popup.
                $popup_data = [
                    'popup_id'             => $popup_id,
                    'milliseconds'         => $milliseconds,
                    'cookie_days'          => boostbox_settings_cookie_days( $popup_id ),
                    'scroll_distance'      => $scroll_distance,
                    'trigger'              => get_post_meta( $popup_id, 'boostbox_trigger_type', true ),
                    'close_icon_placement' => get_post_meta( $popup_id, 'boostbox_close_icon_placement', true ),
                    'disable_analytics'    => boostbox_settings_disable_analytics()
                ];
    
                // Add the popup data to the array.
                $all_popups_data[] = $popup_data;
            }
    
            // Enqueue the script files.
            wp_enqueue_script( $this->plugin_name . '-js-cookie', plugin_dir_url( __FILE__ ) . 'js/js.cookie.min.js', [ 'jquery' ], $this->version, false );
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boostbox-public.js', [ 'jquery' ], $this->version, false );
    
            // Localize the script with all popups' data, AJAX URL, and nonce.
            wp_localize_script( $this->plugin_name, 'boostbox_settings', [
                'ajax_url' => admin_url( 'admin-ajax.php' ), // Localize ajax_url only once
                'nonce'    => wp_create_nonce( 'boostbox_nonce' ), // Localize nonce only once
                'popups'   => $all_popups_data // Add all popups to the popups array
            ]);
        }
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
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    // Get the popup ID from the AJAX request.
    $popup_id = isset( $_POST['popup_id'] ) ? intval( $_POST['popup_id'] ) : 0;
    if ( $popup_id === 0 ) {
        wp_send_json_error('Invalid popup ID');
        wp_die();
    }

    // Increment view count meta field.
    $current_count = get_post_meta( $popup_id, 'boostbox_popup_impressions', true );
    if ( $current_count === '' ) {
        $current_count = 0;
    }

    $new_count = (int) $current_count + 1;
    $updated = update_post_meta( $popup_id, 'boostbox_popup_impressions', $new_count );

    if ( $updated === false ) {
        wp_send_json_error('Failed to update post meta');
        wp_die();
    }

    wp_send_json_success(array('popup_id' => $popup_id, 'new_count' => $new_count));
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
