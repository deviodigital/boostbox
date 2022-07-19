<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      0.0.1
  */

/**
 * Adds a menu item for the BoostBox page.
 *
 * @since  0.0.1
 * @return void
 */
function boostbox_settings_page_menu() {

    add_submenu_page(
        'edit.php?post_type=boostbox_popups',
        esc_attr__( 'BoostBox Settings', 'boostbox' ),
        esc_attr__( 'Settings', 'boostbox' ),
        'manage_options',
        'boostbox_settings',
        'boostbox_settings_page'
    );

}
add_action( 'admin_menu', 'boostbox_settings_page_menu', 99 );

/**
 * Outputs the markup used on the Getting Started
 *
 * @since  0.0.1
 * @return string
 */
function boostbox_settings_page() {
    ?>
    <div class="wrap boostbox">
        <div class="intro-wrap">
            <div class="intro">
                <a href="<?php echo esc_url( 'https://deviodigital.com/' ); ?>"><img class="devio-digital-logo" src="<?php echo esc_url( plugins_url( 'images/logo.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Visit Devio Digital', 'boostbox' ); ?>" /></a>
                <h3><strong><?php esc_html_e( 'BoostBox', 'boostbox' ); ?></strong> <?php esc_html_e( 'Settings', 'boostbox' ); ?></h3>
            </div>
        </div>

        <div class="panels">
            <div id="panel" class="panel">
                <div id="boostbox-panel" class="panel-left visible">
                    <div class="block-feature-wrap clear">
                        <div class="boostbox-content">
                        <form action="options.php" method="post">
                            <?php 
                            settings_fields( 'boostbox_admin_settings' );
                            do_settings_sections( 'boostbox_admin' );
                            ?>
                            <input
                            type="submit"
                            name="submit"
                            class="button button-primary"
                            value="<?php esc_attr_e( 'Save' ); ?>"
                            />
                        </form>
                        </div><!-- .boostbox-content -->
                    </div><!-- .block-feature-wrap -->
                </div><!-- .panel-left -->

                <div class="footer-wrap">
                    <div class="footer">
                        <div class="footer-links">
                            <a href="https://deviodigital.com/" target="_blank"><?php esc_html_e( 'Devio Digital', 'boostbox' ); ?></a>
                            <a href="https://deviodigial.com/documentation/" target="_blank"><?php esc_html_e( 'Docs', 'boostbox' ); ?></a>
                            <a href="https://twitter.com/deviodigital" target="_blank"><?php esc_html_e( 'Twitter', 'boostbox' ); ?></a>
                        </div>
                    </div>
                </div><!-- .footer-wrap -->
            </div><!-- .panel -->
        </div><!-- .panels -->
    </div><!-- .boostbox -->
    <?php
}

/**
 * Register settings
 * 
 * @since  1.0.0
 * @return void
 */
function boostbox_register_settings() {
    register_setting(
        'boostbox_admin_settings',
        'boostbox_admin_settings',
        'boostbox_validate_admin_settings'
    );
    add_settings_section(
        'global_settings',
        '',
        'boostbox_global_settings_text',
        'boostbox_admin'
    );
    add_settings_field(
        'global_popup_field',
        esc_attr__( 'Global popup', 'boostbox' ),
        'boostbox_render_global_popup_field',
        'boostbox_admin',
        'global_settings'
    );
}
add_action( 'admin_init', 'boostbox_register_settings' );

/**
 * Validate admin settings
 * 
 * @param [type] $input 
 * 
 * @since  1.0.0
 * @return array
 */
function boostbox_validate_admin_settings( $input ) {
    $output['global_popup_field'] = sanitize_text_field( $input['global_popup_field'] );

    return $output;
}

/**
 * Global Settins text (if any)
 * 
 * @since  1.0.0
 * @return string
 */
function boostbox_global_settings_text() {
    // Uncomment if more text needs added to the section.
    //echo '<p>' . esc_attr__( 'Global Settings', 'boostbox' ) . '</p>';
}

/**
 * Render the global popup field
 * 
 * @since  1.0.0
 * @return string
 */
function boostbox_render_global_popup_field() {
    $options = get_option( 'boostbox_admin_settings' );

    // Args for popups.
    $args = array(
        'sort_order'   => 'asc',
        'sort_column'  => 'post_title',
        'hierarchical' => 1,
        'exclude'      => '',
        'include'      => '',
        'meta_key'     => '',
        'meta_value'   => '',
        'authors'      => '',
        'child_of'     => 0,
        'parent'       => -1,
        'exclude_tree' => '',
        'number'       => '',
        'offset'       => 0,
        'post_type'    => 'boostbox_popups',
        'post_status'  => 'publish'
    );

    $args = apply_filters( 'boostbox_popup_settings_args', $args );

    // Get all popups.
    $popups = get_posts( $args );


    printf(
        '<select id="boostbox_popup_selected" name="boostbox_popup_selected">'
    );

    printf(
        '<option value="">' . esc_attr__( '--', 'boostbox' ) . '</option>'
    );

    // Loop through popups.
    if ( ! empty( $popups ) ) {
        foreach ( $popups as $popup ) {
            if ( $popup->ID == $popup_selected ) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            printf( '<option value="%s" '. $selected .'>%s</option>', esc_attr( $popup->ID ), esc_html( $popup->post_title ) );
        }
    }
    printf(
        '</select>'
    );

}
