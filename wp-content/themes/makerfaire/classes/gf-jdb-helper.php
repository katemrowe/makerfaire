<?php
if ( ! class_exists( 'GFJDBHELPER' ) ) {
	die();
}

class GFJDBHELPER {
	/*
	 * Function to send notes directly to JDB.
	*/
	public static function gravityforms_send_note_to_jdb( $id = 0, $noteid=0, $note = '' , $note_username='', $note_datecreated='') {
		$local_server = array( 'localhost', 'make.com', 'makerfaire.local', 'staging.makerfaire.com' );
		$remote_post_url = 'http://db.makerfaire.com/addExhibitNote';
		if ( isset( $_SERVER['HTTP_HOST'] ) && in_array( $_SERVER['HTTP_HOST'], $local_server ) )
			$remote_post_url= 'http://makerfaire.local/wp-content/allpostdata.php';
		$encoded_array = http_build_query(  array( 'CS_ID' => intval( $id ), 'note_id' => intval( $noteid ), 'note' => esc_attr( $note ), 'user' => esc_attr($note_username), 'datecreated' => esc_attr($note_datecreated)));
	
		$post_body = array(
				'method' => 'POST',
				'timeout' => 45,
				'headers' => array(),
				'body' => $encoded_array);
	
		$res  = wp_remote_post( $remote_post_url, $post_body  );
		$er  = 0;
	
		if ( 200 == $res['response']['code'] ) {
			$body = json_decode( $res['body'] );
			if ( 'ERROR' != $body->status ) {
				$er = time();
			}
			gform_update_meta( $id, 'mf_jdb_note_sync', $body );
	
		}
		return $er;
	}
	
	public static function gravityforms_send_entry_to_jdb ($id)
	{
		$mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		error_log('gravityforms_send_entry_to_jdb');
		$entry_id=$id;
		$entry = GFAPI::get_entry($entry_id);
		$form = GFAPI::get_form($entry['form_id']);
		//$jdb_encoded_entry = gravityforms_to_jdb_record($entry,$row[0],$row[1]);
		$jdb_encoded_entry = http_build_query(self::gravityforms_to_jdb_record($entry,$entry_id,$form));
		$synccontents = '"'.$mysqli->real_escape_string($jdb_encoded_entry).'"';
		$results_on_send = self::gravityforms_send_record_to_jdb($entry_id,$jdb_encoded_entry);
		$results_on_send_prepared = '"'.$mysqli->real_escape_string($results_on_send).'"';

		// MySqli Insert Query
		$insert_row = $mysqli->query("INSERT INTO `wp_rg_lead_jdb_sync`(`lead_id`, `synccontents`, `jdb_response`) VALUES ($entry_id,$synccontents, $results_on_send_prepared)");
		if($insert_row){
			error_log( 'Success! Response from JDB  was: ' .$results_on_send .'<br />');
		}else{
			die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		};

	}
	
	public static function gravityforms_send_record_to_jdb($entry_id, $jdb_encoded_record) {
		$local_server = array (
				'localhost',
				'make.com',
				'makerfaire.local',
				'staging.makerfaire.com'
		);
		$remote_post_url = 'http://db.makerfaire.com/updateExhibitInfo';
		if (isset ( $_SERVER ['HTTP_HOST'] ) && in_array ( $_SERVER ['HTTP_HOST'], $local_server ))
			$remote_post_url = 'http://makerfaire.local/wp-content/allpostdata.php';
	
		$post_body = array (
				'method' => 'POST',
				'timeout' => 45,
				'headers' => array (),
				'body' => $jdb_encoded_record
		);
	
		$res = wp_remote_post ( $remote_post_url, $post_body );
		if (200 == wp_remote_retrieve_response_code ( $res )) {
			$body = json_decode ( $res ['body'] );
			if ($body->exhibit_id == '' || $body->exhibit_id == 0) {
				gform_update_meta ( $entry_id, 'mf_jdb_sync', 'fail' );
			} else {
				gform_update_meta ( $entry_id, 'mf_jdb_sync', time () );
			}
		}
		else 	gform_update_meta ( $entry_id, 'mf_jdb_sync', 'fail' );
			
		return ($res ['body']);
	}
	/*
	 * Function for formatting gravity forms lead into usable jdb data
	*/
	public static function gravityforms_to_jdb_record($lead,$lead_id,$form)
	{
		//load form
		$form_id = $form['id'];
		// Load Names
		$allmakername='';
		$makerfirstname1=$lead['160.3'];$makerlastname1=$lead['160.6'];
		$makerfirstname2=$lead['158.3'];$makerlastname2=$lead['158.6'];
		$makerfirstname3=$lead['155.3'];$makerlastname3=$lead['155.6'];
		$makerfirstname4=$lead['156.3'];$makerlastname4=$lead['156.6'];
		$makerfirstname5=$lead['157.3'];$makerlastname5=$lead['157.6'];
		$makerfirstname6=$lead['159.3'];$makerlastname6=$lead['159.6'];
		$makerfirstname7=$lead['154.3'];$makerlastname7=$lead['154.6'];
		$allmakername = $allmakername + !empty($makerfirstname1) ?  $makerfirstname1.' '.$makerlastname1 : '' ;
		$allmakername = $allmakername + !empty($makerfirstname2) ?  ', '.$makerfirstname2.' '.$makerlastname2 : '' ;
		$allmakername = $allmakername + !empty($makerfirstname3) ?  ', '.$makerfirstname3.' '.$makerlastname3 : '' ;
		$allmakername = $allmakername + !empty($makerfirstname4) ?  ', '.$makerfirstname4.' '.$makerlastname4 : '' ;
		$allmakername = $allmakername + !empty($makerfirstname5) ?  ', '.$makerfirstname5.' '.$makerlastname5 : '' ;
		$allmakername = $allmakername + !empty($makerfirstname6) ?  ', '.$makerfirstname6.' '.$makerlastname6 : '' ;
		$allmakername = $allmakername + !empty($makerfirstname7) ?  ', '.$makerfirstname7.' '.$makerlastname7 : '' ;
		// Load Categories
		$fieldtopics=RGFormsModel::get_field($form,'147');
		$topicsarray = array();
		foreach($fieldtopics['inputs'] as $topic)
		{
			if (strlen($lead[$topic['id']]) > 0)  $topicsarray[] = $lead[$topic['id']];
		}
		// Load Plans
		$fieldplans=RGFormsModel::get_field($form,'55');
		$plansarray = array();
		foreach($fieldplans['inputs'] as $plan)
		{
			if (strlen($lead[$plan['id']]) > 0)  $plansarray[] = $lead[$plan['id']];
		}
		// Load Loctations

		$fieldlocations=RGFormsModel::get_field($form,'70');
		$locationsarray = array();
		foreach($fieldlocations['inputs'] as $location)
		{
			if (strlen($lead[$location['id']]) > 0)  $locationsarray[] = $lead[$location['id']];
		}
		// Load RF

		$rfinputs=RGFormsModel::get_field($form,'79');
		$rfarray = array();
		foreach($rfinputs['inputs'] as $rfinput)
		{
			if (strlen($lead[$rfinput['id']]) > 0)  $rfarray[] = $lead[$rfinput['id']];
		}
		// Load statuses
		//$entrystatuses=RGFormsModel::get_field($form,'303');
		//$currentstatus = "";
		//foreach($entrystatuses['inputs'] as $entrystatus)
		//{
			//	if (strlen($lead[$entrystatus['id']]) > 0)  $currentstatus = $lead[$entrystatus['id']];
			//}

		$jdb_entry_data = array(
				'form_type' => self::gravityforms_form_type_jdb($form_id), //(Form ID)
				'noise' => isset($lead['72']) ? $lead['72'] : '',
				'radio' => isset($lead['78']) ? $lead['78'] : '',
				'hands_on' => isset($lead['66']) ? $lead['66'] : '',
				'referrals' => isset($lead['127']) ? $lead['127']  : '',
				'food_details' => isset($lead['144']) ? $lead['144']  : '',
				'fire' =>  isset($lead['83']) ? $lead['83']  : '',
				'booth_size_details' => isset($lead['61']) ? $lead['61']  : '',
				'layout' => isset($lead['65']) ? $lead['65']  : '',
				'amps_details' =>  isset($lead['76']) ? $lead['76']  : '',
				'booth_size' => isset($lead['60']) ? $lead['60']  : '',
				'group_bio' => isset($lead['110']) ? $lead['110']  : '',
				'group_website' => isset($lead['112']) ? $lead['112']  : '',
				'hear_about' => isset($lead['128']) ? $lead['128']  : '',
				'maker_faire' => isset($lead['131']) ? $lead['131']  : '',
				'project_website' => isset($lead['27']) ? $lead['27']  : '',
				'supporting_documents' => isset($lead['122']) ? $lead['122']  : '',
				'tables_chairs' => isset($lead['62']) ? $lead['62']  : '',
				'project_video' => isset($lead['32']) ? $lead['32']  : '',
				'cats' => isset($topicsarray) ? $topicsarray  : '',
				'loctype' => isset($lead['69']) ? $lead['69']  : '',
				'tables_chairs_details' => isset($lead['288']) ? $lead['288']  : '',
				'internet' => isset($lead['77']) ? $lead['77']  : '',
				'maker_photo' => isset($lead['217']) ? $lead['217']  : '',
				'email' => isset($lead['98']) ? $lead['98']  : '',
				'project_photo' => isset($lead['22']) ? $lead['22']  : '',
				'project_name' => isset($lead['151']) ? $lead['151']  : '',
				'first_time' => isset($lead['130']) ? $lead['130']  : '',
				'power' => isset($lead['73']) ? $lead['73']  : '',
				'food' => isset($lead['44']) ? $lead['44']  : '',
				'safety_details' => isset($lead['85']) ? $lead['85']  : '',
				'anything_else' => isset($lead['134']) ? $lead['134']  : '',
				'phone1_type' => isset($lead['148']) ? $lead['148']  : '',
				'maker_bio' => isset($lead['234']) ? $lead['234']  : '',
				'group_photo' => isset($lead['111']) ? $lead['111']  : '',
				'lighting' => isset($lead['71']) ? $lead['71']  : '',
				'phone1' => isset($lead['99']) ? $lead['99']  : '',
				'project_photo_thumb' => '',
				'group_name' => isset($lead['109']) ? $lead['109']  : '',
				'private_address' => isset($lead['101.1']) ? $lead['101.1']  : '',
				'private_state' => isset($lead['101.4']) ? $lead['101.4']  : '',
				'private_city' => isset($lead['101.3']) ? $lead['101.3']  : '',
				'private_address2' => isset($lead['101.2']) ? $lead['101.2']  : '',
				'private_country' => isset($lead['101.6']) ? $lead['101.6']  : '',
				'private_zip' => isset($lead['101.5']) ? $lead['101.5']  : '',
				'placement' => isset($lead['68']) ? $lead['68']  : '',
				'firstname' => isset($lead['96.3']) ? $lead['96.3']  : '',
				'lastname' => isset($lead['96.6']) ? $lead['96.6']  : '',
				'phone2_type' => isset($lead['149']) ? $lead['149']  : '',
				'maker_name' => isset($allmakername) ? $allmakername  : '',
				'radio_frequency' => $rfarray,
				'what_are_you_powering' => isset($lead['74']) ? $lead['74']  : '',
				'private_description' => isset($lead['11']) ? $lead['11']  : '',
				'org_type' => isset($lead['45']) ? $lead['45']  : '',
				'public_description' => isset($lead['16']) ? $lead['16']  : '',
				'activity' => isset($lead['84']) ? $lead['84']  : '',
				'amps' => isset($lead['75']) ? $lead['75']  : '',
				'sales_details' => isset($lead['52']) ? $lead['52']  : '',
				'phone2' => isset($lead['100']) ? $lead['100']  : '',
				'maker' => isset($lead['105']) ? $lead['105']  : '',
				'non_profit_desc' => isset($lead['47']) ? $lead['47']  : '',
				'plans' => isset($plansarray) ? $plansarray  : '',
				'launch_details' => isset($lead['54']) ? $lead['54']  : '',
				'crowdfunding' => isset($lead['56']) ? $lead['56']  : '',
				'crowdfunding_details' => isset($lead['59']) ? $lead['59']  : '',
				'special_request' => isset($lead['64']) ? $lead['64']  : '',
				'hands_on_desc' => isset($lead['67']) ? $lead['67']  : '',
				'activity_wrist' => isset($lead['293']) ? $lead['293']  : '',
				'loctype_outdoors' => $locationsarray,
				'makerfaire_other' => isset($lead['132']) ? $lead['132']  : '',
				'under_18' => (isset($lead['295']) && $lead['295'] == "Yes") ? 'NO'  : 'YES',
				'CS_ID' => $lead_id,
				'status' => isset($lead['303']) ? $lead['303']  : '',
				'waste' => (isset($lead['317']) && $lead['317'] == "Yes") ? 'NO'  : 'YES',
				'waste_detail' => isset($lead['318']) ? $lead['318']  : '',
				'learn_to' => isset($lead['319']) ? $lead['319']  : '',
				//'m_maker_name' => isset($lead['96']) ? $lead['96']  : '',
				//'maker_email' => isset($lead['161']) ? $lead['161']  : '',
				//'presentation' => isset($lead['No']) ? $lead['999']  : '', //(No match)
				//'performance' => isset($lead['No']) ? $lead['999']  : '', // (No match)
				//'maker_photo_thumb' => '', //$lead['http://mf.insourcecode.com/wp-content/uploads/2013/02/IMG_1823_crop1-362x500.jpg (No Match)']
				//'ignore' => isset($lead['']) ? $lead['999']  : '',
				//'tags' => isset($lead['3d-imaging, alternative-energy, art, art-cars, bicycles, biology, chemistry, circuit-bending, computers']) ? $lead['999']  : '',// (No Match)
				//'group_photo_thumb' => isset($lead['']) ? $lead['999']  : '',// (No Match)
				//'large_non_profit' => isset($lead['I am a large non-profit.']) ? $lead['999']  : '',// (No Match)
				//'m_maker_bio' => $lead[' (Depends on Contact vs. Maker issue?)'],
		);

		return $jdb_entry_data;


	}

	/*
	 * Function to do the actual sending to jdb
	*/
	public static function gravityforms_post_submission_entry_to_jdb( $entry_id,$jdb_encoded_record ) {
		// Don't sync from any of our testing locations.
		$local_server = array( 'localhost', 'make.com', 'makerfaire.local', 'staging.makerfaire.com' );
		//$remote_post_url = 'http://db.makerfaire.com/updateExhibitInfo';
		$remote_post_url='';
		if ( isset( $_SERVER['HTTP_HOST'] ) && in_array( $_SERVER['HTTP_HOST'], $local_server ) )
			$remote_post_url= 'http://makerfaire.local/wp-content/allpostdata.php';

		$post_body = array(
				'method' => 'POST',
				'timeout' => 45,
				'headers' => array(),
				'body' => $jdb_encoded_record);

		$res  = wp_remote_post( $remote_post_url, $post_body  );
		if ( 200 == wp_remote_retrieve_response_code( $res ) ) {
			$body = json_decode( $res['body'] );
			if ( $body->exhibit_id == '' && $body->exhibit_id == 0 ) {
				gform_update_meta( $entry_id, 'mf_jdb_sync', 'fail' );
			} else {
				gform_update_meta( $entry_id, 'mf_jdb_sync', time() );
			}
		}
		return ($res['body']);
	}
	public static function gravityforms_sync_all_entry_notes($entry_id) {
		$mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
	
		$result = $mysqli->query ( 'SELECT value,id,user_name,date_created FROM wp_rg_lead_notes where lead_id=' . $entry_id . '' );
	
		while ( $row = $result->fetch_row () ) {
			$results_on_send = self::gravityforms_send_note_to_jdb ( $entry_id, $row[1], $row [0], $row [2], $row[3] );
		}
	}
	
	
	/*
	 * Sync MakerFaire Application Statuses
	*
	* @access private
	* @param int $id Post id to SYNC
	* @param string $app_status Post status
	* =====================================================================*/
	public static function gravityforms_sync_status_jdb( $id = 0, $status = '' ) {
		$local_server = array( 'localhost', 'make.com', 'makerfaire.local', 'staging.makerfaire.com' );
		$remote_post_url = 'http://db.makerfaire.com/updateExhibitStatus';
		if ( isset( $_SERVER['HTTP_HOST'] ) && in_array( $_SERVER['HTTP_HOST'], $local_server ) )
			$remote_post_url= 'http://makerfaire.local/wp-content/allpostdata.php';
		$encoded_array = http_build_query(  array( 'CS_ID' => intval( $id ), 'status' => esc_attr( $status )));
	
		$post_body = array(
				'method' => 'POST',
				'timeout' => 45,
				'headers' => array(),
				'body' => $encoded_array);
	
		$res  = wp_remote_post( $remote_post_url, $post_body  );
		$er  = 0;
	
		if ( 200 == $res['response']['code'] ) {
			$body = json_decode( $res['body'] );
			if ( 'ERROR' != $body->status ) {
				$er = time();
			}
		}
		self::gravityforms_sync_all_entry_notes($id);
		gform_update_meta( $id, 'mf_jdb_status_sync', $er );
	
		return $er;
	}
	
	public static function gravityforms_form_type_jdb($formid = 0)
	{
		$return_formtype = 'Other';
		
		switch ($formid) {
			case 0:
				$return_formtype = 'Exhibit';
				break;
			case 0:
				$return_formtype = 'Presentation';
				break;
			case 0:
				$return_formtype = 'Performance';
				break;
			case 0:
				$return_formtype = 'Sponsor';
				break;
			case 0:
				$return_formtype = 'Show Management';
				break;
			default:
				$return_formtype = 'Other';
				break;
		}
		
	}
	
}
