=== Voter Plugin ===
Contributors: aheadzen
Tags: voter,review,woocommerce,buddypress,like,unlike
Requires at least : 3.0.0
Tested up to: 4.0
Stable tag: 1.0.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin added votes option for pages, post, custom post types, comments, BuddyPress activity, groups, member profiles, WooCommerce products etc...

== Description ==

If you want to add the voting system in your wordpress blog site, or WooCommerce site or BuddyPress forum, the Voter plugin is best option to add the up & down voting system.
Even you can display like/unlike link option as voting in place of up & down voting.
The plugin have added option for add voting option enable/disable for pages, post, custom post types, comments, BuddyPress activity, groups, member profiles, WooCommerce products. You don't need to make any change or any thing as soon as the plugin activated related voting options will be added on with description of post, pages etc...
Related to comments it will be appear with comment content both for normal blog and BuddyPress.

<h4>Features :</h4>
<ul>
<li>• Up & Down voting options. </li>
<li>• Like & Unlike voting options.</li>
<li>• Ajax based plugin so no page refresh.</li>
<li>• added votes option for pages, post, custom post types, comments, BuddyPress activity, groups, member profiles, WooCommerce products etc...</li>
<li>• Enable or disable voting option for specifict area like posts, pages, BuddyPress activity, groups, member profiles, WooCommerce products etc...</li>
<li>• Optimum css & js code.</li>
<li>• Localization ready.</li>
</ul>

<h4>Top voted Widget</h4>
New Widget for top voted listing for posts,pages,products,profile & groups.<br />
Widget name : "Top Listings Voter Plugin"<br />
Go to wp-admin > widgets > Top Listings Voter Plugin (drag & drop) as per you want to display.<br /><br />

<h4>Top voted Shotcode</h4>
Shortcode for top voted listing for posts,pages,products,profile & groups.<br />
Get shortcode examples ::<br />
shortcode for posts :     [voter_plugin_top_voted type=post num=5]<br />
shortcode for pages :     [voter_plugin_top_voted type=page num=5]<br />
shortcode for products :  [voter_plugin_top_voted type=product num=5]<br />
shortcode for profile :   [voter_plugin_top_voted type=profile num=5]<br />
shortcode for groups :    [voter_plugin_top_voted type=groups num=5]<br />
shortcode for members :   [voter_plugin_top_voted type=profile num=5]<br />


== Installation ==
1. Unzip and upload plugin folder to your /wp-content/plugins/ directory  OR Go to wp-admin > plugins > Add new Plugin & Upload plugin zip.
2. Go to wp-admin > Plugins(left menu) > Activate the plugin
3. See the plugin option link with plugin description on plugin activation page or directly access from wp-admin > Settings(left menu) > VOTER

== Screenshots ==
1. Plugin Activation
2. Plugin Settings
3. UP & Down voting
4. Like Unlike voting
5. Voting for comments
6. Voting for Buddpress groups
7. Voting for Buddpress activity
8. Voting for Buddpress Member Profile
9. Voting for Woocommerce Product
10. Login Settings

== Configuration ==

1. Go to wp-admin > Settings(left menu) > VOTER, manage settings as per you want.
2. Default will be up & down voting system so you can change it to like/unlike voting
3. new database table will be added to manage voting data, make sure you should add it manually in case of user security permission. 

== Changelog ==

= 1.0.0.0 =
* Fresh Public Release.

= 1.0.0.1 =
* BBpress topics page voting features added
* Login form & related options added

= 1.0.0.2 =
* On plugin deactivation all data is lost
* dialog js code will go into voter.js file
* Manual loading for js - jquery-ui.js

= 1.0.0.3 =
* Login form css changes
* registration page redirectin settings

= 1.0.0.4 =
* Login dialog should close on outside click

= 1.0.0.5 =
* Buddypress Activity & notification settings on forum topic voting
* voting up/donw related api also added

= 1.0.0.6 =
* Buddypress Activity & notification for posts,pages,comments,topics,groups,profile added...
* voting up/donw related api ERROR - for user login only - solved

= 1.0.0.7 =
* Buddypress Activity & notification for posts,pages,comments,topics,groups,profile added. Error for API solved.

= 1.0.0.8 =
* Notification for posts,pages,comments,topics,groups,profile related error solved. Now notification will display to poster account only.
* Notification will not added for user buddypress activity.


= 1.0.0.9 =
* Notification added for user buddypress activity.
* Login dialog form url settings as per plugin setting options.


= 1.1.0.0 =
*New Widget added for top voted listing for posts,pages,products,profile & groups.<br />
Widget name : "Top Listings Voter Plugin"<br />
Go to wp-admin > widgets > Top Listings Voter Plugin (drag & drop) as per you want to display.<br /><br />

*New Shortcode added for top voted listing for posts,pages,products,profile & groups.<br />
Get shortcode examples ::<br />
shortcode for posts :     [voter_plugin_top_voted type=post num=5]<br />
shortcode for pages :     [voter_plugin_top_voted type=page num=5]<br />
shortcode for products :  [voter_plugin_top_voted type=product num=5]<br />
shortcode for profile :   [voter_plugin_top_voted type=profile num=5]<br />
shortcode for groups :    [voter_plugin_top_voted type=groups num=5]<br />
shortcode for members :   [voter_plugin_top_voted type=profile num=5]<br />


= 1.1.0.1 =
* notification message changed (error solved)

= 1.1.0.2 =
* if buddypress not installed, gives some Warning - SOLVED

= 1.1.0.3 =
* Disable voter plugin settings for specific page templates > New feature added to plugin settings page.

= 1.1.0.4 =
* Notification & activity related changed for older version of buddypress done.

= 1.2.0.0 =
* Notification changes added for older version of buddypress.
* New Email notification option added while you like any post,page,group,member profile, comments,products, etc...

= 1.3.0.0 =
* delete vote, notification & activity related data while delete any post or forum topic.
* notification will be automatically marked as read while any creator or post author visit the detail page.
