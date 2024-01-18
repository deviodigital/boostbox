<?php
/**
 * BoostBox Metabox - Metrics
 *
 * This file is used to define the metrics metabox of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin/metaboxes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.3.0
 */

/**
 * Metrics metabox
 *
 * Adds a metrics metabox to the BoostBox post type.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.3.0
 */
function boostbox_metrics_metabox() {
    // Add Metabox.
    add_meta_box(
        'boostbox_metrics',
        esc_attr__( 'Metrics', 'boostbox' ),
        'boostbox_metrics_metabox_content',
        'boostbox_popups',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'boostbox_metrics_metabox' );

/**
 * Build the Metrics metabox
 * 
 * @since  1.3.0
 * @return void
 */
function boostbox_metrics_metabox_content() {
    global $post;

    // Noncename needed to verify where the data originated.
    echo '<input type="hidden" name="boostbox_metrics_meta_noncename" id="boostbox_metrics_meta_noncename" value="' .
    wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

    // Get the impression count.
    $impressions = get_post_meta( $post->ID, 'boostbox_popup_impressions', true );
    if ( ! $impressions ) {
        $impressions = 0;
    }
    // Get the conversion count.
    $conversions = get_post_meta( $post->ID, 'boostbox_popup_conversions', true );
    if ( ! $conversions) {
        $conversions = 0;
    }

    // Calculate the conversion percentage.
    $conversion_percentage = ( $impressions > 0 ) ? ( $conversions / $impressions ) * 100 : 0;

    // Format the percentage with 2 decimal places and add the percentage symbol.
    $formatted_percentage = number_format( $conversion_percentage, 2 ) . '%';

    echo '<div class="boostbox-metrics"><div clas="metric-name"><strong>Impressions:</strong></div><div class="metric-value">' . $impressions . '</div></div>';
    echo '<div class="boostbox-metrics"><div clas="metric-name"><strong>Conversions:</strong></div><div class="metric-value">' . $conversions . '</div></div>';
    echo '<div class="boostbox-metrics"><div clas="metric-name"><strong>Conversion Rate:</strong></div><div class="metric-value">' . $formatted_percentage  . '</div></div>';
}

/**
 * Save the Metabox Data
 * 
 * @param int    $post_id 
 * @param object $post 
 * 
 * @since  1.3.0
 * @return void
 */
function boostbox_metrics_metabox_save( $post_id, $post ) {
    /**
     * Verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times
     */
    if ( ! isset( $_POST['boostbox_metrics_meta_noncename' ] ) || ! wp_verify_nonce( $_POST['boostbox_metrics_meta_noncename'], plugin_basename( __FILE__ ) ) ) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( ! current_user_can( 'edit_post', $post->ID ) ) {
        return $post->ID;
    }
}
add_action( 'save_post', 'boostbox_metrics_metabox_save', 1, 2 );
