<?php

/**
 * Fired during plugin activation
 *
 * @package    BoostBox
 * @subpackage BoostBox/includes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      0.0.1
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    BoostBox
 * @subpackage BoostBox/includes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      0.0.1
 */
class BoostBox_Activator {

    /**
     * Activate.
     *
     * @since  0.0.1
     * @return void
     */
    public static function activate() {
        // Add option for activation redirect.
        add_option( 'boostbox_do_activation_redirect', true );
        // Custom post type.
        boostbox_popups();
        // Flush Rewrite Rules
        global $wp_rewrite;
        $wp_rewrite->init();
        $wp_rewrite->flush_rules();
    }

}
