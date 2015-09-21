<?php
/* this provides a javascript button that allows the users to print out 
 * all maker pdf's 
 */
$form_id = 25;
$search_criteria['status'] = 'active';
$search_criteria['field_filters'][] = array( 'key' => '303', 'value' => 'Accepted');
$sorting         = array();
$paging          = array( 'offset' => 0, 'page_size' => 9999 );
$total_count     = 0;
$entries         = GFAPI::get_entries( $form_id, $search_criteria, $sorting, $paging, $total_count );

?>
<h2>Print All Signs for NY15</h2>
<div style="width:75%; float:left">
    To create all signs for the faire, click the button to the right.<br/>
    Individual signs can be created by clicking on the entry ID below.  <br/>
    If a sign has previously been created, it will be listed next to the entry ID with the date of creation.

</div>
<input class="button button-large button-primary" style="text-align:center;float:left" value="Create all <?php echo $total_count;?> signs" id="processButton"   onClick="printSigns()"/>
<br/><br/>
<div style="clear:both"></div>
    <div width="100%">
        <ul>

    <?php
//var_dump($entries);

foreach($entries as $entry){    
    $entry_id = $entry['id'];
    ?>
        <li style="float: left;width: 25%;">
            <?php echo $entry_id.': ';?>
            <a class="fairsign" target="_blank" id="<?php echo $entry_id;?>" href="/wp-content/themes/makerfaire/fpdi/makersigns.php?eid=<?php echo $entry_id;?>">Create</a>
        
    
        <?php
    $filename = TEMPLATEPATH.'/signs/NY15/'.$entry_id.'.pdf';
    if (file_exists($filename)) {
      echo ' (<a target="_blank" href="/'.$filename.'">'.date ("m/d/Y H:i:s", filemtime($filename)).'</a>)';
    }
    ?>
    </li>
    
<?php
}
?>
        </ul>
</div>
<script>
    
        jQuery(document).ready(function(){

         });
         
         function printSigns(){
            jQuery('#processButton').val("Creating PDF's. . . ");
            jQuery("a.fairsign").each(function(){                
            
                jQuery(this).html('Creating');
                jQuery(this).attr("disabled","disabled");
               
               jQuery.ajax({
                    type: "GET",
                    url: "/wp-content/themes/makerfaire/fpdi/makersigns.php",
                    data: { eid: jQuery(this).attr('id'), type: 'save' },
                  }).done(function(data) {
                    jQuery('#'+data).html(data+ ' Created');
                    jQuery('#'+data).attr("href", "/wp-content/themes/makerfaire/signs/NY15/"+data+'.pdf')
                  });
               
            });    
         }
         function fireEvent(obj,evt){

            var fireOnThis = obj;
            if( document.createEvent ) {
              var evObj = document.createEvent('MouseEvents');
              evObj.initEvent( evt, true, false );
              fireOnThis.dispatchEvent(evObj);
            } else if( document.createEventObject ) {
              fireOnThis.fireEvent('on'+evt);
            }
        }    
</script> 

  
   