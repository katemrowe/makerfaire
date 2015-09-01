<?php

/* 
 * This page outputs the html for the faire signs and then calls a process to 
 * convert it to a PDF
 */
ob_clean();

?>
<html style="width:1056px">
    <head>
    <style>
        @font-face {
            font-family: 'Benton Sans';
            src: url("<?php echo TEMPLATEPATH;?>/fonts/admin/bentonsans-regular-webfont.ttf");
        }
        /*
        @font-face {
            font-family: 'Benton Sans';
            src: url("/bentonsans-bold-webfont.ttf");
            font-weight: bold;
        }*/
        @media print {
            @page {
                size: A3 portrait;
                margin: 0.5cm;
            }
        }

        body{font-family: 'Benton Sans';}
        .entry-id{padding-left:900px;color:#A8AAAC}
        .proj-title{padding-top: 120px;font-size: 64px;font-weight: bold;}
        .middle{padding:30px;}
        .proj-img{float:left; width:47%;padding-top:30px;    max-height: 500px;overflow: hidden;}
        .proj-desc{font-size:30;float:right; width:47%;padding-top:30px;}
        .bio{font-size:24px;}
        .name{padding-top: 40px;font-size:48px;color:#00AEEF;font-weight:bold}
    </style>
    </head>
    <body>
<?php
$search_criteria['status'] = 'active';
$search_criteria['field_filters'][] = array( 'key' => '303', 'value' => 'Accepted');
$rec_limit = 300;
$page= (isset($_GET['paged'])?$_GET['paged']:1);
$offset = ($page-1) * $rec_limit;
$entries = GFAPI::get_entries( 25, $search_criteria, null, array('offset' => $offset, 'page_size' =>$rec_limit) );
foreach($entries as $entry){
    ?>
    <div style="background:url('http://makerfaire.com/wp-content/themes/makerfaire/images/maker_sign.png')  no-repeat right top;background-size: 1056px 1632px;padding-top:50px;padding-top: 80px;height: 1632px;">
    <?php   createOutput($entry);?>
    </div>
   <p style="page-break-after:always;"></p> 
    <?php
}        
?>
    </body>
</html>
<?php
function createOutput($entry){    
    $makers = array();
    if (strlen($entry['160.3']) > 0) $makers[] = $entry['160.3'] . ' ' .$entry['160.6'];
    if (strlen($entry['158.3']) > 0) $makers[] = $entry['158.3'] . ' ' .$entry['158.6'];
    if (strlen($entry['155.3']) > 0) $makers[] = $entry['155.3'] . ' ' .$entry['155.6'];
    if (strlen($entry['156.3']) > 0) $makers[] = $entry['156.3'] . ' ' .$entry['156.6'];
    if (strlen($entry['157.3']) > 0) $makers[] = $entry['157.3'] . ' ' .$entry['157.6'];
    if (strlen($entry['159.3']) > 0) $makers[] = $entry['159.3'] . ' ' .$entry['159.6'];
    if (strlen($entry['154.3']) > 0) $makers[] = $entry['154.3'] . ' ' .$entry['154.6'];

    //maker 1 bio
    $bio             = $entry['234'];
  
    $groupname       = $entry['109'];
    $groupphoto      = $entry['111'];
    $groupbio        = $entry['110'];

    $project_name    = $entry['151']; 
    $project_photo   = $entry['22'];
    $project_short   = $entry['16'];
    $project_website = $entry['27'];
    $project_video   = $entry['32'];
    $project_title   = (string)$entry['151'];

    $project_title  = preg_replace('/\v+|\\\[rn]/','<br/>',$project_title);
    // Project ID
    ?>
        <div class="entry-id"><?php echo $entry['id'];?></div><br/>
    
    <?php // Project Title    ?>
    <div class="middle">
        <div class="proj-title"><?php echo $project_title;?></div>    
        <div class="proj-img"><img style="width:500px;height:auto" src="<?php echo $project_photo;?>" /></div>
        <div class="proj-desc"><?php echo $project_short;?></div>        
        <div style="clear:both"></div>
        <br/><br/>
    
    <?php
    if (!empty($groupbio)) {                
        echo '<div class="name">'.$groupname.'</div><br/>';
        echo '<div class="bio">'.$groupbio.'</div>';
    }else {            
      $makerList = implode(', ',$makers);      
      echo '<div class="name">'.$makerList.'</div><br/>';
      //if size of makers is 1, then display maker bio      
      if(sizeof($makerList)==1){
        echo '<div class="bio">'.$bio.'</div>';
      }
    }
    echo '</div>'; //for .middle
    
}
?>



