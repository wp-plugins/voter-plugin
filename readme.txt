=== Voter Plugin ===
Contributors: aheadzen
Tags: voter,review,woocommerce,buddypress,like,unlike,voting
Requires at least : 3.0.0
Tested up to: 4.0
Stable tag: 2.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Voter plugin adds a recommendation engine (voting or like/unlike features) on any WordPress blog or website.

== Description ==

Voter plugin adds voting options for pages, posts, custom post types, comments, BuddyPress activity, groups, member profiles, WooCommerce products, bbPress topics and posts, and more.

Adds a recommendation system on your wordpress blog site:

 - Supports posts, pages, custom post types and comments.
 - Supports BuddyPress - Groups, Profiles, Activities and more.
 - Supports bbPress Posts
 - Supports WooCommerce Products and Reviews.

Voting options:

 - FaceBook style simple Like and Unlike
 - Up and Down buttons
 - Thumbs buttons

<h4>Features :</h4>
<ul>
<li>Three voting options </li>
<li>Thumbs Up & Down voting </li>
<li>Up & Down button voting </li>
<li>Like & Unlike voting</li>
<li>Uses AJAX for best experience</li>
<li>Widgets for promoting top content</li>
<li>ShortCodes for promoting top content</li>
<li>Fast and Lightweight. Works on shared hosting.</li>
<li>Enable or disable voting option for specifict area like posts, pages, BuddyPress activity, groups, member profiles, WooCommerce products etc...</li>
<li>Optimum css & js code.</li>
<li>Localisation ready.</li>
</ul>

<h4>Top voted Widget</h4>
 Widget for top voted listing for posts,pages,products,profile & groups.<br />
Widget name : "Top Listings Voter Plugin"<br />
Go to Wordpress Admin > Appearance > Widgets > Top Listings Voter Plugin (drag & drop) as per you want to display.<br /><br />

<h4>Top voted Shotcode</h4>
Shortcode for top voted listing for posts,pages,products,profile & groups.<br />
`Get shortcode examples ::<br />
shortcode for posts :     [voter_plugin_top_voted type=post num=5]
shortcode for pages :     [voter_plugin_top_voted type=page num=5]
shortcode for custom:     [voter_plugin_top_voted type=custom_post_type num=5]
shortcode for products :  [voter_plugin_top_voted type=product num=5]
shortcode for profile :   [voter_plugin_top_voted type=profile num=5]
shortcode for groups :    [voter_plugin_top_voted type=groups num=5]
shortcode for members :   [voter_plugin_top_voted type=profile num=5]`

New option added after version : 2.2.0 =======
shotcode period option :: [voter_plugin_top_voted type=post num=5 period=7days] 
	where period from :: 7days,15days,30days,90days,180days,365days 

	
<h4>Voting Shotcode</h4>
The shortcode which can be added in any post,product,page or cutom post type content.
`Get shortcode examples ::<br />
[voter]


Any problems? [Contact Us](http://aheadzen.com/contact/)

== Installation ==
1. Unzip and upload plugin folder to your /wp-content/plugins/ directory  OR Go to wp-admin > plugins > Add new Plugin & Upload plugin zip.
2. Go to wp-admin > Plugins(left menu) > Activate the plugin
3. See the plugin option link with plugin description on plugin activation page or directly access from wp-admin > Settings(left menu) > VOTER
4. Get translate your plugin to another language by google tutorial :: http://barry.coffeesprout.com/translating-po-files-using-google-translate/

== Screenshots ==
1. Plugin Activation
2. Plugin Settings
3. UP & Down voting
4. Like Unlike voting
5. Voting for comments
6. Voting for Buddpress groups
7. Voting for Buddpress activity
8. Voting for Buddpress Member Profile
9. Up & Down Button Voting for Woocommerce Product
10. Thumbs Up & Down Voting for Woocommerce Product
11. Login Settings

== Configuration ==

1. Go to wp-admin > Settings(left menu) > VOTER, manage settings as per you want.
2. Default will be up & down voting system so you can change it to like/unlike voting
3. new database table will be added to manage voting data, make sure you should add it manually in case of user security permission. 
4. Get translate your plugin to another language by google tutorial :: http://barry.coffeesprout.com/translating-po-files-using-google-translate/


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

= 1.3.0.1 =
* buddpress older version forum topic notification & activity problem - solved.

= 1.3.1.1 =
* buddpress older version forum topic notification & activity problem - solved.

= 1.3.2.0 =
* buddpress older version forum topic notification & activity problem - solved.

= 1.3.3.0 =
* email content merged with notification function.

= 1.3.3.1 =
* login in dialog redirection for buddypress.

= 1.3.3.2 =
* optimization task for plugin notification and emails.

= 1.3.3.3 =
* forum topic & reply related settings done.
* plugin organization done.

= 1.4.0 =
* buddypress older version related settings done for activity,notificactions & emails

= 1.4.1 =
* post comments email sent problem was wrong - Solved to commenter id

= 1.4.2 =
* added activity,notification & email alert enable/disable related settings.
* pages,post ...like button not adding - problem solved.
* voting settings for comments was display on admin side - Problem solved.

= 1.4.3 =
* email subject related chage done.

= 2.0.0 =
* Pluing in OOPs format
* solved some errors of notifications.

= 2.0.1 =
* undefined function for notification.php file on line 58 the code is :: $reply_id = bbp_get_reply_id();
* Problem solved and and now OK.

= 2.1.0 =
* undefined function for notification.php file on line 209 the code is :: $activity_id = bp_activity_add($arg_arr);
* Problem solved and and now OK.
* added possible components and added condition so it will work if it is activated.

= 2.1.1 =
* Added new voting option type : "Helpful Option".
* Display the YES or NO option on frond end inplace of voting.
* Added conditions for buddypress & bbpress options like it will display only if buddypress or bbpress activated.
* Default up-down thumbs & button settings default set to -- disable.
* Top voted widget - PHP error  - SOLVED.

= 2.1.2 =
* Plugin Settings - wp-admin >> correction of titles.
* Buddpress & bbypress > problem of css - Correction done.

= 2.1.3 =
* Custom post type - notification display problem - SOLVED

= 2.1.4 =
* Localization (multiple language) po & mo file added
* Thumbs up & down - awaresome font added.
* bbPress wp-admin settings hide while buddypress not activated - Problem solved.

= 2.1.5 =
* Css changes for thumb up & down.
* button up & down font style added instead of background image.

= 2.1.5.1 =
* voting buttons css style problem solved.

= 2.2.0 =
* New shortcode added which can be added in any post,product,page or cutom post type content.
	The shotcode :: [voter]
* New shortcode to display top voted list.
	shotcode :: [voter_plugin_top_voted type=post num=5 period=7days] 
	where period from :: 7days,15days,30days,90days,180days,365days 
* New select "period" option added for top voted widget.

= 2.2.1 =
* New voting shotcode not working properly - SOLVED.

= 2.2.1.1 =
* some words missed in po file - ADDED.