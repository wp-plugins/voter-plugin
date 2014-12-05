<?php
include_once('voter_db_settings.php');
include_once('admin_settings.php');
include_once('notification.php');
include_once('voter_api.php');
include_once('voter_widgets_shorcodes.php');

/*************************************************
Voter plugin init function
*************************************************/
function aheadzen_voter_init()
{
	load_plugin_textdomain('aheadzen', false, basename( dirname( __FILE__ ) ) . '/languages');
	if ( current_user_can( 'delete_posts' ) )
	{
        add_action( 'delete_post', 'aheadzen_delete_post_related_data', 10 );
	}
}

/*************************************************
Plugin JS & CSS include
*************************************************/	
function aheadzen_voter_add_custom_scripts()
{
	$pid = get_the_ID();
	if(aheadzen_check_voter_page_disabled($pid))
	{
		return $content;
	}
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
Check if the voter plugin disable or not
*************************************************/
function aheadzen_check_voter_page_disabled($pid)
{
	$exclude_pages = get_option('aheadzen_voter_exclude_pages');
	if($exclude_pages)
	{
		$current_template = get_post_meta($pid,'_wp_page_template',true);
		if(in_array($current_template,$exclude_pages))
		{
			return true;
		}
	}
	return false;
}

/*************************************************
Display voter link conditions checking function
*************************************************/
function aheadzen_display_voting_links($content)
{
	$pid = get_the_ID();
	if(aheadzen_check_voter_page_disabled($pid))
	{
		return $content;
	}
		
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
			$component_name = 'forum';
			$type = "topic";
			$secondary_item_id = $post->ID;
			
			
			if(get_option('aheadzen_voter_for_forum'))
			{
				if($bp->current_component=='groups')
				{
					//$item_id = $group_id = $bp->groups->current_group->id;
				}
				if(function_exists('bp_get_the_topic_id'))
				{
					$item_id = bp_get_the_topic_id();
				}
				if(function_exists('bp_get_the_topic_post_id'))
				{
					$secondary_item_id = bp_get_the_topic_post_id();
				}
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
	if($params['type']=='forum')
	{
		if(function_exists('bp_get_the_topic_permalink'))
		{
			$linkurl =  bp_get_the_topic_permalink();
		}else{		
			$linkurl =  esc_url( bbp_get_topic_permalink( $post_id) );
		}
	}else{
		$linkurl = get_permalink($post_id);
	}
	$total_votes = aheadzen_get_total_votes($params);
	$is_voted = aheadzen_is_voted($params);
	$class_up = 'vote-up-on';
	$class_down = 'vote-down-on';
	$title_up = $title_down = __('click to vote','aheadzen');
	
	$user_id = $current_user->ID;
	if($params['user_id']){$user_id = $params['user_id'];}
	
	if($user_id){
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
	if($_GET['clear-all']=='notifications' && $current_user->ID)
	{
		aheadzen_delete_user_notifications($current_user->ID);
	}elseif($_GET['ntid'] && $current_user->ID)
	{
		$notification_id = $_GET['ntid'];
		aheadzen_read_user_notifications($notification_id);
	}
	
	$post_id = get_the_id();
	$user_id = $current_user->ID;
	if($_REQUEST['user_id']){$user_id = $_REQUEST['user_id'];}
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
	global $bp;
	$pid = get_the_ID();
	if(aheadzen_check_voter_page_disabled($pid))
	{
		return $content;
	}
/*
if($bp->current_component=='activity')
{
	$redirect_to = $bp->canonical_stack['base_url'];
}elseif($bp->current_component=='groups')
{
	$redirect_to = bp_get_root_domain() . '/groups/' . $bp->groups->current_group->slug.'/';
}elseif($bp->current_component=='profile')
{
	$redirect_to = $bp->displayed_user->domain;
}else
{
	$redirect_to = get_permalink();
}
*/
$redirect_to = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$login_title = get_option('aheadzen_voter_login_title');
$login_desc = get_option('aheadzen_voter_login_desc');
$login_link = get_option('aheadzen_voter_login_link');
$register_link = get_option('aheadzen_voter_register_link');
$login_frm = get_option('aheadzen_voter_display_login_frm');
if($login_title==''){$login_title=__('Please Login','aheadzen');}
if($login_link=='')
{
	 $login_link = esc_url( site_url( 'wp-login.php', 'login_post' ) );
}
?>
<div id="aheadzen_voting_login" title="<?php echo $login_title;?>">
<?php echo $login_desc;?>
<?php if($login_frm){?>
<form name="loginform" id="loginform" action="<?php echo $login_link; ?>" method="post">
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
		<?php /*?><input type="hidden" name="testcookie" value="1" /><?php */?>
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


/*******************************
Top voted list main function
****************************/
function aheadzen_top_voted_list_all($arg)
{
	$type = $arg['type'];
	$num = $arg['num'];
	
	if($type=='profile' || $type=='groups')
	{
		$component = 'buddypress';
		$arg = array('component'=>$component,'type'=>$type,'num'=>$num);
		if($type=='profile')
		{
			return aheadzen_top_voted_list_members($arg);
		}elseif($type=='groups')
		{
			return aheadzen_top_voted_list_groups($arg);
		}
	}else
	{
		if($type=='product'){
			$component = 'woocommerce';
		}elseif($type=='topic'){
			$component = 'forum';
		}else{
			$component = 'blog';
		}
		$arg = array('component'=>$component,'type'=>$type,'num'=>$num);
		return aheadzen_top_voted_list_default($arg);
	}
}

/*******************************
Top voted list default listing function
****************************/
function aheadzen_top_voted_list_default($arg)
{
	global $members_template,$table_prefix, $wpdb;
	$return = '';
	$component = $arg['component'];
	$type = $arg['type'];
	$num = $arg['num'];
	
	$sql = "select secondary_item_id,count(action) as count from `".$table_prefix."ask_votes` where component=\"$component\" and type=\"$type\" group by secondary_item_id order by count desc limit $num";
	$res =  $wpdb->get_results($sql);
	if($res)
	{
		$return .= '<ul class="voter_top_list list_'.$type.'">';
		foreach($res as $resobj)
		{
			$title = get_the_title($resobj->secondary_item_id);
			$link = get_permalink($resobj->secondary_item_id);
			$return .=  '<li><a href="'.$link.'">'.$title.'</a></li>';					
		}
		$return .= '</ul>';				
	}

	return $return;
}

/*******************************
Top voted members list listing function
****************************/
function aheadzen_top_voted_list_members($arg)
{
	global $members_template,$table_prefix, $wpdb;
	$return = '';
	$component = $arg['component'];
	$type = $arg['type'];
	$num = $arg['num'];
	
	$ids_arr = array();
	$final_arr = array();
	$sql = "select secondary_item_id,count(action) as count from `".$table_prefix."ask_votes` where component=\"$component\" and type=\"$type\" group by secondary_item_id order by count desc limit $num";
	$res =  $wpdb->get_results($sql);
	if($res)
	{
		foreach($res as $resobj)
		{
			$ids_arr[]=$resobj->secondary_item_id;
			$final_arr[$resobj->secondary_item_id] = $resobj->count;
		}
		if($ids_arr){
			$ids_str = implode(',',$ids_arr);
			$members_args = array(
				'include '         => $ids_str,
				'type'            => 'active',
				'per_page'        => $num,
				'max'             => $num,
				'populate_extras' => true,
				'search_terms'    => false,
			);
			if ( bp_has_members( $members_args ) ) :
				while ( bp_members() ) : bp_the_member();
				ob_start();
				?>
				<li><a href="<?php bp_member_permalink() ?>"><?php bp_member_name() ?></a></li>
				<?php
				$content = ob_get_contents();
				ob_clean();
				$final_arr[$members_template->member->id]=$content; 
			endwhile;
			if($final_arr)
			{
				$return .= '<ul class="voter_top_list list_'.$type.'">';
				$return .= implode(' ',$final_arr);
				$return .= '</ul>';
			}
			endif;
		}
	}
	return $return;
}

/*******************************
Top voted groups list listing function
****************************/
function aheadzen_top_voted_list_groups($arg)
{
	global $members_template,$table_prefix, $wpdb,$bp_prefix;
	$return = '';
	$component = $arg['component'];
	$type = $arg['type'];
	$num = $arg['num'];
	
	$ids_arr = array();
	$final_arr = array();
	$sql = "select g.*,count(v.action) as count from `".$table_prefix."ask_votes` v join ".$table_prefix."bp_groups g on g.id=v.secondary_item_id where g.status='public' and v.component=\"$component\" and v.type=\"$type\" group by v.secondary_item_id order by count desc limit $num";
	$res =  $wpdb->get_results($sql);
	if($res)
	{
		$return .= '<ul class="voter_top_list list_'.$type.'">';
		foreach($res as $resobj)
		{
			$link = bp_get_group_permalink( $resobj );
			$return .=  '<li><a href="'.$link.'">'.$resobj->name.'</a></li>';	
		}
		$return .= '</ul>';
		
	}
	return $return;
}

/*******************************
Read all notifications on one click
****************************/
function aheadzen_read_user_notifications($notification_id)
{
	global $bp, $wpdb,$table_prefix;
	$wpdb->query("update ".$table_prefix."bp_notifications set is_new='0' where id=\"$notification_id\"");
}

/*******************************
Delete all notifications on one click
****************************/
function aheadzen_delete_user_notifications($user_id)
{
	global $bp, $wpdb,$table_prefix;
	$wpdb->query("delete from ".$table_prefix."bp_notifications where user_id=\"$user_id\"");
}

/*******************************
Read all user post notifications on while visit the page
****************************/
function aheadzen_read_user_post_notifications($pid,$uid)
{
	global $wpdb,$table_prefix;
	$wpdb->query("update ".$table_prefix."bp_notifications set is_new='0' where item_id=\"$pid\" and user_id=\"$uid\"");
}

function aheadzen_update_user_notification()
{
	global $wp_query,$post, $bp, $thread_template, $bbP, $forum_id, $wpdb, $table_prefix,$current_user;
	$post_type = $post->post_type;
	if(($post_type || $post_type == "page" || $post_type == "post" || $post_type == "product") && !aheadzen_is_bp_topic()) //check for page or post without buddpress topic
	{
		$uid = $wp_query->queried_object->post_author;
		$pid = $post->ID;
		if($current_user->ID == $uid)
		{
			aheadzen_read_user_post_notifications($pid,$uid);
		}
	}elseif(aheadzen_is_bp_topic())
	{
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
		if(isset($group_id) && $group_id != "" && (!isset($topic_id) && $topic_id == "")) //groups
		{
			$uid = $bp->groups->current_group->creator_id;
			$pid = $bp->groups->current_group->id;
			if($current_user->ID == $uid)
			{
				aheadzen_read_user_post_notifications($pid,$uid);
			}
		}
		else if(isset($member_id) && $member_id != "") //member profile
		{
			if(strtolower($bp->current_component) == "profile")
			{
				if($current_user->ID == $member_id)
				{
					$uid = $member_id;
					aheadzen_read_user_post_notifications($member_id,$uid);
				}
			}
			else if(strtolower($bp->current_component) == "messages") //member messages
			{
				//echo 'VERY LAST 2222';
			}
		}else if(isset($activity_id) && $activity_id != "") //activity
		{
			$activity_id = bp_get_activity_id();
			$uid = $current_user->ID;
			if($uid){
				$wpdb->query("update ".$table_prefix."bp_notifications set is_new='0' where component_action like 'activity_%' and user_id=\"$uid\"");
			}
		}else if(isset($topic_id) && $topic_id != "") //topics
		{
			$uid = $wp_query->queried_object->post_author;
			$pid = $post->ID;
			if($current_user->ID == $uid)
			{
				aheadzen_read_user_post_notifications($pid,$uid);
			}
		}
		else
		{
			//echo 'VERY LAST';
		}
	}
}


function aheadzen_delete_post_related_data($pid)
{
	global $wpdb,$table_prefix;
	$voter_table = $table_prefix.'ask_votes';
	$notifications_table = $table_prefix.'bp_notifications';
	$activity_table = $table_prefix.'bp_activity';
    $wpdb->query("DELETE FROM $voter_table WHERE item_id=\"$pid\" or secondary_item_id=\"$pid\"");
	$wpdb->query("DELETE FROM $notifications_table WHERE item_id=\"$pid\"");
	$wpdb->query("DELETE FROM $activity_table WHERE component='votes' and item_id=\"$pid\"");
}

function aheadzen_bp_delete_topic()
{
	add_action('bbp_delete_topic','aheadzen_delete_post_related_data');
}