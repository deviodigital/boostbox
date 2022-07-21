<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      0.0.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    wp_die();
}

/**
 * Actions/Filters
 *
 * Related to all settings API.
 *
 * @since 1.0.0
 */
if ( class_exists( 'BoostBox_OSA' ) ) {
    /**
     * Function Name
     * 
     * @return string
     */
    function boostbox_initialize_admin_settings() {
        /**
         * Object Instantiation.
         *
         * Object for the class `BoostBox_OSA`.
         */
        $boostbox_obj = new BoostBox_OSA();

        // Args for popups.
        $args = array(
            'sort_order'   => 'asc',
            'sort_column'  => 'post_title',
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
            'post_status'  => 'publish'
        );

        $args = apply_filters( 'boostbox_popup_settings_args', $args );

        // Get all popups.
        $popups = get_posts( $args );

        $options = array(
            '' => esc_attr__( '--', 'boostbox' )
        );

        foreach ( $popups as $popup ) {
            $options[$popup->ID] = get_the_title( $popup->ID );
        }

        // Section: General.
        $boostbox_obj->add_section(
            array(
                'id'    => 'boostbox_general',
                'title' => esc_attr__( 'General Settings', 'boostbox' ),
            )
        );

        // Field: Global popup.
        $boostbox_obj->add_field(
            'boostbox_general',
            array(
                'id'      => 'boostbox_global_popup',
                'type'    => 'select',
                'name'    => esc_attr__( 'Global popup', 'boostbox' ),
                'desc'    => esc_attr__( 'Select the popup used whenever the global option is set on posts/pages', 'boostbox' ),
                'options' => $options,
            )
        );
    }
    add_action( 'init', 'boostbox_initialize_admin_settings', 100 );
}
