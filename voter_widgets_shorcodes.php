<?php

/**Widget Initialize**/
add_action( 'widgets_init','widget_aheadzen_voter_init');

/*******************************
Widget Init Function
****************************/
function widget_aheadzen_voter_init()
{
	register_widget('aheadzen_voter_widget');
}


/*******************************
Widget Function
****************************/

if(!class_exists('aheadzen_voter_widget')){
	class aheadzen_voter_widget extends WP_Widget {
		function aheadzen_voter_widget() {
		//Constructor
			$widget_ops = array('classname' => 'widget aheadzen_voter widget_categories', 'description' => __('Display top voted posts,pages,products,groups,members etc...','aheadzen') );		
			$this->WP_Widget('aheadzen_voter','Top Listings Voter Plugin', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_aheadzen_voter_title', $instance['title']);
			$type = empty($instance['type']) ? 'post' : apply_filters('widget_aheadzen_voter_type', $instance['type']);
			$num = empty($instance['num']) ? '5' : apply_filters('widget_aheadzen_voter_num', intval($instance['num']));
			$period = empty($instance['period']) ? '' : apply_filters('widget_aheadzen_voter_period', $instance['period']);
			global $members_template,$table_prefix, $wpdb;
			
			echo $before_widget;
			
			if($title){ echo $before_title.$title.$after_title; }
			$arg = array('type'=>$type,'num'=>$num,'period'=>$period);
			$voterplugin = new VoterPluginClass();
			echo $voterplugin->aheadzen_top_voted_list_all($arg);
			
			echo $after_widget;				
		}
		
		
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $new_instance;		
			return $instance;
		}
		
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'num' => '5', 'type' => 'post') );		
			$title = strip_tags($instance['title']);
			$num = strip_tags($instance['num']);
			$type = ($instance['type']);
			$period = ($instance['period']);
			?>
			<p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Widget Title','aheadzen');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
			</p>  
			<p><label for="<?php  echo $this->get_field_id('num'); ?>"><?php _e('Number of Records','aheadzen');?>: <input class="widefat" id="<?php  echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo esc_attr($num); ?>" /></label>
			<small><?php _e('eg: default is : 5','aheadzen');?></small>
			</p>     
			<p><label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Select Type','aheadzen');?>: 
			</label>
			
			<select class="widefat" id="<?php  echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
			<option value="post"><?php _e(' -- Select One --','aheadzen');?></option>
			<option value="post" <?php if($type=='post'){echo 'selected';}?>><?php _e('Top voted posts','aheadzen');?></option>
			<option value="page" <?php if($type=='page'){echo 'selected';}?>><?php _e('Top voted pages','aheadzen');?></option>
			<?php global $bp;
			if($bp){
			?>
			<option value="topic" <?php if($type=='topic'){echo 'selected';}?>><?php _e('Top voted topic','aheadzen');?></option>
			<?php /*?><option value="activity" <?php if($type=='activity'){echo 'selected';}?>><?php _e('Top voted activity','aheadzen');?></option><?php */?>
			<option value="profile" <?php if($type=='profile'){echo 'selected';}?>><?php _e('Top voted members','aheadzen');?></option>
			<option value="groups" <?php if($type=='groups'){echo 'selected';}?>><?php _e('Top voted groups','aheadzen');?></option>
			<?php }?>
			<?php global $woocommerce;
			if($woocommerce){?>
			<option value="product" <?php if($type=='product'){echo 'selected';}?>><?php _e('Top voted product','aheadzen');?></option>
			<?php }?>
			</select>
			<small><?php _e('eg: default : post.','aheadzen');?></small>
			</p>
			
			<p><label for="<?php echo $this->get_field_id('period'); ?>"><?php _e('Select Period','aheadzen');?>: 
			</label>
			
			<select class="widefat" id="<?php  echo $this->get_field_id('period'); ?>" name="<?php echo $this->get_field_name('period'); ?>">
			<option value=""><?php _e(' -- All time --','aheadzen');?></option>
			<option value="7days" <?php if($period=='7days'){echo 'selected';}?>><?php _e('Last 7 days','aheadzen');?></option>
			<option value="15days" <?php if($period=='15days'){echo 'selected';}?>><?php _e('Last 15 days','aheadzen');?></option>
			<option value="30days" <?php if($period=='30days'){echo 'selected';}?>><?php _e('Last 30 days','aheadzen');?></option>
			<option value="90days" <?php if($period=='90days'){echo 'selected';}?>><?php _e('Last 90 days','aheadzen');?></option>
			<option value="180days" <?php if($period=='180days'){echo 'selected';}?>><?php _e('Last 180 days','aheadzen');?></option>
			<option value="365days" <?php if($period=='365days'){echo 'selected';}?>><?php _e('Last 365 days','aheadzen');?></option>
			</select>
			<small><?php _e('eg: default : post.','aheadzen');?></small>
			</p>
			<?php
		}
	}
}

/*******************************
shotcode :: [voter_plugin_top_voted type=post num=5 period=7days] 
where period from :: 7days,15days,30days,90days,180days,365days
****************************/
function aheadzen_top_voter_plugin_shortcode($atts) {
	$atts['shortcode']=1;
	$type = $atts['type'];
	$num = intval($atts['num']);
	$period = $atts['period'];
	
	if($type==''){$type='post';}
	if(!$num){$num=5;}
	$arg = array('type'=>$type,'num'=>$num,'period'=>$period);
	$voterplugin = new VoterPluginClass();
	$content = $voterplugin->aheadzen_top_voted_list_all($arg);	
	return $content;
}
add_shortcode('voter_plugin_top_voted', 'aheadzen_top_voter_plugin_shortcode');


/*******************************
shotcode :: [voter]
****************************/
function aheadzen_voter_plugin_shortcode($atts) {
	$atts['shortcode']=1;
	
	global $post,$wpdb;		
	$post_type = $post->post_type;
	$component_name = '';
	if($post_type=='page'){
		$component_name = "blog";
	}elseif($post_type=='post'){
		$component_name = "blog";
	}elseif($post_type=='product'){
		$component_name = "woocommerce";
	}elseif($post_type && !in_array($post_type,array('page','post','product'))){
		$component_name = "custompost";
	}
	$item_id = 0;
	$secondary_item_id = $post->ID;		
	$params = array(
		'component' => $component_name,
		'type' => $post_type,
		'item_id' => $item_id,
		'secondary_item_id' => $secondary_item_id
	);
	
	return $voting_links = VoterPluginClass::aheadzen_get_voting_link($params);

}
add_shortcode('voter', 'aheadzen_voter_plugin_shortcode');