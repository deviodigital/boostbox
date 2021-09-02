<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://deviodigital.com
 * @since      0.0.1
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 */

/**
 * Adds a menu item for the BoostBox page.
 *
 * since 0.0.1
 */
function boostbox_settings_page_menu() {

	add_submenu_page(
		'edit.php?post_type=boostbox_popups',
		__( 'BoostBox Settings', 'boostbox' ),
		__( 'Settings', 'boostbox' ),
		'manage_options',
		'boostbox_settings',
		'boostbox_settings_page'
	);

}
add_action( 'admin_menu', 'boostbox_settings_page_menu', 99 );

/**
 * Outputs the markup used on the Getting Started
 *
 * since 0.0.1
 */
function boostbox_settings_page() {
?>
	<div class="wrap boostbox">
		<div class="intro-wrap">
			<div class="intro">
				<a href="<?php echo esc_url( 'https://deviodigital.com/' ); ?>"><img class="dispensary-logo" src="<?php echo esc_url( plugins_url( 'images/logo.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Visit Devio Digital', 'boostbox' ); ?>" /></a>
				<h3><?php printf( esc_html__( 'Getting started with', 'boostbox' ) ); ?> <strong><?php printf( esc_html__( 'BoostBox', 'boostbox' ) ); ?></strong></h3>
			</div>
		</div>

		<div class="panels">
			<div id="panel" class="panel">
				<div id="boostbox-panel" class="panel-left visible">
					<div class="block-feature-wrap clear">
						<div class="boostbox-content">

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
