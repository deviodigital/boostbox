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
    wp_die();
}

if ( ! function_exists( 'boostbox_popups' ) ) {

    // Register Custom Post Type.
    function boostbox_popups() {

        $labels = array(
            'name'                  => esc_attr_x( 'Popups', 'Post Type General Name', 'boostbox' ),
            'singular_name'         => esc_attr_x( 'Popup', 'Post Type Singular Name', 'boostbox' ),
            'menu_name'             => esc_attr__( 'Popups', 'boostbox' ),
            'name_admin_bar'        => esc_attr__( 'Popup', 'boostbox' ),
            'archives'              => esc_attr__( 'Popup Archives', 'boostbox' ),
            'attributes'            => esc_attr__( 'Popup Attributes', 'boostbox' ),
            'parent_item_colon'     => esc_attr__( 'Parent Popup:', 'boostbox' ),
            'all_items'             => esc_attr__( 'All Popups', 'boostbox' ),
            'add_new_item'          => esc_attr__( 'Add New Popup', 'boostbox' ),
            'add_new'               => esc_attr__( 'Add New', 'boostbox' ),
            'new_item'              => esc_attr__( 'New Popup', 'boostbox' ),
            'edit_item'             => esc_attr__( 'Edit Popup', 'boostbox' ),
            'update_item'           => esc_attr__( 'Update Popup', 'boostbox' ),
            'view_item'             => esc_attr__( 'View Popup', 'boostbox' ),
            'view_items'            => esc_attr__( 'View Popup', 'boostbox' ),
            'search_items'          => esc_attr__( 'Search Popup', 'boostbox' ),
            'not_found'             => esc_attr__( 'Not found', 'boostbox' ),
            'not_found_in_trash'    => esc_attr__( 'Not found in Trash', 'boostbox' ),
            'featured_image'        => esc_attr__( 'Featured Image', 'boostbox' ),
            'set_featured_image'    => esc_attr__( 'Set featured image', 'boostbox' ),
            'remove_featured_image' => esc_attr__( 'Remove featured image', 'boostbox' ),
            'use_featured_image'    => esc_attr__( 'Use as featured image', 'boostbox' ),
            'insert_into_item'      => esc_attr__( 'Insert into tape', 'boostbox' ),
            'uploaded_to_this_item' => esc_attr__( 'Uploaded to this tape', 'boostbox' ),
            'items_list'            => esc_attr__( 'Popups list', 'boostbox' ),
            'items_list_navigation' => esc_attr__( 'Popups list navigation', 'boostbox' ),
            'filter_items_list'     => esc_attr__( 'Filter popups list', 'boostbox' ),
        );
        $rewrite = array(
            'slug'                  => 'tape',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => esc_attr__( 'BoostBox Popups', 'boostbox' ),
            'description'           => esc_attr__( 'Build custom popups with Gutenberg', 'boostbox' ),
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
