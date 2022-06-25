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
 * Adds a menu item for the Analytics page.
 *
 * since 0.0.1
 */
function boostbox_analytics_page_menu() {

    add_submenu_page(
        'edit.php?post_type=boostbox_popups',
        __( 'BoostBox Analytics', 'boostbox' ),
        __( 'Analytics', 'boostbox' ),
        'manage_options',
        'boostbox_analytics',
        'boostbox_analytics_page'
    );

}
add_action( 'admin_menu', 'boostbox_analytics_page_menu', 99 );

/**
 * Outputs the markup used on the Getting Started
 *
 * since 0.0.1
 */
function boostbox_analytics_page() {
?>
    <div class="wrap boostbox analytics">
        <div class="intro-wrap">
            <div class="intro">
                <a href="<?php echo esc_url( 'https://deviodigital.com/' ); ?>"><img class="devio-digital-logo" src="<?php echo esc_url( plugins_url( 'images/logo.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Visit Devio Digital', 'boostbox' ); ?>" /></a>
                <h3><strong><?php printf( esc_html__( 'BoostBox', 'boostbox' ) ); ?></strong> <?php printf( esc_html__( 'Analytics', 'boostbox' ) ); ?></h3>
            </div>
        </div>

        <div class="panels">
            <div id="panel" class="panel">
                <div id="boostbox-analytics-panel" class="panel-left visible">
                    <div class="block-feature-wrap clear">
                        <div class="boostbox-analytics-charts">

                            <div class="section-title">
                                <h2><?php _e( 'Popup Statistics', 'boostbox' ); ?></h2>
                            </div><!-- /.section-title -->

                            <div class="viewport-main">
                                <div class="viewport-top">
                                    <div class="viewport-top-dot"></div>
                                    <div class="viewport-top-dot"></div>
                                    <div class="viewport-top-dot"></div>
                                    <span class="title"><?php _e( 'Overview', 'boostbox' ); ?></span>
                                </div><!-- /.viewport-top -->
                                <div class="viewport-body">
                                    <canvas id="bar-chart"></canvas>
                                </div><!-- /.viewport-body -->
                            </div><!-- /.viewport-main -->

                            <div class="section-title">
                                <h2><?php _e( 'Popup Statistics', 'boostbox' ); ?></h2>
                            </div><!-- /.section-title -->

                            <div class="viewport-main two">
                                <div class="viewport-top">
                                    <div class="viewport-top-dot"></div>
                                    <div class="viewport-top-dot"></div>
                                    <div class="viewport-top-dot"></div>
                                    <span class="title"><?php _e( 'Impressions', 'boostbox' ); ?></span>
                                </div><!-- /.viewport-top -->
                                <div class="viewport-body">
                                    <canvas id="doughnut-chart"></canvas>
                                </div><!-- /.viewport-body -->
                            </div><!-- /.viewport-main.two -->

                            <div class="viewport-main two">
                                <div class="viewport-top">
                                    <div class="viewport-top-dot"></div>
                                    <div class="viewport-top-dot"></div>
                                    <div class="viewport-top-dot"></div>
                                    <span class="title"><?php _e( 'Conversions', 'boostbox' ); ?></span>
                                </div><!-- /.viewport-top -->
                                <div class="viewport-body">
                                    <canvas id="doughnut-chart-2"></canvas>
                                </div><!-- /.viewport-body -->
                            </div><!-- /.viewport-main.two -->

                        </div><!-- .boostbox-analytics-charts -->
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
    </div><!-- .boostbox-analytics -->
<?php
}
