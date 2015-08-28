<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    ?>
    <h2>Export MakerFaire Forms</h2>
    <h3>Please select the form you want to export:</h3>       
    <form  method="post">
        <select id="exportForm" name="exportForm">
                <option value=""><?php _e( 'Select a form', 'gravityforms' ); ?></option>
                <?php
                $forms = RGFormsModel::get_forms( null, 'title' );
                foreach ( $forms as $form ) {
                        ?>
                        <option value="<?php echo absint( $form->id ) ?>"><?php echo esc_html( $form->title ) ?></option>
                <?php
                }
                ?>
        </select>
        <input type="submit"value="Download Export File" class="button button-large button-primary" />
    </form>
    <?php
if(isset($_POST['exportForm']) && $_POST['exportForm']!=''){    
    //create CSV file
    $form_id = $_POST['exportForm'];
    $form = GFAPI::get_form( $form_id );
    $fieldData = array();
    //put fieldData in a usable array
    foreach($form['fields'] as $field){
        if($field->type!='section' && $field->type!='html' && $field->type!='page')
            $fieldData[$field['id']] = $field;
    }
    $search_criteria['status'] = 'active';
    $entries = GFAPI::get_entries( $form_id, $search_criteria, null, array('offset' => 0, 'page_size' => 9999) );

    $output = array('Entry ID','FormID');
    $list = array();
    foreach($fieldData as $field){
        $output[] = $field['label'];
    }
    $list[] = $output;
    echo 'For Form '.$form_id.' '. count($entries).' records';
    foreach($entries as $entry){
        $fieldArray = array($entry['id'],$form_id);
        foreach($fieldData as $field){
            array_push($fieldArray, (isset($entry[$field->id])?$entry[$field->id]:''));
        }
        $list[] = $fieldArray;
    }

    //write CSV file
    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=form-'.$form_id.'.csv');
    $file = fopen("formExport.csv","w");

    foreach ($list as $line){
      fputcsv($file,$line);
    }

    fclose($file); 
}
