<?php
/**
 * The file that defines the metaboxes used by the BoostBox plugin
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    wp_die();
}

// Popup settings metabox.
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/metaboxes/boostbox-popup-settings.php';

// Display settings metabox.
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/metaboxes/boostbox-display-settings.php';

// Popup metrics metabox.
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/metaboxes/boostbox-metrics-settings.php';
