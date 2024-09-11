<?php
/**
 * BoostBox Metabox - Display Settings
 *
 * This file is used to define the display settings metabox of the plugin.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin/metaboxes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    wp_die();
}

/**
 * Display Settings metabox
 *
 * Adds a display settings metabox to the BoostBox post type.
 *
 * @package    BoostBox
 * @subpackage BoostBox/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.1.0
 */
function boostbox_display_settings_metabox() {
    // Add Metabox.
    add_meta_box(
        'boostbox_display_settings',
        esc_attr__( 'Display Settings', 'boostbox' ),
        'boostbox_display_settings_metabox_content',
        'boostbox_popups',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'boostbox_display_settings_metabox' );

/**
 * Build the Display Settings metabox
 * 
 * @since  1.1.0
 * @return void
 */
function boostbox_display_settings_metabox_content() {
    global $post;

    // Noncename needed to verify where the data originated.
    echo '<input type="hidden" name="boostbox_display_settings_meta_noncename" id="boostbox_display_settings_meta_noncename" value="' .
    wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

    $tabs = [
        esc_attr__( 'General', 'boostbox' ),
        esc_attr__( 'Animation', 'boostbox' ),
        esc_attr__( 'Target', 'boostbox' ),
        esc_attr__( 'Trigger', 'boostbox' ),
        esc_attr__( 'Close Button', 'boostbox' ),
    ];

    // Tab label ID names.
    $tab_labels = ['first', 'second', 'third', 'fourth', 'fifth'];

    echo '<div class="radio-tabs">';

    $i = 0;

    // Loop through the tabs.
    foreach ( $tabs as $tab ) {
        $i++;
        if ( $i == 1 ) {
            $checked = 'checked';
        } else {
            $checked = '';
        }
        // Add the tab.
        echo '<input class="state" type="radio" title="' . esc_html( $tab ) . '" name="input-state" id="radio' . $i . '" ' . $checked . ' />';
    }

    echo '<div class="tabs">';

    $i = 0;

    // Loop through the tabs.
    foreach ( $tabs as $tab ) {
        $i++;
        // Get the current tab's label.
        $tab_label = isset( $tab_labels[$i - 1] ) ? $tab_labels[$i - 1] : 'tab' . $i;
        // Add the corresponding label with the dynamic ID.
        echo '<label for="radio' . $i . '" id="' . $tab_label . '-tab" class="tab">
                <div class="tab-label">' . esc_html( $tab ) . '</div>
            </label>';
    }

    echo '</div>

    <div class="panels">
        <div id="first-panel" class="panel active animated slideInRight">';
            // Create an array of locations.
            $locations = [
                'top-left'      => esc_attr__( 'Top Left', 'boostbox' ),
                'top-center'    => esc_attr__( 'Top Center', 'boostbox' ),
                'top-right'     => esc_attr__( 'Top Right', 'boostbox' ),
                'center-left'   => esc_attr__( 'Center Left', 'boostbox' ),
                'center-center' => esc_attr__( 'Center Center', 'boostbox' ),
                'center-right'  => esc_attr__( 'Center Right', 'boostbox' ),
                'bottom-left'   => esc_attr__( 'Bottom Left', 'boostbox' ),
                'bottom-center' => esc_attr__( 'Bottom Center', 'boostbox' ),
                'bottom-right'  => esc_attr__( 'Bottom Right', 'boostbox' ),
            ];

            // Filter the locations.
            $locations = apply_filters( 'boostbox_display_location_locations', $locations );

            // Display location.
            $display_location = get_post_meta( $post->ID, 'boostbox_display_location', true );

            if ( ! $display_location ) {
                $display_location = 'center-center';
            }

            // Select a popup location: Build the field.
            $field  = '<div class="boostbox-field">';
            $field .= '<p>' . esc_attr__( 'Display location', 'boostbox' ) . '</p>';
            $field .= '<select id="boostbox_display_location" name="boostbox_display_location">';
            // Loop through locations.
            if ( ! empty( $locations ) ) {
                foreach ( $locations as $location => $value ) {
                    $selected = '';
                    if ( $location == $display_location ) {
                        $selected = 'selected="selected"';
                    }
                    $field .= '<option value="' . esc_attr( $location ) . '" '. $selected .'>' . esc_html( $value ) . '</option>';
                }
            }
            $field .= '</select>';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

            // Max width.
            $max_width = get_post_meta( $post->ID, 'boostbox_display_max_width', true );

            // Max width: Build the field.
            $field  = '<div class="boostbox-field">';
            $field .= '<p>' . esc_attr__( 'Max width', 'boostbox' ) . '</p>';
            $field .= '<input type="text" name="boostbox_display_max_width" value="' . esc_attr( $max_width ) . '" class="widefat" />';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

            // Cookie Days.
            $cookie_days = get_post_meta( $post->ID, 'boostbox_cookie_days', true );

            // Cookie Days: Build the field.
            $field  = '<div class="boostbox-field">';
            $field .= '<p>' . esc_attr__( 'Cookie days (overrides global setting)', 'boostbox' ) . '</p>';
            $field .= '<input type="number" name="boostbox_cookie_days" value="' . esc_attr( $cookie_days ) . '" class="widefat" />';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

        echo wp_kses( '</div>

        <div id="second-panel" class="panel animated slideInRight">', boostbox_allowed_tags() );
            // Create an array of animations.
            $animations = [
                ''            => esc_attr__( '--', 'boostbox' ),
                'fade-in'     => esc_attr__( 'Fade in', 'boostbox' ),
                'slide-up'    => esc_attr__( 'Slide up', 'boostbox' ),
                'slide-down'  => esc_attr__( 'Slide down', 'boostbox' ),
                'slide-left'  => esc_attr__( 'Slide left', 'boostbox' ),
                'slide-right' => esc_attr__( 'Slide right', 'boostbox' ),
                'pop-swirl'   => esc_attr__( 'Pop swirl', 'boostbox' ),
                'anvil'       => esc_attr__( 'Anvil', 'boostbox' ),
            ];

            // Filter the animations.
            $animations = apply_filters( 'boostbox_animation_type_animations', $animations );

            // Popup animation.
            $popup_animation = get_post_meta( $post->ID, 'boostbox_animation_type', true );

            // Select an animation type: Build the field.
            $field  = '<div class="boostbox-field">';
            $field .= '<p>' . esc_attr__( 'Animation type', 'boostbox' ) . '</p>';
            $field .= '<select id="boostbox_animation_type" name="boostbox_animation_type">';
            // Loop through animations.
            if ( ! empty( $animations ) ) {
                foreach ( $animations as $animation => $value ) {
                    $selected = '';
                    if ( $animation == $popup_animation ) {
                        $selected = 'selected="selected"';
                    }
                    $field .= '<option value="' . esc_attr( $animation ) . '" '. $selected .'>' . esc_html( $value ) . '</option>';
                }
            }
            $field .= '</select>';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

            // Popup animation.
            $animation_speed = get_post_meta( $post->ID, 'boostbox_animation_speed', true );

            // Select an animation type: Build the field.
            $field  = '<div class="boostbox-field">';
            $field .= '<p>' . esc_attr__( 'Animation speed (milliseconds)', 'boostbox' ) . '</p>';
            $field .= '<input type="number" name="boostbox_animation_speed" value="' . esc_attr( $animation_speed ) . '" class="widefat" />';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

        echo wp_kses( '</div>

        <div id="third-panel" class="panel animated slideInRight">', boostbox_allowed_tags() );

        echo display_custom_post_type_select();

        echo wp_kses( '</div>

        <div id="fourth-panel" class="panel animated slideInRight">', boostbox_allowed_tags() );
            // Create an array of triggers.
            $triggers = [
                'auto-open'   => esc_attr__( 'Auto open', 'boostbox' ),
                'on-scroll'   => esc_attr__( 'On Scroll', 'boostbox' ),
                'time'        => esc_attr__( 'Time', 'boostbox' ),
            ];

            // Filter the triggers.
            $triggers = apply_filters( 'boostbox_trigger_type_triggers', $triggers );

            // Popup trigger.
            $trigger_type = get_post_meta( $post->ID, 'boostbox_trigger_type', true );

            // Select an trigger type: Build the field.
            $field  = '<div class="boostbox-field">';
            $field .= '<p>' . esc_attr__( 'Trigger type', 'boostbox' ) . '</p>';
            $field .= '<select id="boostbox_trigger_type" name="boostbox_trigger_type">';
            // Loop through triggers.
            if ( ! empty( $triggers ) ) {
                foreach ( $triggers as $trigger => $value ) {
                    $selected = '';
                    if ( $trigger == $trigger_type ) {
                        $selected = 'selected="selected"';
                    }
                    $field .= '<option value="' . esc_attr( $trigger ) . '" '. $selected .'>' . esc_html( $value ) . '</option>';
                }
            }
            $field .= '</select>';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

            // Display speed.
            $display_speed = get_post_meta( $post->ID, 'boostbox_display_speed', true );

            // Display Speed: Build the field.
            $field  = '<div class="boostbox-field display-speed">';
            $field .= '<p>' . esc_attr__( 'Display speed (milliseconds)', 'boostbox' ) . '</p>';
            $field .= '<input type="number" name="boostbox_display_speed" value="' . esc_attr( $display_speed ) . '" class="widefat" />';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

            // Scroll distance.
            $scroll_distance = get_post_meta( $post->ID, 'boostbox_scroll_distance', true );

            // Scroll distance: Build the field.
            $field  = '<div class="boostbox-field on-scroll">';
            $field .= '<p>' . esc_attr__( 'Scroll distance', 'boostbox' ) . '</p>';
            $field .= '<input type="text" name="boostbox_scroll_distance" value="' . esc_attr( $scroll_distance ) . '" class="widefat" />';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

        echo wp_kses( '</div>

        <div id="fifth-panel" class="panel animated slideInRight">', boostbox_allowed_tags() );
            // Create an array of placements.
            $placements = [
                'outside' => esc_attr__( 'Outside', 'boostbox' ),
                'inside'  => esc_attr__( 'Inside', 'boostbox' ),
                'hidden'  => esc_attr__( 'Hidden', 'boostbox' )
            ];
        
            // Filter the placement.
            $close_icon_placement = apply_filters( 'boostbox_close_icon_placements', $placements );

            // Icon placement.
            $icon_placement = get_post_meta( $post->ID, 'boostbox_close_icon_placement', true );

            // Select close icon placement: Build the field.
            $field  = '<div class="boostbox-field">';
            $field .= '<p>' . esc_attr__( 'Close icon placement', 'boostbox' ) . '</p>';
            $field .= '<select id="boostbox_close_icon_placement" name="boostbox_close_icon_placement">';
            // Loop through animations.
            if ( ! empty( $close_icon_placement ) ) {
                foreach ( $close_icon_placement as $placement => $value ) {
                    $selected = '';
                    if ( $placement == $icon_placement ) {
                        $selected = 'selected="selected"';
                    }
                    $field .= '<option value="' . esc_attr( $placement ) . '" '. $selected .'>' . esc_html( $value ) . '</option>';
                }
            }
            $field .= '</select>';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );

            // Close color.
            $close_color = get_post_meta( $post->ID, 'boostbox_close_icon_color', true );
            // Set default color to #FFFFFF if no value is saved.
            if ( empty( $close_color ) ) {
                $close_color = '#FFFFFF';
            }

            // Close Color: Build the field with WordPress color picker.
            $field  = '<div class="boostbox-field">';
            $field .= '<p>' . esc_attr__( 'Close icon color', 'boostbox' ) . '</p>';
            $field .= '<input type="text" class="boostbox-close-icon-color-picker" name="boostbox_close_icon_color" value="' . esc_attr( $close_color ) . '" />';
            $field .= '</div>';

            echo wp_kses( $field, boostbox_allowed_tags() );
        echo wp_kses( '</div>
    </div>

</div>', boostbox_allowed_tags() );
}

/**
 * Save the Metabox Data
 * 
 * @param int    $post_id 
 * @param object $post 
 * 
 * @since  1.1.0
 * @return void
 */
function boostbox_display_settings_metabox_save( $post_id, $post ) {
    /**
     * Verify this came from our screen and with proper authorization,
     * because save_post can be triggered at other times
     */
    if ( ! isset( $_POST['boostbox_display_settings_meta_noncename'] ) || ! wp_verify_nonce( $_POST['boostbox_display_settings_meta_noncename'], 'boostbox_display_settings_meta_nonce_action' ) ) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post->ID;
    }

    // Don't save during autosave.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post->ID;
    }

    // Don't save during post revision.
    if ( 'revision' === $post->post_type ) {
        return;
    }

    // Display settings.
    $settings_meta['boostbox_display_location']     = filter_input( INPUT_POST, 'boostbox_display_location' );
    $settings_meta['boostbox_trigger_type']         = filter_input( INPUT_POST, 'boostbox_trigger_type' );
    $settings_meta['boostbox_display_speed']        = filter_input( INPUT_POST, 'boostbox_display_speed' );
    $settings_meta['boostbox_animation_type']       = filter_input( INPUT_POST, 'boostbox_animation_type' );
    $settings_meta['boostbox_animation_speed']      = filter_input( INPUT_POST, 'boostbox_animation_speed' );
    $settings_meta['boostbox_display_max_width']    = filter_input( INPUT_POST, 'boostbox_display_max_width' );
    $settings_meta['boostbox_close_icon_color']     = sanitize_hex_color( filter_input( INPUT_POST, 'boostbox_close_icon_color' ) );
    $settings_meta['boostbox_close_icon_placement'] = filter_input( INPUT_POST, 'boostbox_close_icon_placement' );
    $settings_meta['boostbox_cookie_days']          = filter_input( INPUT_POST, 'boostbox_cookie_days' );
    $settings_meta['boostbox_scroll_distance']      = filter_input( INPUT_POST, 'boostbox_scroll_distance' );

    // Save custom post types (as an array).
    if ( isset( $_POST['custom_post_types'] ) ) {
        $custom_post_types = array_map( 'sanitize_text_field', (array) $_POST['custom_post_types'] );
        update_post_meta( $post_id, '_custom_post_types', $custom_post_types );
    } else {
        delete_post_meta( $post_id, '_custom_post_types' );
    }

    // Save selected posts (as an array).
    if ( isset( $_POST['posts'] ) ) {
        $selected_posts = array_map( 'sanitize_text_field', (array) $_POST['posts'] );
        update_post_meta( $post_id, '_selected_posts', $selected_posts );
    } else {
        delete_post_meta( $post_id, '_selected_posts' );
    }

    // Save general field (as an array).
    if ( isset( $_POST['general_field'] ) && is_array( $_POST['general_field'] ) ) {
        $general_field = array_map( 'sanitize_text_field', $_POST['general_field'] ); // Sanitize each value
        update_post_meta( $post_id, '_general_field', $general_field );
    } else {
        delete_post_meta( $post_id, '_general_field' );
    }

    // Save $settings_meta as metadata.
    foreach ( $settings_meta as $key => $value ) {
        // Check if the value is an array or a single value.
        $value = is_array( $value ) ? $value : sanitize_text_field( $value );

        // Check for meta value and either update or add the metadata.
        if ( get_post_meta( $post_id, $key, false ) ) {
            update_post_meta( $post_id, $key, $value );
        } else {
            add_post_meta( $post_id, $key, $value );
        }

        // Delete the meta value if blank.
        if ( empty( $value ) ) {
            delete_post_meta( $post_id, $key );
        }
    }
}
add_action( 'save_post', 'boostbox_display_settings_metabox_save', 1, 2 );
