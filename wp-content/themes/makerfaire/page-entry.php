<?php
/**
 * Template Name: Entry
 *
 * @version 2.0
 */

  global $wp_query;
  $entryId = $wp_query->query_vars['e_id'];
  $entry = GFAPI::get_entry($entryId);
  $makers = array();
  if (strlen($entry['160.3']) > 0) $makers[] = array('firstname' => $entry['160.3'], 'lastname' => $entry['160.6'], 'bio'=>$entry['234'], 'photo'=>$entry['217']);
  if (strlen($entry['158.3']) > 0) $makers[] = array('firstname' => $entry['158.3'], 'lastname' => $entry['158.6'], 'bio'=>$entry['258'], 'photo'=>$entry['224']);
  if (strlen($entry['155.3']) > 0) $makers[] = array('firstname' => $entry['155.3'], 'lastname' => $entry['155.6'], 'bio'=>$entry['259'], 'photo'=>$entry['223']);
  if (strlen($entry['156.3']) > 0) $makers[] = array('firstname' => $entry['156.3'], 'lastname' => $entry['156.6'], 'bio'=>$entry['260'], 'photo'=>$entry['222']);
  if (strlen($entry['157.3']) > 0) $makers[] = array('firstname' => $entry['157.3'], 'lastname' => $entry['157.6'], 'bio'=>$entry['261'], 'photo'=>$entry['220']);
  if (strlen($entry['159.3']) > 0) $makers[] = array('firstname' => $entry['159.3'], 'lastname' => $entry['159.6'], 'bio'=>$entry['262'], 'photo'=>$entry['221']);
  if (strlen($entry['154.3']) > 0) $makers[] = array('firstname' => $entry['154.3'], 'lastname' => $entry['154.6'], 'bio'=>$entry['263'], 'photo'=>$entry['219']);
  
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

<div class="container modal-fix">

  <div class="row">

    <div class="content span8">
      <?php 
        
      $url = wp_get_referer();    
      $path_parts = pathinfo($url);  
      if (strpos($url, 'topics') !== false) {
          echo '<a class="backLink" href="'. $url.'" target="_self">&#65513; Back to Topics: '.$path_parts['filename']. "</a>"; 
      }elseif (strpos($url, 'search') !== false) {
          echo '<a class="backLink" href="'. $url.'" target="_self">&#65513; Back to Search Results</a>';
      }else{
          echo '<a class="backLink" href="/bay-area-2015/meet-the-makers/">&#65513; Look for More Makers</a>';
      }
              
                      
        ?>
      <div class="page-header entryPage <?php echo ($entry['304.11']!=''?'blueRibbon ':'');echo ($entry['304.9']!=''?'redRibbon':'');?>">

        <h1><?php echo $entry['151']; ?></h1>

      </div>

      <img class="img-responsive padbottom" src="<?php echo $entry['22']; ?>" />

      <p class="lead"><?php echo $project_short; ?></p> 

      <?php if (!empty($project_website)) {
          echo '<a href="' . $project_website . '" class="btn btn-info pull-left" target="_blank" style="margin-right:15px;">Project Website</a>';
      } ?>
      
      <!-- Button to trigger video modal -->
      <?php if (!empty($project_video)) {
          echo '<a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Project Video</a>';
      } ?>
      <div class="clearfix">&nbsp;</div>

      <!-- Video Modal -->
      <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel"><?php echo $entry['151']; ?></h3>
        </div>
        <div class="modal-body">
          
           <?php  
           $dispVideo = str_replace('//vimeo.com','//player.vimeo.com/video',$project_video);
           //youtube has two type of url formats we need to look for and change
           $videoID = parse_yturl($dispVideo);
           if($videoID!=''){
               $dispVideo = 'https://www.youtube.com/embed/'.$videoID;
           }
           ?>
            <iframe src="<?php echo $dispVideo; ?>" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>
      </div>
      <div class="clearfix">&nbsp;</div>

      <?php
        if (!empty(display_entry_schedule($entryId))) {
          display_entry_schedule($entryId);
        }
      ?>
      <div class="clearfix">&nbsp;</div>
      
      <h2>Makers/Group</h2>
      <hr />
      <?php
      if (!empty($groupbio)) {
        echo '<div class="row padbottom">
                ',(!empty($groupphoto) ? '<img class="span3 pull-left" src="' . $groupphoto . '" alt="Group Image">' : '<img class="span3 pull-left" src="' . get_stylesheet_directory_uri() . '/images/maker-placeholder.jpg" alt="Group Image">');
        echo    '<div class="span5">
                  <h3 style="margin-top: 0px;">' . $groupname . '</h3>
                  <p>' . $groupbio . '</p>
                </div>
              </div>';
      } 
      else {
        foreach($makers as $maker) {
          echo '<div class="row padbottom">
                  ',(!empty($maker['photo']) ? '<img class="span3 pull-left" src="' . $maker['photo'] . '" alt="Maker Image">' : '<img class="span3 pull-left" src="' . get_stylesheet_directory_uri() . '/images/maker-placeholder.jpg" alt="Maker Image">');
          echo    '<div class="span5">
                    <h3 style="margin-top: 0px;">' . $maker['firstname'] . ' ' . $maker['lastname'] . '</h3>
                    <p>' . $maker['bio'] . '</p>
                  </div>
                </div>';
        }
      }
      ?>

    </div><!--span8-->

    <?php get_sidebar(); ?>

  </div><!--row-->

</div><!--container-->


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
  echo ('<link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>');
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  $query_text = sprintf("SELECT `wp_mf_schedule`.`ID`,
    `wp_mf_schedule`.`entry_id`,
    `wp_mf_schedule`.`location_id`,
    `wp_mf_schedule`.`faire`,
    `wp_mf_schedule`.`start_dt`,
    `wp_mf_schedule`.`end_dt`,
   DAYNAME(`wp_mf_schedule`.`start_dt`) AS `day`,
	    `wp_mf_location`.`area`,`wp_mf_location`.`subarea`
  FROM `wp_mf_schedule`
  left outer join `wp_mf_location` on `wp_mf_schedule`.`entry_id`= `wp_mf_location`.`entry_id`
	where `wp_mf_schedule`.`entry_id`=$entry_id");
  $result = $mysqli->query($query_text);
  if ($result)
  {
    if ($result->num_rows === 0) echo '';
    else 
    {
    	echo ' <h2>Schedule</h2>  <hr />';
    	$schedule_area = '';
    	$schedule_subarea = '';
    while($row = $result->fetch_row())
    {
      //NOTE: This will need to be changed for future logic when more than one area and subarea could be assigned.
      $schedule_area = $row[7];
      $schedule_subarea=$row[8];
      $start_dt = strtotime( $row[4]);
      $end_dt = strtotime($row[5]);
      
      $schedule_time_start = date('h:i A', strtotime( '0 hour',  $start_dt ) );
      $schedule_time_end = date('h:i A', strtotime( '0 hour', $end_dt ) );
      $schedule_day = $row[6];
      
      $schedule_entry_id = $row[0];
      $schedule_list .= ('<li style="margin: 0; padding: 0;">'.$schedule_day.' : '. $schedule_time_start.' to '.$schedule_time_end.'</li>');
    }
    echo '<h4>'.$schedule_area.' '.$schedule_subarea.'';
    echo '<ul class="unstyled" style="margin: 0; padding: 0;">'.$schedule_list.'</ul></h4>';
    }
  }
}
?>