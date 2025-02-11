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
 * Plugin URI:        https://robertdevore.com/project/boostbox/
 * Description:       Build popups for lead generation, content promotion and more using the core editor.
 * Version:           2.2.1
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

require 'vendor/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/deviodigital/boostbox/',
    __FILE__,
    'boostbox'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch( 'main' );

// Current plugin version.
define( 'BOOSTBOX_VERSION', '2.2.1' );

// Check if Composer's autoloader is already registered globally.
if ( ! class_exists( 'RobertDevore\WPComCheck\WPComPluginHandler' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use RobertDevore\WPComCheck\WPComPluginHandler;

new WPComPluginHandler( plugin_basename( __FILE__ ), 'https://robertdevore.com/why-this-plugin-doesnt-support-wordpress-com-hosting/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-boostbox-activator.php
 * 
 * @since  1.0.0
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
 * @since  1.0.0
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
 * @since  1.0.0
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
