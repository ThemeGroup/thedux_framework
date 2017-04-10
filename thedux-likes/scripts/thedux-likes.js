jQuery(document).ready(function($){

	$('.thedux-likes').live('click',
	    function() {
    		var link = $(this);
    		if(link.hasClass('active')) return false;
		
    		var id = $(this).attr('id'),
    			postfix = link.find('.thedux-likes-postfix').text();
			
    		$.post(thedux_likes.ajaxurl, { action:'thedux-likes', likes_id:id, postfix:postfix }, function(data){
    			link.html(data).addClass('active').attr('title','You already like this');
    		});
		
    		return false;
	});
	
	if( $('body.ajax-thedux-likes').length ) {
        $('.thedux-likes').each(function(){
    		var id = $(this).attr('id');
    		$(this).load(thedux.ajaxurl, { action:'thedux-likes', post_id:id });
    	});
	}

});