<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://deviodigital.com
 * @since      0.0.1
 *
 * @package    BoostBox
 * @subpackage BoostBox/public
 */

/**
 * Popup HTML
 * 
 * The HTML used to create the popups
 * 
 * @since  0.0.1
 * @return void
 */
function boostbox_popup_html() {
    // @todo make the ID in wp_remote_get dynamic.
    $popup_id = get_post_meta( get_the_ID(), 'boostbox_popup_selected', true );
    echo '<pre>';
    var_dump( $popup_id );
    echo '</pre>';
    // Bail early?
    if ( ! $popup_id ) { return; }
    // Get blog post from rest API.
    $response = wp_remote_get( 'https://deviodigital.dev.cc/wp-json/wp/v2/popups/' . $popup_id );
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
    ?>
    <!--Creates the popup body-->
    <div class="boostbox-popup-overlay">
    <!--Creates the popup content-->
    <div class="boostbox-popup-content">
        <?php echo $popup->content->rendered; ?>
        <!--popup's close button-->
        <button class="boostbox-close"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg></button>
    </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'boostbox_popup_html' );
