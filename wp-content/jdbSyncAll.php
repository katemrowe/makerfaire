<?php 
echo (print_r(check_gravityforms()));
ini_set('memory_limit', '16128M');
error_reporting(E_ALL);
ini_set('display_errors', 1);
//require_once( './plugins/gravityforms/gravityforms.php' );
//require_once( './plugins/gravityforms/common.php' );
//require_once(	'./plugins/gravityforms/forms_model.php' );
//require_once( './plugins/gravityforms/includes/api.php' );
//equire_once( './plugins/gravityforms/includes/fields/class-gf-fields.php' );

$mysqli = new mysqli("localhost","root","Cetti201a", "wp_makerfaire_022015");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//if (!$mysqli->query("Select * from wp_rg_lead_posts")) {
//    echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
//}
//$link = mysqli("localhost","root","Cetti201a") or die("Error " . mysql_error($link)); 
//$db_selected = mysql_select_db('wp_makerfaire_production', $link);
//$query = "Select * from wp_rg_lead_posts";

$result = $mysqli->query("Select  id,form_id from wp_rg_lead limit 10");
echo 'result ='.print_r($result);

while($row = $result->fetch_row())
        {
		//$entry = GFAPI::get_entry($row[0]);
       //echo ($entry);print_r($entry);
       print_r($row);
        }
//echo getcwd().'*.{xml}';
$files = glob(getcwd().'/makezineblog/*.{xml}', GLOB_BRACE);
//foreach ($result as $result) {
//	print_r($lead);
//}
/*
$jdb_entry_data = array(
'form_type' => $lead['Exhibit'], //(Form ID)
'noise' => $lead['72'],
'radio' => $lead['78'],
'private_address2' => $lead['(see private_address below: address is one field now)'],
'group_website' => $lead['112'],
'm_maker_bio' => $lead[' (Depends on Contact vs. Maker issue?)'],
'hands_on' => $lead['66'],
'referrals' => $lead['127'],
'private_zip' => $lead['95472'],// (see private_address below: address is one field now)
'food_details' => $lead['144'],
'fire' => $lead['83'],
'booth_size_details' => $lead['61'],
'layout' => $lead['65'],
'amps_details' => $lead['76'],
'booth_size' => $lead['60'],
'group_bio' => $lead['110'],
'hear_about' => $lead['128'],
'maker_faire' => $lead['131'],
'project_website' => $lead['27'],
'supporting_documents' => $lead['122'],
'tables_chairs' => $lead['62'], //(values triggers to resources)
'project_video' => $lead['32'],
'cats' => $lead['147'],// (categories updated)
'booth_location' => $lead['69'], 
'tables_chairs_details' => $lead['288'],
'internet' => $lead['77'],
'performance' => $lead['No'], // (No match)
'maker_photo' => $lead['217'],
'presentation' => $lead['No'], //(No match)
'email' => $lead['monkey@sooch.com'], //(Depends on Contact vs. Maker issue?)
'project_photo' => $lead['22'],
'm_maker_photo' => $lead[''], //'(Depends on Contact vs. Maker issue?)',
'project_name' => $lead['151'],
'first_time' => $lead['130'],
'maker_email' => $lead['161'],
'power' => $lead['73'],
'tags' => $lead['3d-imaging, alternative-energy, art, art-cars, bicycles, biology, chemistry, circuit-bending, computers'],// (No Match)
'food' => $lead['44'],
'm_maker_photo_thumb' => '', 
'safety_details' => $lead['85'],
'anything_else' => $lead['134'],
'phone1_type' => $lead['148'],
'maker_bio' => $lead['234'],
'group_photo' => $lead['111'],
'lighting' => $lead['71'],
'private_country' => $lead['US'], 
'phone1' => $lead['99'],
'project_photo_thumb' => '',
'm_maker_name' => $lead['96'],
'group_name' => $lead['109'],
'private_city' => $lead['Sebastopol'],// (see private_address below: address is one field now)
'group_photo_thumb' => $lead[''],// (No Match)
'large_non_profit' => $lead['I am a large non-profit.'],// (No Match)
'private_state' => $lead['CA'],// (see private_address below: address is one field now)
'placement' => $lead['68'],
'name' => $lead['Kendra Markle'],// (Depends on Contact vs. Maker issue?)
'phone2_type' => $lead['149'],
'maker_name' => $lead['160'],
'radio_frequency' => $lead['79'],
'what_are_you_powering' => $lead['74'],
'maker_photo_thumb' => '', //$lead['http://mf.insourcecode.com/wp-content/uploads/2013/02/IMG_1823_crop1-362x500.jpg (No Match)']
'private_description' => $lead['11'],
'private_address' => $lead['101'],
'org_type' => $lead['45'],
'public_description' => $lead['16'],
'activity' => $lead['84'], 
'amps' => $lead['75'],
'sales_details' => $lead['52'],
'phone2' => $lead['100'],
'maker' => $lead['105'],
'ignore' => $lead[''],
'non_profit_desc' => $lead['47'],
'plans' => $lead['55'], (multiple values)
'launch_details' => $lead['54'],
'crowdfunding' => $lead['56'],
'crowdfunding_details' => $lead['59'],
'special_request' => $lead['64'],
'hands_on_desc' => $lead['67'],		
'activity_wrist' => $lead['293'],
'outdoor_detail' => $lead['70'],// (dump in the comments of the Exposure line in Resources)
'makerfaire_other' => $lead['132'],
'18_years' => $lead['295'],
'CS_ID' => $lead['??']);

print_r($jdb_entry_data);

//$files = glob(getcwd().'/*.{json}', GLOB_BRACE);
//print_r($files);
$count=0;
	$posts = array();
foreach($files as $file) {
	$xml = file_get_contents($file);

	$xml = str_ireplace("wp:", "", $xml);
	$xml = str_ireplace(":encoded", "", $xml);
	$xml = str_ireplace("dc:creator", "creator", $xml);
	//file_put_contents($file.'2', $xml);
	  //do your work here
	//$xml = utf8_encode($xml);

	$xml = simplexml_load_string($xml, null, LIBXML_NOCDATA);

	$json = json_encode($xml);
	$array = json_decode($json,true);
	foreach ($array['channel']['item'] as $project) {
	array_push($posts, $project);
	$count++;
	}
}
echo $count;
//print_r($posts);
$c= 0;
foreach ($posts as $project) {

	//print_r($project);
		
		$resolvedproject  = array();
		//$resolvedproject['_ID'] = $project['post_id'];
		$id = $project['post_id'];
		if($id == '267885'){
		print_r($project);
		$resolvedproject['project_author_id'] = "Maker Media";
		$resolvedproject['project_id'] = $project['post_id'];
		$resolvedproject['title'] = $project['title'];
		$resolvedproject['zinelink'] = $project['link'];
		$resolvedproject['published_at'] = $project['pubDate'];
		$resolvedproject['posted_at'] = $project['post_date_gmt'];
		$resolvedproject['creator'] = $project['creator'];
		$resolvedproject['creatorUrl'] = $project['guid'];
		$resolvedproject['status'] = $project['status']; //post_name
		$resolvedproject['post_name'] = $project['post_name'];
		$resolvedproject['content'] = $project['content'];
		$resolvedproject['excerpt'] = $project['excerpt'];
		$c++;	
		}
	 $query = "INSERT INTO post (post_id, title, link, post_type)
    VALUES ('".mysql_real_escape_string($project['post_id'])."', '".mysql_real_escape_string($project['title'])."', '".mysql_real_escape_string($project['link'])."','".mysql_real_escape_string($project['post_type'])."')
    ON DUPLICATE KEY UPDATE post_type='".mysql_real_escape_string($project['post_type'])."';";
    $result = mysql_query($query);

		// Check result
		// This shows the actual query sent to MySQL, and the error. Useful for debugging.
		if (!$result) {
		    $message  = 'Invalid query: ' . mysql_error() . "\n";
		    $message .= 'Whole query: ' . $query;
		     echo $message;
		}
					
}

*/
function check_gravityforms() {

		// Bypass other checks: if the class exists and the version's right, we're good.
		if( class_exists( 'GFCommon' ) && true === version_compare( GFCommon::$version, GV_MIN_GF_VERSION, ">=" ) ) {
			return true;
		}

		$gf_status = self::get_plugin_status( 'gravityforms/gravityforms.php' );

		if( $gf_status !== true ) {
			if( $gf_status === 'inactive' ) {
				self::$admin_notices['gf_inactive'] = array( 'class' => 'error', 'message' => sprintf( __( '%sGravityView requires Gravity Forms to be active. %sActivate Gravity Forms%s to use the GravityView plugin.', 'gravityview' ), '<h3>', "</h3>\n\n".'<strong><a href="'. wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=gravityforms/gravityforms.php' ), 'activate-plugin_gravityforms/gravityforms.php') . '" class="button button-large">', '</a></strong>' ) );
			} else {
				self::$admin_notices['gf_installed'] = array( 'class' => 'error', 'message' => sprintf( __( '%sGravityView requires Gravity Forms to be installed in order to run properly. %sGet Gravity Forms%s - starting at $39%s%s', 'gravityview' ), '<h3>', "</h3>\n\n".'<a href="http://katz.si/gravityforms" class="button button-secondary button-large button-hero">' , '<em>', '</em>', '</a>') );
			}
			return false;

		} else if( class_exists( 'GFCommon' ) && false === version_compare( GFCommon::$version, GV_MIN_GF_VERSION, ">=" ) ) {

			self::$admin_notices['gf_version'] = array( 'class' => 'error', 'message' => sprintf( __( "%sGravityView requires Gravity Forms Version 1.8 or newer.%s \n\nYou're using Version %s. Please update your Gravity Forms or purchase a license. %sGet Gravity Forms%s - starting at $39%s%s", 'gravityview' ), '<h3>', "</h3>\n\n", '<tt>'.GFCommon::$version.'</tt>', "\n\n".'<a href="http://katz.si/gravityforms" class="button button-secondary button-large button-hero">' , '<em>', '</em>', '</a>') );

			return false;
		}

		return true;
	}
?>