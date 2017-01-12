<?php
/* this provides a javascript button that allows the users to print out 
 * all maker pdf's 
 */
?> 
<h2>Print Faire Signs by Form</h2>
    <form method="post" action="">
        
         
        <select id="printForm" name="printForm">
                <option value=""><?php _e( 'Select a form', 'gravityforms' ); ?></option>
                <?php
                $forms = RGFormsModel::get_forms( null, 'title' );
                foreach ( $forms as $form ) {
                        ?>
                        <option value="<?php echo absint( $form->id ) ?>"><?php echo esc_html( $form->title ); ?></option>
                <?php
                }
                ?>
        </select>
        <br/>
        <input type="checkbox" name="showAll" value='yes'> Show for all Statuses
        <br/><br/>
        <input type="submit" value="Submit" class="button button-large button-primary" />
    </form>
<?php

if(isset($_POST['printForm'])){

    $form_id = $_POST['printForm'];
    $search_criteria['status'] = 'active';
    if(isset($_POST['showAll']) && $_POST['showAll']=='yes'){
        //no search criteria
        
    }else{
        $search_criteria['field_filters'][] = array( 'key' => '303', 'value' => 'Accepted');
    }
    $sorting         = array();
    $paging          = array( 'offset' => 0, 'page_size' => 9999 );
    $total_count     = 0;
    $entries         = GFAPI::get_entries( $form_id, $search_criteria, $sorting, $paging, $total_count );

    ?>
    <br/><br/>
    <input class="button button-large button-primary" style="text-align:center" value="Create all for Form <?php echo $form_id;?>" id="processButton"   onClick="printSigns()"/><br/>
    <br/>
    <?php
    //var_dump($entries);
    foreach($entries as $entry){
        $entry_id = $entry['id'];
        ?>
        <a class="fairsign" target="_blank" id="<?php echo $entry_id;?>" href="/wp-content/themes/makerfaire/fpdi/makersigns.php?eid=<?php echo $entry_id;?>"><?php echo $entry_id;?></a><br/>  
                 <?php
    }
}
?>

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

  
   