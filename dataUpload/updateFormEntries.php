<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'db_connect.php';


function calculate_signature($string, $private_key) {
    $hash = hash_hmac("sha1", $string, $private_key, true);
    $sig = rawurlencode(base64_encode($hash));
    return $sig;
}
function call_api($data){
    
    $api_key = '84ed801ad4';
    $private_key = 'cacff8d71d9cc6e';
    $method  = 'POST';
    $domain = $_SERVER['HTTP_HOST'];
    if($domain=='localhost')    $domain .= '/makerfaire';

    //$endpoint = 'http://makerfaire.staging.wpengine.com/gravityformsapi/';
    $endpoint = $domain.'/gravityformsapi/';
    echo 'sending to '.$endpoint.'<br/>';
    //$route = 'entries';
    $route = 'forms/20/entries';
    $expires = strtotime('+60 mins');
    $string_to_sign = sprintf('%s:%s:%s:%s', $api_key, $method, $route, $expires);
    $sig = calculate_signature($string_to_sign, $private_key);

    $api_call = $endpoint.$route.'?api_key='.$api_key.'&signature='.$sig.'&expires='.$expires;
    //print_r(json_encode($data));
    
    $ch = curl_init($api_call);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);

    $result = curl_exec($ch);
    //print_r($result);
    $returnedData = json_decode($result);//201 status indicates it inserted the entry. Should return id of the entry.
    //die('stop');
    if($returnedData->status==201){ 
            return $returnedData->response;        
    }else{        
        print_r($result);
    }
}

ini_set("auto_detect_line_endings", "1");
//$success = GFAPI::update_entry_field( $entry_id, $input_id, $value );
if ( isset($_POST["submit"]) ) {
    $csv = [];
   if ( isset($_FILES["fileToUpload"])) {

            //if there was an error uploading the file
        if ($_FILES["fileToUpload"]["error"] > 0) {
            echo "Return Code: " . $_FILES["fileToUpload"]["error"] . "<br />";

        }
        else {
                 //Print file details
             
            $name = $_FILES['fileToUpload']['name'];
            $ext = strtolower(end(explode('.', $_FILES['fileToUpload']['name'])));
            $type = $_FILES['fileToUpload']['type'];
            $tmpName = $_FILES['fileToUpload']['tmp_name'];
            
            echo "Upload: " . $name . "<br />";
            echo "Type: " . $type . "<br />";
            echo "Size: " . ($_FILES["fileToUpload"]["size"] / 1024) . " Kb<br />";
            echo "Temp file: " . $tmpName . "<br />";
            if(($handle = fopen($tmpName, 'r')) !== FALSE) {
                // necessary if a large csv file
                set_time_limit(0);

                $row = 0;

                while(($data = fgetcsv($handle, 0, ',')) !== FALSE) {
                    // number of fields in the csv
                    $col_count = count($data);
                    
                    foreach($data as $value){
                        $csv[$row][] = $value;
                       
                    }
                 
                    // inc the row
                    $row++;
                }
                fclose($handle);
            }
            
        }
    } else {
             echo "No file selected <br />";
    }
    
    //row 0 contains field id's 
    //row 1 contains field names
    $fieldIDs = $csv[0];
    $catKey = array_search('147.44', $fieldIDs);
    
    unset($csv[0]);
    unset($csv[1]);
    $tableData = [];
    $APIdata   = [];
    $catArray  = [];
    //print_r($csv);
    foreach ($csv as $rowData){
       $faire = $rowData[0];
       $form  = $rowData[1]; 
       $parentID = $rowData[2];
       
       $data  = array('form_id'=>$form,'status'=>'active',"id" => "","date_created" => "");
       foreach($rowData as $key => $value){
           
           if($fieldIDs[$key] != ''  && $value !=''){
               $data[$fieldIDs[$key]] = htmlspecialchars($value);
               //echo 'For ' .$faire .' setting form '.$form.' for group '.$group .' - ';
               //echo 'Setting field '.$fieldIDs[$key]. ' to '.htmlspecialchars($value).'<br/>';
           }
            
            
       }
       $APIdata[] = array($data);     
       $tableData[] = array('parentID'=> $parentID, 
                          'childID' => '', 
                          'faire'   => $faire,
                          'form_id' => $form,
                          '147.44'  => $rowData[$catKey]);
    }
    
    $childID = call_api ($APIdata);
  
    foreach($tableData as $key=>$value){
        $tableData[$key]['childID'] = $childID[$key];
    }
    //print_r($tableData);
    //die('stop');
       
    //now we need to update the database
    //find the end of the $tableData
    $endkey = key( array_slice( $tableData, -1, 1, TRUE ) );
    $contchar = ',';
    
    //loop thru array to build SQL inserts
    foreach($tableData as $key => $value){        
        if($endkey == $key) $contchar = '';
        $insertRel .= " (NULL, ".$value['parentID'].", ".$value['childID'].", '".$value['faire']."', '".$value['form_id']."')".$contchar;
        $insertLead .= "(NULL, '".$value['childID']."', '".$value['form_id']."', '147.44', '".$value['147.44']."')".$contchar;
    }
    // check if table exists
    // if it doesn't exist, create it
    $sql = "CREATE TABLE IF NOT EXISTS `wp_rg_lead_rel` (
      `id` int(10) NOT NULL,
      `parentID` int(10) NOT NULL,
      `childID` int(10) NOT NULL,
      `faire` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
      `form` mediumint(8) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    // add to the wp_rg_lead_rel table
        $sql .= "INSERT INTO `wp_makerfaire`.`wp_rg_lead_rel` "
                . "(`id`, `parentID`, `childID`, `faire`, `form`) values " .$insertRel.";";

    // update wp_rg_lead_detail with category
        $sql = "INSERT INTO `wp_makerfaire`.`wp_rg_lead_detail` "
            . "(`id`, `lead_id`, `form_id`, `field_number`, `value`) "
            . "VALUES ".$insertLead.";";
        $result=mysql_query($sql) or die("error in SQL ".mysql_error().' '.$sql);
}
?>

<!DOCTYPE html>
<html>
<body>

    <h2>Update Form entries</h2>
<form method="post" enctype="multipart/form-data">
    Select File to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload" name="submit">
</form>

</body>
</html>
<?php
