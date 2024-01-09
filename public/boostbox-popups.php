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
    global $content_width;
    // Settings.
    $settings = get_option( 'boostbox_general' );
    // Get the popup ID.
    $popup_id = get_post_meta( get_the_ID(), 'boostbox_popup_selected', true );
    // Check for global popup.
    if ( '' == $popup_id ) {
        $popup_id = $settings['boostbox_global_popup'];
    }
    // Bail early?
    if ( ! $popup_id || 'popup_disabled' == $popup_id ) { return; }

    // Set popup width from popup meta.
    $popup_width = 'max-width: ' . get_post_meta( $popup_id, 'boostbox_display_max_width', true );
    // Set width based on the first block, or defaults as a fallback.
    if ( ! get_post_meta( $popup_id, 'boostbox_display_max_width', true ) ) {
        $popup_width = get_cover_block_styles( $popup_id );
    }
    // Get the popup max width (if any).
    $max_width = 'style="' . $popup_width . '"';
    // Popup position.
    $popup_position = get_post_meta( $popup_id, 'boostbox_display_location', true );
    // Popup animation.
    $popup_animation = get_post_meta( $popup_id, 'boostbox_animation_type', true );
    // @TODO set custom icon options in the settings for users to choose from.
    $close_icon = apply_filters( 'boostbox_popup_close_icon', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>' );
    // Popup overlay classes.
    $popup_overlay_classes = apply_filters( 'boostbox_popup_overlay_classes', 'boostbox-popup-overlay' );
    // Popup content classes.
    $popup_content_classes = apply_filters( 'boostbox_popup_content_classes', 'boostbox-popup-content' );
    ?>
    <!--Creates the popup body-->
    <div class="<?php echo $popup_overlay_classes; ?>">
    <!--Creates the popup content-->
    <div class="<?php echo $popup_content_classes; ?> <?php echo $popup_position . ' ' . $popup_animation; ?>"<?php echo $max_width; ?>>
        <?php
        // Query args.
        $args = array(
            'post_type'           => 'boostbox_popups',
            'post_status'         => 'publish',
            'p'                   => $popup_id,
            'no_found_rows'       => true,
            'ignore_sticky_posts' => true
        );

        // Filter the args.
        $args = apply_filters( 'boostbox_popup_html_wp_query_args', $args );

        // Build the query.
        $query = new WP_Query( $args );

        // Check if there are any posts.
        if ( $query->have_posts() ) {
            // Loop through the posts.
            while ( $query->have_posts() ) {
                $query->the_post();
                    the_content();
            }
            // Restore original post data.
            wp_reset_postdata();
        }
        ?>
        <!--popup's close button-->
        <button class="boostbox-close"><?php print_r( $close_icon ); ?></button>
    </div>
    </div>
    <?php
}
add_action( 'template_redirect', 'boostbox_popup_html' );
