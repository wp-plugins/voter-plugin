jQuery('.aheadzen_voter_css').live("click",function(){
		var ajaxurl = site_url;
		var data_object = new Object();
		data_object.user_id = current_user_id;
		
		//ajaxloading
		
		var hashes = this.href.slice(this.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hashes2 = hashes[i].split('=');
			if(hashes2[0]=='component'){data_object.component = hashes2[1];}
			if(hashes2[0]=='type'){data_object.type = hashes2[1];}
			if(hashes2[0]=='action'){data_object.action = hashes2[1];}
			if(hashes2[0]=='item_id'){data_object.item_id = hashes2[1];}
			if(hashes2[0]=='secondary_item_id'){data_object.secondary_item_id = hashes2[1];}
			if(hashes2[0]=='unread_status'){data_object.unread_status = hashes2[1];}
			if(hashes2[0]=='_wpnonce'){data_object._wpnonce = hashes2[1];}
		}
		
		var voter_div_id = '#aheadzen_voting_'+data_object.secondary_item_id+'_'+data_object.item_id+'_'+data_object.component;
		jQuery(voter_div_id+' .vote-count-post').addClass(" ajaxloading ");
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: data_object,
			success: function(data)
			{
				jQuery(voter_div_id).html(data);
				jQuery(voter_div_id+' .vote-count-post').removeClass(" ajaxloading ");
			}
		});
	return false;
})