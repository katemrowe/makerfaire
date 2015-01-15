jQuery( document ).ready(function() {   

	 jQuery(".checkbox_makerfaire_plans input").on("click", function() {
	    var value = jQuery(this).attr("value");
	 	if (value=='Selling at Maker Faire [Commercial Maker]' || value=='Promoting a product or service [Commercial Maker]')
			{
	 			var checked1=jQuery('input[value="Selling at Maker Faire [Commercial Maker]"]').attr("checked");
				var checked2=jQuery('input[value="Promoting a product or service [Commercial Maker]"]').attr("checked");
				var disablesizes = (checked1 == 'checked' || checked2=='checked');
				if (disablesizes)
					{
				jQuery('input[value="10\' x 20\'"]').prop("checked",false)
				jQuery('input[value="Other"]').prop("checked",false);
				
				jQuery('input[value="10\' x 20\'"]').prop("disabled",true);
				jQuery('input[value="Other"]').prop("disabled",true);
					} 
				else 
				{
					jQuery('input[value="10\' x 20\'"]').prop("disabled",false);
					jQuery('input[value="Other"]').prop("disabled",false);
				}
				
			}
	 });
	 jQuery(".presentation_type input").on("click", function() {
		    var value = jQuery(this).attr("value");
		 	if (value=='Standard Presentation (1-2 presenters)')
				{
		 			var checked1=jQuery('input[value="Standard Presentation (1-2 presenters)"]').attr("checked");
					var disablesizes = (checked1 == 'checked');
					if (disablesizes)
						{
							jQuery('input[value="45 minutes"]').prop("checked",false)
							jQuery('input[value="45 minutes"]').prop("disabled",true);
						} 
					else 
					{
						jQuery('input[value="45 minutes"]').prop("disabled",false);
					}
					
				}
		 });
});
