<?php
/* 
 * this script will hold all the cronjobs for makerfaire
 */

//for testing
/*define( 'BLOCK_LOAD', true );
require_once( '../../../../wp-config.php' );
require_once( '../../../../wp-includes/wp-db.php' );
$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
*/
 $dataArray = array( 'Contact'       =>array(
                            
                            'Bio'           => '',
                            'Email'         => '98',
                            'First Name'    => '96.3',
                            'Last Name'     => '96.6',
                            'OnsitePhone'   => '99',
                            'Photo'         => '',
                            'TWITTER'       => '',
                        ),
                        'Presenter'     =>array(
                            
                            'Bio'           => '234',
                            'Email'         => '161',
                            'First Name'    => '160.3',
                            'Last Name'     => '160.6',
                            'OnsitePhone'   => '265',
                            'Photo'         => '217',
                            'TWITTER'       => '201',
                        ),                        
                        'Presenter2'    =>array(
                            
                            'Bio'           => '',
                            'Email'         => '162',
                            'First Name'    => '158.3',
                            'Last Name'     => '158.6',
                            'OnsitePhone'   => '266',
                            'Photo'         => '224',
                            'TWITTER'       => '208',
                        ),
                        'Presenter3'    =>array(
                            
                            'Bio'           => '',
                            'Email'         => '167',
                            'First Name'    => '155.3',
                            'Last Name'     => '155.6',
                            'OnsitePhone'   => '267',
                            'Photo'         => '223',
                            'TWITTER'       => '207',
                        ),
                        'Presenter4'    =>array(
                                 
                            'Bio'           => '',
                            'Email'         => '166',
                            'First Name'    => '156.3',
                            'Last Name'     => '156.6',
                            'OnsitePhone'   => '268',
                            'Photo'         => '222',
                            'TWITTER'       => '206',
                        ),
                        'Presenter5'    =>array(
                            
                            'Bio'           => '',
                            'Email'         => '165',
                            'First Name'    => '157.3',
                            'Last Name'     => '157.6',
                            'OnsitePhone'   => '268',
                            'Photo'         => '220',
                            'TWITTER'       => '205',
                        ),
                        'Presenter6'    =>array(
                            
                            'Bio'           => '',
                            'Email'         => '164',
                            'First Name'    => '159.3',
                            'Last Name'     => '159.6',
                            'OnsitePhone'   => '270',
                            'Photo'         => '221',
                            'TWITTER'       => '204',
                        ),
                        'Presenter7'    =>array(
                            
                            'Bio'           => '',
                            'Email'         => '163',
                            'First Name'    => '154.3',
                            'Last Name'     => '154.6',
                            'OnsitePhone'   => '271',
                            'Photo'         => '219',
                            'TWITTER'       => '203',
                        ),
                        'Group'         =>array(
                            
                            'Bio'           => '110',
                            'Email'         => '',
                            'First Name'    => '109',
                            'Last Name'     => '',
                            'OnsitePhone'   => '',
                            'Photo'         => '111',
                            'TWITTER'       => '',
                        )
        );
//dailyCronFunction(); //for testing
add_action('dailyCronHook', 'dailyCronFunction');

function dailyCronFunction(){    
   build_wp_mf_maker();
   // build_wp_mf_maker_summary();
    
}
function build_wp_mf_maker(){
    
    global $wpdb; global $dataArray;
        
    $tableData = array();
    //pull data for table
    $nameID = 0;
    foreach($dataArray as $type=>$lead_detail){   
        $sql = '';
        $sql .= "select  `b`.`id` AS `lead_id`,
                    group_concat(if((format(`wp_rg_lead_detail`.`field_number`,2) = 76),`wp_rg_lead_detail`.`value`,NULL) separator ',') AS `SpecialRequest`,
                    group_concat(if((format(`wp_rg_lead_detail`.`field_number`,2) = 151),`wp_rg_lead_detail`.`value`,NULL) separator ',') AS `PresentationTitle`,
                    group_concat(if((format(`wp_rg_lead_detail`.`field_number`,2) = 1),`wp_rg_lead_detail`.`value`,NULL) separator ',') AS `PresentationType`,
                    group_concat(if((format(`wp_rg_lead_detail`.`field_number`,2) between 301.9999 and 302.9999),`wp_rg_lead_detail`.`value`,NULL) separator ',') AS `Location`,
                    max(if((`wp_rg_lead_detail`.`field_number` = 303),`wp_rg_lead_detail`.`value`,NULL)) AS `Status`,
                    `b`.`form_id` AS `form_id`,
                    concat(`wp_rg_lead_detail`.`lead_id`,'-".$nameID."') AS `maker_id`, ";
        $nameID++;            
        foreach($lead_detail as $field_value=>$field_number){
            
            if($field_number==''){
                $sql.= "'' as '".$field_value."', ";
            }else{
                $sql .= "group_concat(if((format(`wp_rg_lead_detail`.`field_number`,2) = ".$field_number."),`wp_rg_lead_detail`.`value`,NULL) separator ',') AS `".$field_value."`,";
            }
        }
        $sql .= "'".$type."' as 'Name'                
                from `wp_rg_lead_detail` 
                    join `wp_rg_lead` `b` 
                        on`wp_rg_lead_detail`.`lead_id` = `b`.`id`
                group by `wp_rg_lead_detail`.`lead_id` ";
        
        foreach( $wpdb->get_results($sql, ARRAY_A ) as $key=>$row) {
            // each column in your row will be accessible like this
            $tableData[] = $row;            
        }

    }
        
        
    //drop current table
    $sql = "DROP TABLE IF EXISTS `wp_mf_maker`;";
    $wpdb->get_results($sql);
    
    //create table
    $sql = "CREATE TABLE `wp_mf_maker` (
              `ID` int(11) NOT NULL,
              `lead_id` int(11) unsigned NOT NULL DEFAULT '0',
              `First Name` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `Last Name` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `Bio` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `Email` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `OnsitePhone` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `TWITTER` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `SpecialRequest` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `PresentationTitle` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `PresentationType` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `Name` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
              `Location` varchar(341) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `Status` varchar(1024) DEFAULT NULL,
              `form_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
              `maker_id` varchar(12) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
              `Photo` varchar(1024) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $wpdb->get_results($sql);
    
    $sql = "ALTER TABLE `wp_mf_maker` ADD PRIMARY KEY (`ID`)";
    $wpdb->get_results($sql); 
    
    $sql = "ALTER TABLE `wp_mf_maker` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";    
    $wpdb->get_results($sql);   
    //print_r($tableData);
    $labels = array_keys($tableData[0]);
    $labels = array('lead_id', 'First Name', 'Last Name', 'Bio', 'Email', 
                    'OnsitePhone', 'TWITTER', 'SpecialRequest', 
                    'PresentationTitle', 'PresentationType', 'Name', 'Location', 
                    'Status', 'form_id', 'maker_id', 'Photo');
    //insert data rows
    $sqlInsert = "insert into wp_mf_maker (";
    $i = 0;
    $numLabels = count($labels);
    foreach($labels as $label){
        $sqlInsert .= '"'.$label.'"';
        if(++$i === $numLabels) {
            //
        }else{
            $sqlInsert .= ",";
        }
        
    }
    $sqlInsert .=") values (";
    $sqlInsert = "INSERT INTO `wp_mf_maker`(`lead_id`, `First Name`, `Last Name`, `Bio`, `Email`, `OnsitePhone`, `TWITTER`, `SpecialRequest`, `PresentationTitle`, `PresentationType`, `Name`, `Location`, `Status`, `form_id`, `maker_id`, `Photo`) VALUES (";
    $rows = 0;
    $numRows = count($tableData);
    foreach($tableData as $value){                  
        $sql ='';
        $i = 0;
        $numItems = count($labels);
        foreach($labels as $label){
            if($label == 'lead_id' || $label == 'form_id'){ //numeric
                $sql.= $value[$label];                
            }else{
                $sql .= '"'.$value[$label].'"';
            }
            
            if(++$i === $numItems) {
               //
            }else{
                $sql .= ",";
            }
        }
        echo $sqlInsert.$sql.')<br/><br/>';
        $wpdb->get_results($sqlInsert.$sql.')');         
    }
    //echo 'sql='.$sqlInsert.'<br/><br/>';
        
    
}

function build_wp_mf_maker_summary(){
    
    
}

