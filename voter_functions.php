<?php
/*************************************************
Admin Settings For voter plugin menu function
*************************************************/
function aheadzen_voter_admin_menu()
{
	add_submenu_page('options-general.php', 'VOTER Options', 'VOTER', 'manage_options', 'voter','aheadzen_voter_settings_page');
}

/*************************************************
Admin Settings For voter plugin
*************************************************/
function aheadzen_voter_settings_page()
{
	global $bp,$post;	
	if($_POST)
	{
		update_option('aheadzen_voter_for_page',$_POST['aheadzen_voter_for_page']);
		update_option('aheadzen_voter_for_post',$_POST['aheadzen_voter_for_post']);
		update_option('aheadzen_voter_for_product',$_POST['aheadzen_voter_for_product']);
		update_option('aheadzen_voter_for_custom_posttype',$_POST['aheadzen_voter_for_custom_posttype']);
		update_option('aheadzen_voter_for_comments',$_POST['aheadzen_voter_for_comments']);
		update_option('aheadzen_voter_for_activity',$_POST['aheadzen_voter_for_activity']);
		update_option('aheadzen_voter_for_group',$_POST['aheadzen_voter_for_group']);
		update_option('aheadzen_voter_for_profile',$_POST['aheadzen_voter_for_profile']);
		update_option('aheadzen_voter_for_messages',$_POST['aheadzen_voter_for_messages']);
		update_option('aheadzen_voter_for_forum',$_POST['aheadzen_voter_for_forum']);
		update_option('aheadzen_voter_display_options',$_POST['aheadzen_voter_display_options']);
		update_option('aheadzen_voter_login_title',$_POST['aheadzen_voter_login_title']);
		update_option('aheadzen_voter_login_desc',$_POST['aheadzen_voter_login_desc']);
		update_option('aheadzen_voter_login_link',$_POST['aheadzen_voter_login_link']);
		update_option('aheadzen_voter_register_link',$_POST['aheadzen_voter_register_link']);
		update_option('aheadzen_voter_display_login_frm',$_POST['aheadzen_voter_display_login_frm']);
		update_option('aheadzen_voter_include_dialog_js',$_POST['aheadzen_voter_include_dialog_js']);		
		   
		echo '<script>window.location.href="'.admin_url().'options-general.php?page=voter&msg=success";</script>';
		exit;
	}	
	?>
	<h2><?php _e('Voter Settings','aheadzen');?></h2>
	<?php
	if($_GET['msg']=='success'){
	echo '<p class="success">'.__('Your settings updated successfully.','aheadzen').'</p>';
	}
	?>
	<style>.success{padding:10px; border:solid 1px green; width:70%; color:green;font-weight:bold;}</style>
	<form method="post" action="<?php echo admin_url();?>options-general.php?page=voter">
		<table class="form-table">
			<tr valign="top">
				<td>
				<?php
				$display_options = get_option('aheadzen_voter_display_options');
				?>
				<label for="aheadzen_voter_display_options">
				<p><?php _e('Voting Display Options','aheadzen');?> ::
				<select name="aheadzen_voter_display_options" id="aheadzen_voter_display_options">
				<option value=""><?php _e(' -- Select One -- ','aheadzen');?></option>
				<option value="1" <?php if($display_options=='1'){echo 'selected';}?>><?php _e('Simple Like/Unlike','aheadzen');?></option>
				<option value="2" <?php if($display_options=='2'){echo 'selected';}?>><?php _e('Voting Up/Down Arrow','aheadzen');?></option>
				</select>
				</p>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_custom_posttype">
				<input type="checkbox" value="1" id="aheadzen_voter_for_custom_posttype" name="aheadzen_voter_for_custom_posttype" <?php if(get_option('aheadzen_voter_for_custom_posttype')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for all posts types/all custom post types','aheadzen');?>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_page">
				<input type="checkbox" value="1" id="aheadzen_voter_for_page" name="aheadzen_voter_for_page" <?php if(get_option('aheadzen_voter_for_page')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for pages','aheadzen');?>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_post">
				<input type="checkbox" value="1" id="aheadzen_voter_for_post" name="aheadzen_voter_for_post" <?php if(get_option('aheadzen_voter_for_post')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for post','aheadzen');?></td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_product">
				<input type="checkbox" value="1" id="aheadzen_voter_for_product" name="aheadzen_voter_for_product" <?php if(get_option('aheadzen_voter_for_product')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for product','aheadzen');?></td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_comments">
				<input type="checkbox" value="1" id="aheadzen_voter_for_comments" name="aheadzen_voter_for_comments" <?php if(get_option('aheadzen_voter_for_comments')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for comments','aheadzen');?>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_activity">
				<input type="checkbox" value="1" id="aheadzen_voter_for_activity" name="aheadzen_voter_for_activity" <?php if(get_option('aheadzen_voter_for_activity')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for buddypress activity','aheadzen');?>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_group">
				<input type="checkbox" value="1" id="aheadzen_voter_for_group" name="aheadzen_voter_for_group" <?php if(get_option('aheadzen_voter_for_group')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for buddypress groups','aheadzen');?>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_forum">
				<input type="checkbox" value="1" id="aheadzen_voter_for_forum" name="aheadzen_voter_for_forum" <?php if(get_option('aheadzen_voter_for_forum')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for buddypress forums','aheadzen');?>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_profile">
				<input type="checkbox" value="1" id="aheadzen_voter_for_profile" name="aheadzen_voter_for_profile" <?php if(get_option('aheadzen_voter_for_profile')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for buddypress profile','aheadzen');?>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_for_messages">
				<input type="checkbox" value="1" id="aheadzen_voter_for_messages" name="aheadzen_voter_for_messages" <?php if(get_option('aheadzen_voter_for_messages')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Enable vote for buddypress messages','aheadzen');?>
				</label>
				</td>
			</tr>
			
			<tr valign="top">
				<td>
				<h3><?php _e('Login Popup Settings','aheadzen');?></h3>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<?php
				$login_title = get_option('aheadzen_voter_login_title');
				?>
				<label for="aheadzen_voter_login_title">
				<p><?php _e('Popup Title','aheadzen');?> ::<br />
				<input type="text" id="aheadzen_voter_login_title" name="aheadzen_voter_login_title" value="<?php echo $login_title;?>" />
				</p>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<?php 
				$login_desc = get_option('aheadzen_voter_login_desc');
				?>
				<label for="aheadzen_voter_login_desc">
				<p><?php _e('Popup Content','aheadzen');?> ::<br />
				<textarea style="width:80%;" id="aheadzen_voter_login_desc" name="aheadzen_voter_login_desc"><?php echo $login_desc;?></textarea>
				</p>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<?php
				$login_link = get_option('aheadzen_voter_login_link');
				?>
				<label for="aheadzen_voter_login_link">
				<p><?php _e('Login URL','aheadzen');?> ::<br />
				<input type="text" id="aheadzen_voter_login_link" name="aheadzen_voter_login_link" value="<?php echo $login_link;?>" />
				<br /><small><?php _e('default:','aheadzen'); echo ' '.wp_login_url();?></small>
				</p>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<?php
				$register_link = get_option('aheadzen_voter_register_link');
				?>
				<label for="aheadzen_voter_register_link">
				<p><?php _e('Registration URL','aheadzen');?> ::<br />
				<input type="text" id="aheadzen_voter_register_link" name="aheadzen_voter_register_link" value="<?php echo $register_link;?>" />
				<br /><small><?php _e('default:','aheadzen'); echo ' '.wp_registration_url();?></small>
				</p>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_display_login_frm">
				<input type="checkbox" value="1" id="aheadzen_voter_display_login_frm" name="aheadzen_voter_display_login_frm" <?php if(get_option('aheadzen_voter_display_login_frm')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Display Login Form?','aheadzen');?>
				<br /> <small><?php _e('By selecting the option it will display the login form with popup.','aheadzen');?></small>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<label for="aheadzen_voter_include_dialog_js">
				<input type="checkbox" value="1" id="aheadzen_voter_include_dialog_js" name="aheadzen_voter_include_dialog_js" <?php if(get_option('aheadzen_voter_include_dialog_js')){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;<?php _e('Do you want to disable login box js (jquery-ui.js)?','aheadzen');?>
				<br /> <small><?php _e('The plugin including "http://code.jquery.com/ui/1.10.3/jquery-ui.js" for login dialog box In case your website already included and may creating conflict you can disable/remove it by this option.','aheadzen');?></small>
				</label>
				</td>
			</tr>
			<tr valign="top">
				<td>
					<input type="hidden" name="page_options" value="<?php echo $value;?>" />
					<input type="hidden" name="action" value="update" />
					<input type="submit" value="Save settings" class="button-primary"/>
				</td>
			</tr>					
		</table>
	</form>
	<?php
	// Check that the user is allowed to update options  
	if (!current_user_can('manage_options'))
	{
		wp_die('You do not have sufficient permissions to access this page.');
	}
}



/*************************************************
Voter plugin init function
*************************************************/
function aheadzen_voter_init()
{
	load_plugin_textdomain('aheadzen', false, basename( dirname( __FILE__ ) ) . '/languages');
	//aheadzen_voter_add_vote();
}

/*************************************************
Install plugin related Database table
*************************************************/
function aheadzen_voter_install()
{
	global $wpdb, $table_prefix;
	
	/**Vote plugin default settings**/
	if(get_option('aheadzen_voter_display_login_frm') || get_option('aheadzen_voter_register_link') || get_option('aheadzen_voter_login_title') || get_option('aheadzen_voter_login_desc'))
	{
	
	}else{
		update_option('aheadzen_voter_for_page',1);
		update_option('aheadzen_voter_for_post',1);
		update_option('aheadzen_voter_for_product',1);
		update_option('aheadzen_voter_for_custom_posttype',1);
		update_option('aheadzen_voter_for_comments',1);
		update_option('aheadzen_voter_for_activity',1);
		update_option('aheadzen_voter_for_group',1);
		update_option('aheadzen_voter_for_profile',1);
		update_option('aheadzen_voter_for_messages',1);
		update_option('aheadzen_voter_for_forum',1);
		update_option('aheadzen_voter_display_options',0);
		update_option('aheadzen_voter_login_title','Please Login');
		update_option('aheadzen_voter_login_desc','<p>This site is free and open to everyone, but our registered users get extra privileges like commenting, and voting.</p>');
		update_option('aheadzen_voter_login_link',wp_login_url());
		update_option('aheadzen_voter_register_link',wp_registration_url());
		update_option('aheadzen_voter_display_login_frm',1);
	}
	/**Vote plugin Database table**/
	$sql = "CREATE TABLE IF NOT EXISTS `".$table_prefix."ask_votes` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `user_id` int(10) NOT NULL,
		  `component` varchar(40) NOT NULL,
		  `type` varchar(40) NOT NULL,
		  `action` varchar(10) NOT NULL,
		  `item_id` int(10) NOT NULL,
		  `secondary_item_id` int(10) DEFAULT NULL,
		  `date_recorded` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `user_id_2` (`user_id`,`component`,`type`,`item_id`,`secondary_item_id`),
		  KEY `date_recorded` (`date_recorded`),
		  KEY `user_id` (`user_id`),
		  KEY `item_id` (`item_id`),
		  KEY `secondary_item_id` (`secondary_item_id`),
		  KEY `component` (`component`),
		  KEY `type` (`type`)
		)";
			
	$wpdb->query($sql);
}


/*************************************************
Uninstall plugin related Database table & Settings
*************************************************/
function aheadzen_voter_uninstall()
{
	global $wpdb, $table_prefix;
	$sql = "DROP TABLE IF EXISTS `".$table_prefix."ask_votes`;";
	$wpdb->query($sql);
}

/*************************************************
Plugin JS & CSS include
*************************************************/	
function aheadzen_voter_add_custom_scripts()
{
	wp_enqueue_script('aheadzen-voter-script', plugins_url('js/voter.js', __FILE__), array('jquery'));
	wp_enqueue_style('', plugins_url('css/voter.css', __FILE__));
}

/*************************************************
Header JS related settings
*************************************************/	
function aheadzen_header_settings()
{
	global $current_user;
?>
<script>
var site_url = '<?php echo site_url();?>/';
var current_user_id = '<?php echo $current_user->ID;?>';
var current_post_id = '<?php echo get_the_id();?>';
</script>
<?php
}

/*************************************************
Check for user either voted or not, 
return value true  or false
*************************************************/
function aheadzen_is_voted($params,$return='action')
{
	global $post, $bp, $thread_template, $bbP, $forum_id, $wpdb, $table_prefix,$current_user;
	$user_id = $current_user->ID;
	if(!$user_id){return false;}
	
	$item_id = $params['item_id'];
	$component_name = $params['component'];
	$type = $params['type'];
	$secondary_item_id = $params['secondary_item_id'];
	$voteed_action = $wpdb->get_results("SELECT id,action FROM `".$table_prefix."ask_votes` WHERE user_id=\"$user_id\" AND item_id=\"$item_id\" AND component=\"$component_name\" AND type=\"$type\" AND secondary_item_id=\"$secondary_item_id\"");
	if($voteed_action)
	{
		if($return=='action')
		{
			return $voteed_action[0]->action;
		}else{
			return $voteed_action[0];
		}		
	}else{
		return false;
	}
	
}

/*************************************************
Check is the Buddypress Topic
*************************************************/
function aheadzen_is_bp_topic()
{
	global $post, $bp, $thread_template, $bbP, $forum_id, $wpdb, $table_prefix,$current_user;
	if($bp)
	{
		$check_url_for_topic = $bp->unfiltered_uri;
		//echo $type = $check_url_for_topic[0];
		if (in_array("topic", $check_url_for_topic) || in_array("activity", $check_url_for_topic) || in_array("members", $check_url_for_topic) || in_array("groups", $check_url_for_topic))
		{
			return 1;
		}
	}
	return 0;
}


/*************************************************
Display voter link conditions checking function
*************************************************/
function aheadzen_display_voting_links($content)
{
	global $post, $bp, $thread_template, $bbP, $forum_id, $wpdb, $table_prefix,$current_user;
	$post_type = $post->post_type;
	$comment_id = get_comment_ID();
	$params = array();	
	
	if(($post_type || $post_type == "page" || $post_type == "post" || $post_type == "product") && !aheadzen_is_bp_topic()) //check for page or post without buddpress topic
	{
		if($post_type == "product"){
			$component_name = "woocommerce";
		}elseif($post_type == "page" || $post_type == "post"){
			$component_name = "blog";
		}else{
			$component_name = "custompost";
		}
		
		$type = $post->post_type;
		$item_id = $post->ID;
		if(isset($comment_id) && $comment_id != "")
		{
			$item_id = $post->ID;
			$secondary_item_id = $comment_id;
			if(get_option('aheadzen_voter_for_comments'))
			{
				$type = 'comment';
				$params = array(
					'component' => $component_name,
					'type' => $type,
					'item_id' => $item_id,
					'secondary_item_id' => $secondary_item_id
					);	
				$votestr = aheadzen_get_voting_link($params);
			}			
		}else{
			$item_id = 0;
			$secondary_item_id = $post->ID;
			
			if(($type && get_option('aheadzen_voter_for_custom_posttype')) || ($type=='page' && get_option('aheadzen_voter_for_page')) || ($type=='post' && get_option('aheadzen_voter_for_post'))  || ($type=='product' && get_option('aheadzen_voter_for_product')))
			{
				$params = array(
					'component' => $component_name,
					'type' => $type,
					'item_id' => $item_id,
					'secondary_item_id' => $secondary_item_id
					);
				$votestr = aheadzen_get_voting_link($params);
			}	
		}
	}elseif(aheadzen_is_bp_topic()) //if(function_exists('bp_get_activity_id'))
	{
		global $bp;
		$activity_id = bp_get_activity_id();
		$group_id = $bp->groups->current_group->id;
		$member_id = $bp->displayed_user->id;
		$component_name = "buddypress";
		$item_id = $post->ID;
		
		$check_url_for_topic = $bp->unfiltered_uri;
		if (in_array("topic", $check_url_for_topic))
		{
			$topic_id = 1;
		}
		
		if(isset($activity_id) && $activity_id != "") //activity
		{
			$type = "activity";
			$activity_id = bp_get_activity_id();
			$secondary_item_id = $activity_id;
			if(get_option('aheadzen_voter_for_activity'))
			{
				$params = array(
					'component' => $component_name,
					'type' => $type,
					'item_id' => $item_id,
					'secondary_item_id' => $secondary_item_id
					);	
				echo $votestr = aheadzen_get_voting_link($params);
			}
		}else if(isset($group_id) && $group_id != "" && (!isset($topic_id) && $topic_id == "")) //groups
		{
			$type = $bp->current_component;			
			$secondary_item_id = $group_id;
			if(get_option('aheadzen_voter_for_group'))
			{
				$params = array(
					'component' => $component_name,
					'type' => $type,
					'item_id' => $item_id,
					'secondary_item_id' => $secondary_item_id
					);
				echo $votestr = aheadzen_get_voting_link($params);
			}
		}
		else if(isset($member_id) && $member_id != "") //member profile
		{
			if(strtolower($bp->current_component) == "profile")
			{
				$type = $bp->current_component;
				$secondary_item_id = $member_id;						
				if(get_option('aheadzen_voter_for_profile'))
				{
					$params = array(
						'component' => $component_name,
						'type' => $type,
						'item_id' => $item_id,
						'secondary_item_id' => $secondary_item_id
						);	
					echo $votestr = aheadzen_get_voting_link($params);
				}
			}
			else if(strtolower($bp->current_component) == "messages") //member messages
			{
				$type = $bp->current_component;
				$secondary_item_id = $thread_template->message->id;
				if(get_option('aheadzen_voter_for_messages'))
				{
					$params = array(
						'component' => $component_name,
						'type' => $type,
						'item_id' => $item_id,
						'secondary_item_id' => $secondary_item_id
						);	
					$votestr = aheadzen_get_voting_link($params);
				}
			}
		}
		else if(isset($topic_id) && $topic_id != "") //topics
		{
			$type = "forum";
			$secondary_item_id = $post->ID;
			
			if(get_option('aheadzen_voter_for_forum'))
			{
				$params = array(
					'component' => $component_name,
					'type' => $type,
					'item_id' => $item_id,
					'secondary_item_id' => $secondary_item_id
					);	
				echo $votestr = aheadzen_get_voting_link($params);
			}
		}
		else
		{			
			// bp_get_member_user_id
			$type = $post->post_title;
			$member_id = get_current_user_id();
			$secondary_item_id = $member_id;					
			$params = array(
				'component' => $component_name,
				'type' => $type,
				'item_id' => $item_id,
				'secondary_item_id' => $secondary_item_id
				);	
			$votestr = aheadzen_get_voting_link($params);
		}
	}
	$voting_options = get_option('aheadzen_voter_display_options');
	
	if($voting_options==1)
	{
		return $content.$votestr;
	}else{
		return $votestr.$content;
	}
	
}


/*************************************************
Display up & down link function
*************************************************/
function aheadzen_get_voting_link($params)
{
	global $current_user;
	$votestr = '';
	$the_result = $params['result'];
	unset($params['result']);
	
	$post_id = $params['item_id'];
	$linkurl = get_permalink($post_id);
	
	$total_votes = aheadzen_get_total_votes($params);
	$is_voted = aheadzen_is_voted($params);
	$class_up = 'vote-up-on';
	$class_down = 'vote-down-on';
	$title_up = $title_down = __('click to vote','aheadzen');
	
	if($current_user->ID){
		$params['action']='up';
		$url_up = esc_url(wp_nonce_url(add_query_arg($params,$linkurl),'toggle-vote_' . $post_id));
		
		$params['action']='down';
		$url_down = esc_url(wp_nonce_url(add_query_arg($params,$linkurl),'toggle-vote_' . $post_id));
	}else{
		$class_up = 'vote-up-off aheadzen_voting_add';
		$class_down = 'vote-down-off aheadzen_voting_add';
		$title_up = $title_down = __('please login to vote','aheadzen');
		$url_up = $url_down = '#';
	}
	
	$voting_options = get_option('aheadzen_voter_display_options');
	if($voting_options==1)
	{
		$votestr.= '<div id="aheadzen_voting_'.$params['secondary_item_id'].'_'.$params['item_id'].'_'.$params['component'].'" class="aheadzen_vote alignright like_unlike_vote">';
		if($is_voted){
			if($is_voted=='up')
			{
				$votestr.= '<a rel="nofollow" title="'.$title_up.'" class="aheadzen_voter_css ' . $class_up . '" href="' . $url_up . '">'.__('Unlike','aheadzen').' <span>('.$total_votes.')</span></a>';
			}else{
				$votestr.= '<a rel="nofollow" title="'.$title_up.'" class="aheadzen_voter_css ' . $class_up . '" href="' . $url_up . '">'.__('Like','aheadzen').' <span>('.$total_votes.')</span></a>';
			}
		}else{
			$votestr.= '<a rel="nofollow" title="'.$title_up.'" class="aheadzen_voter_css ' . $class_up . '" href="' . $url_up . '">'.__('Like','aheadzen').' <span>('.$total_votes.')</span></a>';
		}
		$votestr.= '</div>';
	}else{
		if($is_voted){
			if($is_voted=='up')
			{
				$class_up = 'vote-up-off';
				$class_down = 'vote-down-on';
				$title_up = __('already voted, click to remove','aheadzen');
				//$url_up = '#';
			}elseif($is_voted=='down')
			{
				$class_up = 'vote-up-on';
				$class_down = 'vote-down-off';
				$title_down = __('already voted','aheadzen');
				$url_down = '#';
			}
		}
	
		$votestr.= '<div id="aheadzen_voting_'.$params['secondary_item_id'].'_'.$params['item_id'].'_'.$params['component'].'" class="aheadzen_vote alignright">';	
		
		$votestr.= '<a rel="nofollow" title="'.$title_up.'" class="aheadzen_voter_css ' . $class_up . '" href="' . $url_up . '"></a>';
		
		$votestr.= '<span class="vote-count-post">';
		$votestr.= $total_votes;
		$votestr.= '</span>';	
		
		$votestr.= '<a rel="nofollow" title="'.$title_down.'" class="aheadzen_voter_css ' . $class_down . '" href="' . $url_down . '"></a>';
		
		$votestr.= '</div>';
	}
	
	if($_REQUEST['rtype']=='json')
	{
		$return_arr = array();
		$return_arr['result'] = $the_result;
		$return_arr['total_votes'] = $total_votes;
		$return_arr['url_up'] = $url_up;
		$return_arr['url_down'] = $url_down;
		return $return_arr;
	}else{
		return $votestr;
	}
}


/*************************************************
Get Total votes of particulate item
*************************************************/
function aheadzen_get_total_votes($params)
{	
	global $current_user,$wpdb, $table_prefix, $post, $bp, $bbP;
	$total = $total_up = $total_down = 0;
	$component = $params['component'];
	$type = $params['type'];
	$item_id = $params['item_id'];
	$secondary_item_id = $params['secondary_item_id'];
	$total_up = $wpdb->get_var("select count(id) from `".$table_prefix."ask_votes` WHERE action='up' AND item_id=\"$item_id\" AND component=\"$component\" AND type=\"$type\" AND secondary_item_id=\"$secondary_item_id\"");
	$total_down = $wpdb->get_var("select count(id) from `".$table_prefix."ask_votes` WHERE action='down' AND item_id=\"$item_id\" AND component=\"$component\" AND type=\"$type\" AND secondary_item_id=\"$secondary_item_id\"");
	$total = $total_up-$total_down;
	return $total;
}

/*************************************************
Insert user vote to Databse
*************************************************/

function aheadzen_voter_add_vote($template)
{
	global $wp_query,$current_user,$wpdb, $table_prefix, $post, $bp, $bbP;
	$post_id = get_the_id();	
	$user_id = $current_user->ID;
	$result = '0';
	
	if($user_id && isset($_REQUEST) && !empty($_REQUEST))
	{
		if(isset($_REQUEST['component']) && isset($_REQUEST['type']) && isset($_REQUEST['action']) &&  isset($_REQUEST['item_id']) && isset($_REQUEST['secondary_item_id']))
		{
			if($_REQUEST['action']=='up'){$result='1';}elseif($_REQUEST['action']=='down'){$result='-1';}
			$params = array(
				'component' => $_REQUEST['component'],
				'type' => $_REQUEST['type'],
				'item_id' => $_REQUEST['item_id'],
				'secondary_item_id' => $_REQUEST['secondary_item_id']
				);
				
			$is_voted = aheadzen_is_voted($params,'all');
			if($is_voted){
				$voted_id = $is_voted->id;
				$action = $_REQUEST['action'];
				if($action=='up' && $is_voted->action=='up')
				{
					$sql = "delete from `".$table_prefix."ask_votes` where id=\"$voted_id\"";
					$wpdb->query($sql);
					$result = '0';
				}else{				
					$sql = "update `".$table_prefix."ask_votes` set action=\"$action\" where id=\"$voted_id\"";
					$wpdb->query($sql);
				}				
			}else{
				$sql =  "INSERT INTO `".$table_prefix."ask_votes` (user_id, component, type, action, date_recorded, item_id, secondary_item_id) VALUES ('".$user_id."', '".$_REQUEST['component']."', '".urldecode($_REQUEST['type'])."', '".$_REQUEST['action']."', '".date("Y-m-d h:i:s")."', '".$_REQUEST['item_id']."', '".$_REQUEST['secondary_item_id']."')";
				$wpdb->query($sql);
				aheadzen_voter_add_vote_bbpress_notification();
			}
			
			if($_REQUEST['rtype']=='json')
			{
				$params['result'] = $result;
				$params['user_id'] = $_REQUEST['user_id'];
				$params['rtype'] = $_REQUEST['rtype'];
				$return_arr = aheadzen_get_voting_link($params);
				echo  json_encode($return_arr);
				header('Content-Type: application/json; charset=UTF-8', true);
				exit;
			}else{
				echo aheadzen_get_voting_link($params);
			}
			exit;
		}
	}
	return $template;
}


function aheadzen_voter_add_vote_bbpress_notification()
{
	global $wpdb,$post, $bp, $current_user,$wp_query;	
	$post_id = (int)$_REQUEST['secondary_item_id'];
	$action = $_REQUEST['action'];
	$check_url_for_topic = $bp->unfiltered_uri;
	
	if($bp && $_REQUEST['action'] == 'up' && $post_id && $action && in_array("topic", $check_url_for_topic))
	{
		$action = 'vote_' .$_REQUEST['action'];
		
		$topic_id = $post_id;
		
		$user_id = bp_loggedin_user_id();
		$userlink = bp_core_get_userlink( $user_id );
		$topic = $wp_query->queried_object;
		$topic_slug = $topic->post_name;
		$topic_title = $topic->post_title;
		
		$poster_link = bp_core_get_userlink( $post->poster_id );
		//$topic_link = '<a href="' . bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/' . $topic_slug . '/' . 'forum/topic/' . $topic_slug . '/">' . $topic_title . '</a>';
		$topic_link = '<a href="' . bp_get_root_domain() . '/' . 'forum/topic/' . $topic_slug . '/">' . $topic_title . '</a>';
		$arg_arr = array(
					'user_id'   => $user_id,
					'action'    => sprintf( __( "%s likes %s's post in %s", 'buddypress' ), $userlink, $poster_link, $topic_link ),
					'component' => 'votes',
					'item_id'           => $topic_id, 
					'secondary_item_id' => $post_id,
					'type'      => 'forums'
				);
		
		$activity_id = bp_activity_add($arg_arr);
		bp_core_add_notification( $topic_id, $user_id, 'votes', 'vote_up');
		//bp_core_add_notification( $activity_id, $user_id, 'activity', 'activity_viewed');		
		//bp_core_add_notification('100', (int)$bp->loggedin_user->id, 'activity', 'activity_viewed');
		return true;
		
	}
	return false;
}

function voter_format_notifications( $action, $item_id, $secondary_item_id, $total_items )
{

	global $bp;
	$post = bp_forums_get_post( $secondary_item_id );

	$topic_url = $bp->loggedin_user->domain . $bp->activity->slug . '/' . $bp->gifts->slug . '/';
	$topic_id = $post->topic_id;

	$topic = bp_forums_get_topic_details( $topic_id );
	$topic_link = '<a href="' . bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/' . $topic->object_slug . '/' . 'forum/topic/' . $topic->topic_slug . '/">' . $topic->topic_title . '</a>';

	$voter_link = bp_core_get_userlink( $item_id );

	$notification = "$voter_link likes your post in $topic_link";

	return array( 'text' => $notification,
				'link' => '' );
}

function voter_setup_globals()
{
	global $bp;
	$bp->votes->notification_callback        = 'voter_format_notifications';
}
add_action( 'bp_setup_globals', 'voter_setup_globals' );

/*************************************************
Get user's voting details
*************************************************/
function aheadzen_get_user_all_vote_details($params)
{	
	global $current_user,$wpdb, $table_prefix, $post, $bp, $bbP;
	$return_arr = array();
	$user_id = $current_user->ID;
	$component = $params['component'];
	$type = $params['type'];
	$item_id = $params['item_id'];
	$secondary_item_id = $params['secondary_item_id'];
	$sql = "select id,item_id,secondary_item_id,component,type from `".$table_prefix."ask_votes` WHERE user_id=\"$user_id\"";
	$result = $wpdb->get_results($sql);
	if($result)
	{
		foreach($result as $resultobj)
		{
			$return_arr[$resultobj->component][$resultobj->type][$resultobj->secondary_item_id][$resultobj->item_id]=$resultobj->id;
		}
	}
	return $return_arr;
}


/*************************************************
Voting settings for API
www.ask-oracle.com/?voterapi=1&pid=200&username=arpit123
*************************************************/
add_filter('template_include','aheadzen_voter_add_vote_api');
function aheadzen_voter_add_vote_api($template)
{
	if($_GET['voterapi'])
	{
		global $wpdb,$current_user;
		$user_error = $post_error = '';
		$pid = $_GET['pid'];
		$user_id = $current_user->ID;
		if($_GET['uid']){
			$user_id = $_GET['uid'];
			$user_id = $wpdb->get_var("select ID from $wpdb->users where ID=\"$user_id\"");
		}
		if($_GET['username']){
			$username = $_GET['username'];
			$user_id = $wpdb->get_var("select ID from $wpdb->users where user_login=\"$username\"");
		}		
		if(!$user_id){
			$user_error='wronguser';
		}
		if(get_the_title($pid)=='')
		{
			$post_error = 'wrongpost';
		}
		if(!is_numeric($pid))
		{
			$post_error = 'invalidpost';
		}
		
		$arg = array(
			'item_id'=>$pid,
			'item_error'=>$post_error,
			'user_id'=>$user_id,
			'user_error'=>$user_error,
			'type'=>$_GET['type'],
			);
		echo aheadzen_get_post_all_vote_details($arg);
		header('Content-Type: application/json; charset=UTF-8', true);
		exit;
	}
	return $template;
}

/*************************************************
Get post's voting details
*************************************************/
function aheadzen_get_post_all_vote_details($arg)
{	
	global $current_user,$wpdb, $table_prefix;
	$post_error = $user_error = '';
	$return_arr = array();
	$comments_arr = array();
	$user_comments_arr = array();
	$post_vote_links = array();
	$item_id = $arg['item_id'];
	$type = $arg['type'];
	$user_id = $arg['user_id'];
	if($arg['user_error']=='wronguser')
	{
		$user_error=__('Wrong User','aheadzen');
	}
	
	if($arg['item_error']=='wrongpost')
	{
		$post_error=__('Unknown Post','aheadzen');
	}elseif($arg['item_error']=='invalidpost')
	{
		$post_error=__('Invalid Post ID','aheadzen');
	}
	
	if($item_id && $arg['item_error']=='')
	{
		$subsql = '';
		if($type)
		{
			$subsql = "and type=\"$type\"";
		}else{
			$subsql = "and type!='comment'";
		}
		$item_total_votes = $wpdb->get_var("select count(id) from `".$table_prefix."ask_votes` WHERE secondary_item_id=\"$item_id\" $subsql limit 1");
		$item_total_up_votes = $wpdb->get_var("select count(id) from `".$table_prefix."ask_votes` WHERE  action='up' and secondary_item_id=\"$item_id\" $subsql limit 1");
		$item_total_down_votes = $wpdb->get_var("select count(id) from `".$table_prefix."ask_votes` WHERE  action='down' and secondary_item_id=\"$item_id\" $subsql limit 1");
		
		$linkurl = get_permalink($item_id);
		$params = array();
		$params['component'] = 'blog';
		$params['type']= get_post_type($item_id);
		$params['item_id'] = 0;
		$params['secondary_item_id'] = $item_id;
		$params['action']='up';
		$params['rtype']='json';
		$params['user_id']=$user_id;
		$url_up = wp_nonce_url(add_query_arg($params,$linkurl),'toggle-vote_' . $item_id);
		$post_vote_links['up'] = $url_up;
		$params['action']='down';
		$url_down = wp_nonce_url(add_query_arg($params,$linkurl),'toggle-vote_' . $item_id);
		$post_vote_links['down'] = $url_down;
		if($user_id && $user_error=='')
		{
			$user_total_votes = $wpdb->get_var("select action from `".$table_prefix."ask_votes` WHERE secondary_item_id=\"$item_id\" and user_id=\"$user_id\" $subsql limit 1");
			if($user_total_votes=='up'){$user_vote='1';}elseif($user_total_votes=='down'){$user_vote='-1';}
			
			$user_comment_results = $wpdb->get_results("select action,secondary_item_id from `".$table_prefix."ask_votes` WHERE user_id=\"$user_id\" and item_id=\"$item_id\" and type='comment' group by secondary_item_id");
			if($user_comment_results)
			{
				foreach($user_comment_results as $usercommobj)
				{
					$user_vote=0;
					if($usercommobj->action=='up'){$user_vote='1';}elseif($usercommobj->action=='down'){$user_vote='-1';}
					$user_comments_arr[$usercommobj->secondary_item_id]=$user_vote;
				}
			}
		}
		
		$total_comments = $wpdb->get_var("select count(distinct(secondary_item_id)) from `".$table_prefix."ask_votes` WHERE item_id=\"$item_id\" and type='comment'");
		$comment_results = $wpdb->get_results("select count(id) as total_count,secondary_item_id from `".$table_prefix."ask_votes` WHERE item_id=\"$item_id\" and type='comment' group by secondary_item_id");
		if($comment_results)
		{
			foreach($comment_results as $resultsobj)
			{
				$comment_vote_links = array();
				$params = array();
				$params['component'] = 'blog';
				$params['type']= 'comment';
				$params['item_id'] = $item_id;
				$params['secondary_item_id'] = $resultsobj->secondary_item_id;
				$params['action']='up';
				$params['rtype']='json';
				$params['user_id']=$user_id;
				$url_up = wp_nonce_url(add_query_arg($params,$linkurl),'toggle-vote_' . $item_id);
				$comment_vote_links['up'] = $url_up;
				$params['action']='down';
				$url_down = wp_nonce_url(add_query_arg($params,$linkurl),'toggle-vote_' . $item_id);
				$comment_vote_links['down'] = $url_down;
				$comments_arr[] = array(
					'comment_id' => $resultsobj->secondary_item_id,
					'total_count' => $resultsobj->total_count,
					'current_user_vote' => $user_comments_arr[$resultsobj->secondary_item_id],
					'comment_voter_links' => $comment_vote_links,
					);
				
			}
		}
		
	}
	$return_arr['post_id']=$item_id;
	$return_arr['post_error']=$post_error;
	$return_arr['total_votes']=$item_total_votes;
	$return_arr['total_up']=$item_total_up_votes;
	$return_arr['total_down']=$item_total_down_votes;
	$return_arr['post_voter_links']=$post_vote_links;
	$return_arr['current_user_id']=$user_id;
	$return_arr['user_error']=$user_error;
	$return_arr['user_vote']=$user_vote;
	$return_arr['total_voted_comments']=$total_comments;
	$return_arr['comments']=$comments_arr;
	
	$return_str = json_encode($return_arr);	
	return $return_str;
}

/*************************************************
Login form for -- Not login user 
*************************************************/
function aheadzen_voting_login_dialog()
{
$redirect_to = get_permalink();
$login_title = get_option('aheadzen_voter_login_title');
$login_desc = get_option('aheadzen_voter_login_desc');
$login_link = get_option('aheadzen_voter_login_link');
$register_link = get_option('aheadzen_voter_register_link');
$login_frm = get_option('aheadzen_voter_display_login_frm');
if($login_title==''){$login_title=__('Please Login','aheadzen');}
?>
<div id="aheadzen_voting_login" title="<?php echo $login_title;?>">
<?php echo $login_desc;?>
<?php if($login_frm){?>
<form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
	<p>
		<label for="user_login"><?php _e('Username') ?><br />
		<input type="text" name="log" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" /></label>
	</p>
	<p>
		<label for="user_pass"><?php _e('Password') ?><br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" /></label>
	</p>
	
	<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" <?php checked( $rememberme ); ?> /> <?php esc_attr_e('Remember Me'); ?></label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php _e('Log In','aheadzen'); ?>" />
		<?php if($register_link){?>
		<a href="<?php echo $register_link;?>?redirect_to=<?php echo urlencode($redirect_to); ?>" class="aheadzen_button_red"><?php _e('Register','aheadzen'); ?></a>
		<?php }?>

	<input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>" />
		<input type="hidden" name="testcookie" value="1" />
	</p>
</form>
<?php }else{?>
<?php if($register_link){?>
<a href="<?php echo $register_link;?>" class="aheadzen_button_blue"><?php _e('Login','aheadzen'); ?></a>
<?php }?>
<?php if($register_link){?>
<a href="<?php echo $register_link;?>?redirect_to=<?php echo urlencode($redirect_to); ?>" class="aheadzen_button_red"><?php _e('Register','aheadzen'); ?></a>
<?php }?>
<?php }?>
</div>
<?php if(get_option('aheadzen_voter_include_dialog_js')){  }else{?>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<?php } ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<?php
}