<?php
/* This is where we run code on the entry info screen.  Logic for action handling goes here */
function mf_sidebar_entry_info($form_id, $lead) {
	// Load Fields to show on entry info
	$form = GFAPI::get_form($form_id);
	
	$field302=RGFormsModel::get_field($form,'302');
	$field303=RGFormsModel::get_field($form,'303');
	$field304=RGFormsModel::get_field($form,'304');
	$field307=RGFormsModel::get_field($form,'307');
	
	echo ('<input type="hidden" name="entry_info_entry_id" value="'.$lead['id'].'">');
	echo ('<h4><label class="detail-label" for="entry_info_status_change">Status:</label></h4>');
	echo ('<select name="entry_info_status_change">');
	foreach( $field303['choices'] as $choice )
	{
		$selected = '';
	
		if ($lead[$field303['id']] == $choice['text']) $selected=' selected ';
	
		echo('<option '.$selected.' value="'.$choice['text'].'">'.$choice['text'].'</option>');
	}
	echo('</select><br />');

	
	echo ('<h4><label class="detail-label">Flags:</label></h4>');
	foreach(   $field304['inputs'] as $choice)
	{
		$selected = '';
		if ($lead[$choice['id']] == $choice['label']) $selected=' checked ';
		echo('<input type="checkbox" '.$selected.' name="entry_info_flags_change[]" style="margin: 3px;" value="'.$choice['id'].'_'.$choice['label'].'" />'.$choice['label'].' <br />');
	}
	
	
	echo ('<h4><label class="detail-label">Location:</label></h4>');
	foreach(   $field302['inputs'] as $choice)
	{
		$selected = '';
		if ($lead[$choice['id']] == $choice['label']) $selected=' checked ';
		echo('<input type="checkbox" '.$selected.' name="entry_info_location_change[]" style="margin: 3px;" value="'.$choice['id'].'_'.$choice['label'].'" />'.$choice['label'].' <br />');
	}
	
	
	echo ('<textarea name="entry_location_comment" id="entry_location_comment"
					style="width: 100%; height: 50px; margin-bottom: 4px;" cols=""
					rows="">'.$lead['307'].'</textarea>');
	

}

/* A function to determine status counts */

function get_makerfaire_status_counts( $form_id ) {
	global $wpdb;
	$lead_details_table_name = self::get_lead_details_tablename();
	$sql             = $wpdb->prepare(
			"SELECT entries=count(0),label=value FROM $lead_details_table_name
			where field_number='303'
			and form_id=%d
			group by value",
			$form_id
	);

	$results = $wpdb->get_results( $sql, ARRAY_A );

	return $results[0];

}

/* Side bar Layout */
add_action("gform_entry_detail_sidebar_before", "add_sidebar_text_before", 10,2);
function add_sidebar_text_before($form, $lead){
	$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
	?>
<div id="infoboxdiv" class="postbox">
	<h3>
		<span class="hndle"><?php _e( 'Entry', 'gravityforms' ); ?></span>
	</h3>
	<div id="minor-publishing" style="padding: 10px;">
			<br />
			<?php _e( 'Entry Id', 'gravityforms' ); ?>
			:
			<?php echo absint( $lead['id'] ) ?><br />
			<?php _e( 'Submitted on', 'gravityforms' ); ?>
			:<br />
			<?php echo esc_html( GFCommon::format_date( $lead['date_created'], false, 'Y/m/d' ) ) ?>
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
		
<?php 
if ($mode != 'view') return;

/* Entry Management Sidebar Area */?>
<div class='postbox' style="float:none;padding: 10px;">
<h4>
	<label class="detail-label">Entry Management:</label>
</h4>

<?php
// Load Entry Sidebar details
mf_sidebar_entry_info( $form['id'], $lead );

// Create Update button for sidebar entry management
$entry_sidebar_button = '<input type="submit" name="update_management" value="Update Management" class="button"
	 style="width:auto;padding-bottom:2px;" 
	onclick="jQuery(\'#action\').val(\'update_entry_management\');"/>';
echo $entry_sidebar_button;	?>
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
}


/* Notes Sidebar Grid Function */
function notes_sidebar_grid( $notes, $is_editable, $emails = null, $subject = '' ) {
		?>
<table class="widefat fixed entry-detail-notes" cellspacing="0">
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
					<?php echo esc_html( $note->value ) ?>
				</div>
			</td>

		</tr>
		<?php
			}
			if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
				?>
		<tr>
			<td style="padding: 10px;" class="lastrow">
				<textarea
					name="new_note_sidebar"
					style="width: 100%; height: 50px; margin-bottom: 4px;" cols=""
					rows=""></textarea> <?php
						$note_button = '<input type="submit" name="add_note_sidebar" value="' . __( 'Add Note', 'gravityforms' ) . '" class="button" style="width:auto;padding-bottom:2px;" onclick="jQuery(\'#action\').val(\'add_note_sidebar\');"/>';
						echo apply_filters( 'gform_addnote_button', $note_button );	?>
				&nbsp;&nbsp; <span> 
				<br />
				<label >Email Note To:</label><br />
				<?php 
				$emailto = array(
   				"rich@makermedia.com" => "rich@makermedia.com",
					 "admin@makerfaire.com" => "admin@makerfaire.com",
				  "Brian Jepson" => "bjepson@makermedia.com",
				  "Bridgette Vanderlaan" => "bvanderlaan@mac.com",
				  "Editorial Make" => "onlineeditors@makezine.com",
				  "Jason Babler" => "jbabler@makermedia.com",
				  "Jay Kravitz" => "jay@thecrucible.org",
				  "Jonathan Maginn" => "jonathan.maginn@sbcglobal.net",
				  "Kate Rowe" => "krowe@makermedia.com",
				  "Kerry Moore" => "kerry@contextfurniture.com",
				  "Louise Glasgow" => "lglasgow@makermedia.com",
				  "Maker Relations" => "makers@makerfaire.com",
				  "Marketing Make" => "marketing@makermedia.com",
				  "Michelle Hlubinka" => "mhlubinka@makermedia.com",
				  "Miranda Mota" => "miranda@makermedia.com",
				  "Nick Normal" => "nicknormal@gmail.com",
				  "PR MakerFaire" => "pr@makerfaire.com",
				  "Sabrina Merlo" => "smerlo@makermedia.com",
				  "Shed Make" => "makershed@makerfaire.com",
				  "Sherry Huss" => "sherry@makermedia.com",
				  "Sponsor Sales" => "sales@makerfaire.com",
				  "Tami Jo Benson" => "tj@tamijo.com",
				  "Dale Dougherty" => "dale@makermedia.com");
				?>
				<?php foreach ( $emailto as $name => $email ) { 
					echo('<input type="checkbox"  name="gentry_email_notes_to_sidebar[]" style="margin: 3px;" value="'.$email.'" />'.$name.' <br />');
					 } ?>&nbsp;&nbsp; <span id='gentry_email_subject_container_sidebar'
					style="display: none;"> <label for="gentry_email_subject_sidebar"><?php _e( 'Subject:', 'gravityforms' ) ?></label>
						<input type="text" name="gentry_email_subject_sidebar"
						id="gentry_email_subject_sidebar" value="" style="width: 35%" />
				</span>
			</span> <?php } ?></td>
		</tr>
	</tbody>
</table>
<?php
}


// This is where our custom post action handing occurs
add_action("gform_admin_pre_render", "mf_admin_pre_render", 10, 2);
function mf_admin_pre_render($form){
//Get the current action
$mfAction=RGForms::post( 'action' );

//Only process if there was a gravity forms action
if (!empty($mfAction))
{
	$entry_info_entry_id=$_POST['entry_info_entry_id'];
	$lead = GFAPI::get_entry( $entry_info_entry_id );
	switch ($mfAction ) {
		// Entry Management Update
		case 'update_entry_management' :
			set_entry_status_content($lead,$form);
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
	error_log(print_r($_POST,true));
	$location_change=$_POST['entry_info_location_change'];
	$flags_change=$_POST['entry_info_flags_change'];
	$location_comment_change=$_POST['entry_location_comment'];
	$acceptance_status_change=$_POST['entry_info_status_change'];
	$entry_info_entry_id=$_POST['entry_info_entry_id'];
	$acceptance_current_status = $lead['303'];

	$is_acceptance_status_changed = (strcmp($acceptance_current_status, $acceptance_status_change) != 0);
	
	if (!empty($entry_info_entry_id))
	{
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
		if (!empty($acceptance_status_change))
		{
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
						
			}
			//Update Field for Acceptance Status
			$entry_info_entry['303'] = $acceptance_status_change;
			GFAPI::update_entry_field($entry_info_entry_id,'303',$acceptance_status_change);
		 }
		
		
	}
}



function add_note_sidebar($lead, $form)
{
	global $current_user;
	
	$user_data = get_userdata( $current_user->ID );
	mf_add_note( $lead['id'], stripslashes( $_POST['new_note_sidebar'] ) );
	
	$email_to      = $_POST['gentry_email_notes_to_sidebar'];
	
	//emailing notes if configured
	if ( !empty($email_to) ) {
		GFCommon::log_debug( 'GFEntryDetail::lead_detail_page(): Preparing to email entry notes.' );
		$email_to      = $_POST['gentry_email_notes_to_sidebar'];
		$email_from    = $current_user->user_email;
		$email_subject = stripslashes( $_POST['gentry_email_subject_sidebar'] );
		$body = stripslashes( $_POST['new_note_sidebar'] );
	
		$headers = "From: \"$email_from\" <$email_from> \r\n";
		GFCommon::log_debug( "GFEntryDetail::lead_detail_page(): Emailing notes - TO: $email_to SUBJECT: $email_subject BODY: $body HEADERS: $headers" );
		error_log( "GFEntryDetail::lead_detail_page(): Emailing notes - TO: $email_to SUBJECT: $email_subject BODY: $body HEADERS: $headers" );
		$result  = wp_mail( $email_to, $email_subject, $body, $headers );
		GFCommon::log_debug( "GFEntryDetail::lead_detail_page(): Result from wp_mail(): {$result}" );
		if ( $result ) {
			GFCommon::log_debug( 'GFEntryDetail::lead_detail_page(): Mail was passed from WordPress to the mail server.' );
		} else {
			GFCommon::log_error( 'GFEntryDetail::lead_detail_page(): The mail message was passed off to WordPress for processing, but WordPress was unable to send the message.' );
		}
	}
}



function mf_add_note($leadid,$notetext)
{
	global $current_user;
		
	$user_data = get_userdata( $current_user->ID );
	RGFormsModel::add_note( $leadid, $current_user->ID, $user_data->display_name, $notetext );
}
