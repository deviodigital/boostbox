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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    wp_die();
}

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
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $_version - The current version of this plugin.
     */
    private $version;

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
            in_array( $current_screen->post_type, [ 'boostbox_popups', 'post', 'page' ] ) ||
            ( 'post' === $current_screen->base && 'post-new.php' === $current_screen->id )
        ) ) {
            // General: Select2 CSS.
            wp_enqueue_style( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', [], $this->version, 'all' );
        }
        // General: Admin CSS.
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boostbox-admin.min.css', [], $this->version, 'all' );
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
        $args = [
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
        ];

        // Filter the args.
        $args = apply_filters( 'boostbox_popup_settings_args', $args );

        // Get all popups.
        $popups = get_posts( $args );

        // Generate empty arrays.
        $popup_conversions = [];
        $popup_impressions = [];
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
        wp_enqueue_script( $this->plugin_name . '-charts', plugin_dir_url( __FILE__ ) . 'js/charts.js', [ 'jquery' ], $this->version, false );
        wp_localize_script( $this->plugin_name . '-charts', 'chart_vars', [
            'total_impressions' => $total_impressions,
            'total_conversions' => $total_conversions,
            'popup_impressions' => $popup_impressions,
            'popup_conversions' => $popup_conversions
        ] );
        // Check if you're on the edit screen for the "boostbox_popups" Custom Post Type
        if ( is_admin() && $current_screen && (
            in_array( $current_screen->post_type, [ 'boostbox_popups' ] ) ||
            ( 'post' === $current_screen->base && 'post-new.php' === $current_screen->id )
        ) ) {
            // General: Select2 JS.
            wp_enqueue_script( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', [ 'jquery' ], $this->version, false );
            // General: Admin JS.
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boostbox-admin.js', [ 'jquery', 'wp-hooks', 'wp-blocks', 'wp-color-picker', 'boostbox-select2' ], $this->version, false );
            wp_localize_script( $this->plugin_name, 'script_vars', [
                'stylesheet_url'      => get_stylesheet_directory_uri(),
                'popup_id'            => json_encode( get_the_ID() ),
                'metrics_reset_nonce' => wp_create_nonce( 'boostbox_metrics_reset_nonce' ),
                'ajax_url'            => admin_url( 'admin-ajax.php' )
            ] );
        }
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
        [ 'wp-blocks', 'wp-components', 'wp-editor', 'wp-data' ],
        BOOSTBOX_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'boostbox_enqueue_boostbox_popups_block' );

/**
 * Run on save post
 * 
 * @param int    $post_id - the post ID.
 * @param object $post    - the post data.
 */
function save_boostbox_popups_block( $post_id, $post ) {
    if ( $post->post_type === 'post' ) {
        $selected_popup = isset( $_POST['attributes']['selectedPopup'] ) ? absint( $_POST['attributes']['selectedPopup'] ) : 0;
        update_post_meta( $post_id, '_selected_popup', $selected_popup );
    }
}
add_action( 'save_post', 'save_boostbox_popups_block', 10, 2 );

/**
 * Fetch posts by post type
 * 
 * @since  2.0.0
 * @return void
 */
function fetch_posts_by_post_type() {
    // Get the selected post types (can be multiple).
    $post_types = isset( $_POST['post_types'] ) ? array_map( 'sanitize_text_field', (array) $_POST['post_types'] ) : [];

    if ( empty( $post_types ) ) {
        wp_send_json_error( 'No post type selected' );
    }

    // Get posts from the selected post types.
    $args = [
        'post_type'      => $post_types,
        'posts_per_page' => -1,
    ];

    $posts = get_posts( $args );

    $output = [];

    // Loop through the posts.
    foreach ( $posts as $post ) {
        $output[] = array(
            'id'    => $post->ID,
            'title' => $post->post_title,
        );
    }

    wp_send_json_success( $output );
}
add_action( 'wp_ajax_fetch_posts_by_post_type', 'fetch_posts_by_post_type' );
add_action( 'wp_ajax_nopriv_fetch_posts_by_post_type', 'fetch_posts_by_post_type' );

/**
 * Fetch posts by search
 * 
 * @since  2.0.0
 * @return void
 */
function fetch_posts_by_search() {
    // Check if the search term exists.
    $search_term = isset( $_POST['search_term'] ) ? sanitize_text_field( $_POST['search_term'] ) : '';

    // If search term is empty, return no results.
    if ( empty( $search_term ) ) {
        wp_send_json_error( 'No search term provided.' );
    }

    // Get all public post types (including custom post types).
    $post_types = get_post_types( [ 'public' => true ], 'names' );

    // Fetch posts based on the search term across all post types.
    $args = [
        's'              => $search_term, // Search term for post title
        'post_type'      => $post_types,  // Search all public post types
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    $posts = get_posts( $args );

    $output = [];

    // Loop through the posts and prepare output for Select2.
    foreach ( $posts as $post ) {
        $output[] = [
            'id'    => $post->ID,
            'text'  => $post->post_title,
        ];
    }

    // Return the posts as a JSON response.
    wp_send_json_success( $output );
}
add_action( 'wp_ajax_fetch_posts_by_search', 'fetch_posts_by_search' );
add_action( 'wp_ajax_nopriv_fetch_posts_by_search', 'fetch_posts_by_search' );
