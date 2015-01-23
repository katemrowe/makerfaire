jQuery( document ).ready(function() {   
	 var $tableheader = jQuery('th#header');
	 var $tableheadentry = jQuery('th#details');
	 $tableheadentry.parents('table.entry-detail-view') .children('tbody') .hide();
	 jQuery(function() {
		     
		    jQuery($tableheadentry).click(
		    		function() {
		    			jQuery(this) .parents('table.entry-detail-view') .children('tbody') .toggle();
		    		}
		    	)
		    jQuery($tableheader).click(
		    		function() {
		    			jQuery(this) .parents('table.entry-detail-view') .children('tbody') .toggle();
		    		}
		    	)
		    	
		    	
		});
	 
	 jQuery('select[name=gentry_email_notes_to]').empty();
	 jQuery('select[name=gentry_email_notes_to]').append(new Option("admin@makerfaire.com", "admin@makerfaire.com"));
	
	 
});
