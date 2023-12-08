<?php

/**
 * The custom post type functionality of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @link       https://deviodigital.com
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'boostbox_popups' ) ) {

    // Register Custom Post Type.
    function boostbox_popups() {

        $labels = array(
            'name'                  => _x( 'Popups', 'Post Type General Name', 'boostbox' ),
            'singular_name'         => _x( 'Popup', 'Post Type Singular Name', 'boostbox' ),
            'menu_name'             => esc_html__( 'BoostBox', 'boostbox' ),
            'name_admin_bar'        => esc_html__( 'Popup', 'boostbox' ),
            'archives'              => esc_html__( 'Popup Archives', 'boostbox' ),
            'attributes'            => esc_html__( 'Popup Attributes', 'boostbox' ),
            'parent_item_colon'     => esc_html__( 'Parent Popup:', 'boostbox' ),
            'all_items'             => esc_html__( 'All Popups', 'boostbox' ),
            'add_new_item'          => esc_html__( 'Add New Popup', 'boostbox' ),
            'add_new'               => esc_html__( 'Add New', 'boostbox' ),
            'new_item'              => esc_html__( 'New Popup', 'boostbox' ),
            'edit_item'             => esc_html__( 'Edit Popup', 'boostbox' ),
            'update_item'           => esc_html__( 'Update Popup', 'boostbox' ),
            'view_item'             => esc_html__( 'View Popup', 'boostbox' ),
            'view_items'            => esc_html__( 'View Popup', 'boostbox' ),
            'search_items'          => esc_html__( 'Search Popup', 'boostbox' ),
            'not_found'             => esc_html__( 'Not found', 'boostbox' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'boostbox' ),
            'featured_image'        => esc_html__( 'Featured Image', 'boostbox' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'boostbox' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'boostbox' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'boostbox' ),
            'insert_into_item'      => esc_html__( 'Insert into popup', 'boostbox' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this popup', 'boostbox' ),
            'items_list'            => esc_html__( 'Popups list', 'boostbox' ),
            'items_list_navigation' => esc_html__( 'Popups list navigation', 'boostbox' ),
            'filter_items_list'     => esc_html__( 'Filter popups list', 'boostbox' ),
        );
        $rewrite = array(
            'slug'                  => 'boostbox',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => esc_html__( 'BoostBox Popups', 'boostbox' ),
            'description'           => esc_html__( 'Build custom popups with Gutenberg', 'boostbox' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
            'taxonomies'            => array(),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-cover-image',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'query_var'             => 'popups',
            'rewrite'               => $rewrite,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'popups',
        );
        register_post_type( 'boostbox_popups', $args );

    }
    add_action( 'init', 'boostbox_popups', 0 );

}

/**
 * Function to check and redirect single posts with the post type "boostbox."
 */
function restrict_boostbox_posts() {
    // Check if it's a single post.
    if (is_single()) {
        global $post;

        // Check if the post type is "boostbox_popups".
        if ( $post->post_type === 'boostbox_popups' ) {
            // Redirect to the homepage or a custom URL.
            wp_redirect( home_url() ); // @TODO make a filter?
            exit();
        }
    }
}
add_action( 'template_redirect', 'restrict_boostbox_posts' );
