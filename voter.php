<?php
/*
Plugin Name: Voter Plugin
Plugin URI: http://aheadzen.com/
Description: The plugin added votes option for pages, post, custom post types, comments, buddypress activity, groups, member profiles, woocommerce products etc. <br />You can control display option from <a href="options-general.php?page=voter" target="_blank"><b>Plugin Settings >></b></a>
Author: Aheadzen Team  | <a href="options-general.php?page=voter" target="_blank">Manage Plugin Settings</a>
Version: 1.3.3.1
Author URI: http://aheadzen.com/

Copyright: © 2014-2015 ASK-ORACLE.COM
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

global $aheadzen_voter_plugin_version;
$aheadzen_voter_plugin_version = '1.1.0.0';

include(dirname(__FILE__).'/voter_functions.php');

register_activation_hook(__FILE__, 'aheadzen_voter_install');
//register_deactivation_hook(__FILE__, 'aheadzen_voter_uninstall');

add_action('init', 'aheadzen_voter_init');

add_action('admin_menu', 'aheadzen_voter_admin_menu');
add_action('wp_enqueue_scripts', 'aheadzen_voter_add_custom_scripts');
add_action('wp_head','aheadzen_header_settings');
add_filter('template_include','aheadzen_voter_add_vote');
add_action('bp_init','aheadzen_voter_add_vote', 99999);
add_action('bp_init','aheadzen_bp_delete_topic', 99);

add_filter('the_content', 'aheadzen_display_voting_links');
add_filter('comment_reply_link', 'aheadzen_display_voting_links');
add_action('bp_activity_entry_meta', 'aheadzen_display_voting_links');
//add_action('bp_after_profile_field_content', 'aheadzen_display_voting_links');
//add_action('bp_before_group_header', 'aheadzen_display_voting_links');
add_action('bp_after_message_content', 'aheadzen_display_voting_links');
add_action('bbp_theme_after_reply_content', 'aheadzen_display_voting_links');

add_action('wp_footer','aheadzen_voting_login_dialog',999);
add_action('wp_footer','aheadzen_update_user_notification',999);

add_filter( 'bp_notifications_get_registered_components', 'aheadzen_voter_filter_notifications_get_registered_components', 10 );
add_filter('bp_notifications_get_notifications_for_user','aheadzen_voter_notification_title_format','',3);
add_action( 'bp_setup_globals', 'aheadzen_voter_setup_globals',999 );
