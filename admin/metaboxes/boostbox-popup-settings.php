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
    $post_types = array_diff( $post_types, array( 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request', 'wp_block' ) );
    // Filter the post types.
    $post_types = apply_filters( 'boostbox_popup_settings_metabox_post_types', array( 'products', 'post', 'page' ) );
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

    // Noncename needed to verify where the data originated.
    echo '<input type="hidden" name="boostbox_popup_settings_meta_noncename" id="boostbox_popup_settings_meta_noncename" value="' .
    wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

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

    // Popup selected.
    $popup_selected = get_post_meta( $post->ID, 'boostbox_popup_selected', true );

    // Select a Popup: Build the field.
    echo '<div class="boostbox-field">';
    echo '<p>' . esc_attr__( 'Select popup to display', 'boostbox' ) . '</p>';
    echo '<select id="boostbox_popup_selected" name="boostbox_popup_selected">';
    echo '<option value="popup_disabled">' . esc_attr__( 'Disable Popup', 'boostbox' ) . '</option>';
    echo '<option value="">' . esc_attr__( 'Global Popup', 'boostbox' ) . '</option>';
    // Loop through popups.
    if ( ! empty( $popups ) ) {
        foreach ( $popups as $popup ) {
            if ( $popup->ID == $popup_selected ) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            printf( '<option value="%s" '. $selected .'>%s</option>', esc_attr( $popup->ID ), esc_html( $popup->post_title ) );
        }
    }
    echo '</select>';
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

    /**
     * Verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times
     */
    if ( ! isset( $_POST['boostbox_popup_settings_meta_noncename' ] ) || ! wp_verify_nonce( $_POST['boostbox_popup_settings_meta_noncename'], plugin_basename( __FILE__ ) ) ) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( ! current_user_can( 'edit_post', $post->ID ) ) {
        return $post->ID;
    }

    // Popup settings.
    $settings_meta['boostbox_popup_selected'] = filter_input( INPUT_POST, 'boostbox_popup_selected' );

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
add_action( 'save_post', 'boostbox_popup_settings_metabox_save', 1, 2 );
