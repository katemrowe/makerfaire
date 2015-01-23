<?php
add_action("gform_entry_detail_content_before", "add_main_text_before", 10, 2);
function add_main_text_before($form, $lead){
	
	echo gf_summary_metabox($form, $lead);
	
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

$photo = $lead['22'];
$short_description = $lead['16'];
$long_description = $lead['21'];
$project_name = $lead['151'];
$entry_form_type = '';
$entry_form_status = '';
$is_commercialmaker = '';
$commercialmaker_sales = '';
$wkey = 'https://makezineblog.files.wordpress.com/2015/01/unisphere-final-exp.mp4';//$this->merge_fields( 'project_website', $data->form_type );
$vkey = 'https://makezineblog.files.wordpress.com/2015/01/unisphere-final-exp.mp4';//$this->merge_fields( 'project_video', $data->form_type );
$data->project_video;


$main_description = '';

// Check if we are loading the public description or a short description
if ( isset( $long_description ) ) {
	$main_description = $long_description;
} else if ( isset($short_description ) ) {
	$main_description = $short_description;
}
?>
			<h1><?php echo esc_html($project_name); ?></h1>
			<table class="widefat fixed entry-detail-view">
				<tr>
					<td style="width:210px;" valign="top"><img src="<?php echo esc_url($photo);// get_resized_remote_image_url( $photo, 200, 200 ) ); ?>" width="200" height="200" /></td>
					<td valign="top">
						<p><?php echo Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $main_description, "\n" ) ) ) ); ?></p>
						<table style="width:100%">
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
								<td valign="top"><a href="<?php echo esc_url( $data->{ $wkey } ); ?>" target="_blank"><?php echo esc_url( $data->{ $wkey } ); ?></a></td>
							</tr>
							<tr>
							<td valign="top"><strong>Video:</strong></td>
								<?php
								  echo ( isset( $entry_project_video ) ) ? '<td valign="top"><a href="' . esc_url( $entry_project_video ) . '" target="_blank">' . esc_url( $entry_project_video ) . '</a></td>' : null ;
								  echo ( isset( $entry_performer_video ) ) ? '<td valign="top"><a href="' . esc_url( $entry_performer_video ) . '" target="_blank">' . esc_url( $entry_performer_video ) . '</a></td>' : null ;
								  echo ( isset( $entry_video ) ) ? '<td valign="top"><a href="' . esc_url( $entry_video ) . '" target="_blank">' . esc_url( $entry_video ) . '</a></td>' : '<td></td>' ;
								?>
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
											'value'	=> $post->ID
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
										<td valign="top"><a href="<?php echo admin_url(); ?>post-new.php?post_type=event-items&amp;refer_id=<?php echo absint( $parent_post_id ); ?>">Schedule Another Event</a></td>
									</tr>
								<?php } else { ?>
									<tr>
										<td style="width:80px;" valign="top"><strong>Scheduled:</strong></a></td>
										<td valign="top"><a href="<?php echo admin_url(); ?>post-new.php?post_type=event-items&amp;refer_id=<?php echo get_the_ID(); ?>">Schedule This Event</a></td>
									</tr>
								<?php }
							?>
							<tr>
								<td style="width:80px;" valign="middle"><strong>MF Video:</strong></td>
								<td valign="top">
									<input type="text" id="video-coverage" name="video-coverage" style="width:25%;" value="<?php echo !empty( $event_record['mfei_coverage'][0] ) ? esc_url( $event_record['mfei_coverage'][0] ) : ''; ?>" />
									<input type="hidden" name="event-id" value="<?php echo get_the_ID(); ?>" />
								</td>
							</tr>
							<tr>
								<td valign="top"><strong>JDB Sync:</strong></td>
								<td valign="top"><?php echo esc_html( $jdb ); ?></td>
							</tr>
						</table>
						</td>
					</tr>
					</table>
					
					<?php
					
} //end function