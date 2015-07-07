<?php
// Adding Entry Detail and checking for Processing Posts

add_action("gform_entry_detail_content_before", "add_main_text_before", 10, 2);
function add_main_text_before($form, $lead){
	$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
	if ($mode != "view") return;
	echo gf_summary_metabox($form, $lead);
        echo gf_collapsible_sections($form, $lead);
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
$size_request = $lead['60'];
$size_request_other = $lead['61'];
$entry_form_type = $form['title'];
$entry_form_status = $lead['303'];
$wkey = $lead['27'];
$vkey = $lead['32'];

$makerfirstname1=$lead['160.3'];$makerlastname1=$lead['160.6'];
$makerPhoto1    =$lead['217'];
$makerfirstname2=$lead['158.3'];$makerlastname2=$lead['158.6'];
$makerPhoto2    =$lead['224'];
$makerfirstname3=$lead['155.3'];$makerlastname3=$lead['155.6'];
$makerPhoto3    =$lead['223'];
$makerfirstname4=$lead['156.3'];$makerlastname4=$lead['156.6'];
$makerPhoto4    =$lead['222'];
$makerfirstname5=$lead['157.3'];$makerlastname5=$lead['157.6'];
$makerPhoto5    =$lead['220'];
$makerfirstname6=$lead['159.3'];$makerlastname6=$lead['159.6'];
$makerPhoto6    =(isset($lead['221'])?$lead['221']:'');
$makerfirstname7=$lead['154.3'];$makerlastname7=$lead['154.6'];
$makerPhoto7    =(isset($lead['219'])?$lead['219']:'');
$makergroupname=$lead['109'];
$field55=RGFormsModel::get_field($form,'55');
$whatareyourplansvalues=$field55['choices'];

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
			<td style="width:440px; padding:5px;" valign="top">
				<a href="<?php echo $photo;?>" class='thickbox'>
				<img width="400px" src="<?php echo legacy_get_resized_remote_image_url($photo, 400,400);?>" alt="" /></a>
			</td>
			<td style="width:340px" valign="top">
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
                                                <?php if(!empty($makerPhoto1)){?>  
                                                    <a href="<?php echo $makerPhoto1;?>" class='thickbox'>
                                                    <img width="30px" src="<?php echo legacy_get_resized_remote_image_url($makerPhoto1, 30,30);?>" alt="" />
                                                    </a>
                                                <?php  }?>    
						<?php echo !empty($makerfirstname1) ?  $makerfirstname1.' '.$makerlastname1.'</br>' : '' ; ?>
						<?php if(!empty($makerPhoto2)){?>  
                                                    <a href="<?php echo $makerPhoto2;?>" class='thickbox'>
                                                    <img width="30px" src="<?php echo legacy_get_resized_remote_image_url($makerPhoto2, 30,30);?>" alt="" />
                                                    </a>
                                                <?php  }?> 
                                                <?php echo !empty($makerfirstname2) ?  $makerfirstname2.' '.$makerlastname2.'</br>' : '' ; ?>
                                                <?php if(!empty($makerPhoto3)){?>  
                                                    <a href="<?php echo $makerPhoto3;?>" class='thickbox'>
                                                    <img width="30px" src="<?php echo legacy_get_resized_remote_image_url($makerPhoto3, 30,30);?>" alt="" />
                                                    </a>
                                                <?php  }?>     
						<?php echo !empty($makerfirstname3) ?  $makerfirstname3.' '.$makerlastname3.'</br>' : '' ; ?>
                                                <?php if(!empty($makerPhoto4)){?>  
                                                    <a href="<?php echo $makerPhoto4;?>" class='thickbox'>
                                                    <img width="30px" src="<?php echo legacy_get_resized_remote_image_url($makerPhoto4, 30,30);?>" alt="" />
                                                    </a>
                                                <?php  }?>     
						<?php echo !empty($makerfirstname4) ?  $makerfirstname4.' '.$makerlastname4.'</br>' : '' ; ?>
                                                <?php if(!empty($makerPhoto5)){?>  
                                                    <a href="<?php echo $makerPhoto5;?>" class='thickbox'>
                                                    <img width="30px" src="<?php echo legacy_get_resized_remote_image_url($makerPhoto5, 30,30);?>" alt="" />
                                                    </a>
                                                <?php  }?>     
						<?php echo !empty($makerfirstname5) ?  $makerfirstname5.' '.$makerlastname5.'</br>' : '' ; ?>
                                                <?php if(!empty($makerPhoto6)){?>  
                                                    <a href="<?php echo $makerPhoto6;?>" class='thickbox'>
                                                    <img width="30px" src="<?php echo legacy_get_resized_remote_image_url($makerPhoto6, 30,30);?>" alt="" />
                                                    </a>
                                                <?php  }?>     
						<?php echo !empty($makerfirstname6) ?  $makerfirstname6.' '.$makerlastname6.'</br>' : '' ; ?>
                                                <?php if(!empty($makerPhoto7)){?>  
                                                    <a href="<?php echo $makerPhoto7;?>" class='thickbox'>
                                                    <img width="30px" src="<?php echo legacy_get_resized_remote_image_url($makerPhoto7, 30,30);?>" alt="" />
                                                    </a>
                                                <?php  }?>     
						<?php echo !empty($makerfirstname7) ?  $makerfirstname7.' '.$makerlastname7.'</br>' : '' ; ?>
												
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
					<tr>
						<td valign="top"><strong>Size Request:</strong></td>
						<td>
						<?php echo ( isset( $size_request ) ) ? $size_request : 'Not Filled out' ; ?>
						<?php echo ( isset( $size_request_other ) ) ? 'Other: '.$size_request_other : '' ; ?>
						</td>
					</tr>
					
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<label >Email Note To:</label><br />
				<?php 
				$emailto1 = array("Alasdair Allan"          => "alasdair@makezine.com",
                                                  "Brian Jepson"            => "bjepson@makermedia.com",
                                                  "Bridgette Vanderlaan"    => "bvanderlaan@mac.com",
                                                  "Dale Dougherty"          => "dale@makermedia.com",
                                                  "DC Denison"              => "dcdenison@makermedia.com",
                                                  "Jason Babler"            => "jbabler@makermedia.com",
                                                  "Jay Kravitz"             => "jay@thecrucible.org",
                                                  "Jess Hobbs"              => "jess@makermedia.com",
                                                  "Jonathan Maginn"         => "jonathan.maginn@sbcglobal.net",
                                                  "Kate Rowe"               => "krowe@makermedia.com",
                                                  "Kerry Moore"             => "kerry@contextfurniture.com");
$emailto2 = array(
		"Kim Dow" => "dow@dowhouse.com",
		"Louise Glasgow" => "lglasgow@makermedia.com",
		"Michelle Hlubinka" => "mhlubinka@makermedia.com",
		"Miranda Mota" => "miranda@makermedia.com",
		"Nick Normal" => "nicknormal@gmail.com",
		"Rob Bullington" => "rbullington@makermedia.com",
		"Sabrina Merlo" => "smerlo@makermedia.com",
		"Sherry Huss" => "sherry@makermedia.com",
		"Tami Jo Benson" => "tj@tamijo.com",
		"Travis Good" => "travisgood@gmail.com");

$emailtoaliases = array(
		"Editors" => "editor@makezine.com",
		"Maker Relations" => "makers@makerfaire.com",
		"Marketing" => "marketing@makermedia.com",
		"PR" => "pr@makerfaire.com",
		"Shed" => "shedmakers@makermedia.com",
		"Education" => "education@makermedia.com",
		"Sales" => "sales@makerfaire.com",
		"MakerCon" => "makercon@makermedia.com");
				?>
				<div style="float:left">
				<?php foreach ( $emailtoaliases as $name => $email ) { 
					echo('<input type="checkbox"  name="gentry_email_notes_to_sidebar[]" style="margin: 3px;" value="'.$email.'" /><strong>'.$name.'</strong> <br />');
					 } ?> 
					 </div>
			   <div style="float:left">
				<?php foreach ( $emailto1 as $name => $email ) { 
					echo('<input type="checkbox"  name="gentry_email_notes_to_sidebar[]" style="margin: 3px;" value="'.$email.'" />'.$name.'<br />');
					 } ?> 
					 </div>
			   <div style="float:left">
				<?php foreach ( $emailto2 as $name => $email ) { 
					echo('<input type="checkbox"  name="gentry_email_notes_to_sidebar[]" style="margin: 3px;" value="'.$email.'" />'.$name.' <br />');
					 } ?>
				</div>
				</td>
			<td style="vertical-align: top; padding: 10px;"><textarea
					name="new_note_sidebar"
					style="width: 90%; height: 140px;" cols=""
					rows=""></textarea> 
					<?php
						$note_button = '<input type="submit" name="add_note_sidebar" value="' . __( 'Add Note', 'gravityforms' ) . '" class="button" style="width:auto;padding-bottom:2px;" onclick="jQuery(\'#action\').val(\'add_note_sidebar\');"/>';
						echo apply_filters( 'gform_addnote_button', $note_button );	?>
			</td>
		</tr>
	</tbody>
</table>
<?php				
} //end function

function gf_collapsible_sections($form, $lead){
    /*
     * 1. Content
Include field IDs:
11 [Tell us about your project and exhibit.]
16 [Provide a short description for our website, mobile app, and your sign.]
2. Logistics
Include field IDs:
60 [Space Size Request]
61 [Other: List the specific dimensions (__ft x __ft ) and provide additional details about the size of space you require.]
62 [Tables and Chairs]
288 [How many tables and chairs?]
     */
   
    $fieldLabel = array();
    foreach($form['fields'] as $field){
        $fieldData[$field['id']] = $field;
    }
    
    $data = array('content'=> array(11,16,320,321),
                  'logistics'=>array(60,61,62,288),
        );
    ?>
    <table class="widefat fixed entry-detail-view" cellspacing="0">
        <tr><td class="entry-view-collapse"><span onclick="jQuery('#entryContent').toggle();">Content</span></td></tr>
        <tr id="entryContent" style="display:none"><td>
                <table class="widefat fixed entry-detail-view" cellspacing="0">
                    <?php echo displayContent($data['content'],$lead,$fieldData);?>                
                </table>    
         </td></tr>

        <tr><td class="entry-view-collapse"><span onclick="jQuery('#entryLogistics').toggle();">Logistics/Production</span></td></tr>
        <tr id="entryLogistics" style="display:none">
            <td><table class="widefat fixed entry-detail-view" cellspacing="0">
                <?php echo displayContent($data['logistics'],$lead,$fieldData);?>                      
                </table>   
            </td>
        </tr>
        <!--
        <tr><td class="entry-view-collapse"><span onclick="jQuery('#makerInfo').toggle();">Maker Information</span></td></tr>
        <tr id="makerInfo" style="display:none"><td>Maker Information goes here</td></tr>
        <tr><td class="entry-view-collapse"><span onclick="jQuery('#entryMisc').toggle();">Misc</span></td></tr>
        <tr id="entryMisc" style="display:none"><td>Misc goes here</td></tr>-->
    </table>
    <?php
}

function displayContent($content,$lead,$fieldData){
   $return = '';
    foreach($content as $fieldID){
        $field = $fieldData[$fieldID];
        $label = $fieldData[$fieldID]['label'];
        $value = (isset($lead[$fieldID])?$lead[$fieldID]:'');
        $value =  setTaxName($value, $field, $lead, array());
        $return .= '<tr><td  class="entry-view-field-name" colspan="2">'.$label.'</td></tr>'.
                    '<tr><td>'.$value.'</td></tr>';
   }
   return $return;
}







