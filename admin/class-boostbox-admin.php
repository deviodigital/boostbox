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
        // Get current screen.
        $current_screen = get_current_screen();
        // Check if you're on the edit screen for BoostBox popups.
        if ( is_admin() && $current_screen && (
            in_array( $current_screen->post_type, array( 'boostbox_popups', 'post', 'page' ) ) ||
            ( 'post' === $current_screen->base && 'post-new.php' === $current_screen->id )
        ) ) {
            // General: Select2 CSS.
            wp_enqueue_style( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
        }
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
        // Get current screen.
        $current_screen = get_current_screen();

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
        // General: Charts JS.
        wp_enqueue_script( $this->plugin_name . '-charts', plugin_dir_url( __FILE__ ) . 'js/charts.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name . '-charts', 'chart_vars', array(
            'total_impressions' => $total_impressions,
            'total_conversions' => $total_conversions,
            'popup_impressions' => $popup_impressions,
            'popup_conversions' => $popup_conversions
        ) );
        // Check if you're on the edit screen for the "boostbox_popups" Custom Post Type
        if ( is_admin() && $current_screen && (
            in_array( $current_screen->post_type, array( 'boostbox_popups', 'post', 'page' ) ) ||
            ( 'post' === $current_screen->base && 'post-new.php' === $current_screen->id )
        ) ) {
            // General: Select2 JS.
            wp_enqueue_script( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
        }
        // General: Admin JS.
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boostbox-admin.js', array( 'jquery', 'wp-hooks', 'wp-blocks', 'wp-color-picker', 'boostbox-select2' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'script_vars', array(
            'stylesheet_url'      => get_stylesheet_directory_uri(),
            'popup_id'            => json_encode( get_the_ID() ),
            'metrics_reset_nonce' => wp_create_nonce( 'boostbox_metrics_reset_nonce' ),
        ) );
    }

}

/**
 * Insert Popups Block
 * 
 * This block will let users insert a popup directly into their post content
 * 
 * @TODO figure out how to track metrics for times it's viewed in content and not the regular popup way
 * 
 * @since  1.5.0
 * @return void
 */
function boostbox_enqueue_boostbox_popups_block() {
    wp_enqueue_script(
        'boostbox-popups-block',
        plugin_dir_url( __FILE__ ) . '/js/boostbox-popups-block.js',
        array( 'wp-blocks', 'wp-components', 'wp-editor', 'wp-data' ),
        BOOSTBOX_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'boostbox_enqueue_boostbox_popups_block' );

/**
 * Run on save post
 * 
 * @param int $post_id - the post ID.
 * @param object $post - the post data.
 */
function save_boostbox_popups_block( $post_id, $post ) {
    if ( $post->post_type === 'post' ) {
        $selected_popup = isset( $_POST['attributes']['selectedPopup'] ) ? absint( $_POST['attributes']['selectedPopup'] ) : 0;
        update_post_meta( $post_id, '_selected_popup', $selected_popup );
    }
}
add_action( 'save_post', 'save_boostbox_popups_block', 10, 2 );
