=== BoostBox - Popup Builder for the Core Editor ===
Contributors: deviodigital
Donate link: https://deviodigital.com
Tags: popup, lead-generation, marketing, popups, exit-intent
Requires at least: 3.0.1
Tested up to: 6.4.2
Stable tag: 1.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Build popups with the core editor for lead generation, content promotion and more.

== Description ==

**BoostBox** helps you increase conversion rates, customer retention and revenue.

Build popups for lead generation, content promotion and more using the core WordPress editor. 

Easily style your popups, modals, and content overlays in the editor you are already used to. No more trying to learn *another popup plugin* and their unique design experience.

With **BoostBox**, the type of popup you build is limitless.

*   Generate email signups
*   Giveaway free downloads
*   Build a sales funnel
*   Showcase featured products
*   Promote upcoming events
*   ... and more!

### FSE popup builder

The **BoostBox** plugin was created to give website owners the ability to create popups within the core editor, and it succeeds flawlessly in this mission.

Using WordPress blocks, columns, groups and patterns, the style possibilities for the popups you build with the **BoostBox** plugin are endless.

== Installation ==

1. Go to `Plugins - Add New` in your WordPress admin panel and search for **BoostBox**
2. Install and activate the plugin directly in your admin panel
3. Pat yourself on the back for a job well done :)

== Screenshots ==

1. Example popup display using a simple pattern
2. Example popup using a pattern from the Powder theme
3. BoostBox admin settings page
4. BoostBox popup display settings
5. BoostBox metrics displayed on the Popups screen

== Changelog ==

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
