<?php

/**
 * The plugin bootstrap file
 *
 * @package BoostBox
 * @author  Devio Digital <contact@deviodigital.com>
 * @license GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link    https://deviodigital.com
 * @since   0.0.1
 *
 * @wordpress-plugin
 * Plugin Name:       BoostBox
 * Plugin URI:        https://deviodigital.com/boostbox-lead-generation-plugin
 * Description:       Build popups for lead generation, content promotion and more.
 * Version:           0.0.1
 * Author:            Devio Digital
 * Author URI:        https://deviodigital.com
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       boostbox
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    wp_die();
}

// Current plugin version.
define( 'BOOSTBOX_VERSION', '0.0.1' );

// Plugin basename.
$plugin_name = plugin_basename( __FILE__ );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-boostbox-activator.php
 * 
 * @return void
 */
function activate_boostbox() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-boostbox-activator.php';
    BoostBox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-boostbox-deactivator.php
 * 
 * @return void
 */
function deactivate_boostbox() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-boostbox-deactivator.php';
    BoostBox_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_boostbox' );
register_deactivation_hook( __FILE__, 'deactivate_boostbox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * 
 * @return void
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-boostbox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since  0.0.1
 * @return void
 */
function run_boostbox() {

    $plugin = new BoostBox();
    $plugin->run();

}
run_boostbox();

/**
 * Add settings link on plugin page
 *
 * @param array $links an array of links related to the plugin.
 * 
 * @since  0.0.1
 * @return array updatead array of links related to the plugin.
 */
function boostbox_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=boostbox_settings">' . esc_attr__( 'Settings', 'boostbox' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
add_filter( "plugin_action_links_$plugin_name", 'boostbox_settings_link' );

/**
 * Redirect to the BoostBox Settings page on single plugin activation
 *
 * @since 0.0.1
 */
function boostbox_redirect() {
    if ( get_option( 'boostbox_do_activation_redirect', false ) ) {
        delete_option( 'boostbox_do_activation_redirect' );
        if ( ! isset( $_GET['activate-multi'] ) ) {
            wp_redirect( 'admin.php?page=boostbox_settings' );
        }
    }
}
add_action( 'admin_init', 'boostbox_redirect' );
