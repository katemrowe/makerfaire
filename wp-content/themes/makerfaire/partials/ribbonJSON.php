<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function  createJson($year=''){
    global $wpdb;
    $filter = " and year= ".($year!=''? $year:date("Y"));
    $sql = "SELECT entry_id, location, year, ribbonType, numRibbons,project_name,project_photo, post_id, maker_name "
            . " FROM `wp_mf_ribbons` where entry_id > 0 AND post_id > 0 ".$filter." "
            . " group by entry_id, location, year, ribbonType, numRibbons";

    $ribbonData=array();
    $data = array();
    $json = array();

    foreach($wpdb->get_results($sql,ARRAY_A) as $ribbon){  
        $entry_id       = $ribbon['entry_id'];
        $post_id        = $ribbon['post_id'];
        $project_name   = $ribbon['project_name'];
        $project_photo  = $ribbon['project_photo']; 
        $project_photo  = legacy_get_fit_remote_image_url($project_photo,285,270,0);
        $maker_name     = $ribbon['maker_name'];
                
                
        //pull the project information - mf_ribbons data takes precedence
        $makerSQL= "select * from wp_postmeta where (post_id = $post_id and meta_key like '%maker_name%') or "
                . "                                 (post_id = $post_id and meta_key in('project_photo','project_name')) "
                . "  ORDER BY `wp_postmeta`.`meta_key` DESC";            
        foreach($wpdb->get_results($makerSQL,ARRAY_A) as $projData){ 
            $field = $projData['meta_key'];
            $value = $projData['meta_value'];
            if($field=='project_photo' && $project_photo ==''){  
                if(is_numeric($value)){                    
                    $project_photo = wp_get_attachment_url( $value);
                }else{
                    $project_photo = $value;
                }
            }
            if($field=='project_name'  && $project_name =='')   $project_name  = $value;
            if(strpos($field, 'maker_name')!== false){
                //if maker name has field_ in it, it is not a valid maker name.
                if(strpos($value, 'field_')===false && $maker_name=='')  $maker_name = $value;
            }
        }
               
        
        $ribbonData[$entry_id]['maker_name'] = $maker_name;
        
        $location   = $ribbon['location'];
        $year       = $ribbon['year'];
        $ribbonType = $ribbon['ribbonType'];
        $numRibbons = $ribbon['numRibbons'];    

        
        
        $currCount = (isset($ribbonData[$entry_id]['ribbon'][$ribbonType]['count']) ? $ribbonData[$entry_id]['ribbon'][$ribbonType]['count']:0);
        $ribbonData[$entry_id]['ribbon'][$ribbonType]['count']  = $currCount + $numRibbons;
        $ribbonData[$entry_id]['fairedata'][]   = array( 'year'=>$year, 'faire'=>$location,'ribbonType'=>($ribbonType==0?'blue':'red'),'numRibbons'=>$numRibbons);
        $ribbonData[$entry_id]['project_name']  = $project_name;
        $ribbonData[$entry_id]['project_photo'] = $project_photo;    
    }
    
    foreach($ribbonData as $entry_id=>$data){  
        $blueCount = (isset($data['ribbon'][0]['count'])?$data['ribbon'][0]['count']:0);
        $redCount  = (isset($data['ribbon'][1]['count'])?$data['ribbon'][1]['count']:0);
        $json[]= array('entryID'=> $entry_id,
                "blueCount"     => $blueCount,
                "redCount"      => $redCount,
                "project_name"  => $data['project_name'],
                "project_photo" => $data['project_photo'],
                "maker_name"    => $data['maker_name'],
                "faireData"     => $data['fairedata']
            );
    }

    return json_encode($json);
}
