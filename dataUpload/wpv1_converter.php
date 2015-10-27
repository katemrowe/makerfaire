<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'db_connect.php';

//pull all archive data
$sql = "SELECT * FROM wp_posts right join wp_postmeta on id = post_id WHERE post_type = 'mf_form'";

$mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query($sql) or trigger_error($mysqli->error."[$sql]");

$postData = array();
// Loop through the posts
while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
    //build archive array
    $postData[$row['ID']]['data'] = array(
        'post_author'   => $row['post_author'],
        'post_date'     => $row['post_date'],
        'post_content'  => $row['post_content'],
        'post_title'    => $row['post_title'],
        'post_name'     => $row['post_name'],
        'guid'          => $row['guid'],
        'post_type'     => $row['post_type']        
    );
   $postData[$row['ID']]['meta'][] = array(        
        'meta_key'      => $row['meta_key'],
        'meta_value'    => $row['meta_value']
    );
}
$errorCount = 0;
$total = 0;
foreach($postData as $ID=>$post){    
    $total++;
    $makers=array();
    $jsonArray = json_decode( $post['data']['post_content'], true );
     if(empty($jsonArray)){  
         $content = $post['data']['post_content'];
         
        //left and right curly brace
         $content = str_replace('{"',  ' ||squigDQ|| ', $content);
         $content = str_replace('"}',  ' ||DQsquig|| ', $content);
         
         //colon, basic text and empty field values
         $content = str_replace('","', ' ||dqCommadq|| ', $content);
         $content = str_replace('":"', ' ||dqColondq|| ', $content);

         $content = str_replace('""',  ' ||dqdq|| ', $content);
        
         //clean up any remaining
         $content = str_replace('":',  ' ||DQcolon|| ',$content);
         $content = str_replace(':"',  ' ||colonDQ|| ',$content);        
        
         
         $content = str_replace('["',  ' ||LBdq|| ',$content);
         $content = str_replace('"],"',' ||dqrbcommadq|| ',$content);  
         $content = str_replace('],"', ' ||RBcommaDQ|| ',$content);                                
         
         $precontent = $content;
         //remove extra double quotes
         $content = str_replace('"', "'", $content);         
         $content = stripslashes($content);    //get rid of any \
         
         
         //now convert the other data back
         //left and right curly brace
         $content = str_replace(' ||squigDQ|| ', '{"',  $content);
         $content = str_replace(' ||DQsquig|| ', '"}',  $content);
         
         //colon, basic text and empty field values
         $content = str_replace(' ||dqCommadq|| ', '","', $content);
         $content = str_replace(' ||dqColondq|| ', '":"', $content);

         $content = str_replace(' ||dqdq|| ', '""',  $content);
        
         //clean up any remaining
         $content = str_replace(' ||DQcolon|| ','":',  $content);
         $content = str_replace(' ||colonDQ|| ',':"',  $content);        
        
         $content = str_replace(' ||LBdq|| ',       '["',  $content);         
         $content = str_replace(' ||dqrbcommadq|| ','"],"',$content);                   
         $content = str_replace(' ||RBcommaDQ|| ','"],"', $content);
         
         //remove weird stuff 
         $content = str_replace('"""','""',$content);
         $content = str_replace('[""]','[]',$content);
         $content = str_replace('["]','[]',$content);
         $content = str_replace("''","'",$content);
         $content = str_replace(' ""',"'",$content);
         $content = str_replace('"" ',"'",$content);
         
         $errorIDs = array('21749','17738','16062','15524','14121','14058','13371','11674','6621','6170','5754');
         if(in_array($ID,$errorIDs)){
           $content = str_replace('["h","t","t","p",":""]','""',$content);
           $content = str_replace('.""','.SngleQuot"',$content);  
           
           //fix for 6621           
           $content = str_replace('Raspberry Pi""]','Raspberry PiSngleQuot"]',$content);  
           //fix for 14058
           $content = str_replace("'presenter_",'"presenter_',$content);
           //fix for 14121
           $content = str_replace('Objects":','ObjectsSngleQuot:',$content);
           //fix for 16062
           $content = str_replace('The New Literacies""]','The New LiteraciesSngleQuot"]',$content);
           //fix for 17738
           $content = str_replace('u2026','...',$content);
           $content = str_replace('":u00a0n','',$content);
           //fix for 21749
           $content = str_replace('""Science Bob','"SngleQuotScience Bob',$content);
           
           $content = str_replace('SngleQuot',"'",$content);  
         }
         $jsonArray = json_decode($content, true );
        
     }
    //now let's update the db
    $projectName = $post['data']['post_title'];            
    $link = $post['data']['post_name'];

    
    $sql  = "update wp_posts set post_type = 'maker-entry-archive', post_status='publish', "
                . "     post_title='".$ID
            . " where id = ".$ID;
    $result = $mysqli->query($sql) or trigger_error($mysqli->error."[$sql]");
    $makerTitle = '';
    switch ($jsonArray['form_type']) {
         case 'exhibit':
                 $project_faire   = $jsonArray['maker_faire'];
                 $project_name    = $jsonArray['project_name'];
                 $project_photo   = $jsonArray['project_photo'];
                 $project_short   = $jsonArray['public_description'];
                 $project_website = $jsonArray['project_website'];
                 $project_video   = $jsonArray['project_video'];
                 $project_title   = $jsonArray['project_name'];
                 $makers = array();
                 if(is_array($jsonArray['m_maker_name'])){ 
                     foreach($jsonArray['m_maker_name'] as $mkey=>$mvalue){
                         $makers[] = array('maker_name'   => $mvalue,
                                           'maker_description'    => (isset($jsonArray['m_maker_bio'][$mkey])?$jsonArray['m_maker_bio'][$mkey]:''),
                                           'maker_photo'  => (isset($jsonArray['m_maker_photo'][$mkey])?$jsonArray['m_maker_photo'][$mkey]:''),
                                           'maker_email'  => (isset($jsonArray['m_maker_email'][$mkey])?$jsonArray['m_maker_email'][$mkey]:''));
                     }
                 }else{
                        $makers[] = array('maker_name'   => $jsonArray['maker_name'],
                                          'maker_description'    => $jsonArray['maker_bio'],
                                          'maker_photo'  => $jsonArray['maker_photo'],
                                          'maker_email'  => $jsonArray['maker_email']);
                 }
         break;
         case 'performer':
                 $project_faire = $jsonArray['maker_faire'];
                 $project_name  = $jsonArray['performer_name'];
                 $project_photo = $jsonArray['performer_photo'];
                 $project_short = $jsonArray['public_description'];
                 $project_website = $jsonArray['performer_website'];
                 $project_video = $jsonArray['performer_video'];
                 $project_title = $jsonArray['performer_name'];
                 $makers = array();

                 break;
         default:
                $project_faire = $jsonArray['maker_faire']; 
                $project_name  = $jsonArray['presentation_name']; 
                $project_photo = $jsonArray['presentation_photo'];
                $project_short = $jsonArray['short_description'];
                $project_website = $jsonArray['presentation_website'];
                $project_video = $jsonArray['video'];
                $project_title = $jsonArray['presentation_name'];
                $makers = array();
                if (strlen($jsonArray['presenter_name'][0]) > 0)
                      $makers[] = array('name'  => $jsonArray['presenter_name'][0],
                                        'bio'   => $jsonArray['presenter_bio'][0],
                                        'photo' => $jsonArray['presenter_photo'][0],
                                        'email' => $jsonArray['presenter_email'][0]
                                        );
                $makers = array();
                 if(is_array($jsonArray['presenter_name'])){ 
                     foreach($jsonArray['presenter_name'] as $mkey=>$mvalue){
                         $makers[] = array('maker_name'   => $mvalue,
                                           'maker_description'    => (isset($jsonArray['presenter_bio'][$mkey])?$jsonArray['m_maker_bio'][$mkey]:''),
                                           'maker_photo'  => (isset($jsonArray['presenter_photo'][$mkey])?$jsonArray['m_maker_photo'][$mkey]:''),
                                           'maker_email'  => (isset($jsonArray['presenter_email'][$mkey])?$jsonArray['m_maker_email'][$mkey]:''));
                     }
                 }else{
                        $makers[] = array('maker_name'   => $jsonArray['presenter_name'],
                                          'maker_description'    => $jsonArray['presenter_bio'],
                                          'maker_photo'  => $jsonArray['presenter_photo'],
                                          'maker_email'  => $jsonArray['presenter_email']);
                 }
                break;
       }
    $projectEmail = $jsonArray['email'];

    $field_array=array(
        'field_56156d5f04351'=>$project_faire,
        'field_56156d7404352'=>$project_name,
        'field_56156d9304355'=>$project_short,
        'field_56156dbd04358'=>$project_photo,
        'field_56156d9f04356'=>$project_website,
        'field_56156dcc04359'=>$projectEmail,
        'field_56156da704357'=>$project_video
    );
    
    foreach($field_array as $field_key=>$field){
        //set ACF data
        update_field($field_key, $field, $ID);
    }
    //set maker data
    update_field('field_56157e9ad04c2',$makers,$ID);
       
echo 'updated '.$ID.'<br/>';

}
echo '<br/><br/>'. $errorCount.' out of '.$total.' in error';

