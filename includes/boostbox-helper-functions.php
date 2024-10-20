<?php

/**
 * The file that defines the core helper functions
 *
 * @package    BoostBox
 * @subpackage BoostBox/includes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://deviodigital.com
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Allowed HTML tags
 * 
 * This function extends the wp_kses_allowed_html function to include
 * a handful of additional HTML fields that are used throughout
 * this plugin
 * 
 * @since  1.0.0
 * @return array
 */
function boostbox_allowed_tags() {
    $my_allowed = wp_kses_allowed_html( 'post' );
    // iframe
    $my_allowed['iframe'] = [
        'src'             => [],
        'height'          => [],
        'width'           => [],
        'frameborder'     => [],
        'allowfullscreen' => [],
    ];
    // form fields - input
    $my_allowed['input'] = [
        'class'   => [],
        'id'      => [],
        'name'    => [],
        'value'   => [],
        'type'    => [],
        'checked' => [],
    ];
    // select
    $my_allowed['select'] = [
        'class' => [],
        'id'    => [],
        'name'  => [],
        'value' => [],
        'type'  => [],
    ];
    // select options
    $my_allowed['option'] = [
        'selected' => [],
        'value'    => [],
    ];
    // style
    $my_allowed['style'] = [
        'types' => [],
    ];
    // SVG.
    $my_allowed['svg'] = [
        'xmlns'           => [],
        'width'           => [],
        'height'          => [],
        'viewBox'         => [],
        'stroke-width'    => [],
        'stroke'          => [],
        'fill'            => [],
        'stroke-linecap'  => [],
        'stroke-linejoin' => [],
        'class'           => [],
    ];
    $my_allowed['path'] = [
        'd'      => [],
        'stroke' => [],
        'fill'   => [],
    ];
    $my_allowed['line'] = [
        'x1' => [],
        'y1' => [],
        'x2' => [],
        'y2' => [],
        'stroke' => [],
    ];

    return $my_allowed;
}

/**
 * Get the width of the first block in WordPress post content.
 *
 * @param int $post_id Post ID.
 * 
 * @return int|false Width of the first block, or false on failure.
 */
function get_first_block_width( $post_id ) {
    // Get the post content
    $post_content = get_post_field( 'post_content', $post_id );

    // Check if the post content is not empty
    if ( ! empty( $post_content ) ) {
        // Parse the post content to get blocks
        $blocks = parse_blocks( $post_content );

        // Check if there are blocks
        if (!empty($blocks)) {
            // Get the first block
            $first_block = $blocks[0];

            // Check if the block has attributes and a width attribute
            if ( isset( $first_block['attrs']['width'] ) ) {
                // Return the width of the first block.
                return $first_block['attrs']['width'];
            } elseif ( isset( $first_block['attrs']['align'] ) ) {
                return $first_block['attrs']['align'];
            }
        }
    }

    // Return false if unable to get the width
    return false;
}


/**
 * Get the alignment of the first cover block in WordPress post content.
 * Apply CSS styles based on the alignment.
 *
 * @param int $post_id Post ID.
 * 
 * @return string CSS styles for cover block alignment.
 */
function get_cover_block_styles( $post_id ) {
    global $content_width;
    // Get the post content.
    $post_content = get_post_field( 'post_content', $post_id );

    // Check if the post content is not empty
    if ( ! empty( $post_content ) ) {
        // Parse the post content to get blocks
        $blocks = parse_blocks( $post_content );

        // Check if there are blocks.
        if ( ! empty( $blocks ) ) {
            // Check if the cover block has an 'align' attribute.
            if ( isset( $blocks[0]['attrs']['align'] ) ) {
                // Get the alignment value.
                $alignment = $blocks[0]['attrs']['align'];

                // Check if the theme has set a content width.
                if ( isset( $content_width ) && is_numeric( $content_width ) ) {
                    $default_width = $content_width;
                    // Calculate the wide width based on the theme's content width.
                    $wide_width = $content_width * 1.5;
                } else {
                    // Use a default wide width if content_width is not set.
                    $default_width = apply_filters( 'boostbox_popup_default_width', 980 );
                    $wide_width    = apply_filters( 'boostbox_popup_default_wide_width', 980 );
                }

                // Map alignment values to corresponding CSS styles.
                switch ( $alignment ) {
                    case 'wide':
                        return 'margin-left: auto; margin-right: auto; width: ' . esc_html( $wide_width ) . 'px; max-width: 100%;';
                    case 'full':
                        return 'width: 100%; max-width: 100%;';
                    case 'center':
                        return 'width: ' . esc_html( $default_width ) . 'px; max-width: 100%;';
                    case 'left':
                        return 'width: ' . esc_html( $default_width ) . 'px; max-width: 100%;';
                    case 'right':
                        return 'width: ' . esc_html( $default_width ) . 'px; max-width: 100%;';
                    case 'none':
                        return 'width: ' . esc_html( $default_width ) . 'px; max-width: 100%;';
                }
            }
        }
    }

    // Return an empty string if no cover block or alignment found.
    return '';
}

/**
 * Get popup conversion rate
 * 
 * @param int $popup_id - the Popup ID to retrieve data for.
 * 
 * @return string
 */
function boostbox_popup_conversion_rate( $popup_id ) {
    // Check if $popup_id is provided and is an integer.
    if ( ! isset( $popup_id ) || ! is_int( $popup_id ) ) {
        return '';
    }

    // Get the impression count.
    $impressions = get_post_meta( $popup_id, 'boostbox_popup_impressions', true );
    if ( ! $impressions ) {
        $impressions = 0;
    }
    // Get the conversion count.
    $conversions = get_post_meta( $popup_id, 'boostbox_popup_conversions', true );
    if ( ! $conversions) {
        $conversions = 0;
    }

    // Calculate the conversion percentage.
    $conversion_percentage = ( $impressions > 0 ) ? ( $conversions / $impressions ) * 100 : 0;

    // Format the percentage with 2 decimal places and add the percentage symbol.
    $formatted_percentage = number_format( $conversion_percentage, 2 ) . '%';

    return apply_filters( 'boostbox_popup_conversion_rate_formatted_percentage', $formatted_percentage, $conversion_percentage );
}

/**
 * Settings - Disable analytics
 * 
 * @since  1.6.0
 * @return bool
 */
function boostbox_settings_disable_analytics() {
    // Get the general settings.
    $settings = get_option( 'boostbox_general' );
    // Disable anaytics.
    $disable_analytics = true;
    if ( ! isset( $settings['boostbox_privacy_disable_analytics'] ) ) {
        $disable_analytics = false;
    } elseif ( isset( $settings['boostbox_privacy_disable_analytics'] ) && 'on' !== $settings['boostbox_privacy_disable_analytics'] ) {
        $disable_analytics = false;
    }

    return apply_filters( 'boostbox_settings_disable_analytics', $disable_analytics );
}

/**
 * Settings - Cookie days
 * 
 * @param int $popup_id - the popup ID to check for overrides from
 * 
 * @since  1.6.0
 * @return int
 */
function boostbox_settings_cookie_days( $popup_id = null ) {
    // Cookie days.
    $settings    = get_option( 'boostbox_general' );
    $cookie_days = 30;

    // Check if the setting is filled out.
    if ( isset( $settings['boostbox_cookie_days'] ) ) {
        $cookie_days = $settings['boostbox_cookie_days'];
    }

    // Override global cookie days with popup setting.
    if ( isset( $popup_id ) && get_post_meta( $popup_id, 'boostbox_cookie_days', true ) ) {
        $cookie_days = get_post_meta( $popup_id, 'boostbox_cookie_days', true );
    }

    return apply_filters( 'boostbox_settings_cookie_days', $cookie_days, $popup_id );
}

/**
 * Display custom post type and general fields
 * 
 * @since  2.0.0
 * @return void
 */
function display_custom_post_type_select() {
    global $post;

    // Add nonce field for security.
    wp_nonce_field( 'boostbox_display_settings_meta_nonce_action', 'boostbox_display_settings_meta_noncename' );

    // Retrieve previously saved values.
    $saved_custom_post_types = get_post_meta( $post->ID, '_custom_post_types', true );
    $saved_selected_posts    = get_post_meta( $post->ID, '_selected_posts', true );
    $saved_general_field     = get_post_meta( $post->ID, '_general_field', true ); // New general field value

    // Ensure the retrieved values are arrays to avoid issues.
    $saved_custom_post_types = !empty($saved_custom_post_types) ? (array) $saved_custom_post_types : [];
    $saved_selected_posts    = !empty($saved_selected_posts) ? (array) $saved_selected_posts : [];

    // Get all public post types (including built-in ones).
    $args = [
        'public' => true,
    ];
    $custom_post_types = get_post_types( $args, 'objects' );

    // General Field (Home Page, Search Results, etc.)
    $field  = '<div class="boostbox-field">';
    $field .= '<p><label for="general_field">' . esc_html__( 'General Pages', 'boostbox' ) . ':</label></p>';
    $field .= '<select id="general_field" name="general_field[]" multiple>';
    $general_options = [
        'site_wide'      => esc_html__( 'Sitewide', 'boostbox' ),
        'home_page'      => esc_html__( 'Home Page', 'boostbox' ),
        'search_results' => esc_html__( 'Search Results', 'boostbox' ),
        '404_page'       => esc_html__( '404 Page', 'boostbox' ),
        'posts_archive'  => esc_html__( 'Posts Archive', 'boostbox' ),
    ];

    // Filter the general options.
    $general_options = apply_filters( 'boostbox_display_metabox_target_general_options', $general_options );

    // Populate the general field with the saved value.
    foreach ( $general_options as $value => $label ) {
        $selected = in_array( $value, (array) $saved_general_field ) ? 'selected' : ''; // Treat saved value as array
        $field .= '<option value="' . esc_attr( $value ) . '" ' . $selected . '>' . esc_html( $label ) . '</option>';
    }

    $field .= '</select>';
    $field .= '</div>';

    // Custom Post Types Field.
    $field .= '<div class="boostbox-field">';
    $field .= '<p><label for="custom_post_types">' . esc_html__( 'Custom Post Type(s)', 'boostbox' ) . ':</label></p>';
    $field .= '<select id="custom_post_types" class="select2" name="custom_post_types[]" multiple>';
    $field .= '<option value="">' . esc_html__( 'Select Post Type(s)', 'boostbox' ) . '</option>';

    // Populate select field with custom post types.
    foreach ( $custom_post_types as $post_type ) {
        $selected = in_array( $post_type->name, $saved_custom_post_types ) ? 'selected' : '';
        $field .= '<option value="' . esc_attr( $post_type->name ) . '" ' . $selected . '>' . esc_html( $post_type->label ) . '</option>';
    }

    $field .= '</select>';
    $field .= '</div>';

    // Posts Field (dynamically loaded via AJAX).
    $field .= '<div class="boostbox-field">';
    $field .= '<p><label for="posts">' . esc_html__( 'Singular Content', 'boostbox' ) . ':</label></p>';
    $field .= '<select id="posts" class="select2" name="posts[]" multiple>';
    $field .= '<option value="">' . esc_html__( 'Search and Select Post(s)', 'boostbox' ) . '</option>';

    // Populate the select field for posts with saved values.
    foreach ( $saved_selected_posts as $post_id ) {
        $post_title = get_the_title( $post_id );
        $field .= '<option value="' . esc_attr( $post_id ) . '" selected>' . esc_html( $post_title ) . '</option>';
    }

    $field .= '</select>';
    $field .= '</div>';

    // Filter the fields.
    $field = apply_filters( 'display_custom_post_type_select_fields', $field );

    echo $field;
}

/**
 * Detect the current page context for displaying the popup.
 * 
 * @since  2.0.0
 * @return string The detected context for the current page (e.g., 'home_page', 'search_results').
 */
function boostbox_detect_page_context() {
    $context = '';

    // Detect the page type using standard WordPress conditionals.
    if ( is_front_page() ) {
        $context = 'home_page';
    } elseif ( is_home() ) {
        $context = 'posts_archive'; // Default blog post archive.
    } elseif ( is_search() ) {
        $context = 'search_results';
    } elseif ( is_404() ) {
        $context = '404_page';
    } else {
        // Get all public post types.
        $public_post_types = get_post_types( [ 'public' => true ], 'names' );

        // Loop through each public post type and check if we are viewing a single post or archive of that type.
        foreach ( $public_post_types as $post_type ) {
            if ( is_singular( $post_type ) ) {
                // Dynamically set the context for single post types.
                $context = 'single_' . $post_type;
                break; // Exit the loop once a matching post type is found.
            } elseif ( is_post_type_archive( $post_type ) ) {
                // Dynamically set the context for custom post type archives.
                $context = 'archive_' . $post_type;
                break; // Exit the loop once a matching archive is found.
            }
        }
    }

    // Allow developers to modify or add custom contexts using a filter.
    return apply_filters( 'boostbox_detect_page_context', $context );
}

/**
 * Check if a given post ID or page context is found in the _selected_posts metadata,
 * matches the general options, or matches custom post types in the boostbox_popups metadata.
 *
 * @param int $post_id The ID of the post to check.
 * 
 * @since 2.0.0
 * @return array|false An array of boostbox_popups post IDs if found, false otherwise.
 */
function boostbox_popup_post_check( $post_id ) {
    // Ensure the $post_id is an integer.
    $post_id = (int) $post_id;

    // Array to store boostbox_popups post IDs where the $post_id or context is found.
    $found_in_popups = [];

    // Query all published posts of type 'boostbox_popups'.
    $query = new WP_Query( [
        'post_type'   => 'boostbox_popups',
        'post_status' => 'publish',
        'fields'      => 'ids', // Only get post IDs to reduce query size.
    ] );

    // Loop through the found posts.
    if ( $query->have_posts() ) {
        foreach ( $query->posts as $popup_post_id ) {
            // Get the _general_field metadata (general options).
            $popup_general_options = get_post_meta( $popup_post_id, '_general_field', true );

            // If "site_wide" is selected, the popup should be shown on all pages.
            if ( is_array( $popup_general_options ) && in_array( 'site_wide', $popup_general_options, true ) ) {
                $found_in_popups[] = $popup_post_id;
                continue;  // Skip further checks for this popup since it's site-wide.
            }

            // Check for home page.
            if ( is_front_page() ) {
                if ( is_array( $popup_general_options ) && in_array( 'home_page', $popup_general_options, true ) ) {
                    $found_in_popups[] = $popup_post_id;
                }
            }

            // Check for blog post archive - the default posts archive page.
            if ( is_home() && ! is_front_page() ) {
                if ( is_array( $popup_general_options ) && in_array( 'posts_archive', $popup_general_options, true ) ) {
                    $found_in_popups[] = $popup_post_id;
                }
            }

            // Check for search results.
            if ( is_search() ) {
                if ( is_array( $popup_general_options ) && in_array( 'search_results', $popup_general_options, true ) ) {
                    $found_in_popups[] = $popup_post_id;
                }
            }

            // Check for 404 page.
            if ( is_404() ) {
                if ( is_array( $popup_general_options ) && in_array( '404_page', $popup_general_options, true ) ) {
                    $found_in_popups[] = $popup_post_id;
                }
            }

            // Check for custom post type archives.
            if ( is_post_type_archive() ) {
                $current_post_type = get_query_var( 'post_type' );
                if ( is_array( $popup_general_options ) && in_array( 'archive_' . $current_post_type, $popup_general_options, true ) ) {
                    $found_in_popups[] = $popup_post_id; // Add if the archive for this post type matches.
                }
            }

            // Continue checking regular posts, CPT archives, and taxonomies if we're not on a special page.
            if ( ! is_front_page() && ! is_home() && ! is_search() && ! is_404() && ! is_archive() ) {
                // Check if the popup is disabled for this specific post.
                $popup_disabled = get_post_meta( $post_id, 'boostbox_popup_disabled', true );
                if ( $popup_disabled ) {
                    // Skip showing the popup for this post.
                    continue;
                }

                // Get the _selected_posts metadata.
                $selected_posts = get_post_meta( $popup_post_id, '_selected_posts', true );

                // Ensure it's always an array.
                if ( ! is_array( $selected_posts ) ) {
                    $selected_posts = ! empty( $selected_posts ) ? (array) $selected_posts : [];
                }

                // Convert all post IDs in _selected_posts to integers for reliable comparison.
                $selected_posts = array_map( 'intval', $selected_posts );

                // Check if the provided $post_id exists in the selected posts array.
                if ( in_array( $post_id, $selected_posts, true ) ) {
                    $found_in_popups[] = $popup_post_id; // Store the boostbox_popups post ID.
                }

                // Check the current post type against the custom post types saved in the metadata.
                $custom_post_types = get_post_meta( $popup_post_id, '_custom_post_types', true );
                if ( is_array( $custom_post_types ) ) {
                    $current_post_type = get_post_type();

                    // Check if the current post type matches any of the saved custom post types in the metadata.
                    if ( in_array( $current_post_type, $custom_post_types, true ) ) {
                        $found_in_popups[] = $popup_post_id; // Add if the current post type matches.
                    }
                }
            }
        }
    }

    // If found in any boostbox_popups posts, return the array of post IDs, otherwise return false.
    return ! empty( $found_in_popups ) ? array_unique( $found_in_popups ) : false;
}

/**
 * Build the popup HTML
 *
 * @param int $popup_id The ID of the popup to build.
 * 
 * @since  2.0.0
 * @return void
 */
function boostbox_popup_build_html( $popup_id ) {
    global $content_width;

    // Ensure the $popup_id is an integer.
    $popup_id = (int) $popup_id;

    // Set popup width from popup meta.
    $popup_width = 'max-width: ' . get_post_meta( $popup_id, 'boostbox_display_max_width', true );
    if ( ! get_post_meta( $popup_id, 'boostbox_display_max_width', true ) ) {
        $popup_width = get_cover_block_styles( $popup_id );
    }
    $max_width = 'style="' . $popup_width . '"';

    // Popup position.
    $popup_position = get_post_meta( $popup_id, 'boostbox_display_location', true );

    // Popup animation.
    $popup_animation = get_post_meta( $popup_id, 'boostbox_animation_type', true );

    // Close icon color and placement.
    $close_color     = get_post_meta( $popup_id, 'boostbox_close_icon_color', true ) ?: '#FFFFFF';
    $close_placement = get_post_meta( $popup_id, 'boostbox_close_icon_placement', true ) ?: 'outside';
    
    // Close icon (default or custom).
    $close_icon = apply_filters( 'boostbox_popup_close_icon', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="' . $close_color . '" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>', $close_color );

    // Popup overlay and content classes.
    $popup_overlay_classes = apply_filters( 'boostbox_popup_overlay_classes', 'boostbox-popup-overlay' );
    $popup_content_classes = apply_filters( 'boostbox_popup_content_classes', 'boostbox-popup-content' );
    ?>
    <!-- Popup container with unique data-popup-id -->
    <div class="<?php esc_attr_e( $popup_overlay_classes ); ?>" role="dialog" data-popup-id="<?php echo esc_attr( $popup_id ); ?>">
        <div class="<?php esc_attr_e( $popup_content_classes ); ?> <?php esc_html_e( $popup_position . ' ' . $popup_animation ); ?>"<?php echo wp_kses_post( $max_width ); ?>>
            <?php
            // Query args for content.
            $args = [
                'post_type'           => 'boostbox_popups',
                'post_status'         => 'publish',
                'p'                   => $popup_id,
                'no_found_rows'       => true,
                'ignore_sticky_posts' => true
            ];

            // Build the query.
            $query = new WP_Query( $args );

            // Output content.
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    the_content();
                }
                wp_reset_postdata();
            }
            ?>
            <!-- Close button if not hidden -->
            <?php if ( $close_placement !== 'hidden' ) { ?>
            <button class="boostbox-close <?php echo ( $close_placement == 'inside' ) ? 'inside' : ''; ?>">
                <?php echo wp_kses( $close_icon, boostbox_allowed_tags() ); ?>
            </button>
            <?php } ?>
        </div>
    </div>
    <?php
}
