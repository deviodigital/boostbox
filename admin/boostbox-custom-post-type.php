<?php

/**
 * The custom post type functionality of the plugin.
 *
 * @link       https://deviodigital.com
 * @since      0.0.1
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
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
            'menu_name'             => __( 'Popups', 'boostbox' ),
            'name_admin_bar'        => __( 'Popup', 'boostbox' ),
            'archives'              => __( 'Popup Archives', 'boostbox' ),
            'attributes'            => __( 'Popup Attributes', 'boostbox' ),
            'parent_item_colon'     => __( 'Parent Popup:', 'boostbox' ),
            'all_items'             => __( 'All Popups', 'boostbox' ),
            'add_new_item'          => __( 'Add New Popup', 'boostbox' ),
            'add_new'               => __( 'Add New', 'boostbox' ),
            'new_item'              => __( 'New Popup', 'boostbox' ),
            'edit_item'             => __( 'Edit Popup', 'boostbox' ),
            'update_item'           => __( 'Update Popup', 'boostbox' ),
            'view_item'             => __( 'View Popup', 'boostbox' ),
            'view_items'            => __( 'View Popup', 'boostbox' ),
            'search_items'          => __( 'Search Popup', 'boostbox' ),
            'not_found'             => __( 'Not found', 'boostbox' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'boostbox' ),
            'featured_image'        => __( 'Featured Image', 'boostbox' ),
            'set_featured_image'    => __( 'Set featured image', 'boostbox' ),
            'remove_featured_image' => __( 'Remove featured image', 'boostbox' ),
            'use_featured_image'    => __( 'Use as featured image', 'boostbox' ),
            'insert_into_item'      => __( 'Insert into tape', 'boostbox' ),
            'uploaded_to_this_item' => __( 'Uploaded to this tape', 'boostbox' ),
            'items_list'            => __( 'Popups list', 'boostbox' ),
            'items_list_navigation' => __( 'Popups list navigation', 'boostbox' ),
            'filter_items_list'     => __( 'Filter popups list', 'boostbox' ),
        );
        $rewrite = array(
            'slug'                  => 'tape',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => __( 'BoostBox Popups', 'boostbox' ),
            'description'           => __( 'Build custom popups with Gutenberg', 'boostbox' ),
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
            'publicly_queryable'    => false,
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
