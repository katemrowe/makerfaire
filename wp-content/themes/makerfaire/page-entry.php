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

<div class="clear"></div>

<div class="container">

  <div class="row">

    <div class="content span8">

      <div class="page-header">

        <h1><?php echo $entry['151']; ?></h1>
        <hr />

      </div>

      <img class="img-responsive" src="<?php echo $entry['22']; ?>" />

      <p class="lead"><?php echo $project_short; ?></p> 

      <?php if (isset($project_website)) {
          echo '<a href="' . $project_website . '" class="btn btn-info pull-left padright" target="_blank">Project Website</a>';
      } ?>

      <!-- Button to trigger video modal -->
      <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Project Video</a>
       
      <!-- Modal -->
      <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel"><?php echo $entry['151']; ?></h3>
        </div>
        <div class="modal-body">
          <iframe src="<?php echo str_replace('//vimeo.com','//player.vimeo.com/video',$project_video); ?>" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> 
        </div>
      </div>
      <br />

      <h2>Schedule</h2>
      <hr />
      <?php
        if (!empty(display_entry_schedule($entryId))) {
          display_entry_schedule($entryId);
        }
      ?>
      <br />
      
      <h2>Makers/Group</h2>
      <hr />
      <?php 
      if (isset($groupbio)) {
        echo '<div class="row padbottom">
                <div class="12">
                  <img class="span4 pull-left" src="' . echo $groupphoto . '" alt="Maker Profile Image">
                  <div class="span8">
                    <h3 style="margin-top: 0px;">' . echo $groupname . '</h3>
                    <p>' . echo $groupbio . '</p>
                  </div>
                </div>
              </div>';
      } 
      else {
        echo '<!-- Need to loop through the Makers 1-7... -->
              <div class="row padbottom">
                <img class="span4 pull-left" src="' . echo $makerphoto1 . '" alt="Maker Profile Image">
                <div class="span8">
                  <h3 style="margin-top: 0px;">' . echo $makerfirstname1 . ' ' . echo $makerlastname1 . '</h3>
                  <p>' . echo $makerbio1 . '</p>
                </div>
              </div>';
      }
      ?>

    </div><!--Content-->

    <?php get_sidebar(); ?>

  </div>

</div><!--Container-->


<!-- What do i do with these?
Duplicate to $project_website;
<p>Homepage: <i><?php echo $entry['27']; ?></i></p>

Duplicate $entry['22']
<li>Project Photo: <?php echo $project_photo; ?></li> 

Duplicate to $entry['151']
<li>Short Desription<?php echo $entry['16']; ?></li>
-->

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