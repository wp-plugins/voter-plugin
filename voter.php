<?php
/*
Plugin Name: Voter Plugin
Plugin URI: http://aheadzen.com/
Description: The plugin added votes option for pages, post, custom post types, comments, buddypress activity, groups, member profiles, woocommerce products etc. <br />You can control display option from <a href="options-general.php?page=voter" target="_blank"><b>Plugin Settings >></b></a>
Author: Aheadzen Team  | <a href="options-general.php?page=voter" target="_blank">Manage Plugin Settings</a>
Version: 1.0.0.0
Author URI: http://aheadzen.com/

Copyright: © 2014-2015 ASK-ORACLE.COM
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

include(dirname(__FILE__).'/voter_functions.php');

register_activation_hook(__FILE__, 'aheadzen_voter_install');
register_deactivation_hook(__FILE__, 'aheadzen_voter_uninstall');

add_action('init', 'aheadzen_voter_init');

add_action('admin_menu', 'aheadzen_voter_admin_menu');
add_action('wp_enqueue_scripts', 'aheadzen_voter_add_custom_scripts');
add_action('wp_head','aheadzen_header_settings');
add_filter('template_include','aheadzen_voter_add_vote');

add_filter('the_content', 'aheadzen_display_voting_links');
add_filter('comment_reply_link', 'aheadzen_display_voting_links');
add_action('bp_activity_entry_meta', 'aheadzen_display_voting_links');
//add_action('bp_after_profile_field_content', 'aheadzen_display_voting_links');
//add_action('bp_before_group_header', 'aheadzen_display_voting_links');
add_action('bp_after_message_content', 'aheadzen_display_voting_links');
add_action('bbp_theme_before_reply_author_details', 'aheadzen_display_voting_links');

