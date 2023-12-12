=== BoostBox ===
Contributors: deviodigital
Donate link: https://deviodigital.com
Tags: popup, lead-generation, marketing, modal, exit-intent
Requires at least: 3.0.1
Tested up to: 6.4.2
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Build popups for lead generation, content promotion and more.

== Description ==

**BoostBox** helps you increase conversion rates, customer retention and revenue.

Build popups for lead generation, content promotion and more using the Gutenberg editor. 

Easily style your popups, modals, and content overlays in the editor you are already used to. No more trying to learn *another popup plugin* and their unique design experience.

With **BoostBox**, the type of popup you build is limitless.

*   Generate email signups
*   Giveaway free downloads
*   Build a sales funnel
*   Showcase featured products
*   Promote upcoming events
*   ... and more!

### Using Gutenberg to style popups

The **BoostBox** plugin was created to give website owners the ability to create popups within the Gutenberg editor, and it succeeds flawlessly in this mission.

Using Gutenberg blocks, columns, groups and patterns, the style possibilities for the popups you build with the **BoostBox** plugin are endless.

== Installation ==

1. Go to `Plugins - Add New` in your WordPress admin panel and search for **BoostBox**
2. Install and activate the plugin directly in your admin panel
3. Pat yourself on the back for a job well done :)

== Screenshots ==

1. Example popup display
2. BoostBox metabox settings
3. BoostBox admin settings

== Changelog ==

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
