jQuery( document ).ready(function() {   

	 jQuery(".checkbox_makerfaire_plans input").on("click", function() {
	    var value = jQuery(this).attr("value");
	 	if (value==='Selling at Maker Faire [Commercial Maker]' || value==='Promoting a product or service [Commercial Maker]')
			{
	 			var checked1=jQuery('input[value="Selling at Maker Faire [Commercial Maker]"]').attr("checked");
				var checked2=jQuery('input[value="Promoting a product or service [Commercial Maker]"]').attr("checked");
				var disablesizes = (checked1 === 'checked' || checked2==='checked');
				if (disablesizes){
				jQuery('input[value="10\' x 10\'"]').prop("checked",false);
                                jQuery('input[value="10\' x 20\'"]').prop("checked",false);                                
				jQuery('input[value="Other"]').prop("checked",false);
				
				jQuery('input[value="10\' x 10\'"]').prop("disabled",true);
                                jQuery('input[value="10\' x 20\'"]').prop("disabled",true);
				jQuery('input[value="Other"]').prop("disabled",true);
					} 
				else 
				{
					jQuery('input[value="10\' x 10\'"]').prop("disabled",false);
                                        jQuery('input[value="10\' x 20\'"]').prop("disabled",false);
					jQuery('input[value="Other"]').prop("disabled",false);
				}
				
			}
	 });
	 jQuery(".presentation_type input").on("click", function() {
		    var value = jQuery(this).attr("value");
		 	if (value=='Standard Presentation (1-2 presenters)' || value=='Panel Presentation (up to 5 participants, with moderator)')
				{
		 			var checked1=jQuery('input[value="Standard Presentation (1-2 presenters)"]').attr("checked");
					var disablesizes = (checked1 == 'checked');
					if (disablesizes)
						{
							jQuery('input[value="45 minutes"]').prop("checked",false);
							jQuery('input[value="45 minutes"]').prop("disabled",true);
						} 
					else 
					{
						jQuery('input[value="45 minutes"]').prop("disabled",false);
					}
					
				}
		 });
	jQuery("#input_43_340").change(function() {            
            var state = jQuery(this).val();
            var locationjson=[{"AK":["Anchorage","Fairbanks"],"AL":["Birmingham","Dothan","Hoover","Huntsville/Bridge Street TC","Huntsville/Jones Valley Mall","Spanish Fort","Tuscaloosa"],"AR":["Fayetteville","Jonesboro","Little Rock","N. Little Rock","Rogers"],"AZ":["Chandler","Flagstaff","Gilbert","Goodyear","Mesa","Peoria","Phoenix/Desert Ridge","Phoenix/Happy Valley","Phoenix/Metro","Scottsdale","Surprise","Tempe","Tucson/Eastside","Tucson/Westside","Yuma"],"CA":["Aliso Viejo","Antioch","Bakersfield","Burbank","Calabasas","Chico","Chino Hills","Chula Vista","Citrus Heights","Corona","Corte Madera","Costa Mesa","Dublin","El Cerrito","Emeryville","Encinitas","Escondido","Fairfield","Fresno","Fullerton","Gilroy","Glendale","Glendora","Huntington Beach","Irvine","Irvine/Spectrum","Irvine/Tustin","La Mesa","Long Beach","Long Beach/Carson & 405","Los Angeles","Manhattan Beach","Marina Del Rey","Merced","Modesto","Montclair","Newport Beach","Oceanside","Orange","Palm Desert","Palmdale","Rancho Cucamonga","Redding","Redlands","Redwood City","Riverside","Roseville","Sacramento/Arden Fair","Sacramento/Natomas","San Bruno","San Diego/Costa Verde","San Diego/Loma Theatre","San Diego/Mira Mesa","San Diego/Mission Valley","San Diego/Rancho Bernardo","San Jose/Blossom Hill","San Jose/Eastridge Mall","San Jose/Stevens Creek Blvd","San Luis Obispo","San Mateo","Santa Clarita","Santa Monica","Santa Rosa","Santee","Stockton","Studio City","Temecula","Thousand Oaks","Torrance","Ventura","Victorville","Walnut Creek"],"CO":["Aurora","Aurora/Southlands Town Center","Boulder","Colorado Springs/Briargate","Colorado Springs/Citadel","Denver","Ft. Collins","Glendale","Grand Junction","Lakewood","Littleton","Lone Tree","Loveland","Pueblo","Thornton","Westminster"],"CT":["Canton","Danbury","Enfield","Farmington","Glastonbury","Manchester/Buckland Hills Mall","Milford","North Haven","Stamford","Waterbury","West Hartford","Westport"],"DC":["Washington"],"DE":["Newark","Wilmington"],"FL":["Altamonte Springs","Boca Raton","Boynton Beach","Brandon","Clearwater","Coral Gables","Coral Springs","Daytona Beach","Destin","Estero","Fort Lauderdale","Ft. Myers","Jacksonville/San Jose Blvd","Jacksonville/St. Johns Town Ctr","Jensen Beach","Merritt Island","Miami","Naples","Ocala","Orlando","Orlando/Colonial","Orlando/Florida Mall","Orlando/Plaza Venezia","Oviedo","Palm Beach Gardens","Pembroke Pines","Pembroke Pines","Pensacola","Plantation","S. Miami","Sarasota","St Petersburg","St. Augustine","Tallahassee","Tampa/Carrollwood","Tampa/Dale Mabry","The Villages","Wellington","Wesley Chapel","West Melbourne"],"GA":["Alpharetta","Athens","Atlanta/Buckhead","Atlanta/Cumberland","Atlanta/Edgewood Retail","Atlanta/Perimeter","Augusta/Augusta Mall","Buford","Columbus","Cumming","Macon","Marietta","Marietta","Morrow","Newnan","Norcross","Rome","Savannah","Snellville"],"HI":["Honolulu","Lahaina"],"IA":["Cedar Rapids","Coralville","Davenport","Sioux City","Waterloo","West Des Moines","West Des Moines/Jordan Creek"],"ID":["Boise","Idaho Falls","Twin Falls"],"IL":["Arlington Heights","Bloomingdale","Bloomington","Bolingbrook","Bourbonnais","Carbondale","Champaign","Chicago/Clybourne","Chicago/Old Orchard","Chicago/Schaumburg","Chicago/Skokie","Chicago/State and Elm","Crystal Lake","Deer Park","Deerfield","Evanston","Fairview Heights","Geneva","Joliet","Lincolnshire","Naperville","Oak Brook","Orland Park","Peoria","Rockford","Springfield","Vernon Hills","West Dundee"],"IN":["Bloomington","Carmel","Evansville","Fort Wayne","Fort Wayne/Glenbrook Square Mall","Greenwood","Indianapolis","Lafayette","Mishawaka","Noblesville","Plainfield","Valparaiso"],"KS":["Leawood","Overland Park","Topeka","Wichita"],"KY":["Bowling Green","Elizabethtown","Florence","Lexington","Louisville","Louisville/The Summit","Newport"],"LA":["Baton Rouge","Baton Rouge/Perkins Rowe","Harvey","Lafayette","Mandeville","Metairie","Shreveport"],"MA":["Bellingham","Boston/Prudential Center","Braintree","Burlington","East Walpole","Framingham","Hadley","Hingham","Holyoke","Hyannis","Leominster","Millbury","North Dartmouth","Peabody","Pittsfield","Saugus","Worcester"],"MD":["Annapolis","Baltimore/Pikesville","Baltimore/Power Plant","Baltimore/White Marsh","Bel Air","Bethesda","Bowie","Ellicott City","Frederick","Gaithersburg","Rockville","Salisbury","Towson"],"ME":["Augusta"],"MI":["Allen Park","Ann Arbor","Battle Creek","Flint","Fort Gratiot","Grand Rapids","Grandville","Green Oak Township","Grosse Pointe","Holland","Lansing","Midland","Muskegon","Northville","Portage","Rochester Hills","Saginaw","Shelby Township","Troy","West Bloomfield"],"MN":["Blaine","Bloomington","Burnsville","Duluth","Eagan","Eden Prairie","Edina","Mankato","Maple Grove","Maplewood","Minneapolis/Calhoun","Minneapolis/Downtown","Minnetonka","Rochester","Roseville","St. Cloud","Woodbury"],"MO":["Cape Girardeau","Chesterfield","Columbia","Des Peres","Fenton","Independence","Jefferson City","Kansas City/Country Club Plaza","Kansas City/Zona Rosa","Ladue","Springfield","St Peters"],"MS":["Gulfport","Ridgeland","Tupelo"],"MT":["Billings","Bozeman","Great Falls","Missoula"],"NC":["Asheville/Asheville Mall","Asheville/Town Square","Burlington","Cary","Charlotte/Morrison Place","Charlotte/The Arboretum","Durham/New Hope Commons","Durham/The Streets at Southpoint","Fayetteville","Greensboro","Greenville","Hickory","High Point","Huntersville","Jacksonville","Pineville","Raleigh/Brier Creek Commons","Raleigh/Crabtree Mall","Raleigh/Triangle Town Center","Wilmington","Winston-Salem"],"ND":["Bismarck","Fargo","Minot"],"NE":["Lincoln/O Street","Lincoln/Pine Lake Road","Omaha/Crossroads","Omaha/Oakview Mall"],"NH":["Manchester","Nashua","Newington","Salem"],"NJ":["Brick","Bridgewater","Cherry Hill","Clark","Clifton","Deptford","East Brunswick","Eatontown","Edison","Freehold","Hackensack","Hamilton","Holmdel","Howell","Ledgewood","Livingston","Marlton","Moorestown","Morris Plains","North Brunswick","Paramus","Princeton","Springfield","Woodland Park"],"NM":["Albuquerque/Coroonado Mall","Albuquerque/West Side","Las Cruces"],"NV":["Henderson","Las Vegas/Northwest","Las Vegas/Summerlin","Reno"],"NY":["Albany","Amherst","Bay Shore","Bayside","Bronx","Brooklyn/Court Street","Brooklyn/Park Slope","Buffalo/Clarence","Buffalo/McKinley Mall","Carle Place","Dewitt","East Northport","Elmira","Forest Hills","Ithaca","Kingston","Lake Grove","Liverpool","Manhasset","Massapequa Park","Mohegan Lake","Nanuet","New Hartford","New Hyde Park","Newburgh","NYC/82nd & Broadway","NYC/86th & Lexington Ave.","NYC/Citigroup","NYC/New York/555 Fifth Ave","NYC/Tribeca","NYC/Union Square","Poughkeepsie","Rochester/Greece","Rochester/Pittsford","Saratoga Springs","Staten Island","Vestal","Webster","West Nyack","White Plains","Yonkers"],"OH":["Akron","Beavercreek","Cincinnati","Columbus/Easton","Columbus/Lennox Town","Columbus/Polaris Fashion Center","Columbus/Sawmill","Columbus/Upper Arlington","Dayton","Mansfield","Maumee","Mentor","Pickerington","Toledo","West Chester","Westlake","Woodmere","Youngstown"],"OK":["Norman","Oklahoma City/May Ave.","Oklahoma City/Quail Springs","Tulsa/Southroads","Tulsa/Woodland Plaza"],"OR":["Beaverton","Bend","Eugene","Medford","Portland/Clackamas Town Ctr Mal","Portland/Lloyd Center","Tigard"],"PA":["Altoona","Bensalem","Broomall","Camp Hill","Center Valley","Cranberry Township","Devon","Easton","Erie","Exton","Fairless Hills","Greensburg","Homestead","Lancaster","Monroeville","North Wales","Philadelphia","Pittsburgh/Settlers Ridge","Pittsburgh/South Hills Village","Pittsburgh/Waterworks","Plymouth Meeting","State College","Whitehall","Wilkes-Barre","Willow Grove","Wyomissing"],"RI":["Middletown","Smithfield","Warwick"],"SC":["Charleston/Northwoods","Charleston/Westwood","Columbia","Florence","Greenville","Greenville/The Shops@Greenridge","Hilton Head Island","Mt. Pleasant","Myrtle Beach","Spartanburg"],"SD":["Sioux Falls"],"TN":["Brentwood","Chattanooga","Collierville","Hendersonville","Johnson City","Knoxville","Memphis","Murfreesboro"],"TX":["Amarillo","Arlington/Relo","Austin/Arboretum","Austin/Sunset Valley","Austin/The Homestead","Beaumont","Bee Cave","Cedar Hill","College Station","Corpus Christi","Dallas/North Park","Dallas/Preston & Royal","Dallas/Prestonwood Center","Denton","El Paso/ The Fountains at Farah","El Paso/Sunland Park","Frisco","Ft Worth","Garland","Harker Heights","Highland Village","Houston Champions","Houston/River Oaks Shopping Center","Houston/The Centre in Copperfield","Houston/Town & Country","Houston/Vanderbilt Sq","Houston/West Oaks Village","Houston/Westheimer","Humble","Hurst","Lewisville","Lubbock","McAllen/Northcross","McAllen/Palms Crossing","Midland","Pasadena","Pearland","Plano","Plano","Round Rock","San Antonio 78232","San Antonio 78256","San Antonio/Bandera","San Antonio/Ingram Festival","San Antonio/San Pedro Crossing","Southlake","Sugar Land","The Woodlands","Tyler","Waco","Webster"],"UT":["Layton","Midvale","Murray","Orem","Salt Lake City/Gateway","Salt Lake City/Sugarhouse","Sandy","St. George","West Bountiful","West Jordan"],"VA":["Alexandria","Arlington/Clarendon Market","Charlottesville","Chesapeake","Christiansburg","Fairfax","Falls Church","Fredericksburg","Glen Allen","Hampton","Harrisonburg","Lynchburg","Manassas","McLean","Newport News","Richmond 23230","Richmond 23235","Richmond/Short Pump","Roanoke 24012","Roanoke/Tanglewood","Springfield","Virginia Beach 23462","Virginia Beach/Lynnhaven Mall","Williamsburg"],"VT":["S. Burlington"],"WA":["Bellevue","Bellevue/Crossroads","Bellingham","Federal Way","Issaquah","Kennewick","Lakewood","Lynnwood","Olympia","Seattle/Downtown","Seattle/Northgate","Seattle/W. Seattle","Silverdale","Spokane/Eastside","Spokane/Northtown Mall","Tukwila","Vancouver","Woodinville"],"WI":["Brookfield","Glendale","Grand Chute","Green Bay","Greenfield","La Crosse","Madison","Madison/East Towne Mall","Racine","Wausau","Wauwatosa"],"WV":["Morgantown"],"WY":["Cheyenne"]}];
            for(var i = 0; i < locationjson.length; i++) {                
                var obj = locationjson[i];
                var stateData = obj[state];
                var arrayLength = stateData.length;
                jQuery('#input_43_341').empty();
                jQuery('#input_43_342').empty();
                jQuery('#input_43_343').empty();
                for (var x = 0; x < arrayLength; x++) {
                    //build drop down for field 341, 342 and 343
                    jQuery('#input_43_341').append('<option value="'+stateData[x]+'">'+stateData[x]+'</option>');
                    jQuery('#input_43_342').append('<option value="'+stateData[x]+'">'+stateData[x]+'</option>');
                    jQuery('#input_43_343').append('<option value="'+stateData[x]+'">'+stateData[x]+'</option>');
                }

            }
            
        });   
	 
});
