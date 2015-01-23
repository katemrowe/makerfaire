jQuery( document ).ready(function() {   

	 jQuery('#gentry_email_notes_to')
     .append($('<option>', { "rich" })
             .text("rich")); 
	 
	 jQuery(function() {
		    var $research = $('.entry-detail-view');
		    $research.find("tr").not('.accordion').hide();
		    $research.find("tr").eq(0).show();
		    
		    $research.find(".accordion").click(function(){
		        $research.find('.accordion').not(this).siblings().fadeOut(500);
		        $(this).siblings().fadeToggle(500);
		    }).eq(0).trigger('click');
		});
	 
});
