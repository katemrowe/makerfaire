<?php
// Adding Entry Detail and checking for Processing Posts
add_action("gform_entry_detail_content_before", "add_main_text_before", 10, 2);
function add_main_text_before($form, $lead){
	$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
	if ($mode != "view") return;
	echo gf_summary_metabox($form, $lead);
}

// Summary Metabox
function gf_summary_metabox($form, $lead)
{
	
$jdb_success = gform_get_meta( $lead['id'], 'mf_jdb_sync');

if ( $jdb_success == '' ) {
	$jdb_fail = gform_get_meta( $lead['id'], 'mf_jdb_sync_fail', true );
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


$main_description = '';

// Check if we are loading the public description or a short description
if ( isset( $long_description ) ) {
	$main_description = $long_description;
} else if ( isset($short_description ) ) {
	$main_description = $short_description;
}
?>
<table class="fixed entry-detail-view">
	<thead>
		<th colspan="2" style="text-align: left" id="header">
			<h1>
				<?php echo esc_html($project_name); ?>
			</h1>
		</th>
	</thead>
	<tbody>
		<tr>
			<td valign="top"><img
				src="&lt;?php echo esc_url($photo);// get_resized_remote_image_url( $photo, 200, 200 ) ); ?&gt;"
				width="300" alt="" /></td>
			<td valign="top">
				<table>
					<tr>
						<td colspan="2">
							<p>
								<?php echo stripslashes( nl2br( $main_description, "\n" )  ); ?>
							</p>
						</td>
					</tr>
					<tr>

						<td style="width: 80px;" valign="top"><strong>Type:</strong></td>
						<td valign="top"><?php echo esc_attr( ucfirst( $entry_form_type ) ); ?></td>
					</tr>
					<tr>
						<td style="width: 80px;" valign="top"><strong>Status:</strong></td>
						<td valign="top"><?php echo esc_attr( $entry_form_status ); ?></td>
					</tr>
					<?php
							?>
					<tr>
						<td style="width: 80px;" valign="top"><strong>Website:</strong></td>
						<td valign="top"><a
							href="<?php echo esc_url(  $wkey ); ?>" target="_blank"><?php echo esc_url( $wkey ); ?></a></td>
					</tr>
					<tr>
						<td valign="top"><strong>Video:</strong></td>
						<td><?php
								  echo ( isset( $vkey ) ) ? '<a href="' . esc_url( $vkey ) . '" target="_blank">' . esc_url( $vkey ) . '</a><br/>' : '' ;
								?>
						</td>
					</tr>
					<?php

								// Store the current application ID so we can return it within the loop
								//$parent_post_id = $lead['id'];

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
						<td style="width: 80px;"><strong>Scheduled:</strong></td>
						<td valign="top">Yes<a></a>
						</td>
					</tr>
					<?php // Loop through theme
									while ( $get_events->have_posts() ) : $get_events->the_post();

										// Get an array of our event data
										$event_record = get_post_meta( get_the_ID() );

										// Setup the edit URL and add an edit link to the admin area
										$edit_event_url = get_edit_post_link();

										// Check that fields are set, and display them as needed.
										if ( ! empty( $event_record['mfei_day'][0] ) ) : ?>
					<tr <?php post_class(); ?>>
						<td style="width: 80px;" valign="top"><strong>Day:</strong></td>
						<td valign="top"><?php echo esc_html( $event_record['mfei_day'][0] ); ?></td>
					</tr>
					<?php endif; if ( ! empty( $event_record['mfei_start'][0] ) ) : ?>
					<tr class="&lt;?php post_class(); ?&gt;">
						<td style="width: 80px;" valign="top"><strong>Start
								Time:</strong></td>
						<td valign="top"><?php echo esc_html( $event_record['mfei_start'][0] ); ?></td>
					</tr>
					<?php endif; if ( ! empty( $event_record['mfei_stop'][0] ) ) : ?>
					<tr class="&lt;?php post_class(); ?&gt;">
						<td style="width: 80px;" valign="top"><strong>Stop
								Time:</strong></td>
						<td valign="top"><?php echo esc_html( $event_record['mfei_stop'][0] ); ?></td>
					</tr>
					<?php endif; if ( ! empty( $event_record['mfei_schedule_completed'][0] ) ) : ?>
					<tr class="&lt;?php post_class(); ?&gt;">
						<td style="width: 80px;" valign="top"><strong>Schedule
								Completed:</strong></td>
						<td valign="top"><?php echo esc_html( $event_record['mfei_schedule_completed'][0] ); ?></td>
					</tr>
					<?php endif; ?>
					<tr class="&lt;?php post_class(); ?&gt;">
						<td valign="top"><strong>Edit</strong></td>
						<td><a href="&lt;?php echo esc_url( $edit_event_url ); ?&gt;"
							class="button" target="_blank">Edit the Time and Date</a>
							<button href=""
								class="deleteme button-small button-secondary delete"
								data-key="mfei_record"
								data-nonce="&lt;?php echo esc_attr( wp_create_nonce( 'delete_scheduled_post' ) ); ?&gt;"
								data-postid="&lt;?php echo esc_attr( get_the_id() ); ?&gt;"
								data-value="&lt;?php echo esc_attr( $event_record['mfei_record'][0] ); ?&gt;"
								title="">Delete Scheduled Event</button></td>
					</tr>

					<?php endwhile; ?>
					<tr>
						<td style="width: 80px;" valign="top"><strong>Schedule:</strong><a></a></td>
						<td valign="top"><a
							href="&lt;?php echo admin_url(); ?&gt;post-new.php?post_type=event-items&amp;refer_id=&lt;?php echo absint( $entry_id ); ?&gt;">Schedule
								Another Event</a></td>
					</tr>
					<?php } else { ?>
					<tr>
						<td style="width: 80px;" valign="top"><strong>Scheduled:</strong><a></a></td>
						<td valign="top"><a
							href="&lt;?php echo admin_url(); ?&gt;post-new.php?post_type=event-items&amp;refer_id=&lt;?php echo $entry_id; ?&gt;">Schedule
								This Event</a></td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<?php				
} //end function







