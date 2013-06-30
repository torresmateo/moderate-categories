=== Moderate Categories ===
Contributors: Maluchi
Donate link: http://arsisteam.com/donate
Tags: categories, visibility, moderation, admin
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin to assign edition and visibility capabilities to roles and users for individual categories

== Description ==

= Moderate Categories =

Gives the WordPress admin the ability to give visibility access to roles and users for posts in a by-category way.

This plugin does NOT modify the roles capabilities, your users will be able to do whatever their role says they can do, this tool just limits the back-end interface. 

This plug-in was written mainly because of the lack of intuitive category-moderation plug-ins, and because most of the plug-ins have "restrict access" logic rather than the more intuitive "give access" logic. 

= Features =

* By default, all categories are accessible (WP default)
* Role-Category rules define permissions for the entire role.
* User-Category rules define permissions for particular users and have higher priority.
* Adding a Rule for a single category, gives permission for this category ancestors (the whole parent branch in the category tree).
    * Adding a rule also removes permission to edit under other categories. 

== Installation ==

1. Upload `moderate-categories` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure access from the Plugin Menu Page.

== Frequently asked questions ==

= Does this changes or manages user roles and/or capabilites? =

Nope, this plug-in only deals with posts visibility.

== Screenshots ==

1. Configuration Menu

== Changelog ==
1.0.1

Fixed Bug when creating new posts with no categories

1.0
First Release

== Upgrade notice ==

First Release
