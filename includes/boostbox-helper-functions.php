<?php

/**
 * The file that defines the core helper functions
 *
 * @package    BoostBox
 * @subpackage BoostBox/includes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      0.0.1
 */

/**
 * Allowed HTML tags
 * 
 * This function extends the wp_kses_allowed_html function to include
 * a handful of additional HTML fields that are used throughout
 * this plugin
 * 
 * @since  0.0.1
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
