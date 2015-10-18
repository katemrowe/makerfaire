<?php
/*
Plugin Name: RS CSV Importer Customizer
Version: 0.1
*/
 
function rsci_meta_filter( $meta, $post, $is_update ) {

    // Create containers
    $meta_array = array();
    $repeater_array = array();

    foreach ($meta as $key => $value) {
        // Create array data to import to the Maker Information Repeater Field
        if($value!=''){
            switch ($key){
                //name
                case 'maker_name1':
                    $repeater_array[1]['field_56157eadd04c3'] = $value;
                    break;
                case 'maker_name2':
                    $repeater_array[2]['field_56157eadd04c3'] = $value;
                    break;
                case 'maker_name3':
                    $repeater_array[3]['field_56157eadd04c3'] = $value;
                    break;
                case 'maker_name4':
                    $repeater_array[4]['field_56157eadd04c3'] = $value;
                    break;
                case 'maker_name5':
                    $repeater_array[5]['field_56157eadd04c3'] = $value;
                    break;
                case 'maker_name6':
                    $repeater_array[6]['field_56157eadd04c3'] = $value;
                    break; 

                //title
                case 'maker_title1':
                   $repeater_array[1]['field_56157ec4d04c4'] = $value;
                    break;   
                case 'maker_title2':
                   $repeater_array[2]['field_56157ec4d04c4'] = $value;
                    break;   
                case 'maker_title3':
                   $repeater_array[3]['field_56157ec4d04c4'] = $value;
                    break;   
                case 'maker_title4':
                   $repeater_array[4]['field_56157ec4d04c4'] = $value;
                    break;   
                case 'maker_title5':
                   $repeater_array[5]['field_56157ec4d04c4'] = $value;
                    break;   
                case 'maker_title5':
                   $repeater_array[6]['field_56157ec4d04c4'] = $value;
                    break;               

                //description
                case 'maker_description1':
                   $repeater_array[1]['field_56157ed3d04c5'] = $value;
                    break;               
                case 'maker_description2':
                   $repeater_array[2]['field_56157ed3d04c5'] = $value;
                    break;               
                case 'maker_description3':
                   $repeater_array[3]['field_56157ed3d04c5'] = $value;
                    break;               
                case 'maker_description4':
                   $repeater_array[4]['field_56157ed3d04c5'] = $value;
                    break;               
                case 'maker_description5':
                   $repeater_array[5]['field_56157ed3d04c5'] = $value;
                    break;               
                case 'maker_description6':
                   $repeater_array[6]['field_56157ed3d04c5'] = $value;
                    break;                           

                //photo
                case 'maker_photo1':
                   $repeater_array[1]['field_56157eded04c6'] = $value;
                    break;               
                case 'maker_photo2':
                   $repeater_array[2]['field_56157eded04c6'] = $value;
                    break;               
                case 'maker_photo3':
                   $repeater_array[3]['field_56157eded04c6'] = $value;
                    break;               
                case 'maker_photo4':
                   $repeater_array[4]['field_56157eded04c6'] = $value;
                    break;               
                case 'maker_photo5':
                   $repeater_array[5]['field_56157eded04c6'] = $value;
                    break;               
                case 'maker_photo6':
                   $repeater_array[6]['field_56157eded04c6'] = $value;
                    break;

                //email
                case 'maker_email1':
                   $repeater_array[1]['field_56157efcd04c7'] = $value;
                    break;               
                case 'maker_email2':
                   $repeater_array[2]['field_56157efcd04c7'] = $value;
                    break;               
                case 'maker_email3':
                   $repeater_array[3]['field_56157efcd04c7'] = $value;
                    break;               
                case 'maker_email4':
                   $repeater_array[4]['field_56157efcd04c7'] = $value;
                    break;               
                case 'maker_email5':
                   $repeater_array[5]['field_56157efcd04c7'] = $value;
                    break;               
                case 'maker_email6':
                   $repeater_array[6]['field_56157efcd04c7'] = $value;
                    break;
                //website
                case 'maker_website1':
                   $repeater_array[1]['field_56157f27d04c8'] = $value;
                    break;               
                case 'maker_website2':
                   $repeater_array[2]['field_56157f27d04c8'] = $value;
                    break;               
                case 'maker_website3':
                   $repeater_array[3]['field_56157f27d04c8'] = $value;
                    break;               
                case 'maker_website4':
                   $repeater_array[4]['field_56157f27d04c8'] = $value;
                    break;               
                case 'maker_website5':
                   $repeater_array[5]['field_56157f27d04c8'] = $value;
                    break;               
                case 'maker_website6':
                   $repeater_array[6]['field_56157f27d04c8'] = $value;
                    break;         

                // Pass through normal (not ACF) custom field data
                default:
                    $meta_array[$key] = $value;
            }
        }else{ //if value is empty just pass thru normal 
            $meta_array[$key] = $value;
        }
    }
    
    // Insert Repeater data
    $meta_array['field_56157e9ad04c2'] = $repeater_array;
 
    return $meta_array;
 
}
add_filter( 'really_simple_csv_importer_save_meta', 'rsci_meta_filter', 10, 3 );