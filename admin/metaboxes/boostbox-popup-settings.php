<?php
/**
 * BoostBox Metabox - Popup Settings
 *
 * This file is used to define the popup settings metabox of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin/metaboxes
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
 * Popup Settings metabox
 *
 * Adds a settings metabox to the BoostBox post type.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */
function boostbox_popup_settings_metabox() {
    // Get all registered post types.
    $post_types = get_post_types();
    // Remove unnecessary post types.
    $post_types = array_diff( $post_types, [ 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request', 'wp_block' ] );
    // Filter the post types.
    $post_types = apply_filters( 'boostbox_popup_settings_metabox_post_types', [ 'products', 'post', 'page' ] );
    // Loop through the post types.
    foreach ( $post_types as $post_type ) {
        // Add Metabox.
        add_meta_box(
            'boostbox_popup_settings',
            esc_attr__( 'BoostBox Settings', 'boostbox' ),
            'boostbox_popup_settings_metabox_content',
            $post_type,
            'side',
            'default'
        );
    }
}
add_action( 'add_meta_boxes', 'boostbox_popup_settings_metabox' );

/**
 * Build the Popup Settings metabox
 * 
 * @return void
 */
function boostbox_popup_settings_metabox_content() {
    global $post;

    // Nonce for verification.
    echo '<input type="hidden" name="boostbox_popup_settings_meta_noncename" id="boostbox_popup_settings_meta_noncename" value="' .
    wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

    // Retrieve the current value for disabling the popup.
    $popup_disabled = get_post_meta( $post->ID, 'boostbox_popup_disabled', true );

    // Build the checkbox field.
    echo '<div class="boostbox-field">';
    echo '<label for="boostbox_popup_disabled">';
    echo '<input type="checkbox" id="boostbox_popup_disabled" name="boostbox_popup_disabled" value="1" ' . checked( 1, $popup_disabled, false ) . '/>';
    echo esc_html__( 'Disable Popups', 'boostbox' );
    echo '</label>';
    echo '</div>';
}

/**
 * Save the Metabox Data
 * 
 * @param int    $post_id 
 * @param object $post 
 * 
 * @return void
 */
function boostbox_popup_settings_metabox_save( $post_id, $post ) {

    // Verify this came from our screen and with proper authorization.
    if ( ! isset( $_POST['boostbox_popup_settings_meta_noncename' ] ) || ! wp_verify_nonce( $_POST['boostbox_popup_settings_meta_noncename'], plugin_basename( __FILE__ ) ) ) {
        return $post->ID;
    }

    // Check if the user has permission to edit the post/page.
    if ( ! current_user_can( 'edit_post', $post->ID ) ) {
        return $post->ID;
    }

    // Checkbox value for disabling the popup.
    $popup_disabled = isset( $_POST['boostbox_popup_disabled'] ) ? 1 : 0;

    // Update or delete the meta value based on the checkbox state.
    if ( $popup_disabled ) {
        update_post_meta( $post->ID, 'boostbox_popup_disabled', $popup_disabled );
    } else {
        delete_post_meta( $post->ID, 'boostbox_popup_disabled' );
    }
}
add_action( 'save_post', 'boostbox_popup_settings_metabox_save', 1, 2 );
