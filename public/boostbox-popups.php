<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/public
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Popup HTML
 * 
 * The HTML used to create the popups
 * 
 * @since  1.0.0
 * @return void
 */
function boostbox_popup_html() {
    // Check popups for post ID's.
    $popup_check = boostbox_popup_post_check( get_the_ID() );

    // Loop through popup checks.
    foreach ( $popup_check as $popup_id ) {
        echo boostbox_popup_build_html( $popup_id );
    }
}
add_action( 'wp_footer', 'boostbox_popup_html' );
