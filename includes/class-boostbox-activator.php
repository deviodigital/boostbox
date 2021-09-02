<?php

/**
 * Fired during plugin activation
 *
 * @link       https://deviodigital.com
 * @since      0.0.1
 *
 * @package    BoostBox
 * @subpackage BoostBox/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.1
 * @package    BoostBox
 * @subpackage BoostBox/includes
 * @author     Devio Digital <contact@deviodigital.com>
 */
class BoostBox_Activator {

	/**
	 * Activate.
	 *
	 * @since    0.0.1
	 */
	public static function activate() {
		// Add option for activation redirect.
		add_option( 'boostbox_do_activation_redirect', true );
	}

}
