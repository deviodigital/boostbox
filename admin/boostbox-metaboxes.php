<?php
/**
 * The file that defines the metaboxes used by the Tape Tracker plugin
 *
 * @link       https://deviodigital.com
 * @since      0.0.1
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Popup settings metabox.
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/metaboxes/boostbox-popup-settings.php';
