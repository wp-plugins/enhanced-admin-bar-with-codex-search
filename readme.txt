=== Plugin Name ===
Enhanced Admin Bar with Codex Search and Custom Menus

Contributors: jtsternberg
Plugin Name: Enhanced Admin Bar with Codex Search and Custom Menus
Plugin URI: http://dsgnwrks.pro/enhanced-admin-bar-with-codex-search/
Tags: Admin Bar, Codex Search, Search, Admin, adminbar, bar, topbar, plugin search, dashboard widget, wpbeginner, custom menu, menus
Author URI: http://dsgnwrks.pro/enhanced-admin-bar-with-codex-search/
Author: DsgnWrks
Donate link: http://dsgnwrks.pro/give/
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 1.5.3
Version: 1.5.3

This plugin adds convenient search fields to provide easy access to the codex, wpbeginner, and common wp-admin areas via the 3.1 Admin Bar. Also, add your own custom menu to the Admin Bar.

== Description ==

This simple plugin enhances the default WordPress admin bar by adding a new menu that includes search fields for searching the Codex, wpbeginner.com, plugins repository, themes repository etc. Links and search fields to common areas in wp-admin (posts, pages, custom post types, plugins, media, settings) are included in the drop down menu when you are not in the WordPress admin area. The plugin search box now takes you to the WordPress internal plugins search page rather than wordpress.org.

If that's not enough link goodness for you, the plugin now has the option for a custom WordPress menu in the WordPress Admin Bar. (Props to <a href="https://twitter.com/wpsnipp" target="_blank">@wpsnipp</a> - <a href="http://wpsnipp.com/" target="_blank">http://wpsnipp.com/</a>) If you go to wp-admin/nav-menus.php you'll see a theme location, "Admin Bar Custom Navigation Menu" where you can attach a custom menu.

The plugin also includes a dashboard widget that conveniently displays info about the currently active theme.


== Installation ==

1. Upload the `admin-bar-enhancements` directory to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
2. Admin bar should be updated with new menu.
3. If you would like a custom menu in the admin bar, navigate to "Menus" under "Appearance." You'll see a theme location, "Admin Bar Custom Navigation Menu" where you can attach a custom menu.

== Frequently Asked Questions ==

This plugin adds convenient search fields to provide easy access to the codex, wpbeginner, and common wp-admin areas via the 3.1 Admin Bar. Also, add your own custom menu to the Admin Bar.

== Screenshots ==

1. Menu view from your site's front-end. Posts and Pges are displayed, but if you have custom post types, they would also show up in this list with a search field / add new link on hover.
2. Menu view from WordPress Admin back-end. Again, if you have custom post types, the corresponding search field would show up in this list.
3. Menu view from WordPress Version 3.2+ Admin back-end. (as of this plugin's creation, the admin bar is not enabled in the back-end in version 3.2+) the Plugin search box now takes you to the WordPress internal plugins search page rather than wordpress.org.
4. View of WordPress built-in menu system with a custom menu added to the Admin Bar
5. View of Admin Bar with custom menu added.

== Changelog ==

= 1.5.3 =
* Fixed bug with duplicate menu classes. Also removed search forms from admin side. *future release: options page to enable/disable plugin features

= 1.5.2 =
* Fixed bug that displayed labels intended for screenreaders on the screen.

= 1.5.1 =
* Fixed small bug that didn't remove main menu item when a custom menu was removed.

= 1.5 =
* Plugins search now takes you to the WordPress internal plugins search page rather than wordpress.org.
* Added search for: wpbeginner.com Themes, Media, Pages, Posts, Custom Post Types.
* Added an "Upload" menu item to Plugins, Themes, and Media.
* Added an "Add New" menu item to Pages, Posts, Custom Post Types.
* Added Settings sub-menus to the Settings dropdown in the Admin Bar Menu.
* Added an option to add a custom menu to the Admin Bar from the built-in WordPress menu system.

== Upgrade Notice ==

= 1.5.3 =
Fixed bug with duplicate menu classes. Also removed search forms from admin side. *future release: options page to enable/disable plugin features*

= 1.5.2 =
Fixed small bug that didn't remove main menu item when a custom menu was removed.

= 1.5.1 =
Fixed small bug that didn't remove main menu item when a custom menu was removed.

= 1.5 =
Upgrade for more search options, and option to add your own custom menu.