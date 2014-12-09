<?php
/*************************************************
Insert voter to duddypress activity & notifications
*************************************************/
function aheadzen_voter_add_vote_bbpress_notification()
{
	global $wpdb,$post, $bp, $current_user,$wp_query;	
	$item_id = (int)$_REQUEST['item_id'];
	$secondary_item_id = (int)$_REQUEST['secondary_item_id'];	
	$action = $_REQUEST['action'];
	$type = $_REQUEST['type'];
	$check_url_for_topic = $bp->unfiltered_uri;
	
	if($bp && $_REQUEST['action'] == 'up' && $secondary_item_id && $type)
	{
		$user_id = bp_loggedin_user_id();
		if($_REQUEST['user_id']){$user_id = $_REQUEST['user_id'];}
		
		$topic_id = $secondary_item_id;
		$action_str = $type.'_'.$user_id.'_vote_' .$action;
		$userlink = bp_core_get_userlink( $user_id );
		
		if($type=='topic-reply'){
			if(is_old_version())
			{		
				$topic = bp_forums_get_topic_details( $item_id );
				$topic_details= bp_forums_get_post( $secondary_item_id ); //reply	
				$topic_details->post_author = $topic_details->poster_id;				
				$topic_details->post_title = $topic->topic_title;
			}else{
				$topic_details = bbp_get_reply($secondary_item_id);
			}
		}elseif($type=='topic'){
			$topic_details = bbp_get_topic( $secondary_item_id );
		}			
	
		if($_REQUEST['type']=='comment')
		{
			$post = get_post($item_id);
			$post_title =$post->post_title;
			$post_type = get_post_type($item_id);
			$post_author = $post->post_author;
			$poster_link = bp_core_get_userlink( $post->post_author );	
			$topic_link = '<a href="' . get_permalink($post->ID) .'">' . $post->post_title . '</a>';
			$action_content = sprintf( __( "%s likes comment on %s's post %s", 'buddypress' ), $userlink, $poster_link, $topic_link );
		}elseif($_REQUEST['type']=='profile' || $_REQUEST['type']=='groups' || $_REQUEST['type']=='activity')
		{
			$post_title = $topic_link = $wp_query->post->post_title;			
			if($_REQUEST['type']=='profile')
			{
				$topic_link = '<a href="' . $bp->displayed_user->domain . '/">' . $bp->displayed_user->fullname . '</a>';
				$post_author = $bp->displayed_user->id;
			}elseif($_REQUEST['type']=='groups')
			{
				$topic_link = '<a href="' . bp_get_root_domain() . '/' . 'groups/' . $bp->groups->current_group->slug . '/">' . $bp->groups->current_group->name . '</a>';
				$post_author = $bp->groups->current_group->creator_id;
			}
			$action_content = sprintf( __( "%s likes %s %s", 'buddypress' ), $userlink, $_REQUEST['type'], $topic_link );
		}elseif(($_REQUEST['type']=='topic' || $_REQUEST['type']=='topic-reply') && $topic_details)
		{
			$post_title = $topic_details->post_title;
			$post_author = $topic_details->post_author;
			if(is_old_version())
			{	
				$group = groups_get_group( array( 'group_id' => $topic->object_id ) );
				$topic_link = trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/' . $group->slug . '/' ).'/forum/topic/' . $topic->topic_slug . '/';
				$topic_post= bp_forums_get_post( $item_id );
			}else{
				$topic_link = bbp_get_topic_permalink( $secondary_item_id );
				$post_author = bbp_get_reply_author( $secondary_item_id );
			}	
			
			$topic_link = '<a href="' . $topic_link .'">' . $post_title . '</a>';
			if($_REQUEST['type']=='topic-reply'){$typestr = 'topic reply';}else{$typestr = 'topic';}
			$action_content = sprintf( __( "%s likes %s %s", 'buddypress' ), $userlink, $typestr, $topic_link );
		}else{
			$post = get_post($secondary_item_id);
			$post_author = $post->post_author;
			$post_title = $post->post_title;
			$post_type = get_post_type($secondary_item_id);
			$topic_link = '<a href="' . get_permalink($post->ID) .'">' . $post->post_title . '</a>';
			//$action_content = sprintf( __( "%s likes %s's post in %s", 'buddypress' ), $userlink, $poster_link, $topic_link );
			$action_content = sprintf( __( "%s likes %s %s", 'buddypress' ), $userlink, $_REQUEST['type'], $topic_link );
		}
		$arg_arr = array(
					'user_id'   => $post_author,
					'action'    => $action_content,
					'component' => 'votes',
					'item_id'           => $topic_id, 
					'secondary_item_id' => $_REQUEST['item_id'],
					'type'      => 'forums'
				);
		$activity_id = bp_activity_add($arg_arr);
		
		if($_REQUEST['type']=='activity')
		{
			//don't send notification for activity
			global $wpdb;
			$table_name =  $bp->activity->table_name;
			$post_author = $wpdb->get_var("select user_id from $table_name where id=\"$topic_id\"");
		}
		
		if($post_author)
		{
			$arg = array(
				'secondary_item_id' => $_REQUEST['secondary_item_id'],
				'item_id' 		=> $_REQUEST['item_id'],
				'post_author' 	=> $post_author,
				'type' 			=> $_REQUEST['type'],
				'action' 		=> $_REQUEST['action'],
				'user_id' 		=> $user_id,
				'like_msg' 		=> $action_content,
				'title_msg' 	=> $post_title,
				);
			aheadzen_send_author_notification($arg);
			
			bp_core_add_notification( $_REQUEST['secondary_item_id'], $post_author, 'votes', $action_str,$_REQUEST['item_id']);
		}
		
		return true;
		
	}
	return false;
}

/*************************************************
Register Buddpress voter component
*************************************************/
function aheadzen_voter_filter_notifications_get_registered_components( $component_names = array() ) {

 // Force $component_names to be an array
 if ( ! is_array( $component_names ) ) {
  $component_names = array();
 }

 // Add 'votes' component to registered components array
 array_push( $component_names, 'votes' );

 // Return component's with 'votes' appended
 return $component_names;
}


/*************************************************
Set voter buddypress componant Global
*************************************************/
function aheadzen_voter_setup_globals()
{
	global $bp;
	//for ask oracle.com
	$bp->votes = new BP_Component;
	$bp->votes->notification_callback = 'aheadzen_voter_notification_title_format';
	$bp->active_components['votes'] = '1';		
}


/*************************************************
Get user's voting details
*************************************************/
function aheadzen_voter_notification_title_format( $component_action, $item_id, $secondary_item_id ) {
   
   global $bp,$wp_query;
   $component_action_arr = explode('_',$component_action);
   $component_action_type = $component_action_arr[0];
   $poster_user_id = (int)$component_action_arr[1];
   
    $notifications = $bp->notifications->query_loop->notifications;
	$notification = '';
    $user_id = $poster_user_id;
    $post_id = $secondary_item_id;
	
	$display_name = bp_core_get_user_displayname( $user_id );
	$url = bp_core_get_user_domain( $user_id );
	$voter_link = $display_name;
	
	if($component_action_type=='topic' || $component_action_type=='topic-reply')
	{
		if(is_old_version())
		{			
			$topic_details = bp_forums_get_topic_details( $post_id );
		}else{
			$topic_details = bbp_get_topic( $post_id );
		}
	}
	
	if($component_action_type=='comment')
	{       
		$post = get_post($secondary_item_id);
		$topic_url = get_permalink($secondary_item_id);
		$title = get_the_title($secondary_item_id);
		$topic_link = '<a href="' . $topic_url . '">' . $title . '</a>';
		$notification = "$voter_link likes your $component_action_type on  $topic_link";
	}elseif($component_action_type=='profile' || $component_action_type=='groups'  || $component_action_type=='activity')
	{
		$topic_link = '';
		if($component_action_type=='groups')
		{
			$post = groups_get_group( array( 'group_id' => $item_id ) );
			$group_name = $post->name;
			$group_slug = $post->slug;
			$topic_link = '<a href="' . bp_get_root_domain() . '/' . 'groups/' . $group_slug . '/">' . $group_name . '</a>';
		}
		$component_action_arr = explode('_',$component_action);
		$component_action_type = $component_action_arr[0];
		$notification = "$voter_link likes your $component_action_type $topic_link";
	}elseif(($component_action_type=='topic' || $component_action_type=='topic-reply') && $topic_details)
	{
		$post_title = $topic_details->post_title;
		$post_author = $topic_details->post_author;
		if(is_old_version())
		{ 
			$post_title = $topic_details->topic_title;
			$group = groups_get_group( array( 'group_id' => $topic_details->object_id ) );
			$topic_link = trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/' . $group->slug . '/' ).'/forum/topic/' . $topic_details->topic_slug . '/';
			$topic_post= bp_forums_get_post( $post_id );
			$post_author = $topic_post->poster_id;
		}else{
			$topic_link = bbp_get_topic_permalink( $post_id );
			$post_author = bbp_get_reply_author( $post_id );
		} 
		
		$topic_link = '<a href="' . $topic_link .'">' . $post_title . '</a>';
		$notification = "$voter_link likes your $component_action_type $topic_link";
		
	}else{
		$post = get_post($item_id);
		$topic_url = get_permalink($item_id);
		$title = get_the_title($item_id);
		$topic_link = '<a href="' . $topic_url . '">' . $title . '</a>';
		$component_action_arr = explode('_',$component_action);
		$component_action_type = $component_action_arr[0];
		$notification = "$voter_link likes your $component_action_type $topic_link";
	}
	
	return $notification;

}

/*************************************************
Email alert send while voting Up
*************************************************/
function aheadzen_send_author_notification($arg)
{
	global $bp;
	$from_name =  get_option('blogname');
	$from_email = get_option('admin_email');
	
	$to = $arg['post_author'];
	$to_display_name = bp_core_get_user_displayname($to);
	$user_data = get_userdata($to);
	$to_email = $user_data->data->user_email;
	
	$secondary_item_id = $arg['secondary_item_id'];
	$item_id = $arg['item_id'];
	$type = $arg['type'];
	$user_id = $arg['user_id'];
	$like_msg = $arg['like_msg'];
	$title_msg = $arg['title_msg'];
	
	$user_id_link = bp_core_get_userlink( $user_id );
	$user_display_name = bp_core_get_user_displayname($user_id);
	$component_action_type = $type;
	$voter_link = bp_core_get_userlink( $user_id );
	$subject = '';
	
	$notification = $like_msg;
	
	$subject = "$user_display_name likes your $component_action_type $title_msg";
	$notification_link = $bp->bp_nav['notifications']['link'];
	$settings_link = '<a href="'.$bp->bp_nav['settings']['link'].'notifications/"> member settings</a>';
	$message =  $notification.'<br /><br />To view all of your pending notifications: <a href="'.$notification_link.'">Click the link</a> <br /><br />Click to view '.$voter_link.'\'s profile.';
	$message .= '<br /><br />'.sprintf( __( 'To disable these notifications please log in and go to: %s', 'aheadzen' ), $settings_link );
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".get_bloginfo('charset')."" . "\r\n";
	$headers .= "From: $from_name <$from_email>" . "\r\n";
	//echo "to : $to_email<br />, SUBJECT: $subject<br />, Message: $message<br />,Header : $headers";exit;
	wp_mail($to_email, $subject, $message, $headers);
}

function aheadzen_bp_the_topic_permalink() {
 global $forum_template, $bbpress_live, $group_obj;
 
 $target_uri = $bbpress_live->fetch->options['target_uri'];
 
 echo bp_group_permalink( $group_obj, false ) . '/forum/topic/' . $forum_template->topic->topic_id;
}