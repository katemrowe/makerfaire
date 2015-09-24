<?php
/**
 * Template Name: Entry
 *
 * @version 2.0
 */

  global $wp_query;
  $entryId = $wp_query->query_vars['e_id'];
  $entry = GFAPI::get_entry($entryId);
  
  //find outwhich faire this entry is for to set the 'look for more makers link'
  $form_id = $entry['form_id'];
  $formSQL = "select replace(lower(faire_name),' ','-') as faire_name, faire from wp_mf_faire where FIND_IN_SET ($form_id, wp_mf_faire.form_ids)> 0";
  $results =  $wpdb->get_row( $formSQL );
  $faire   =  $slug = $results->faire_name;
  $faireID = $results->faire;
  
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
  $project_title = (string)$entry['151'];
  
  $project_title  = preg_replace('/\v+|\\\[rn]/','<br/>',$project_title);
  
  get_header();
?>

<div class="clear"></div>

<div class="container modal-fix">

  <div class="row">

    <div class="content col-md-8">
<?php $url = parse_url(wp_get_referer()); //getting the referring URL   
      $url['path'] = rtrim($url['path'], "/"); //remove any trailing slashes
      $path = explode("/", $url['path']); // splitting the path
      $slug = end($path); // get the value of the last element 
      
      if($slug=='schedule'){     
          $backlink = wp_get_referer();
          $backMsg = '&#65513; Back to the Schedule';
      }else{
          $backlink = "/".$faire."/meet-the-makers/";
          $backMsg = '&#65513; Look for More Makers';
      }
?>
      <a href="<?php echo $backlink;?>"><?php echo $backMsg;?></a>

      <div class="page-header">

        <h1><?php echo $project_title; ?></h1>

      </div>

      <img class="img-responsive padbottom" src="<?php echo $project_photo; ?>" />

      <p class="lead"><?php echo nl2br(make_clickable($project_short)); ?></p> 

      <?php if (!empty($project_website)) {
          echo '<a href="' . $project_website . '" class="btn btn-info pull-left" target="_blank" style="margin-right:15px;">Project Website</a>';
      } ?>
      
      <!-- Button to trigger video modal -->
      <?php if (!empty($project_video)) {
          echo '<a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Project Video</a>';
      } ?>
      <br />

      <!-- Video Modal -->
      <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
      <div class="clearfix">&nbsp;</div>
      <h2>Makers/Group</h2>
      <hr />
      <?php
      if (!empty($groupbio)) {
        echo '<div class="row padbottom">
                ',(!empty($groupphoto) ? '<img class="col-md-3 pull-left img-responsive" src="' . $groupphoto . '" alt="Group Image">' : '<img class="col-md-3 pull-left img-responsive" src="' . get_stylesheet_directory_uri() . '/images/maker-placeholder.jpg" alt="Group Image">');
        echo    '<div class="col-md-5">
                  <h3 style="margin-top: 0px;">' . $groupname . '</h3>
                  <p>' . make_clickable($groupbio) . '</p>
                </div>
              </div>';
      } 
      else {
    		foreach($makers as $maker) {
      		echo '<div class="row padbottom">
                  ',(!empty($maker['photo']) ? '<img class="col-md-3 pull-left img-responsive" src="' . $maker['photo'] . '" alt="Maker Image">' : '<img class="col-md-3 pull-left img-responsive" src="' . get_stylesheet_directory_uri() . '/images/maker-placeholder.jpg" alt="Maker Image">');
          echo    '<div class="col-md-5">
                    <h3 style="margin-top: 0px;">' . $maker['firstname'] . ' ' . $maker['lastname'] . '</h3>
                    <p>' . make_clickable($maker['bio']) . '</p>
                  </div>
                </div>';
    		}
      }
      ?>

      <?php
        if (!empty(display_entry_schedule($entryId))) {
          display_entry_schedule($entryId);
        }
      ?>
      <br />

      
    </div><!--col-md-8-->

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
  global $wpdb;global $faireID; global $faire;

  $sql = "select location.entry_id, area.area, subarea.subarea,location.location, schedule.start_dt, schedule.end_dt
            from  wp_mf_location location 
            join  wp_mf_faire_subarea subarea 
                            ON  location.subarea_id = subarea.ID
            join wp_mf_faire_area area
                            ON subarea.area_id = area.ID and area.faire_id = 2
            left join wp_mf_schedule schedule
                    on location.ID = schedule.location_id
             where location.entry_id=$entry_id"
          . " group by area, subarea, location";
  $results = $wpdb->get_results($sql);
        echo '<table>';
        if($wpdb->num_rows > 0){
            ?>
      <h2>Location at <?php echo (strpos($faireID,'NY')!== false?'World':'');?> Maker Faire <?php echo ucwords(str_replace('-',' ', $faire));?></h2>
      <hr />
            <?php
            foreach($results as $row){    
                echo '<tr><td style="padding:0 10px">'.$row->area.'</td><td style="padding:0 10px">'.$row->subarea.'</td>';
                if(!is_null($row->start_dt)){
                    $start_dt   = strtotime( $row->start_dt);
                    $end_dt     = strtotime($row->end_dt);
                    echo '<td style="padding:0 10px">'.date("m/j/y",$start_dt).'</td><td style="padding:0 10px">'. date("g:i a",$start_dt).' to '.date("g:i a",$end_dt).'</td>';
                }
                echo '</tr>';
            }
        }    
        echo '</table>';
}
?>