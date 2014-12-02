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
			$widget_ops = array('classname' => 'widget aheadzen_voter', 'description' => 'Display top voted posts,pages,products,groups,members etc...' );		
			$this->WP_Widget('aheadzen_voter','Top Listings Voter Plugin', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_aheadzen_voter_title', $instance['title']);
			$type = empty($instance['type']) ? 'post' : apply_filters('widget_aheadzen_voter_type', $instance['type']);
			$num = empty($instance['num']) ? '5' : apply_filters('widget_aheadzen_voter_num', intval($instance['num']));
			global $members_template,$table_prefix, $wpdb;
			
			echo $before_widget;
			
			if($title){ echo $before_title.$title.$after_title; }
			$arg = array('type'=>$type,'num'=>$num);
			echo aheadzen_top_voted_list_all($arg);
			
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
			<?php /*?><option value="comment" <?php if($type=='comment'){echo 'selected';}?>><?php _e('Top voted comment','aheadzen');?></option><?php */?>
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
			<?php
		}
	}
}

/*******************************
shotcode :: [voter_plugin_top_voted type=post num=5]
****************************/
function aheadzen_voter_plugin_shortcode($atts) {
	$atts['shortcode']=1;
	$type = $atts['type'];
	$num = intval($atts['num']);
	if($type==''){$type='post';}
	if(!$num){$num=5;}
	$arg = array('type'=>$type,'num'=>$num);
	$content = aheadzen_top_voted_list_all($arg);	
	return $content;
}
add_shortcode('voter_plugin_top_voted', 'aheadzen_voter_plugin_shortcode');
