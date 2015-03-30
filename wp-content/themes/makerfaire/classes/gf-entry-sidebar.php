<?php

function mf_sidebar_entry_schedule($form_id, $lead) {
	// Load Fields to show on entry info
	
	echo ('
			
			<link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>
			<h4><label class="detail-label">Schedule:</label></h4>
			<input type="text" value="2014/03/15 05:06" id="datetimepickerstart">
			<input type="text" value="2014/03/15 05:06" id="datetimepickerend">
		
			');

	// Create Update button for sidebar entry management
	$entry_sidebar_button = '<input type="submit" name="update_schedule" value="Update Schedule" class="button"
			 style="width:auto;padding-bottom:2px;"
			onclick="jQuery(\'#action\').val(\'update_entry_schedule\');"/>';
			echo $entry_sidebar_button;	

}
/* This is where we run code on the entry info screen.  Logic for action handling goes here */
function mf_sidebar_entry_info($form_id, $lead) {
	// Load Fields to show on entry info
	$form = GFAPI::get_form($form_id);
	
	$field302=RGFormsModel::get_field($form,'302');
	$field303=RGFormsModel::get_field($form,'303');
	$field304=RGFormsModel::get_field($form,'304');
	$field307=RGFormsModel::get_field($form,'307');
	
	
	
	echo ('<h4><label class="detail-label">Flags:</label></h4>');
	foreach(   $field304['inputs'] as $choice)
	{
		$selected = '';
		if (stripslashes($lead[$choice['id']]) == stripslashes($choice['label'])) $selected=' checked ';
		echo('<input type="checkbox" '.$selected.' name="entry_info_flags_change[]" style="margin: 3px;" value="'.$choice['id'].'_'.$choice['label'].'" />'.$choice['label'].' <br />');
	}
	
	
	echo ('<h4><label class="detail-label">Location:</label></h4>');
	foreach(   $field302['inputs'] as $choice)
	{
		$selected = '';
		if (stripslashes($lead[$choice['id']]) == stripslashes($choice['label'])) $selected=' checked ';
		echo('<input type="checkbox" '.$selected.' name="entry_info_location_change[]" style="margin: 3px;" value="'.$choice['id'].'_'.$choice['label'].'" />'.$choice['label'].' <br />');
	}
	
	
	echo ('<textarea name="entry_location_comment" id="entry_location_comment"
					style="width: 100%; height: 50px; margin-bottom: 4px;" cols=""
					rows="">'.$lead['307'].'</textarea>');
	

}

function mf_sidebar_entry_status($form_id, $lead) {
	// Load Fields to show on entry info
	$form = GFAPI::get_form($form_id);

	$field303=RGFormsModel::get_field($form,'303');
	
	echo ('<input type="hidden" name="entry_info_entry_id" value="'.$lead['id'].'">');
	echo ('<label class="detail-label" for="entry_info_status_change">Status:</label>');
	echo ('<select name="entry_info_status_change">');
	foreach( $field303['choices'] as $choice )
	{
		$selected = '';

		if ($lead[$field303['id']] == $choice['text']) $selected=' selected ';

		echo('<option '.$selected.' value="'.$choice['text'].'">'.$choice['text'].'</option>');
	}
	echo('</select><input type="submit" name="update_management" value="Save" class="button"
	 style="width:auto;padding-bottom:2px;"
	onclick="jQuery(\'#action\').val(\'update_entry_status\');"/><br />');


}

function mf_sidebar_forms($form_id, $lead) {
	// Load Fields to show on entry info
	$forms = GFAPI::get_forms(true,false);
	echo ('<h4><label class="detail-label" for="entry_form_change">Form:</label></h4>');
	echo ('<select style="width:250px" name="entry_form_change">');
	foreach( $forms as $choice )
	{
		$selected = '';

		if ($choice['id'] == $lead['form_id']) $selected=' selected ';

		echo('<option '.$selected.' value="'.$choice['id'].'">'.$choice['title'].'</option>');
	}
	echo('</select><input type="submit" name="change_form_id" value="Change Form" class="button"
	 style="width:auto;padding-bottom:2px;"
	onclick="jQuery(\'#action\').val(\'change_form_id\');"/><br />');


}



/* Side bar Layout */
add_action("gform_entry_detail_sidebar_before", "add_sidebar_text_before", 10,2);
function add_sidebar_text_before($form, $lead){
	$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
	$street = $lead['101.1'];
	$street2 = (!empty($lead["101.2"])) ? $lead["101.2"].'<br />' : '' ;
	$city = $lead["101.3"];
	$state = $lead["101.4"];
	$zip = $lead["101.5"];
	$country = $lead["101.6"];
	$email = $lead["98"];
	$phone = $lead["99"];
	$phonetype = $lead["148"];
	?>
	
<div id="infoboxdiv" class="postbox">
	<div id="minor-publishing" style="padding: 10px;">
			<?php mf_sidebar_entry_status( $form['id'], $lead ); ?><br/>
			Contact:<div style="padding:5px"><?php echo $lead['96.3'];  ?> <?php echo $lead['96.6'];  ?><br />
				<?php echo $street; ?><br />
				<?php echo $street2; ?>
				<?php echo $city; ?>, <?php echo $state; ?>  <?php echo $zip; ?><br />
				<?php echo $country; ?><br />
				<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a><br />
				<?php echo $phonetype; ?>:  <?php echo $phone; ?><br />
				
				</div>
			<?php _e( 'Filled out: ', 'gravityforms' ); ?>:<?php echo esc_html( GFCommon::format_date( $lead['date_created'], false, 'Y/m/d' ) ) ?><br />
			</div>
			<div id="delete-action" style="float:none;padding: 10px;">
				<?php
							switch ( $lead['status'] ) {
								case 'spam' :
									if ( GFCommon::spam_enabled( $form['id'] ) ) {
										?>
				<a
					onclick="jQuery('#action').val('unspam'); jQuery('#entry_form').submit()"
					href="#"><?php _e( 'Not Spam', 'gravityforms' ) ?></a>
				<?php
										echo GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ? '|' : '';
									}
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
				<a class="submitdelete deletion"
					onclick="if ( confirm('<?php _e( ';You are about to delete this entry. \'Cancel\' to stop, \'OK\' to delete.', 'gravityforms' ) ?>') ) {jQuery('#action').val('delete'); jQuery('#entry_form').submit(); return true;} return false;"
					href="#"><?php _e( 'Delete Permanently', 'gravityforms' ) ?></a>
				<?php
									}

									break;

								case 'trash' :
									?>
				<a
					onclick="jQuery('#action').val('restore'); jQuery('#entry_form').submit()"
					href="#"><?php _e( 'Restore', 'gravityforms' ) ?></a>
				<?php
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
				| <a class="submitdelete deletion"
					onclick="if ( confirm('<?php _e('You are about to delete this entry. \'Cancel\' to stop, \'OK\' to delete.', 'gravityforms' ) ?>') ) {jQuery('#action').val('delete'); jQuery('#entry_form').submit(); return true;} return false;"
					href="#"><?php _e( 'Delete Permanently', 'gravityforms' ) ?></a>
				<?php
									}

									break;

								default :
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
				<a class="submitdelete deletion"
					onclick="jQuery('#action').val('trash'); jQuery('#entry_form').submit()"
					href="#"><?php _e( 'Move to Trash', 'gravityforms' ) ?></a>
				<?php
										echo GFCommon::spam_enabled( $form['id'] ) ? '|' : '';
									}
									if ( GFCommon::spam_enabled( $form['id'] ) ) {
										?>
				<a class="submitdelete deletion"
					onclick="jQuery('#action').val('spam'); jQuery('#entry_form').submit()"
					href="#"><?php _e( 'Mark as Spam', 'gravityforms' ) ?></a>
				<?php
									}
							}
							if ( GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) && $lead['status'] != 'trash' ) {
								$button_text      = $mode == 'view' ? __( 'Edit', 'gravityforms' ) : __( 'Update', 'gravityforms' );
								$disabled         = $mode == 'view' ? '' : ' disabled="disabled" ';
								$update_button_id = $mode == 'view' ? 'gform_edit_button' : 'gform_update_button';
								$button_click     = $mode == 'view' ? "jQuery('#screen_mode').val('edit');" : "jQuery('#action').val('update'); jQuery('#screen_mode').val('view');";
								$update_button    = '<input id="' . $update_button_id . '" ' . $disabled . ' class="button button-large button-primary" type="submit" tabindex="4" value="' . $button_text . '" name="save" onclick="' . $button_click . '"/>';
								echo apply_filters( 'gform_entrydetail_update_button', $update_button );
								if ( $mode == 'edit' ) {
									echo '&nbsp;&nbsp;<input class="button button-large" type="submit" tabindex="5" value="' . __( 'Cancel', 'gravityforms' ) . '" name="cancel" onclick="jQuery(\'#screen_mode\').val(\'view\');"/>';
								}
							}
							?>
	</div>
</div>
		

<?php /* Notes Sidebar Area */?>
<div class="postbox" style="float:none;padding: 10px;">
	<h3>
		<label for="name"><?php _e( 'Notes', 'gravityforms' ); ?></label>
	</h3>

		<?php wp_nonce_field( 'gforms_update_note', 'gforms_update_note' ) ?>
		<div class="inside">
			<?php
								$notes = RGFormsModel::get_lead_notes( $lead['id'] );

								//getting email values
								$email_fields = GFCommon::get_email_fields( $form );
								$emails = array();

								foreach ( $email_fields as $email_field ) {
									if ( ! empty( $lead[ $email_field->id ] ) ) {
										$emails[] = $lead[ $email_field->id ];
									}
								}
								//displaying notes grid
								$subject = '';
								notes_sidebar_grid( $notes, true, $emails, $subject );
								?>
		</div>
</div>

<?php 
/* Entry Management Sidebar Area */
if ($mode == 'view') {
	?>
	<div class='postbox' style="float:none;padding: 10px;">
	<?php
	// Load Entry Sidebar details
	mf_sidebar_entry_info( $form['id'], $lead );
	?>
	<?php // Create Update button for sidebar entry management
	$entry_sidebar_button = '<input type="submit" name="update_management" value="Update Management" class="button"
		 style="width:auto;padding-bottom:2px;" 
		onclick="jQuery(\'#action\').val(\'update_entry_management\');"/>';
	echo $entry_sidebar_button;	?>
	</div>
	<?php 
	}
	/* Shceduling Management Sidebar Area */
	if ($mode == 'view') :
		?>
		<div class='postbox' style="float:none;padding: 10px;">
		<?php
		// Load Entry Sidebar details
		mf_sidebar_entry_schedule( $form['id'], $lead );
		?>
			</div>
		<div class='postbox' style="float:none;padding: 10px;">
	<?php
	mf_sidebar_forms($form['id'], $lead );
	?>
	</div>
	<?php endif;?>
		
	<div class="detail-view-print">
				<?php $entry_sidebar_button = '<input type="submit" name="sync_jdb" value="Send to JDB" class="button"
				 style="width:auto;padding-bottom:2px;"
				onclick="jQuery(\'#action\').val(\'sync_jdb\');"/>';
					echo $entry_sidebar_button;	?>
					</div>
					<div class="detail-view-print">
				<?php $entry_sidebar_button = '<input type="submit" name="sync_status_jdb" value="Sync Status JDB" class="button"
				 style="width:auto;padding-bottom:2px;"
				onclick="jQuery(\'#action\').val(\'sync_status_jdb\');"/>';
					echo $entry_sidebar_button;	?>
					</div>
				<?php 
}


/* Notes Sidebar Grid Function */
function notes_sidebar_grid( $notes, $is_editable, $emails = null, $subject = '' ) {
		?>
<table class="widefat fixed entry-detail-notes">
	<tbody id="the-comment-list" class="list:comment">
		<?php
			$count = 0;
			$notes_count = sizeof( $notes );
			foreach ( $notes as $note ) {
				$count ++;
				$is_last = $count >= $notes_count ? true : false;
				?>
		<tr valign="top">
			<td
				class="entry-detail-note<?php echo $is_last ? ' lastrow' : '' ?>">
				<?php
						$class = $note->note_type ? " gforms_note_{$note->note_type}" : '';
						?>
				<div style="margin-top: 4px;">
					<div class="note-avatar">
						<?php echo apply_filters( 'gform_notes_avatar', get_avatar( $note->user_id, 48 ), $note ); ?>
					</div>
					<h6 class="note-author">
						<?php echo esc_html( $note->user_name ) ?>
					</h6>
					<p class="note-email">
						<a href="mailto:<?php echo esc_attr( $note->user_email ) ?>"><?php echo esc_html( $note->user_email ) ?></a><br />
						<?php _e( 'added on', 'gravityforms' ); ?>
						<?php echo esc_html( GFCommon::format_date( $note->date_created, false ) ) ?>
					</p>
				</div>
				<div class="detail-note-content<?php echo $class ?>">
					<?php echo html_entity_decode( $note->value ) ?>
				</div>
			</td>

		</tr>
		<?php }?>
	</tbody>
</table>
<?php
}


// This is where our custom post action handing occurs
add_action("gform_admin_pre_render_action", "mf_admin_pre_render");
function mf_admin_pre_render(){
//Get the current action
$mfAction=RGForms::post( 'action' );

//Only process if there was a gravity forms action
if (!empty($mfAction))
{
	$entry_info_entry_id=$_POST['entry_info_entry_id'];
	$lead = GFAPI::get_entry( $entry_info_entry_id );
	$form_id    =  isset($lead['form_id']) ? $lead['form_id'] : 0;
	$form = RGFormsModel::get_form_meta($form_id);
	$entry_status =  isset($lead['303']) ? $lead['303'] : '';
	
	switch ($mfAction ) {
		// Entry Management Update
		case 'update_entry_management' :
			set_entry_status_content($lead,$form);
			break;
		case 'update_entry_status' :
			set_entry_status($lead,$form);
			break;
		case 'update_entry_schedule' :
			set_entry_schedule($lead,$form);
			break;
		case 'change_form_id' :
			set_form_id($lead,$form);
			break;
		case 'sync_jdb' :
			gravityforms_send_entry_to_jdb($entry_info_entry_id);
			break;
		case 'sync_status_jdb' :
			sync_status_jdb($entry_info_entry_id,$entry_status);
			break;
			
		//Sidebar Note Add
		case 'add_note_sidebar' :
			add_note_sidebar($lead, $form);
			break;
	}
	
}

// Return the original form which is required for the filter we're including for our custom processing.
return $form;
}

/* Modify Set Entry Status */
function set_entry_status_content($lead,$form){
	$location_change=$_POST['entry_info_location_change'];
	$flags_change=$_POST['entry_info_flags_change'];
	$location_comment_change=$_POST['entry_location_comment'];
	$acceptance_status_change=$_POST['entry_info_status_change'];
	$entry_info_entry_id=$_POST['entry_info_entry_id'];
	$acceptance_current_status = $lead['303'];
	$field302=RGFormsModel::get_field($form,'302');
	$field304=RGFormsModel::get_field($form,'304');
	
	$is_acceptance_status_changed = (strcmp($acceptance_current_status, $acceptance_status_change) != 0);
	
	if (!empty($entry_info_entry_id))
	{
		/* Clear out old choices */
		foreach(   $field304['inputs'] as $choice)
		{
			GFAPI::update_entry_field($entry_info_entry_id,$choice['id'],'');
		}
		foreach(   $field302['inputs'] as $choice)
		{
			GFAPI::update_entry_field($entry_info_entry_id,$choice['id'],'');
		}
		/* Save entries */	
		if (!empty($location_change))
		{
			foreach($location_change as $location_entry)
			{
				$exploded_location_entry=explode("_",$location_entry);
				$entry_info_entry[$exploded_location_entry[0]] = $exploded_location_entry[1];
				GFAPI::update_entry_field($entry_info_entry_id,$exploded_location_entry[0],$exploded_location_entry[1]);
			}
		}
		if (!empty($flags_change))
		{
			foreach($flags_change as $flags_entry)
			{
				$exploded_flags_entry=explode("_",$flags_entry);
				$entry_info_entry[$exploded_flags_entry[0]] = $exploded_flags_entry[1];
				GFAPI::update_entry_field($entry_info_entry_id,$exploded_flags_entry[0],$exploded_flags_entry[1]);
			}
		}
		if (!empty($location_comment_change))
		{
			$entry_info_entry['307'] = $location_comment_change;
				
			GFAPI::update_entry_field($entry_info_entry_id,'307',$location_comment_change);

		}
			
	}
}

/* Modify Set Entry Status */
function set_entry_status($lead,$form){
	$location_change=$_POST['entry_info_location_change'];
	$flags_change=$_POST['entry_info_flags_change'];
	$location_comment_change=$_POST['entry_location_comment'];
	$acceptance_status_change=$_POST['entry_info_status_change'];
	$entry_info_entry_id=$_POST['entry_info_entry_id'];
	$acceptance_current_status = $lead['303'];

	$is_acceptance_status_changed = (strcmp($acceptance_current_status, $acceptance_status_change) != 0);

	if (!empty($entry_info_entry_id))
	{
		if (!empty($acceptance_status_change))
		{
			//Update Field for Acceptance Status
			$entry_info_entry['303'] = $acceptance_status_change;
			GFAPI::update_entry_field($entry_info_entry_id,'303',$acceptance_status_change);
			//Reload entry to get any changes in status
			$lead['303'] = $acceptance_status_change;
				
			//Handle acceptance status changes
			if ($is_acceptance_status_changed )
			{
				//Create a note of the status change.
				$results=mf_add_note( $entry_info_entry_id, 'EntryID:'.$entry_info_entry_id.' status changed to '.$acceptance_status_change);
				//Handle notifications for acceptance
				$notifications_to_send = GFCommon::get_notifications_to_send( 'mf_acceptance_status_changed', $form, $lead );
				foreach ( $notifications_to_send as $notification ) {
					GFCommon::send_notification( $notification, $form, $lead );
				}
				sync_status_jdb($entry_info_entry_id,$acceptance_status_change);

			}
		}


	}
}

/* Modify Form Id Status */
function set_form_id($lead,$form){
	$form_change=$_POST['entry_form_change'];
	$entry_info_entry_id=$_POST['entry_info_entry_id'];
	
	error_log('$form_change='.$form_change);
	error_log('$$entry_info_entry_id='.$entry_info_entry_id);
	$entry=GFAPI:: get_entry($entry_info_entry_id);
	
	$is_form_id_changed = (strcmp($entry['form_id'], $form_change) != 0);

	if (!empty($entry_info_entry_id))
	{
		if (!empty($is_form_id_changed))
		{
			//Update Field for Acceptance Status
			$result = update_entry_form_id($entry,$form_change);
			error_log('UPDATE RESULTS = '.print_r($result,true));
			
		}
	}
}
/**
 * Updates a form id of an entry.
 *
 * @param int    $entry_id The ID of the Entry object
 * @param int    $form_id The Form ID of the Entry object
  *
 * @param mixed  $value    The value to which the field should be set
 *
 * @return bool Whether the entry property was updated successfully
 */
 function update_entry_form_id( $entry_id, $form_id ) {
	global $wpdb;
	
	$lead_table = GFFormsModel::get_lead_table_name();
	$lead_detail_table = GFFormsModel::get_lead_details_table_name();
	$lead_meta_table = GFFormsModel::get_lead_meta_table_name();
	$result     = $wpdb->query(
			$wpdb->prepare( "UPDATE $lead_table SET form_id={$form_id} WHERE id=%d ", $entry_id)
	);
	$wpdb->query(
		$wpdb->prepare( "UPDATE $lead_detail_table SET form_id={$form_id} WHERE lead_id=%d ", $entry_id)
	);
	$wpdb->query(
			$wpdb->prepare( "UPDATE $lead_meta_table SET form_id={$form_id} WHERE lead_id=%d ", $entry_id)
	);

	
	return $result;
}



/* Modify Set Entry Status */
function set_entry_schedule($lead,$form){
	$entry_schedule_change=$_POST['entry_schedule_change'];
	$entry_info_entry_id=$_POST['entry_info_entry_id'];
	
	$is_acceptance_status_changed = (strcmp($acceptance_current_status, $acceptance_status_change) != 0);

	if (!empty($entry_info_entry_id))
	{
		if (!empty($entry_schedule_change))
		{
			$form = GFAPI::get_form($form_id);
					$schedule=array('schedule1'=>'01012014,02022014','schedule2'=>'01012014,02022014');
					$schedule['schedule'] = $entry_schedule_change;
					gform_update_meta( $lead['id'], 'schedule', json_encode($schedule) );
			
		}	
	}
}

function add_note_sidebar($lead, $form)
{
	global $current_user;
	
	$user_data = get_userdata( $current_user->ID );
	$project_name = $lead['151'];
	$email_to      = $_POST['gentry_email_notes_to_sidebar'];
	
	$email_note_info = '';
	
	//emailing notes if configured
	if ( !empty($email_to) ) {
		
		GFCommon::log_debug( 'GFEntryDetail::lead_detail_page(): Preparing to email entry notes.' );
		$email_to      = $_POST['gentry_email_notes_to_sidebar'];
		$email_from    = $current_user->user_email;
		$email_subject = stripslashes( 'Response Required Maker Application: '.$lead['id'].' '.$project_name);
		$entry_url = get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=gf_entries&view=entry&id=' . $form['id'] . '&lid=' . rgar( $lead, 'id' );
		$body = stripslashes( $_POST['new_note_sidebar'] ). '<br /><br />Please reply in entry:<a href="'.$entry_url.'">'.$entry_url.'</a>';
		$headers = "From: \"$email_from\" <$email_from> \r\n";
		//Enable HTML Email Formatting in the body
		add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );
		$result  = wp_mail( $email_to, $email_subject, $body, $headers );
		//Remove HTML Email Formatting
		remove_filter( 'wp_mail_content_type','wpse27856_set_content_type' );
		$email_note_info = '<br /><br />:SENT TO:['.implode(",", $email_to).']';
	}
	
	mf_add_note( $lead['id'],  nl2br(stripslashes($_POST['new_note_sidebar'].$email_note_info)));
	
}




function wpse27856_set_content_type(){
	return "text/html";
}




function mf_add_note($leadid,$notetext)
{
	global $current_user;
		
	$user_data = get_userdata( $current_user->ID );
	RGFormsModel::add_note( $leadid, $current_user->ID, $user_data->display_name, $notetext );
}

function gravityforms_send_entry_to_jdb ($id)
{

	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$result = $mysqli->query("Select  id,form_id from wp_rg_lead where id = $id");
	
	while($row = $result->fetch_row())
	{
		$entry_id=$row[0];
		$entry = GFAPI::get_entry($row[0]);
		//$jdb_encoded_entry = gravityforms_to_jdb_record($entry,$row[0],$row[1]);
		$jdb_encoded_entry = http_build_query(gravityforms_to_jdb_record($entry,$row[0],$row[1]));
		$synccontents = '"'.$mysqli->real_escape_string($jdb_encoded_entry).'"';
		$results_on_send = gravityforms_send_record_to_jdb($entry_id,$jdb_encoded_entry);
		$results_on_send_prepared = '"'.$mysqli->real_escape_string($results_on_send).'"';
		
		//MySqli Insert Query
		$insert_row = $mysqli->query("INSERT INTO `wp_rg_lead_jdb_sync`(`lead_id`, `synccontents`, `jdb_response`) VALUES ($entry_id,$synccontents, $results_on_send_prepared)");
		if($insert_row){
			print 'Success! Response from JDB  was: ' .$results_on_send .'<br />';
		}else{
			die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		};
	}
}

function gravityforms_to_jdb_record($lead,$lead_id,$form_id)
{
	//load form
	$form = GFAPI::get_form($form_id);
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
			'form_type' => $form_id, //(Form ID)
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

function gravityforms_send_record_to_jdb( $entry_id,$jdb_encoded_record ) {
	// Don't sync from any of our testing locations.
	$local_server = array( 'localhost', 'make.com', 'vip.dev', 'staging.makerfaire.com' );
	if ( isset( $_SERVER['HTTP_HOST'] ) && in_array( $_SERVER['HTTP_HOST'], $local_server ) )
		return false;
	
	$post_body = array(
			'method' => 'POST',
			'timeout' => 45,
			'headers' => array(),
			'body' => $jdb_encoded_record);
	
	$res  = wp_remote_post( 'http://db.makerfaire.com/updateExhibitInfo', $post_body  );
	//$res  = wp_remote_post( 'http://makerfaire.local/wp-content/allpostdata.php', $post_body  );
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

/*
 * Sync MakerFaire Application Statuses
*
* @access private
* @param int $id Post id to SYNC
* @param string $app_status Post status
* =====================================================================*/
function sync_status_jdb( $id = 0, $status = '' ) {
	$post_body = array(
		'method' => 'POST',
		'timeout' => 45,
		'headers' => array(),
		'body' => array( 'body' => array( 'CS_ID' => intval( $id ), 'status' => esc_attr( $status ))));

	//$res  = wp_remote_post( 'http://makerfaire.local/wp-content/allpostdata.php', $post_body  );
	$res  = wp_remote_post( 'http://db.makerfaire.com/updateExhibitStatusForJSON', $post_body  );
	$er  = 0;

	if ( 200 == $res['response']['code'] ) {
		$body = json_decode( $res['body'] );
		if ( 'ERROR' != $body->status ) {
			$er = time();
		}
	}

	gform_update_meta( $id, 'mf_jdb_status_sync', $er );

	return $er;
}
