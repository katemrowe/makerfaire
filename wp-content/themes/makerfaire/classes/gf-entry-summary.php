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

$makerfirstname1=$lead['160.3'];$makerlastname1=$lead['160.6'];
$makerfirstname2=$lead['158.3'];$makerlastname2=$lead['158.6'];
$makerfirstname3=$lead['155.3'];$makerlastname3=$lead['155.6'];
$makerfirstname4=$lead['156.3'];$makerlastname4=$lead['156.6'];
$makerfirstname5=$lead['157.3'];$makerlastname5=$lead['157.6'];
$makerfirstname6=$lead['159.3'];$makerlastname6=$lead['159.6'];
$makerfirstname7=$lead['154.3'];$makerlastname7=$lead['154.6'];
$makergroupname=$lead['109'];
$field55=RGFormsModel::get_field($form,'55');
$whatareyourplansvalues=$field55['choices'];
foreach($location_change as $location_entry)


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
			<td valign="top">
				<a href="<?php echo legacy_get_resized_remote_image_url($photo, 200,200);?>" class='thickbox'>
				<img src="<?php echo legacy_get_resized_remote_image_url($photo, 20,200);?>" alt="" /></a>
			</td>
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
					<tr>
						<td style="width: 80px;" valign="top"><strong>Maker Names:</strong></td>
						<td valign="top"><?php echo !empty($makergroupname) ? $makergroupname.'(Group)</br>' : ''; ?> 
						<?php echo !empty($makerfirstname1) ?  $makerfirstname1.' '.$makerlastname1.'</br>' : '' ; ?>
						<?php echo !empty($makerfirstname2) ?  $makerfirstname2.' '.$makerlastname2.'</br>' : '' ; ?>
						<?php echo !empty($makerfirstname3) ?  $makerfirstname3.' '.$makerlastname3.'</br>' : '' ; ?>
						<?php echo !empty($makerfirstname4) ?  $makerfirstname4.' '.$makerlastname4.'</br>' : '' ; ?>
						<?php echo !empty($makerfirstname5) ?  $makerfirstname5.' '.$makerlastname5.'</br>' : '' ; ?>
						<?php echo !empty($makerfirstname6) ?  $makerfirstname6.' '.$makerlastname6.'</br>' : '' ; ?>
						<?php echo !empty($makerfirstname7) ?  $makerfirstname6.' '.$makerlastname7.'</br>' : '' ; ?>
												
</td>
					</tr>
					<tr>
						<td style="width: 80px;" valign="top"><strong>What are your plans:</strong></td>
						
						
						<td valign="top">
						<?php 
						for ($i=0; $i < count($whatareyourplansvalues); $i++)
						{	
							echo (!empty($lead['55.'.$i])) ? $lead['55.'.$i].'<br />' : '';
						}
?>
												
</td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<?php				
} //end function







