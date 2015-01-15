<?php
/**
* Better Pre-submission Confirmation
* http://gravitywiz.com/2012/08/04/better-pre-submission-confirmation/
*/
class GWPreviewConfirmation {

    private static $lead;

    public static function init() {

        // add the "gform_submit" to post so the RGFormsModel::get_form_unique_id() function will pull correct ID
        /*if( ! rgpost( 'gform_submit' ) && rgpost( 'gform_form_id' ) )
            $_POST['gform_submit'] = rgpost( 'gform_form_id' );*/

        add_filter( 'gform_pre_render', array( __class__, 'prepop_merge_tags' ) );
        add_filter( 'gform_pre_render', array( __class__, 'replace_merge_tags' ) );
        add_filter( 'gform_replace_merge_tags', array( __class__, 'product_summary_merge_tag' ), 10, 3 );

    }

    public static function replace_merge_tags( $form ) {

        $current_page = isset( GFFormDisplay::$submission[ $form['id'] ] ) ? GFFormDisplay::$submission[ $form['id'] ]['page_number'] : 1;
        $replace_merge_tags_in_labels = apply_filters( 'gppc_replace_merge_tags_in_labels', false, $form );

        // get all HTML fields on the current page
        foreach($form['fields'] as &$field) {

            if( $replace_merge_tags_in_labels ) {
                // @todo: add support for individual input labels
                $label = GFCommon::get_label( $field );
                if( gp_preview_submission()->has_any_merge_tag( $label ) ) {
                    $field['label'] = self::preview_replace_variables( $label, $form );
                }
            }

            // skip all fields on the first page
            if( rgar( $field, 'pageNumber' ) <= 1 ) {
                continue;
            }

            $default_value = rgar( $field, 'defaultValue' );
            if( gp_preview_submission()->has_any_merge_tag( $default_value ) ) {
                $field['defaultValue'] = rgar( $field, 'pageNumber' ) != $current_page ? '' : self::preview_replace_variables( $default_value, $form );
            }

            // only run 'content' filter for fields on the current page
            if( rgar( $field, 'pageNumber' ) != $current_page ) {
                continue;
            }

            $html_content = rgar( $field, 'content' );
            if( gp_preview_submission()->has_any_merge_tag( $html_content ) ) {
                $field['content'] = self::preview_replace_variables( $html_content, $form );
            }

        }

        return $form;
    }

    public static function prepop_merge_tags( $form ) {

        $has_applicable_field = false;

        foreach( $form['fields'] as &$field ) {

            if( ! rgar( $field, 'allowsPrepopulate' ) )
                continue;

            $has_applicable_field = true;

            // complex fields store inputName in the "name" property of the inputs array
            if( is_array( rgar( $field, 'inputs' ) ) && $field['type'] != 'checkbox' ) {
                foreach( $field['inputs'] as $input ) {
                    if( rgar( $input, 'name' ) )
                        self::add_dynamic_field_value_filter( rgar( $input, 'name' ), $field, $input['id'] );
                }
            } else {
                self::add_dynamic_field_value_filter( rgar( $field, 'inputName' ), $field );
            }

        }

        if( $has_applicable_field )
            add_filter( "gform_form_tag_{$form['id']}", array( __class__, 'add_page_progression_input' ), 99, 3 );

        return $form;
    }

    public static function add_page_progression_input( $form_tag, $form ) {
        $input = sprintf( '<input type="hidden" value="%s" name="gpps_page_progression_%s" />', self::get_page_progression( $form['id'] ), $form['id'] );
        return $form_tag . $input;
    }

    public static function get_page_progression( $form_id ) {

        $source_page = rgpost( "gform_source_page_number_{$form_id}" );
        $progression = rgpost( "gpps_page_progression_{$form_id}" );

        if( $source_page > $progression )
            $progression = $source_page;

        return $progression;
    }

    public static function add_dynamic_field_value_filter( $name, $field, $input_id = false ) {

        $form = GFAPI::get_form( $field['formId'] );

        $value = self::preview_replace_variables( $name, $form );
        if( $value == $name )
            return;

        $is_submit    = ! empty( $_POST["is_submit_{$form['id']}"] );
        $current_page = GFFormDisplay::get_current_page( $form['id'] );
        $field_page   = rgar( $field, 'pageNumber' );

        $input_id_bits = explode( '.', $input_id );
        $input_id = array_pop( $input_id_bits );
        $key = implode( '_', array_filter( array( 'input', $field['id'], $input_id ) ) );

        $on_field_page = $current_page == $field_page;
        $has_value     = ! rgempty( $key );

        if( $is_submit && $on_field_page ) {
            if( ! $has_value || self::get_page_progression( $form['id'] ) < $current_page )
                $_POST[$key] = $value;
        } else {
            add_filter( "gform_field_value_{$name}", create_function( "", "return '$value';" ) );
        }

    }

    /**
    * Adds special support for file upload, post image and multi input merge tags.
    */
    public static function preview_special_merge_tags( $value, $input_id, $options, $field ) {
        
        // added to prevent overriding :noadmin filter (and other filters that remove fields)
        if( ! $value )
            return $value;
        
        $input_type = RGFormsModel::get_input_type($field);
        
        $is_upload_field = in_array( $input_type, array('post_image', 'fileupload') );
        $is_multi_input = is_array( rgar($field, 'inputs') );
        $is_input = intval( $input_id ) != $input_id;
        
        if( !$is_upload_field && !$is_multi_input )
            return $value;

        // if is individual input of multi-input field, return just that input value
        if( $is_input )
            return $value;
            
        $form = RGFormsModel::get_form_meta($field['formId']);
        $lead = self::create_lead($form);
        $currency = GFCommon::get_currency();

        if(is_array(rgar($field, 'inputs'))) {
            $value = RGFormsModel::get_lead_field_value($lead, $field);
            return GFCommon::get_lead_field_display($field, $value, $currency);
        }

        switch($input_type) {
        case 'fileupload':
            $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
            $value = $input_id == 'all_fields' || $options == 'link' ? self::preview_image_display( $field, $form, $value ) : $value;
            break;
        default:
            $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
            $value = GFCommon::get_lead_field_display( $field, $value, $currency );
            break;
        }

        return $value;
    }

    public static function preview_image_value($input_name, $field, $form, $lead) {

        $field_id = $field['id'];
        $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
        $source = RGFormsModel::get_upload_url($form['id']) . "/tmp/" . $file_info["temp_filename"];

        if(!$file_info)
            return '';

        switch(RGFormsModel::get_input_type($field)){

            case "post_image":
                list(,$image_title, $image_caption, $image_description) = explode("|:|", $lead[$field['id']]);
                $value = !empty($source) ? $source . "|:|" . $image_title . "|:|" . $image_caption . "|:|" . $image_description : "";
                break;

            case "fileupload" :
                $value = $source;
                break;

        }

        return $value;
    }

    public static function preview_image_display($field, $form, $value) {

        // need to get the tmp $file_info to retrieve real uploaded filename, otherwise will display ugly tmp name
        $input_name = "input_" . str_replace('.', '_', $field['id']);
        $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);

        $file_path = $value;
        if(!empty($file_path)){
            $file_path = esc_attr(str_replace(" ", "%20", $file_path));
            $value = "<a href='$file_path' target='_blank' title='" . __("Click to view", "gravityforms") . "'>" . $file_info['uploaded_filename'] . "</a>";
        }
        return $value;

    }

    /**
    * Retrieves $lead object from class if it has already been created; otherwise creates a new $lead object.
    */
    public static function create_lead( $form ) {
        
        if( empty( self::$lead ) ) {

            self::$lead = GFFormsModel::create_lead( $form );
            self::clear_field_value_cache( $form );

            foreach( $form['fields'] as $field ) {

                $input_type = GFFormsModel::get_input_type( $field );

                switch( $input_type ) {
                    case 'signature':
                        if( empty( self::$lead[$field['id']] ) )
                            self::$lead[$field['id']] = rgpost( "input_{$form['id']}_{$field['id']}_signature_filename" );
                        break;
                }

            }

        }
        
        return self::$lead;
    }

    public static function preview_replace_variables( $content, $form ) {

        $lead = self::create_lead($form);

        // add filter that will handle getting temporary URLs for file uploads and post image fields (removed below)
        // beware, the RGFormsModel::create_lead() function also triggers the gform_merge_tag_filter at some point and will
        // result in an infinite loop if not called first above
        add_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'), 10, 4);

        $content = GFCommon::replace_variables( $content, $form, $lead, false, false, false );

        // remove filter so this function is not applied after preview functionality is complete
        remove_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'));

        return $content;
    }
    
    public static function clear_field_value_cache( $form ) {
        
        if( ! class_exists( 'GFCache' ) )
            return;
            
        foreach( $form['fields'] as &$field ) {
            //if( GFFormsModel::get_input_type( $field ) == 'total' )
            GFCache::delete( 'GFFormsModel::get_lead_field_value__' . $field['id'] );
        }
        
    }

    /**
     * Provides an {order_summary} merge tag which outputs only the submitted pricing fields table which is automatically appended to the {all_fields} output.
     * This differentiates itself from the GF default {pricing_fields} merge tag in that it does not output the pricing data in a table withing a table.
     * [Example](http://grab.by/ygKq)
     *
     * @param $text
     * @param $form
     * @param $lead
     *
     * @return mixed
     */
    public static function product_summary_merge_tag( $text, $form, $lead ) {

        if( ! $text ) {
            return $text;
        }

        $tags = array( '{product_summary}', '{order_summary}' );
        $has_tag = false;

        foreach( $tags as $tag ) {
            if( strpos( $text, $tag ) !== false ) {
                $has_tag = true;
                break;
            }
        }

        if( ! $has_tag ) {
            return $text;
        }

        if( empty( $lead ) ) {
            $lead = self::create_lead( $form );
        }

        add_filter( 'gform_order_label', '__return_false', 11 );

        $remove = array( "<tr bgcolor=\"#EAF2FA\">\n                            <td colspan=\"2\">\n                                <font style=\"font-family: sans-serif; font-size:12px;\"><strong>Order</strong></font>\n                            </td>\n                       </tr>\n                       <tr bgcolor=\"#FFFFFF\">\n                            <td width=\"20\">&nbsp;</td>\n                            <td>\n                                ", "\n                            </td>\n                        </tr>" );
        $product_summary = str_replace( $remove, '', GFCommon::get_submitted_pricing_fields( $form, $lead, 'html' ) );

        remove_filter( 'gform_order_label', '__return_false', 11 );

        return str_replace( $tags, $product_summary, $text );
    }


}

GWPreviewConfirmation::init();