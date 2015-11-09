<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include 'db_connect.php';
$filter = '';

$year = (isset($_REQUEST['year']) ? $_REQUEST['year']:'');
$year = filter_var(trim($year), FILTER_SANITIZE_STRING);
$filter = " and year= ".($year!=''? $year:date("Y"));

$sql = "SELECT entry_id, location, year, ribbonType, numRibbons,project_name,project_photo "
        . " FROM `wp_mf_ribbons` where entry_id > 0 ".$filter." "
        . " group by entry_id, location, year, ribbonType, numRibbons order by year DESC, location ASC";
//$mysqli->query("SET NAMES 'utf8'");
//$ribbons = $mysqli->query($sql) or trigger_error($mysqli->error."[$sql]");

$ribbonData=array();
$data = array();
$json = array();

foreach($wpdb->get_results($sql,ARRAY_A) as $ribbon){  
//while ($ribbon = mysqli_fetch_array($ribbons, MYSQLI_ASSOC)) {
    $entry_id   = $ribbon['entry_id'];
    //echo $entry_id.'<br/>';
/*
    //determine the postID
    $makerSQL= "select p1.post_id, p2.meta_key, p2.meta_value "
            . "   from wp_postmeta p1 right join wp_postmeta p2 "
            . "         on p1.post_id=p2.post_id and "
            . "            p2.meta_value !=''    and "
            . "                 p2.meta_key like '%maker_name%' "
            . "   where p1.meta_key='entry_id' and p1.meta_value='".$entry_id."'";
    $makerData = $mysqli->query($makerSQL) or trigger_error($mysqli->error."[$makerSQL]");    
    $maker = mysqli_fetch_array($makerData);
    
    //if maker name has field_ in it, it is not a valid maker name.  return spaces instead
    $ribbonData[$entry_id]['maker_name']    = (strpos($maker['meta_value'], 'field_')===false?$maker['meta_value']:'');*/
    $ribbonData[$entry_id]['maker_name'] ='';
    
    $location   = $ribbon['location'];
        
    $year       = $ribbon['year'];
    $ribbonType = $ribbon['ribbonType'];
    $numRibbons = $ribbon['numRibbons'];    
                        
    $project_name  = $ribbon['project_name'];
    $project_photo = $ribbon['project_photo']; 
    //echo '$project_photo='.$project_photo.'<br/>';
    $project_photo = legacy_get_fit_remote_image_url($project_photo,285,270,0);
    //echo '$project_photo='.$project_photo.'<br/><br/><br/>';
    $currCount = (isset($ribbonData[$entry_id]['ribbon'][$ribbonType]['count']) ? $ribbonData[$entry_id]['ribbon'][$ribbonType]['count']:0);
    $ribbonData[$entry_id]['ribbon'][$ribbonType]['count']  = $currCount + $numRibbons;
    $ribbonData[$entry_id]['fairedata'][] = 
            array( 'year'=>$year, 'faire'=>$location,'ribbonType'=>($ribbonType==0?'blue':'red'),'numRibbons'=>$numRibbons);
    $ribbonData[$entry_id]['project_name']  = $project_name;
    $ribbonData[$entry_id]['project_photo'] = $project_photo;    
   
}
foreach($ribbonData as $entry_id=>$data){  
    $blueCount = (isset($data['ribbon'][0]['count'])?$data['ribbon'][0]['count']:0);
    $redCount  = (isset($data['ribbon'][1]['count'])?$data['ribbon'][1]['count']:0);
    
    $json[]= array('entryID'=>$entry_id,'blueCount'=>$blueCount,'redCount'=>$redCount,
            "project_name"  => $data['project_name'],
            "project_photo" => $data['project_photo'],
            "maker_name"    => $data['maker_name'],
            "faireData"     => $data['fairedata']
        );
}

    
                 
echo json_encode($json);
