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
		    	
		    	
		});
	 
	 //jQuery('select[name=gentry_email_notes_to]').empty();
	 jQuery('select[name=gentry_email_notes_to]').append(new Option("rich@makermedia.com", "rich@makermedia.com"));
	 jQuery('select[name=gentry_email_notes_to]').append(new Option("admin@makerfaire.com", "admin@makerfaire.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Brian Jepson", "bjepson@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Bridgette Vanderlaan", "bvanderlaan@mac.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Editorial Make", "onlineeditors@makezine.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Jason Babler", "jbabler@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Jay Kravitz", "jay@thecrucible.org"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Jonathan Maginn", "jonathan.maginn@sbcglobal.net"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Kate Rowe", "krowe@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Kerry Moore", "kerry@contextfurniture.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Louise Glasgow", "lglasgow@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Maker Relations", "makers@makerfaire.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Marketing Make", "marketing@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Michelle Hlubinka", "mhlubinka@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Miranda Mota", "miranda@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Nick Normal", "nicknormal@gmail.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("PR MakerFaire", "pr@makerfaire.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Sabrina Merlo", "smerlo@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Shed Make", "makershed@makerfaire.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Sherry Huss", "sherry@makermedia.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Sponsor Sales", "sales@makerfaire.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Tami Jo Benson", "tj@tamijo.com"));
  jQuery('select[name=gentry_email_notes_to]').append(new Option("Dale Dougherty", "dale@makermedia.com"));
  
});
