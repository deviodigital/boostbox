<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/public
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      0.0.1
 */

/**
 * Popup HTML
 * 
 * The HTML used to create the popups
 * 
 * @todo   Update $popup_id to use the Global popup selected in the settings
 * @since  0.0.1
 * @return string 
 */
function boostbox_popup_html() {
    // Get the popup ID.
    $popup_id = get_post_meta( get_the_ID(), 'boostbox_popup_selected', true );

    // Bail early?
    if ( ! $popup_id ) { return; }

    // Get blog post from rest API.
    $response = wp_remote_get( get_bloginfo( 'home' ) . '/wp-json/wp/v2/popups/' . $popup_id, array( 'sslverify' => FALSE ) );

    // Exit if error.
    if ( is_wp_error( $response ) ) {
        return;
    }

    // Get the body.
    $popup = json_decode( wp_remote_retrieve_body( $response ) );

    // Exit if nothing is returned.
    if ( empty( $popup ) ) {
        return;
    }

    $close_icon = apply_filters( 'boostbox_popup_close_icon', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>' );
    ?>
    <div class="boostbox-popup-overlay">
        <div class="boostbox-popup-content">
            <?php print_r( $popup->content->rendered ); ?>
            <!--popup's close button-->
            <button class="boostbox-close">
                <?php print_r( $close_icon ); ?>
            </button>
        </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'boostbox_popup_html' );
