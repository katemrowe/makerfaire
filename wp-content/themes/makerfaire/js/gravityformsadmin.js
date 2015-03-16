jQuery( document ).ready(function() {   
	 var $tableheader = jQuery('th#header');
	 var $tableheadentry = jQuery('th#details');
	 //$tableheadentry.parents('table.entry-detail-view') .children('tbody') .hide();
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
		    	
		    	
	
	 jQuery('#datetimepicker').datetimepicker();
	 jQuery('#gf_admin_page_title').click(
			 function() {
				 window.location="/wp-admin/admin.php?page=gf_entries&view=entry&id=20&lid="+prompt('Enter your ID!', ' ');
				 }
			 )
		});
});
