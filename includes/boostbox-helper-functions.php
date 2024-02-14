<?php

/**
 * The file that defines the core helper functions
 *
 * @package    BoostBox
 * @subpackage BoostBox/includes
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
 * Allowed HTML tags
 * 
 * This function extends the wp_kses_allowed_html function to include
 * a handful of additional HTML fields that are used throughout
 * this plugin
 * 
 * @since  1.0.0
 * @return array
 */
function boostbox_allowed_tags() {
    $my_allowed = wp_kses_allowed_html( 'post' );
    // iframe
    $my_allowed['iframe'] = array(
        'src'             => array(),
        'height'          => array(),
        'width'           => array(),
        'frameborder'     => array(),
        'allowfullscreen' => array(),
    );
    // form fields - input
    $my_allowed['input'] = array(
        'class'   => array(),
        'id'      => array(),
        'name'    => array(),
        'value'   => array(),
        'type'    => array(),
        'checked' => array(),
    );
    // select
    $my_allowed['select'] = array(
        'class' => array(),
        'id'    => array(),
        'name'  => array(),
        'value' => array(),
        'type'  => array(),
    );
    // select options
    $my_allowed['option'] = array(
        'selected' => array(),
        'value'    => array(),
    );
    // style
    $my_allowed['style'] = array(
        'types' => array(),
    );
    // SVG.
    $my_allowed['svg'] = array(
        'xmlns'          => array(),
        'width'          => array(),
        'height'         => array(),
        'viewbox'        => array(),
        'class'          => array(),
        'aria-hidden'    => array(),
        'aria-labeledby' => array()
    );
    $my_allowed['path'] = array(
        'd'    => array(),
        'fill' => array()
    );
    return $my_allowed;
}

/**
 * Get the width of the first block in WordPress post content.
 *
 * @param int $post_id Post ID.
 * 
 * @return int|false Width of the first block, or false on failure.
 */
function get_first_block_width( $post_id ) {
    // Get the post content
    $post_content = get_post_field( 'post_content', $post_id );

    // Check if the post content is not empty
    if ( ! empty( $post_content ) ) {
        // Parse the post content to get blocks
        $blocks = parse_blocks( $post_content );

        // Check if there are blocks
        if (!empty($blocks)) {
            // Get the first block
            $first_block = $blocks[0];

            // Check if the block has attributes and a width attribute
            if ( isset( $first_block['attrs']['width'] ) ) {
                // Return the width of the first block.
                return $first_block['attrs']['width'];
            } elseif ( isset( $first_block['attrs']['align'] ) ) {
                return $first_block['attrs']['align'];
            }
        }
    }

    // Return false if unable to get the width
    return false;
}


/**
 * Get the alignment of the first cover block in WordPress post content.
 * Apply CSS styles based on the alignment.
 *
 * @param int $post_id Post ID.
 * 
 * @return string CSS styles for cover block alignment.
 */
function get_cover_block_styles( $post_id ) {
    global $content_width;
    // Get the post content.
    $post_content = get_post_field( 'post_content', $post_id );

    // Check if the post content is not empty
    if ( ! empty( $post_content ) ) {
        // Parse the post content to get blocks
        $blocks = parse_blocks( $post_content );

        // Check if there are blocks.
        if ( ! empty( $blocks ) ) {
            // Check if the cover block has an 'align' attribute.
            if ( isset( $blocks[0]['attrs']['align'] ) ) {
                // Get the alignment value.
                $alignment = $blocks[0]['attrs']['align'];

                // Check if the theme has set a content width.
                if ( isset( $content_width ) && is_numeric( $content_width ) ) {
                    $default_width = $content_width;
                    // Calculate the wide width based on the theme's content width.
                    $wide_width = $content_width * 1.5;
                } else {
                    // Use a default wide width if content_width is not set.
                    $default_width = apply_filters( 'boostbox_popup_default_width', 980 );
                    $wide_width    = apply_filters( 'boostbox_popup_default_wide_width', 980 );
                }

                // Map alignment values to corresponding CSS styles.
                switch ( $alignment ) {
                    case 'wide':
                        return 'margin-left: auto; margin-right: auto; width: ' . esc_html( $wide_width ) . 'px; max-width: 100%;';
                    case 'full':
                        return 'width: 100%; max-width: 100%;';
                    case 'center':
                        return 'width: ' . esc_html( $default_width ) . 'px; max-width: 100%;';
                    case 'left':
                        return 'width: ' . esc_html( $default_width ) . 'px; max-width: 100%;';
                    case 'right':
                        return 'width: ' . esc_html( $default_width ) . 'px; max-width: 100%;';
                    case 'none':
                        return 'width: ' . esc_html( $default_width ) . 'px; max-width: 100%;';
                }
            }
        }
    }

    // Return an empty string if no cover block or alignment found.
    return '';
}

/**
 * Get popup conversion rate
 * 
 * @param int $popup_id - the Popup ID to retrieve data for.
 * 
 * @return string
 */
function boostbox_popup_conversion_rate( $popup_id ) {
    // Check if $popup_id is provided and is an integer.
    if ( ! isset( $popup_id ) || ! is_int( $popup_id ) ) {
        return '';
    }

    // Get the impression count.
    $impressions = get_post_meta( $popup_id, 'boostbox_popup_impressions', true );
    if ( ! $impressions ) {
        $impressions = 0;
    }
    // Get the conversion count.
    $conversions = get_post_meta( $popup_id, 'boostbox_popup_conversions', true );
    if ( ! $conversions) {
        $conversions = 0;
    }

    // Calculate the conversion percentage.
    $conversion_percentage = ( $impressions > 0 ) ? ( $conversions / $impressions ) * 100 : 0;

    // Format the percentage with 2 decimal places and add the percentage symbol.
    $formatted_percentage = number_format( $conversion_percentage, 2 ) . '%';

    return apply_filters( 'boostbox_popup_conversion_rate_formatted_percentage', $formatted_percentage, $conversion_percentage );
}

/**
 * Settings - Disable analytics
 * 
 * @since  1.6.0
 * @return bool
 */
function boostbox_settings_disable_analytics() {
    // Get the general settings.
    $settings = get_option( 'boostbox_general' );
    // Disable anaytics.
    $disable_analytics = true;
    if ( ! isset( $settings['boostbox_privacy_disable_analytics'] ) ) {
        $disable_analytics = false;
    } elseif ( isset( $settings['boostbox_privacy_disable_analytics'] ) && 'on' !== $settings['boostbox_privacy_disable_analytics'] ) {
        $disable_analytics = false;
    }

    return $disable_analytics;
}

/**
 * Settings - Cookie days
 * 
 * @param int $popup_id - the popup ID to check for overrides from
 * 
 * @since  1.6.0
 * @return int
 */
function boostbox_settings_cookie_days( $popup_id = null ) {
    // Cookie days.
    $settings    = get_option( 'boostbox_general' );
    $cookie_days = 30;

    // Check if the setting is filled out.
    if ( isset( $settings['boostbox_cookie_days'] ) ) {
        $cookie_days = $settings['boostbox_cookie_days'];
    }

    // Override global cookie days with popup setting.
    if ( isset( $popup_id ) && get_post_meta( $popup_id, 'boostbox_cookie_days', true ) ) {
        $cookie_days = get_post_meta( $popup_id, 'boostbox_cookie_days', true );
    }

    return $cookie_days;
}
