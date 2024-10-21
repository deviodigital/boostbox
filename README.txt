=== BoostBox - Popup Builder for the Core Editor ===
Contributors: deviodigital
Donate link: https://deviodigital.com
Tags: popup, lead-generation, marketing, popups, exit-intent
Requires at least: 3.0.1
Tested up to: 6.6.2
Stable tag: 2.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Build popups with the core editor for lead generation, content promotion and more.

== Description ==

**BoostBox** is a powerful WordPress® plugin designed to increase conversion rates, customer retention, and revenue by offering flexible, customizable popups, modals, and content overlays.

With **BoostBox**, you can effortlessly build popups directly within the WordPress® editor using blocks, columns, groups, and patterns—no need to learn a new interface or design tool. It's a seamless integration with the editor you're already familiar with, enabling you to create targeted popups that drive engagement and conversions.

Whether you're looking to capture leads, promote events, showcase products, or drive sales, **BoostBox** has you covered. The plugin's versatility allows you to:

*   Capture email signups
*   Showcase featured products
*   Promote upcoming events
*   Build custom sales funnels
*   Launch targeted campaigns
*   ... and more!

### Full-Site Editing (FSE) Integration

**BoostBox** leverages WordPress® Full-Site Editing (FSE) capabilities, enabling you to design popups that perfectly match your site’s branding and layout. Say goodbye to third-party builders—**BoostBox** works natively within WordPress®, making popup creation fast and intuitive.

### Key Features

*   Create popups, modals, and overlays using WordPress® blocks and patterns
*   Customize animations, display settings, and targeting options
*   Support for custom post types and granular targeting of specific pages or posts
*   Multiple trigger options including auto-open, scroll, and timer-based popups
*   Full control over popup design and placement without leaving the WordPress® editor

**BoostBox** is your go-to plugin for building popups that enhance engagement, increase conversions, and improve overall site functionality—all without adding complexity to your workflow.

### Build with BoostBox Pro

**BoostBox Pro** includes additional triggers, targets and animations, making it the perfect addition to your popup building toolbox.

Learn more [here](https://deviodigital.com/product/boostbox-pro/?utm_source=wordpress.org&utm_medium=plugin-directory&utm_campaign=boostbox-free-plugin&utm_content=plugin-description).

== Installation ==

1. Go to `Plugins - Add New` in your WordPress® admin panel and search for **BoostBox**
2. Install and activate the plugin directly in your admin panel
3. Pat yourself on the back for a job well done :)

== Frequently Asked Questions ==

= Can I use BoostBox without any coding knowledge? =

Yes, BoostBox is designed to work seamlessly within the WordPress® editor, using the familiar block-based interface. No coding skills are needed to create beautiful, functional popups.

= What types of popups can I create with BoostBox? =

BoostBox allows you to create various types of popups including:

* Email signups
* Product showcases
* Event promotions
* Lead generation forms
* Basically, the ideas are only limited to your imagination

= How can I customize the appearance and behavior of my popups? =

BoostBox provides a wide range of customization options beyond the actual popup built in the editor, including:

* Setting max width for the popup
* Choosing from various animation styles (fade, slide, pop swirl, and more)
* Configuring popup triggers (on page load, scroll, or timer)
* Targeting specific pages, posts, or custom post types
* Customizing the look and placement of the close button

= Is BoostBox compatible with other WordPress® themes and plugins? =

Yes, BoostBox is designed to be compatible with most WordPress® themes and plugins. It integrates directly with the core WordPress® editor, so it should work smoothly across most environments.

== Screenshots ==

1. Example popup display using a simple pattern
2. Example popup using a pattern from the Powder theme
3. BoostBox admin settings page
4. BoostBox popup display settings
5. BoostBox metrics displayed on the Popups screen
6. Another example popup using a pattern from the Powder theme

== Changelog ==

= 2.1.1 =
*   Added `Go Pro` link in the Plugins page if BoostBox Pro is not installed in `boostbox.php`
*   Updated `boostbox_detect_page_context` function with additional context checks in `includes/boostbox-helper-functions.php`

= 2.1.0 =
*   Added `PluginUpdateChecker` to serve plugin updates directly from GitHub instead of wp.org in `boostbox.php`

= 2.0.1 =
*   Added notice about potential disruption to plugin updates by Matthew Mullenweg and what our next steps will be in `boostbox.php`

= 2.0.0 =
*   Added 2 new AJAX functions for fetching posts in `admin/class-boostbox-admin.php`
*   Added Trigger options to display settings metabox in `admin/metaboxes/boostbox-display-settings.php`
*   Added 4 new helper functions in `includes/boostbox-helper-functions.php`
*   Updated the `boostbox_allowed_tags` function's svg options in `includes/boostbox-helper-functions.php`
*   Updated JS to include new trigger options in `admin/js/boostbox-admin.js`
*   Updated localize scripts with code for multiple popups in `public/class-boostbox-public.php`
*   Updated CSS to include new Trigger tab in `admin/css/boostbox-admin.css`
*   Updated `boostbox_popup_post_check` to include CPTs and general targets in `includes/boostbox-helper-functions.php`
*   Updated impression and conversion tracking to work with multiple popups in `public/class-boostbox-public.php`
*   Updated the public JS to include functionaliy for multiple popups in `public/js/boostbox-public.js`
*   Updated popup metabox with checkbox option to disable popups on a page-by-page basis in `admin/metaboxes/boostbox-popup-settings.php`
*   Updated CSS to only enqueue if popups are present on the page in `public/class-boostbox-public.php`
*   Updated `boostbox_popup_html` to use `wp_footer` instead of `template_redirect` in `public/boostbox-popups.php`
*   Updated admin JS to only load if you are on the edit screen in `admin/class-boostbox-admin.php`
*   Optimized the display settings metabox tabbed content in `admin/metaboxes/boostbox-display-settings.php`
*   General code cleanup throughout multiple files of the plugin

= 1.6.2 =
*   Updated variables to fix deprecation notices throughout multiple files of the plugin
*   Updated array to shorthand syntax throughout multiple files of the plugin
*   General code cleanup throughout multiple files of the plugin

= 1.6.1 =
*   Bugfix for fatal error when plugin is first installed and settings return empty in `public/boostbox-popups.php`

= 1.6.0 =
*   Added 'boostbox_settings_disable_analytics' helper function in `includes/boostbox-helper-functions.php`
*   Added 'boostbox_settings_disable_analytics' filter in `includes/boostbox-helper-functions.php`
*   Added 'boostbox_settings_cookie_days' helper function in `includes/boostbox-helper-functions.php`
*   Added 'boostbox_settings_cookie_days' filter in `includes/boostbox-helper-functions.php`
*   Added 'Disable analytics' setting in `admin/boostbox-admin-settings.php`
*   Updated impressions/conversions to turn off if analytics is disabled in multiple files throughout the plugin
*   Updated boostbox_settings_disable_analytics() checks in multiple files throughout the plugin
*   Updated metabox HTML elements to use echo with `wp_kses` in `admin/metaboxes/boostbox-display-settings.php`
*   Updated input allowed tags to include checked attribute in `includes/boostbox-helper-functions.php`
*   Updated localize script to use new `boostbox_settings_cookie_days` helper function in `public/class-boostbox-public.php`
*   Updated text strings for localization in `languages/boostbox.pot`
*   General code cleanup throughout multiple files throughout the plugin

= 1.5.0 =
*   Added 'BoostBox Popups' block in `admin/class-boostbox-admin.php`
*   Added 'BoostBox Popups' block in `admin/js/boostbox-popups-block.js`
*   Added 'boostbox_popup_settings_popups_options' filter in `admin/boostbox-admin-settings.php`
*   Added 'boostbox_restrict_posts_redirect_url' filter in `admin/boostbox-custom-post-type.php`
*   Added 'boostbox_popup_conversion_rate_formatted_percentage' filter in `includes/boostbox-helper-functions.php`
*   General code cleanup throughout multiple files of the plugin

= 1.4.0 =
*   Added BoostBox_CPT_Columns class in `admin/class-boostbox-cpt-columns.php`
*   Added metrics to popup list view in dashboard in `admin/boostbox-custom-post-type.php`
*   Added `boostbox_popup_conversion_rate` helper function in `includes/boostbox-helper-functions.php`
*   Updated popup conversion rate output to use new helper function in `admin/metaboxes/boostbox-metrics-settings.php`
*   Updated popup conversion rate output to use new helper function in `admin/boostbox-custom-post-type.php`
*   Updated various html elements with escaping functions in various files throughout the plugin
*   Updated popup metabox with select2 for the dropdown in `admin/class-boostbox-admin.php`
*   Updated popup metabox with select2 for the dropdown in `admin/js/boostbox-admin.js`

= 1.3.1 =
*   Added 'scroll distance' setting when 'on-scroll' trigger is selected in `admin/js/boostbox-admin.js`
*   Added 'scroll distance' setting when 'on-scroll' trigger is selected in `admin/metaboxes/boostbox-display-settings.php`
*   Updated metabox tabs to separate 'triggers' settings in `admin/metaboxes/boostbox-display-settings.php`
*   Updated display settings to show/hide trigger settings based on trigger type in `admin/js/boostbox-admin.js`
*   Updated localize script to pass custom scroll distance in `public/class-boostbox-public.php`
*   Updated JS that controlls scroll trigger while including custom scroll distance in `public/js/boostbox-public.js`
*   Updated display settings tab organization in `admin/metaboxes/boostbox-display-settings.php`
*   Updated display settings metabox image in `assets/screenshot-4.jpg`

= 1.3.0 =
*   Added cookie days setting to popup display settings in `admin/metaboxes/boostbox-display-settings.php`
*   Added 'Metrics' metabox to display popup impressions and conversions in `admin/metaboxes/boostbox-metrics-settings.php`
*   Bugfix when setting cookie date and miscalculating the days from current date in `public/class-boostbox-public.php`
*   Bugfix when setting cookie date and miscalculating the days from current date in `public/js/boostbox-public.js`
*   Bugfix for conversion tracking to not run when close icon is clicked in `public/js/boostbox-public.js`
*   Updated screen check for select2 script enqueue in `admin/class-boostbox-admin.php`
*   Updated metabox display placement to 'normal' instead of 'side' in `admin/metaboxes/boostbox-display-settings.php`
*   Updated styles to hide metabox content when clicked closed in `admin/css/boostbox-admin.css`
*   General code cleanup throughout multiple files of the plugin

= 1.2.2 =
*   Added 'hidden' placement option for close icon in `admin/metaboxes/boostbox-display-settings.php`
*   Bugfix for impression count continuously running on scroll trigger in `public/js/boostbox-public.js`
*   Updated display settings metabox with tabbed settings fields in `admin/metaboxes/boostbox-display-settings.php`
*   Updated display settings metabox tabbed settings fields styles in `admin/css/boostbox-admin.css`
*   Updated metabox dropdowns to use select2 in `admin/js/boostbox-admin.js`
*   Updated localize script array to include close icon placement in `public/class-boostbox-public.php`
*   Updated close icon to hide itself if placement is 'hidden' in `public/boostbox-popups.php`
*   Updated popup to close when overlay is clicked when close icon is hidden in `public/js/boostbox-public.js`
*   Updated popup so overlay clicks trigger popup closure when icon is hidden in `public/js/boostbox-public.js`
*   Updated popup HTML to use role='dialog' in `public/boostbox-popups.php`
*   Updated settings page background color in `admin/css/boostbox-admin.css`

= 1.2.1 =
*   Added 'close icon placement' to display settings in `admin/metaboxes/boostbox-display-settings.php`
*   Added select2 integration for display settings (to be used in upcoming releases) in `admin/class-boostbox-admin.php`
*   Bugfix for cookie days setting so the value shows up in the field after you save it in `admin/class-boostbox-admin-settings.php`
*   Bugfix for cookies not keeping popup hidden after closing it in `public/js/boostbox-public.js`
*   Bugfix for on-scroll trigger continuing to display even after popup is closed in `public/js/boostbox-public.js`
*   Updated text for the cookie days option in the settings page in `admin/boostbox-admin-settings.php`
*   Updated popup HTML to include class name for close icon position in `public/boostbox-popups.php`
*   Updated display settings metabox field grid styles in `admin/css/boostbox-admin.css`
*   Updated 'Gutenberg' references to use 'the core editor' instead in various files throughout the plugin

= 1.2.0 =
*   Updated CPT file to escape if accessed directly in `admin/boostbox-custom-post-type.php`
*   Updated popup to use WP_Query instead of REST API in `public/boostbox-popups.php`
*   Updated JS enqueue and localization in `admin/class-boostbox-admin.php`
*   Updated display metabox to include close icon color picker in `admin/metaboxes/boostbox-display-settings.php`
*   Updated close icon color to use metabox settings in `public/boostbox-popups.php`
*   Updated banner and icon assets for WP directory in `assets/`
*   Updated various styles for the core boostbox popup codes

= 1.1.0 =
*   Added `boostbox_popup_default_width`, `boostbox_popup_default_wide_width`, `boostbox_popup_content_classes` and `boostbox_popup_overlay_classes` filters in `public/boostbox-popups.php`
*   Added popup-swirl and anvil animation types in `admin/metaboxes/boostbox-display-settings.php`
*   Added class names to popup based on selected position in `public/boostbox-popups.php`
*   Added max-width option to the popup metabox settings in ``
*   Added Cookie JS script in `public/js/js.cookie.min.js`
*   Updated settings to include cookie days in `admin/boostbox-admin-settings.php`
*   Updated popup wrapper to include animation type class name in `public/boostbox-popups.php`
*   Updated popup to set dynamic cookie days from settings in `public/class-boostbox-public.php`
*   Updated localize_script with impression and conversion data in `admin/class-boostbox-admin.php`
*   Updated popups to include tracking of impressions and conversions in `public/class-boostbox-public.php`
*   Updated usage of `get_bloginfo( 'home' )` with `get_bloginfo( 'url' )` in `public/boostbox-popups.php`
*   Updated styles for all popups and animation styles in `public/css/boostbox-public.css`

= 1.0.0 =
*   Initial commit
