<?php
add_action("gform_entry_detail_content_before", "add_main_text_before", 10, 2);
function add_main_text_before($form, $lead){
	$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
	if ($mode != "view") return;
	
	echo gf_summary_metabox($form, $lead);
	//echo gf_summary_adminNotes($form, $lead);
	
}

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
$entry_form_status = $lead['status'];
$is_commercialmaker = '';
$commercialmaker_sales = '';
$wkey = 'https://makezineblog.files.wordpress.com/2015/01/unisphere-final-exp.mp4';//$this->merge_fields( 'project_website', $data->form_type );
$vkey = 'https://makezineblog.files.wordpress.com/2015/01/unisphere-final-exp.mp4';//$this->merge_fields( 'project_video', $data->form_type );
$entry_project_video = $vkey;
$entry_performer_video = $vkey;
$entry_video = $vkey;
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
				<thead><th id="header">
				<h1><?php echo esc_html($project_name); ?></h1>
			</th></thead>
			<tbody>
				<tr>
					<td valign="top"><img src="<?php echo esc_url($photo);// get_resized_remote_image_url( $photo, 200, 200 ) ); ?>" width="200" height="200" /></td>
					<td valign="top">
						<p><?php echo Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $main_description, "\n" ) ) ) ); ?></p>
						<table>
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
								  echo ( isset( $entry_project_video ) ) ? '<a href="' . esc_url( $entry_project_video ) . '" target="_blank">' . esc_url( $entry_project_video ) . '</a><br />' : null ;
								  echo ( isset( $entry_performer_video ) ) ? '<a href="' . esc_url( $entry_performer_video ) . '" target="_blank">' . esc_url( $entry_performer_video ) . '</a><br />' : null ;
								  echo ( isset( $entry_video ) ) ? '<a href="' . esc_url( $entry_video ) . '" target="_blank">' . esc_url( $entry_video ) . '</a><br/>' : '' ;
								?>
							</td>
							</tr>
							<?php if( $entry_form_type == 'exhibit' ) : ?>
								<tr>
									<td style="width:80px;" valign="top"><strong>Supporting Documents:</strong></td>
									<td valign="top"><a href="<?php echo esc_url( $entry_supporting_documents ); ?>" target="_blank"><?php echo esc_url( $entry_supporting_documents ); ?></a></td>
								</tr>
								<tr>
									<td style="width:80px;" valign="top"><strong>Layout:</strong></td>
									<td valign="top"><a href="<?php echo esc_url( $entry_layout ); ?>" target="_blank"><?php echo esc_url( $entry_layout ); ?></a></td>
								</tr>
							<?php endif; ?>
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
							<tr>
								<td style="width:80px;" valign="middle"><strong>MF Video:</strong></td>
								<td valign="top"> NOTE: Need to research what is supposed to go here.
								<!--  	<input type="text" id="video-coverage" name="video-coverage" style="width:25%;" value="<?php echo !empty( $event_record['mfei_coverage'][0] ) ? esc_url( $event_record['mfei_coverage'][0] ) : ''; ?>" />
									<input type="hidden" name="event-id" value="<?php echo get_the_ID(); ?>" />
									-->
								</td>
							</tr>
							<tr>
								<td valign="top"><strong>JDB Sync:</strong></td>
								<td valign="top"><?php echo esc_html( $jdb ); ?></td>
							</tr>
						</table>
						</td>
					</tr>
					</tbody>
					</table>
		
					<?php
					
} //end function



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

add_action("gform_entry_info", "my_entry_info", 10, 2);
function my_entry_info($form_id, $lead) {
	switch ( RGForms::post( 'action' ) ) {
	case 'status_update' :
		set_entry_status_content();
				$lead = RGFormsModel::get_lead( $lead['id'] );
				//$lead = GFFormsModel::set_entry_meta( $lead, $form );
						break;
}
$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
	if ($mode != "view") return;
	
	
	//print_r( $lead);
	
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
	
	
	echo ('		<input type="submit" onclick="jQuery(\'#action\').val(\'status_update\'); jQuery(\'#screen_mode\').val(\'view\');" name="save" value="Save Changes" tabindex="4" class="button button-large button-primary" id="gform_update_button">&nbsp;&nbsp;');	
}

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