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
 * Actions/Filters
 *
 * Related to all settings API.
 *
 * @since 1.0.0
 */
if ( class_exists( 'BoostBox_OSA' ) ) {
    /**
     * Initialize admin settings
     * 
     * @return void
     */
    function boostbox_initialize_admin_settings() {
        /**
         * Object Instantiation.
         *
         * Object for the class `BoostBox_OSA`.
         */
        $boostbox_obj = new BoostBox_OSA();

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

        $args = apply_filters( 'boostbox_popup_settings_args', $args );

        // Get all popups.
        $popups = get_posts( $args );

        $options = [
            '' => esc_attr__( '--', 'boostbox' )
        ];

        // Loop through the popups.
        foreach ( $popups as $popup ) {
            // Update the otpions array.
            $options[$popup->ID] = get_the_title( $popup->ID );
        }

        // Filter the options array.
        $options = apply_filters( 'boostbox_popup_settings_popups_options', $options );

        // Section: General.
        $boostbox_obj->add_section(
            [
                'id'    => 'boostbox_general',
                'title' => esc_attr__( 'General Settings', 'boostbox' ),
            ]
        );

        // Field: Cookie days.
        $boostbox_obj->add_field(
            'boostbox_general',
            [
                'id'          => 'boostbox_cookie_days',
                'type'        => 'number',
                'name'        => esc_attr__( 'Cookie days', 'boostbox' ),
                'desc'        => esc_attr__( 'Set the days a cookie is stored after the user closes a popup', 'boostbox' ),
                'placeholder' => '',
            ]
        );

        // Field: Privacy - Disable analytics
        $boostbox_obj->add_field(
            'boostbox_general',
            [
                'id'   => 'boostbox_privacy_disable_analytics',
                'type' => 'checkbox',
                'name' => esc_attr__( 'Disable Tracking', 'boostbox' ),
                'desc' => esc_attr__( 'Turn off the impression and conversion tracking', 'boostbox' ),
            ]
        );
    }
    add_action( 'init', 'boostbox_initialize_admin_settings', 100 );
}
