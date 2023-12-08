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
        'class' => array(),
        'id'    => array(),
        'name'  => array(),
        'value' => array(),
        'type'  => array(),
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
 * @return int|false Width of the first block, or false on failure.
 */
function get_first_block_width($post_id) {
    // Get the post content
    $post_content = get_post_field('post_content', $post_id);

    // Check if the post content is not empty
    if (!empty($post_content)) {
        // Parse the post content to get blocks
        $blocks = parse_blocks($post_content);

        echo '<pre>';
var_dump( $blocks );
echo '</pre>';
        // Check if there are blocks
        if (!empty($blocks)) {
            // Get the first block
            $first_block = $blocks[0];

            // Check if the block has attributes and a width attribute
            if (isset($first_block['attrs']['width'])) {
                // Return the width of the first block
                return $first_block['attrs']['width'];
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
            // Loop through the blocks to find the first cover block.
            foreach ( $blocks as $block ) {
                if ( $block['blockName'] === 'core/cover' ) {
                    // Check if the cover block has an 'align' attribute.
                    if ( isset( $block['attrs']['align'] ) ) {
                        // Get the alignment value.
                        $alignment = $block['attrs']['align'];

                        // Check if the theme has set a content width.
                        if ( isset( $content_width ) && is_numeric( $content_width ) ) {
                            $default_width = $content_width;
                            // Calculate the wide width based on the theme's content width.
                            $wide_width = $content_width * 1.5;
                        } else {
                            // Use a default wide width if content_width is not set.
                            $default_width = 980;
                            $wide_width    = 980;
                        }

                        echo '<pre>';
                        var_dump( $alignment );
                        echo '</pre>';

                        // Map alignment values to corresponding CSS styles.
                        switch ( $alignment ) {
                            case 'wide':
                                return 'margin-left: auto; margin-right: auto; max-width: ' . esc_html( $wide_width ) . 'px;';
                            case 'full':
                                return 'width: 100%; max-width: 100%;';
                            case 'center':
                                return 'width: 100%; max-width: ' . esc_html( $default_width ) . 'px;';
                            case 'left':
                                return 'width: 100%; max-width: ' . esc_html( $default_width ) . 'px;';
                            case 'right':
                                return 'width: 100%; max-width: ' . esc_html( $default_width ) . 'px;';
                            case 'none':
                                return 'width: 100%; max-width: ' . esc_html( $default_width ) . 'px;';
                        }
                    }
                }
            }
        }
    }

    // Return an empty string if no cover block or alignment found.
    return '';
}
