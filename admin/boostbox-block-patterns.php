<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://deviodigital.com
 * @since      0.0.1
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 */

function boostbox_wp_block_patterns() {

    register_block_pattern_category(
        'boostbox',
        array( 'label' => __( 'BoostBox', 'boostbox' ) )
    );

    register_block_pattern(
        'boostbox-patterns/boostbox-popup-1',
        array(
            'title'       => __( 'Popup #1', 'boostbox' ),
            'description' => _x( 'Promote a video with this popup', 'Block pattern description', 'boostbox' ),
            'content'     => "<!-- wp:cover -->\n<div class=\"wp-block-cover has-background-dim\"><div class=\"wp-block-cover__inner-container\"></div></div>\n<!-- /wp:cover -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:heading -->\n<h2>Heading</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Content Area #1</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:heading -->\n<h2>Heading</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Content Area #2</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:separator {\"className\":\"is-style-wide\"} -->\n<hr class=\"wp-block-separator is-style-wide\"/>\n<!-- /wp:separator -->\n\n<!-- wp:paragraph -->\n<p>Content Area #3</p>\n<!-- /wp:paragraph -->",
            'categories'  => array( 'boostbox' ),
        )
    );

}    
add_action( 'init', 'boostbox_wp_block_patterns' );