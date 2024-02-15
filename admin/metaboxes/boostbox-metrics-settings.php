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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    wp_die();
}

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
    // Bail early if analytics is disabled.
    if ( boostbox_settings_disable_analytics() ) {
        return;
    }
    
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
    // Bail early if analytics is disabled.
    if ( boostbox_settings_disable_analytics() ) {
        return;
    }

    global $post;

    // Noncename needed to verify where the data originated.
    wp_nonce_field( 'boostbox_metrics_reset_nonce', 'boostbox_metrics_reset_nonce' );

    // Get the impression count.
    $impressions = get_post_meta( $post->ID, 'boostbox_popup_impressions', true );
    if ( ! $impressions ) {
        $impressions = 0;
    }
    // Get the conversion count.
    $conversions = get_post_meta( $post->ID, 'boostbox_popup_conversions', true );
    if ( ! $conversions ) {
        $conversions = 0;
    }

    $html  = '<div id="boostbox-metrics-container-wrapper">';
    $html .= '<div id="boostbox-metrics-container">';
    $html .= '<div class="boostbox-metrics"><div clas="metric-name"><strong>' . esc_html__( 'Impressions', 'boostbox' ) . ':</strong></div><div class="metric-value">' . $impressions . '</div></div>';
    $html .= '<div class="boostbox-metrics"><div clas="metric-name"><strong>' . esc_html__( 'Conversions', 'boostbox' ) . ':</strong></div><div class="metric-value">' . $conversions . '</div></div>';
    $html .= '<div class="boostbox-metrics"><div clas="metric-name"><strong>' . esc_html__( 'Conversion Rate', 'boostbox' ) . ':</strong></div><div class="metric-value">' . boostbox_popup_conversion_rate( $post->ID )  . '</div></div>';
    $html .= '</div><!-- /.boostbox-metrics-container -->';
    $html .= '</div><!-- /.boostbox-metrics-container-wrapper -->';
    $html .= '<button id="reset-metrics" class="button is-primary" type="button">' . esc_html__( 'Reset Metrics', 'boostbox' ) . '</button>';

    echo wp_kses( $html, boostbox_allowed_tags() );
}

/**
 * Reset metrics
 * 
 * Used in an ajax request in the Metrics metabox
 * 
 * @since  1.3.0
 * @return void
 */
function boostbox_reset_metrics() {
    // Check the ajax referrer.
    check_ajax_referer( 'boostbox_metrics_reset_nonce', 'security' );

    // Get the post ID.
    $post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

    // Reset metrics to zero.
    update_post_meta( $post_id, 'boostbox_popup_impressions', 0 );
    update_post_meta( $post_id, 'boostbox_popup_conversions', 0 );
    
    // Render the updated metabox content
    boostbox_metrics_metabox_content();

    // Include the updated nonce in the response
    echo '<input type="hidden" name="boostbox_metrics_reset_nonce" id="boostbox_metrics_reset_nonce" value="' .
        wp_create_nonce( 'boostbox_metrics_reset_nonce' ) . '" />';
    
    exit;
}
add_action( 'wp_ajax_reset_boostbox_metrics', 'boostbox_reset_metrics' );
