<?php

/**
 * The plugin bootstrap file
 *
 * @package BoostBox
 * @author  Devio Digital <contact@deviodigital.com>
 * @license GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link    https://deviodigital.com
 * @since   1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       BoostBox
 * Plugin URI:        https://robertdevore.com/boostbox-wordpress-popup-builder-for-the-core-editor/
 * Description:       Build popups for lead generation, content promotion and more using the core editor.
 * Version:           2.1.1
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

require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/deviodigital/boostbox/',
	__FILE__,
	'boostbox'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch( 'main' );

// Current plugin version.
define( 'BOOSTBOX_VERSION', '2.1.1' );

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
 * @since  1.0.0
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
 * @since  1.0.0
 * @return array updatead array of links related to the plugin.
 */
function boostbox_settings_link( $links ) {
    $settings_link = '<a href="edit.php?post_type=boostbox_popups&page=settings">' . esc_html__( 'Settings', 'boostbox' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
add_filter( "plugin_action_links_$plugin_name", 'boostbox_settings_link' );

/**
 * Redirect to the BoostBox Settings page on single plugin activation
 *
 * @since  1.0.0
 * @return void
 */
function boostbox_redirect() {
    if ( get_option( 'boostbox_do_activation_redirect', false ) ) {
        delete_option( 'boostbox_do_activation_redirect' );
        if ( ! isset( $_GET['activate-multi'] ) ) {
            wp_redirect( 'edit.php?post_type=boostbox_popups&page=settings' );
        }
    }
}
add_action( 'admin_init', 'boostbox_redirect' );

/**
 * Display a custom admin notice to inform users about plugin update issues.
 *
 * This function displays a dismissible admin notice warning users about 
 * restrictions imposed by WordPress® leadership that may impact automatic 
 * plugin updates. It provides a link to a resource where users can learn how 
 * to continue receiving updates.
 *
 * @since  2.0.1
 * @return void
 */
function boostbox_custom_update_notice() {
    // Check if the notice has been dismissed.
    if ( get_option( 'boostbox_custom_update_notice_dismissed' ) ) {
        return;
    }

    // Translating the notice text using WordPress® translation functions.
    $notice_text = sprintf(
        __( 'Important Notice: Due to recent changes initiated by WordPress® leadership, access to the plugin repository is being restricted for certain hosting providers and developers. This may impact automatic updates for your plugins. To ensure you continue receiving updates for BoostBox and to learn about the next steps, please visit %s.', 'boostbox' ),
        '<a href="https://robertdevore.com/wordpress-plugin-updates/" target="_blank">this page</a>'
    );

    // Display the admin notice.
    echo '<div class="notice notice-warning is-dismissible" id="custom-update-notice">
        <p>' . $notice_text . '</p>
    </div>';
}
add_action( 'admin_notices', 'boostbox_custom_update_notice' );

/**
 * Enqueue the JavaScript to handle the dismissal of the notice.
 * 
 * @since  2.0.1
 * @return void
 */
function boostbox_custom_update_notice_scripts() {
    wp_enqueue_script( 'boostbox-custom-notice-dismiss', plugin_dir_url( __FILE__ ) . 'public/js/custom-notice-dismiss.js', [ 'jquery' ], false, true );
    wp_localize_script( 'boostbox-custom-notice-dismiss', 'custom_notice', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'boostbox_custom_notice_dismiss_nonce' ),
    ] );
}
add_action( 'admin_enqueue_scripts', 'boostbox_custom_update_notice_scripts' );

/**
 * AJAX handler to mark the notice as dismissed.
 * 
 * @since  2.0.1
 * @return void
 */
function boostbox_custom_dismiss_update_notice() {
    check_ajax_referer( 'boostbox_custom_notice_dismiss_nonce', 'nonce' );
    update_option( 'boostbox_custom_update_notice_dismissed', 1 );
    wp_send_json_success();
}
add_action( 'wp_ajax_boostbox_custom_dismiss_update_notice', 'boostbox_custom_dismiss_update_notice' );

/**
 * Add Go Pro link on plugin page
 *
 * @param array $links an array of links related to the plugin.
 * 
 * @since  2.1.1
 * @return array updatead array of links related to the plugin.
 */
function boostbox_go_pro_link( $links ) {
    // Pro link.
    $pro_link = '<a href="https://deviodigital.com/product/boostbox-pro" target="_blank" style="font-weight:700;">' . esc_attr__( 'Go Pro', 'boostbox' ) . '</a>';

    if ( ! function_exists( 'run_boostbox_pro' ) ) {
        array_unshift( $links, $pro_link );
    }
    return $links;
}
add_filter( "plugin_action_links_$plugin_name", 'boostbox_go_pro_link' );

/**
 * Check BoostBox Pro version number.
 *
 * If the BoostBox Pro version number is less than what's defined below, there will
 * be a notice added to the admin screen letting the user know there's a new
 * version of the BoostBox Pro plugin available.
 *
 * @since  2.1.1
 * @return void
 */
function boostbox_check_pro_version() {
    // Only run if BoostBox Pro is active.
    if ( function_exists( 'run_boostbox_pro' ) ) {
        // Check if BoostBox Pro version is defined.
        if ( ! defined( 'BOOSTBOX_PRO_VERSION' ) ) {
            define( 'BOOSTBOX_PRO_VERSION', 0 ); // default to zero.
        }
        // Set pro version number.
        $pro_version = BOOSTBOX_PRO_VERSION;
        if ( '0' == $pro_version || $pro_version < '1.0.0' ) {
            add_action( 'admin_notices', 'boostbox_update_boostbox_pro_notice' );
        }
    }
}
add_action( 'admin_init', 'boostbox_check_pro_version' );

/**
 * Error notice - Runs if BoostBox Pro is out of date.
 *
 * @see    boostbox_check_pro_version()
 * @since  2.1.1
 * @return void
 */
function boostbox_update_boostbox_pro_notice() {
    $boostbox_orders = '<a href="https://www.deviodigital.com/my-account/orders/" target="_blank">' . esc_attr__( 'Orders', 'boostbox' ) . '</a>';
    $error       = sprintf( esc_html__( 'There is a new version of BoostBox Pro available. Download your copy from the %1$s page on Devio Digital.', 'boostbox' ), $boostbox_orders );
    echo '<div class="notice notice-info"><p>' . $error . '</p></div>';
}
