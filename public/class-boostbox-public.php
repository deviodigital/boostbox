<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/public
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    BoostBox
 * @subpackage BoostBox/public
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */
class BoostBox_Public {

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $_plugin_name - The ID of this plugin.
     */
    private $_plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $_version - The current version of this plugin.
     */
    private $_version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $_plugin_name - The name of the plugin.
     * @param string $_version     - The version of this plugin.
     * 
     * @since  1.0.0
     * @return void
     */
    public function __construct( $_plugin_name, $_version ) {

        $this->plugin_name = $_plugin_name;
        $this->version     = $_version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_styles() {
        // Publc CSS.
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boostbox-public.min.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_scripts() {
        // Popup ID.
        $popup_id = get_post_meta( get_the_ID(), 'boostbox_popup_selected', true );
        // Milliseconds.
        $milliseconds = get_post_meta( $popup_id, 'boostbox_display_speed', true );
        if ( ! $milliseconds ) {
            $milliseconds = 0;
        }
        // Create localize script args.
        $localize_args = array(
            'popup_id'     => $popup_id,
            'milliseconds' => $milliseconds,
            'cookie_days'  => '',
            'trigger'      => get_post_meta( $popup_id, 'boostbox_trigger_type', true )
        );
        // Filter the args.
        $localize_args = apply_filters( 'boostbox_localize_scripts_args', $localize_args );
        // Public JS.
        wp_enqueue_script( $this->plugin_name . '-js-cookie', plugin_dir_url( __FILE__ ) . 'js/js.cookie.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boostbox-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'boostbox_settings', $localize_args );
    }

}
