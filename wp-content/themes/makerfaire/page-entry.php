<?php
/**
 * Template Name: Entry
 *
 * @version 2.0
 */

  global $wp_query;
  $entryId = $wp_query->query_vars['e_id'];
  $entry = GFAPI::get_entry($entryId);
  
  $makerfirstname1=$entry['160.3'];$makerlastname1=$entry['160.6'];
  $makerfirstname2=$entry['158.3'];$makerlastname2=$entry['158.6'];
  $makerfirstname3=$entry['155.3'];$makerlastname3=$entry['155.6'];
  $makerfirstname4=$entry['156.3'];$makerlastname4=$entry['156.6'];
  $makerfirstname5=$entry['157.3'];$makerlastname5=$entry['157.6'];
  $makerfirstname6=$entry['159.3'];$makerlastname6=$entry['159.6'];
  $makerfirstname7=$entry['154.3'];$makerlastname7=$entry['154.6'];
  
  $makerbio1=$entry['234'];
  $makerphoto1=$entry['217'];
  $makerbio2=$entry['258'];
  $makerphoto2=$entry['224'];
  $makerbio3=$entry['259'];
  $makerphoto3=$entry['223'];
  $makerbio4=$entry['260'];
  $makerphoto4=$entry['222'];
  $makerbio5=$entry['261'];
  $makerphoto5=$entry['220'];
  $makerbio6=$entry['262'];
  $makerphoto6=$entry['221'];
  $makerbio7=$entry['263'];
  $makerphoto7=$entry['219'];
  
  $groupname=$entry['109'];
  $groupphoto=$entry['111'];
  $groupbio=$entry['110'];
  
  $project_name = $entry['151']; 
  $project_photo = $entry['22'];
  $project_short = $entry['16'];
  $project_website = $entry['27'];
  $project_video = $entry['32'];
  
  get_header();
?>
<div style="margin-left: 100px">
<img src="<?php echo $entry['22']; ?>" style="width: 300px;"/>
<h1><?php echo $entry['151']; ?></h1>
<p>Homepage: <i><?php echo $entry['27']; ?></i></p>

<h1>Title and Photo</h1>
<ul>
<li>Project Photo: <?php echo $project_photo; ?></li> 
<li>Short Description: <?php echo $project_short; ?></li> 
<li>Project Website: <?php echo $project_website; ?></li> 
<li>Project Video: 
<iframe src="<?php echo $project_video; ?>" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> 

</li> 
<li>Short Desription<?php echo $entry['16']; ?></li>


</ul>
<h1>Schedule Info</h1>
	<?php display_entry_schedule($entryId);?>


<h1>Maker / Group</h1>
	
<li>Maker 1 Name: <?php echo $makerfirstname1; ?> <?php echo $makerlastname1; ?></li>
<li>$makerbio1: <?php echo $makerbio1; ?></li>
<li>$makerphoto1: <?php echo $makerphoto1; ?></li>
<li>Maker 2 Name: <?php echo $makerfirstname2; ?> <?php echo $makerlastname2; ?></li>
<li>$makerbio2: <?php echo $makerbio2; ?></li>
<li>$makerphoto2: <?php echo $makerphoto2; ?></li>
<li>Maker 3 Name: <?php echo $makerfirstname3; ?> <?php echo $makerlastname3; ?></li>
<li>$makerbio3: <?php echo $makerbio3; ?></li>
<li>$makerphoto3: <?php echo $makerphoto3; ?></li>
<li>Maker 4 Name: <?php echo $makerfirstname4; ?> <?php echo $makerlastname4; ?></li>
<li>$makerbio4: <?php echo $makerbio4; ?></li>
<li>$makerphoto4: <?php echo $makerphoto4; ?></li>
<li>Maker 5 Name: <?php echo $makerfirstname5; ?> <?php echo $makerlastname5; ?></li>
<li>$makerbio5: <?php echo $makerbio5; ?></li>
<li>$makerphoto5: <?php echo $makerphoto5; ?></li>
<li>Maker 6 Name: <?php echo $makerfirstname6; ?> <?php echo $makerlastname6; ?></li>
<li>$makerbio6: <?php echo $makerbio6; ?></li>
<li>$makerphoto6: <?php echo $makerphoto6; ?></li>
<li>Maker 7 Name: <?php echo $makerfirstname7; ?> <?php echo $makerlastname7; ?></li>
<li>$makerbio7: <?php echo $makerbio7; ?></li>
<li>$makerphoto7: <?php echo $makerphoto7; ?></li>









<li>$groupname: <?php echo $groupname; ?></li>
<li>$groupphoto: <?php echo $groupphoto; ?></li>
<li>$groupbio: <?php echo $groupbio; ?></li>
</ul>

</div>

 <?php get_footer();

 
function display_entry_schedule($entry_id) {
	echo ('<link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>
			<h4><label class="detail-label">Schedule:</label></h4>');
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$result = $mysqli->query("SELECT `wp_mf_schedule`.`ID`,
    `wp_mf_schedule`.`entry_id`,
    `wp_mf_schedule`.`location_id`,
    `wp_mf_schedule`.`faire`,
    `wp_mf_schedule`.`start_dt`,
    `wp_mf_schedule`.`end_dt`,
    `wp_mf_schedule`.`day`
	FROM `wp_mf_schedule` where entry_id=$entry_id");

	if ($result)
	{
		if ($result->num_rows === 0) echo 'No schedule found';
		else 
		{
		echo '<ul>';
		while($row = $result->fetch_row())
		{
			$start_dt = strtotime( $row[4]);
			$end_dt = strtotime($row[5]);
			$schedule_entry_id = $row[0];
			echo ('<li>'.date("l",$start_dt).': '. date("H:i:s",$start_dt).' to '.date("H:i:s",$end_dt).'</li>');
			
		}
		echo '</ul>';
		}
	}
}
?>

