<?php
/**
 * BoostBox Metabox - Post Type Settings
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

/**
 * Post Type Settings metabox
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
function boostbox_post_type_settings_metabox() {
    // Add Metabox.
    add_meta_box(
        'boostbox_post_type_settings',
        esc_attr__( 'BoostBox Popup Settings', 'boostbox' ),
        'boostbox_post_type_settings_metabox_content',
        'boostbox_popups',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'boostbox_post_type_settings_metabox' );

/**
 * Build the Post Type Settings metabox
 * 
 * @return void
 */
function boostbox_post_type_settings_metabox_content() {
    global $post;

    // Noncename needed to verify where the data originated.
    echo '<input type="hidden" name="boostbox_post_type_settings_meta_noncename" id="boostbox_post_type_settings_meta_noncename" value="' .
    wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

    $locations = array(
        'top-left'      => esc_attr__( 'Top Left', 'boostbox' ),
        'top-center'    => esc_attr__( 'Top Center', 'boostbox' ),
        'top-right'     => esc_attr__( 'Top Right', 'boostbox' ),
        'center-left'   => esc_attr__( 'Center Left', 'boostbox' ),
        'center-center' => esc_attr__( 'Center Center', 'boostbox' ),
        'center-right'  => esc_attr__( 'Center Right', 'boostbox' ),
        'bottom-left'   => esc_attr__( 'Bottom Left', 'boostbox' ),
        'bottom-center' => esc_attr__( 'Bottom Center', 'boostbox' ),
        'bottom-right'  => esc_attr__( 'Bottom Right', 'boostbox' ),
    );

    // Popup location.
    $popup_location = get_post_meta( $post->ID, 'boostbox_popup_location', true );

    if ( ! $popup_location ) {
        $popup_location = 'center-center';
    }

    // Select a popup location: Build the field.
    $field  = '<div class="boostbox-field">';
    $field .= '<p>' . esc_attr__( 'Select popup display location', 'boostbox' ) . '</p>';
    $field .= '<select id="boostbox_popup_location" name="boostbox_popup_location">';
    // Loop through locations.
    if ( ! empty( $locations ) ) {
        foreach ( $locations as $location => $value ) {
            if ( $location == $popup_location ) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $field .= '<option value="' . esc_attr( $location ) . '" '. $selected .'>' . esc_html( $value ) . '</option>';
        }
    }
    $field .= '</select>';
    $field .= '</div>';

    echo $field;

}

/**
 * Save the Metabox Data
 * 
 * @param int    $post_id 
 * @param object $post 
 * 
 * @return void
 */
function boostbox_post_type_settings_metabox_save( $post_id, $post ) {

    /**
     * Verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times
     */
    if ( ! isset( $_POST['boostbox_post_type_settings_meta_noncename' ] ) || ! wp_verify_nonce( $_POST['boostbox_post_type_settings_meta_noncename'], plugin_basename( __FILE__ ) ) ) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( ! current_user_can( 'edit_post', $post->ID ) ) {
        return $post->ID;
    }

    // Post Type settings.
    $settings_meta['boostbox_popup_location'] = filter_input( INPUT_POST, 'boostbox_popup_location' );

    // Save $settings_meta as metadata.
    foreach ( $settings_meta as $key => $value ) {
        // Bail on post revisions.
        if ( 'revision' === $post->post_type ) {
            return;
        }
        $value = implode( ',', (array) $value );
        // Check for meta value and either update or add the metadata.
        if ( get_post_meta( $post->ID, $key, false ) ) {
            update_post_meta( $post->ID, $key, $value );
        } else {
            add_post_meta( $post->ID, $key, $value );
        }
        // Delete the metavalue if blank.
        if ( ! $value ) {
            delete_post_meta( $post->ID, $key );
        }
    }
}
add_action( 'save_post', 'boostbox_post_type_settings_metabox_save', 1, 2 );
