<?php
// Adding Entry Detail
add_action("gform_entry_detail_content_before", "add_main_text_before", 10, 2);
function add_main_text_before($form, $lead){
	$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
	if ($mode != "view") return;
	
	echo gf_summary_metabox($form, $lead);
	//echo gf_summary_adminNotes($form, $lead);
	
}

//Summary Notes to be shown
function gf_summary_adminNotes($form,$lead) {
	$is_editable = true;
	
	print_r(get_makerfaire_status_counts($form['id']));
	
	$notes = RGFormsModel::get_lead_notes( $lead['id'] );?>
	
	<table class="widefat fixed entry-detail-notes" cellspacing="0">
	<?php
	if ( ! $is_editable && !($mode == "edit") ) {
		?>
					<thead>
					<tr>
						<th id="notes">Notes</th>
					</tr>
					</thead>
				<?php
				}
				?>
				<tbody id="the-comment-list" class="list:comment">
				<?php
				$count = 0;
				$notes_count = sizeof( $notes );
				foreach ( $notes as $note ) {
					$count ++;
					$is_last = $count >= $notes_count ? true : false;
					?>
					<tr valign="top">
						<?php
						if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
						?>
						<th class="check-column" scope="row" style="padding:9px 3px 0 0">
							<input type="checkbox" value="<?php echo $note->id ?>" name="note[]" />
						</th>
						<td colspan="2">
							<?php
							}
							else {
							?>
						<td class="entry-detail-note<?php echo $is_last ? ' lastrow' : '' ?>">
							<?php
							}
							$class = $note->note_type ? " gforms_note_{$note->note_type}" : '';
							?>
							<div style="margin-top:4px;">
								<div class="note-avatar"><?php echo apply_filters( 'gform_notes_avatar', get_avatar( $note->user_id, 48 ), $note ); ?></div>
								<h6 class="note-author"><?php echo esc_html( $note->user_name ) ?></h6>
								<p class="note-email">
									<a href="mailto:<?php echo esc_attr( $note->user_email ) ?>"><?php echo esc_html( $note->user_email ) ?></a><br />
									<?php _e( 'added on', 'gravityforms' ); ?> <?php echo esc_html( GFCommon::format_date( $note->date_created, false ) ) ?>
								</p>
							</div>
							<div class="detail-note-content<?php echo $class ?>"><?php echo esc_html( $note->value ) ?></div>
						</td>
	
					</tr>
				<?php
				}
				if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
					?>
					<tr>
						<td colspan="3" style="padding:10px;" class="lastrow">
							<textarea name="admin_note" style="width:100%; height:50px; margin-bottom:4px;"></textarea>
							<?php
							$note_button = '<input type="submit" name="add_note" value="' . __( 'Add Note', 'gravityforms' ) . '" class="button" style="width:auto;padding-bottom:2px;" onclick="jQuery(\'#action\').val(\'add_note\');"/>';
							echo apply_filters( 'gform_addnote_button', $note_button );
							$blogusers = get_users( 'blog_id=1&orderby=nicename&role=administrator' );
							// Array of WP_User objects.
							
							?>
								&nbsp;&nbsp;
								<span>
	                                <select name="gentry_email_notes_to" onchange="if(jQuery(this).val() != '') {jQuery('#gentry_email_subject_container').css('display', 'inline');} else{jQuery('#gentry_email_subject_container').css('display', 'none');}">
										<option value=""><?php _e( 'Also email this note to', 'gravityforms' ) ?></option>
										<?php foreach ( $blogusers as $user ) {
										echo '<option  value="' . esc_html( $user->user_email ) . '" >'. esc_html( $user->display_name ) . '</option>';
										}?>
										
									</select>
	                                &nbsp;&nbsp;
	
	                                <span id='gentry_email_subject_container' style="display:none;">
	                                    <label for="gentry_email_subject"><?php _e( 'Subject:', 'gravityforms' ) ?></label>
	                                    <input type="text" name="gentry_email_subject" id="gentry_email_subject" value="" style="width:35%" />
	                                </span>
	                            </span>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table><?php 
}


/* Adding Gravity Forms Summary */

function gf_summary_metabox($form, $lead)
{
$jdb_success = gform_get_meta( $lead->ID, 'mf_jdb_sync');

if ( $jdb_success == '' ) {
	$jdb_fail = gform_get_meta( $post->ID, 'mf_jdb_sync_fail', true );
	$jdb      = '[FAILED] : N/A';
	if ( $jdb_success == '' )
		$jdb  = '[FAILED] : ' . date( 'M jS, Y g:i A', $jdb_fail - ( 7 * 3600 ) );
} else {
	$jdb = '[SUCCESS] : ' . date( 'M jS, Y g:i A', $jdb_success - ( 7 * 3600 ) );
}

$entry_id = $lead['id'];
$photo = $lead['22'];
$short_description = $lead['16'];
$long_description = $lead['21'];
$project_name = $lead['151'];
$entry_form_type = $form['title'];
$entry_form_status = $lead['303'];
$wkey = $lead['27'];
$vkey = $lead['32'];
$data->project_video;


$main_description = '';

// Check if we are loading the public description or a short description
if ( isset( $long_description ) ) {
	$main_description = $long_description;
} else if ( isset($short_description ) ) {
	$main_description = $short_description;
}
?>
			<table class="fixed entry-detail-view">
				<thead><th colspan="2" style="text-align:left" id="header">
				<h1><?php echo esc_html($project_name); ?></h1>
			</th></thead>
			<tbody>
				<tr>
					<td valign="top"><img src="<?php echo esc_url($photo);// get_resized_remote_image_url( $photo, 200, 200 ) ); ?>" width="300" /></td>
					<td valign="top">
						<table>
							<tr><td colspan="2">
							<p><?php echo stripslashes( nl2br( $main_description, "\n" )  ); ?></p>
							</td>
							</tr>
							<tr>
							
								<td style="width:80px;" valign="top"><strong>Type:</strong></td>
								<td valign="top"><?php echo esc_attr( ucfirst( $entry_form_type ) ); ?></td>
							</tr>
							<tr>
								<td style="width:80px;" valign="top"><strong>Status:</strong></td>
								<td valign="top"><?php echo esc_attr( $entry_form_status ); ?></td>
							</tr>
							<?php if( $data->form_type == 'exhibit' ) : ?>
								<tr>
									<td valign="top"><strong>Commercial Maker:</strong></td>
									<td valign="top"><?php echo esc_html( $data->sales == '' ? 'N/A' : $data->sales ); ?></td>
								</tr>
							<?php endif; ?>
							<?php
							?>
							<tr>
								<td style="width:80px;" valign="top"><strong>Website:</strong></td>
								<td valign="top"><a href="<?php echo esc_url(  $wkey ); ?>" target="_blank"><?php echo esc_url( $wkey ); ?></a></td>
							</tr>
							<tr>
							<td valign="top"><strong>Video:</strong></td>
							<td>
								<?php
								  echo ( isset( $vkey ) ) ? '<a href="' . esc_url( $vkey ) . '" target="_blank">' . esc_url( $vkey ) . '</a><br/>' : '' ;
								?>
							</td>
							</tr>
							<?php

								// Store the current application ID so we can return it within the loop
								$parent_post_id = $entry['ID'];

								$args = array(
									'post_type'		=> 'event-items',
									'orderby' 		=> 'meta_value',
									'meta_key'		=> 'mfei_start',
									'order'			=> 'asc',
									'posts_per_page'=> '30',
									'meta_query' 	=> array(
										array(
											'key' 	=> 'mfei_record',
											'value'	=> $entry_id
									   ),
									)
								);
								$get_events = new WP_Query( $args );

								// Check that we have returned our query of events, if not, give the option to schedule the event
								if ( $get_events->found_posts >= 1 ) { ?>
									<tr>
										<td style="width:80px;"><strong>Scheduled:</strong></td>
										<td valign="top">Yes</a>
									</tr>
									<?php // Loop through theme
									while ( $get_events->have_posts() ) : $get_events->the_post();

										// Get an array of our event data
										$event_record = get_post_meta( get_the_ID() );

										// Setup the edit URL and add an edit link to the admin area
										$edit_event_url = get_edit_post_link();

										// Show the location this event is setup for
										if ( !empty( $event_record['faire_location'][0] ) ) : ?>
											<tr>
												<td style="width:80px;" valign="top"><strong>Location:</strong></td>
												<td valign="top"><?php // echo esc_html( get_the_title( intval( unserialize( $event_record['faire_location'][0] )[0] ) ) ); ?></td>
											</tr>
										<?php endif;

										// Check that fields are set, and display them as needed.
										if ( ! empty( $event_record['mfei_day'][0] ) ) : ?>
											<tr <?php post_class(); ?>>
												<td style="width:80px;" valign="top"><strong>Day:</strong></td>
												<td valign="top"><?php echo esc_html( $event_record['mfei_day'][0] ); ?></td>
											</tr>
										<?php endif; if ( ! empty( $event_record['mfei_start'][0] ) ) : ?>
											<tr class="<?php post_class(); ?>">
												<td style="width:80px;" valign="top"><strong>Start Time:</strong></td>
												<td valign="top"><?php echo esc_html( $event_record['mfei_start'][0] ); ?></td>
											</tr>
										<?php endif; if ( ! empty( $event_record['mfei_stop'][0] ) ) : ?>
											<tr class="<?php post_class(); ?>">
												<td style="width:80px;" valign="top"><strong>Stop Time:</strong></td>
												<td valign="top"><?php echo esc_html( $event_record['mfei_stop'][0] ); ?></td>
											</tr>
										<?php endif; if ( ! empty( $event_record['mfei_schedule_completed'][0] ) ) : ?>
											<tr class="<?php post_class(); ?>">
												<td style="width:80px;" valign="top"><strong>Schedule Completed:</strong></td>
												<td valign="top"><?php echo esc_html( $event_record['mfei_schedule_completed'][0] ); ?></td>
											</tr>
										<?php endif; ?>
											<tr class="<?php post_class(); ?>">
												<td valign="top"><strong>Edit</strong></td>
												<td>
													<a href="<?php echo esc_url( $edit_event_url ); ?>" class="button" target="_blank">Edit the Time and Date</a> <button href="" class="deleteme button-small button-secondary delete" data-key="mfei_record" data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_scheduled_post' ) ); ?>" data-postid="<?php echo esc_attr( get_the_id() ); ?>" data-value="<?php echo esc_attr( $event_record['mfei_record'][0] ); ?>" title="">Delete Scheduled Event</button>
												</td>
											</tr>

									<?php endwhile; ?>
									<tr>
										<td style="width:80px;" valign="top"><strong>Schedule:</strong></a></td>
										<td valign="top"><a href="<?php echo admin_url(); ?>post-new.php?post_type=event-items&amp;refer_id=<?php echo absint( $entry_id ); ?>">Schedule Another Event</a></td>
									</tr>
								<?php } else { ?>
									<tr>
										<td style="width:80px;" valign="top"><strong>Scheduled:</strong></a></td>
										<td valign="top"><a href="<?php echo admin_url(); ?>post-new.php?post_type=event-items&amp;refer_id=<?php echo $entry_id; ?>">Schedule This Event</a></td>
									</tr>
								<?php }
							?>
						</table>
						</td>
					</tr>
					</tbody>
					</table>
		
					<?php
					
} //end function


/* Modify Set Entry Status */
function set_entry_status_content(){
	$location_change=$_POST['entry_info_location_change'];
	$status_change=$_POST['entry_info_status_change'];
	$entry_info_entry_id=$_POST['entry_info_entry_id'];
	
	error_log(print_r($_POST, true));
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
		if (!empty($status_change))
		{
			$entry_info_entry['303'] = $status_change;
			GFAPI::update_entry_field($entry_info_entry_id,'303',$status_change);
				
		}
		$results=GFAPI::update_entry($entry_info_entry);
	}
}


/* This is where we run code on the entry info screen.  Logic for action handling goes here */
add_action("gform_entry_info", "my_entry_info", 10, 2);
function my_entry_info($form_id, $lead) {
	switch ( RGForms::post( 'action' ) ) {
	case 'status_update' :
		set_entry_status_content();
		$lead = RGFormsModel::get_lead( $lead['id'] );
		break;
	}
	
	$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
	if ($mode != "view") return;
	
	// Load Fields to show on entry info
	$form = GFAPI::get_form($form_id);
	
	$field302=RGFormsModel::get_field($form,'302');
	$field303=RGFormsModel::get_field($form,'303');
	
	echo ('<input type="hidden" name="entry_info_entry_id" value="'.$lead['id'].'">');
	echo ('<h4><label class="detail-label">Status:</label></h4>');
	echo ('<select name="entry_info_status_change">');
	foreach( $field303['choices'] as $choice )
	{
		$selected = '';
	
		if ($lead[$field303['id']] == $choice['text']) $selected=' selected ';
	
		echo('<option '.$selected.' value="'.$choice['text'].'">'.$choice['text'].'</option>');
	}
	echo('</select><br />');
	
	
	echo ('<h4><label class="detail-label">Location:</label></h4>');
	foreach(   $field302['inputs'] as $choice)
	{
		$selected = '';
		if ($lead[$choice['id']] == $choice['label']) $selected=' checked ';
		echo('<input type="checkbox" '.$selected.' name="entry_info_location_change[]" value="'.$choice['id'].'_'.$choice['label'].'" />'.$choice['label'].' <br />');
	}
	
	//Add the button for updating entry info
	echo ('		<input type="submit" onclick="jQuery(\'#action\').val(\'status_update\'); jQuery(\'#screen_mode\').val(\'view\');" name="save" value="Save Changes" tabindex="4" class="button button-large button-primary" id="gform_update_button">&nbsp;&nbsp;');	
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

add_action("gform_entry_detail_sidebar_before", "add_sidebar_text_before", 10,2);
function add_sidebar_text_before($form, $lead){
	$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];

	?>	<!-- INFO BOX -->
		<div id="infoboxdiv" class="stuffbox">
			<h3>
				<span class="hndle"><?php _e( 'Entry', 'gravityforms' ); ?></span>
			</h3>

			<div class="inside">
				<div id="submitcomment" class="submitbox">
					<div id="minor-publishing" style="padding:10px;">
						<br />
						<?php _e( 'Entry Id', 'gravityforms' ); ?>: <?php echo absint( $lead['id'] ) ?><br /><br />
						<?php _e( 'Submitted on', 'gravityforms' ); ?>: <?php echo esc_html( GFCommon::format_date( $lead['date_created'], false, 'Y/m/d' ) ) ?>
						
						<?php 
						do_action( 'gform_entry_info', $form['id'], $lead );

						?>
					</div>
						<div id="publishing-action">
						<div id="delete-action">
							<?php
							switch ( $lead['status'] ) {
								case 'spam' :
									if ( GFCommon::spam_enabled( $form['id'] ) ) {
										?>
										<a onclick="jQuery('#action').val('unspam'); jQuery('#entry_form').submit()" href="#"><?php _e( 'Not Spam', 'gravityforms' ) ?></a>
										<?php
										echo GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ? '|' : '';
									}
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
										<a class="submitdelete deletion" onclick="if ( confirm('<?php _e( "You are about to delete this entry. \'Cancel\' to stop, \'OK\' to delete.", 'gravityforms' ) ?>') ) {jQuery('#action').val('delete'); jQuery('#entry_form').submit(); return true;} return false;" href="#"><?php _e( 'Delete Permanently', 'gravityforms' ) ?></a>
									<?php
									}

									break;

								case 'trash' :
									?>
									<a onclick="jQuery('#action').val('restore'); jQuery('#entry_form').submit()" href="#"><?php _e( 'Restore', 'gravityforms' ) ?></a>
									<?php
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
										|
										<a class="submitdelete deletion" onclick="if ( confirm('<?php _e( "You are about to delete this entry. \'Cancel\' to stop, \'OK\' to delete.", 'gravityforms' ) ?>') ) {jQuery('#action').val('delete'); jQuery('#entry_form').submit(); return true;} return false;" href="#"><?php _e( 'Delete Permanently', 'gravityforms' ) ?></a>
									<?php
									}

									break;

								default :
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
										<a class="submitdelete deletion" onclick="jQuery('#action').val('trash'); jQuery('#entry_form').submit()" href="#"><?php _e( 'Move to Trash', 'gravityforms' ) ?></a>
										<?php
										echo GFCommon::spam_enabled( $form['id'] ) ? '|' : '';
									}
									if ( GFCommon::spam_enabled( $form['id'] ) ) {
										?>
										<a class="submitdelete deletion" onclick="jQuery('#action').val('spam'); jQuery('#entry_form').submit()" href="#"><?php _e( 'Mark as Spam', 'gravityforms' ) ?></a>
									<?php
									}
							}

							?>
						</div>
						
							<?php
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
						<div class="clear"></div>
					</div>
				</div>
			</div>
			
				<div class="postbox">
						<h3>
							<label for="name"><?php _e( 'Notes', 'gravityforms' ); ?></label>
						</h3>

						<form method="post">
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
								notes_grid( $notes, true, $emails, $subject );
								?>
							</div>
						</form>
					</div>
			
	<?php 
	echo "<div class='stuffbox'><h3><span class='hndle'>Extra Cool Stuff</span></h3><div class='inside'>text added before!<br/></div></div>";
}


function notes_grid( $notes, $is_editable, $emails = null, $subject = '' ) {
	if ( sizeof( $notes ) > 0 && $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
		?>
			<div class="alignleft actions" style="padding:3px 0;">
				<label class="hidden" for="bulk_action"><?php _e( ' Bulk action', 'gravityforms' ) ?></label>
				<select name="bulk_action" id="bulk_action">
					<option value=''><?php _e( ' Bulk action ', 'gravityforms' ) ?></option>
					<option value='delete'><?php _e( 'Delete', 'gravityforms' ) ?></option>
				</select>
				<?php
				$apply_button = '<input type="submit" class="button" value="' . __( 'Apply', 'gravityforms' ) . '" onclick="jQuery(\'#action\').val(\'bulk\');" style="width: 50px;" />';
				echo apply_filters( 'gform_notes_apply_button', $apply_button );
				?>
			</div>
		<?php
		}
		?>
		<table class="widefat fixed entry-detail-notes" cellspacing="0">
			<?php
			if ( ! $is_editable ) {
				?>
				<thead>
				<tr>
					<th id="notes">Notes</th>
				</tr>
				</thead>
			<?php
			}
			?>
			<tbody id="the-comment-list" class="list:comment">
			<?php
			$count = 0;
			$notes_count = sizeof( $notes );
			foreach ( $notes as $note ) {
				$count ++;
				$is_last = $count >= $notes_count ? true : false;
				?>
				<tr valign="top">
					<?php
					if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
					?>
					<th class="check-column" scope="row" style="padding:9px 3px 0 0">
						<input type="checkbox" value="<?php echo $note->id ?>" name="note[]" />
					</th>
					<td colspan="2">
						<?php
						}
						else {
						?>
					<td class="entry-detail-note<?php echo $is_last ? ' lastrow' : '' ?>">
						<?php
						}
						$class = $note->note_type ? " gforms_note_{$note->note_type}" : '';
						?>
						<div style="margin-top:4px;">
							<div class="note-avatar"><?php echo apply_filters( 'gform_notes_avatar', get_avatar( $note->user_id, 48 ), $note ); ?></div>
							<h6 class="note-author"><?php echo esc_html( $note->user_name ) ?></h6>
							<p class="note-email">
								<a href="mailto:<?php echo esc_attr( $note->user_email ) ?>"><?php echo esc_html( $note->user_email ) ?></a><br />
								<?php _e( 'added on', 'gravityforms' ); ?> <?php echo esc_html( GFCommon::format_date( $note->date_created, false ) ) ?>
							</p>
						</div>
						<div class="detail-note-content<?php echo $class ?>"><?php echo esc_html( $note->value ) ?></div>
					</td>

				</tr>
			<?php
			}
			if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
				?>
				<tr>
					<td colspan="3" style="padding:10px;" class="lastrow">
						<textarea name="new_note" style="width:100%; height:50px; margin-bottom:4px;"></textarea>
						<?php
						$note_button = '<input type="submit" name="add_note" value="' . __( 'Add Note', 'gravityforms' ) . '" class="button" style="width:auto;padding-bottom:2px;" onclick="jQuery(\'#action\').val(\'add_note\');"/>';
						echo apply_filters( 'gform_addnote_button', $note_button );

						if ( ! empty( $emails ) ) {
							?>
							&nbsp;&nbsp;
							<span>
                                <select name="gentry_email_notes_to" onchange="if(jQuery(this).val() != '') {jQuery('#gentry_email_subject_container').css('display', 'inline');} else{jQuery('#gentry_email_subject_container').css('display', 'none');}">
									<option value=""><?php _e( 'Also email this note to', 'gravityforms' ) ?></option>
									<?php foreach ( $emails as $email ) { ?>
										<option value="<?php echo $email ?>"><?php echo $email ?></option>
									<?php } ?>
								</select>
                                &nbsp;&nbsp;

                                <span id='gentry_email_subject_container' style="display:none;">
                                    <label for="gentry_email_subject"><?php _e( 'Subject:', 'gravityforms' ) ?></label>
                                    <input type="text" name="gentry_email_subject" id="gentry_email_subject" value="" style="width:35%" />
                                </span>
                            </span>
						<?php } ?>
					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	<?php
	}