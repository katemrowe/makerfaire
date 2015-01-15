<?php

/**
* Plugin Name: GP Copy Cat
* Description: Allow users to copy the value of one field to another by clicking a checkbox. Is your shipping address the same as your billing? Copy cat!
* Plugin URI: http://gravitywiz/category/perks/
* Version: 1.0.4
* Author: David Smith
* Author URI: http://gravitywiz.com/
* License: GPL2
* Perk: True
*/

/**
* Saftey net for individual perks that are active when core Gravity Perks plugin is inactive.
*/
$gw_perk_file = __FILE__;
if(!require_once(dirname($gw_perk_file) . '/safetynet.php'))
    return;

class GWCopyCat extends GWPerk {

    protected $min_perks_version = '1.0.6';
    public $version = '1.0.4';

    private $script_loaded;

    public function init() {

        add_filter('gform_pre_render', array(&$this, 'copy_cat_js'));

    }

    public function copy_cat_js($form) {

        $form_id = $form['id'];
        $copy_fields = $trigger_selectors = array();

        foreach($form['fields'] as &$field) {

            preg_match_all('/copy-([0-9]+)-to-([0-9]+)/', $field['cssClass'], $matches, PREG_SET_ORDER);

            if(empty($matches))
                continue;

            foreach($matches as $match) {
                list($class, $source_field, $target_field) = $match;
                $copy_fields[$field['id']][] = array('source' => $source_field, 'target' => $target_field);
            }

            $field['cssClass'] .= ' gwcopy';

        }

        if(empty($copy_fields))
            return $form;

        if(!$this->script_loaded) { ?>

        <script type="text/javascript">

        var gwCopyObj = function(formId, fields, overwrite) {

            this._formId = formId;
            this._fields = fields;

            // do not overwrite existing values when a checkbox field is the copy trigger
            this._overwrite = <?php echo GWPerks::apply_filters( 'gpcc_overwrite_existing_values', $form['id'], false, $form, 'test' ) ? 1 : 0; ?>;

            this.init = function() {

                var copyObj = this;

                jQuery('.gwcopy input[type="checkbox"]').bind( 'click.gpcopycat', function(){

                    if(jQuery(this).is(':checked')) {
                        copyObj.copyValues(this);
                    } else {
                        copyObj.clearValues(this);
                    }

                } );

                jQuery( '#gform_wrapper_' + this._formId ).data( 'GPCopyCat', this );

            }

            this.copyValues = function(elem) {

                var copyObj = this;
                var fieldId = jQuery(elem).parents('li.gwcopy').attr('id').replace('field_' + this._formId + '_', '');
                var fields = this._fields[fieldId];

                for(i in fields) {

                    var field = fields[i];

                    var sourceValues = new Array();

                    // group of inputs, selects, etc that are to have their values copied
                    var sourceGroup = jQuery('#field_<?php echo $form_id; ?>_' + field.source + ' input, #field_<?php echo $form_id; ?>_' + field.source + ' select');

                    sourceGroup.each(function(i){
                        // store the values in an array
                        sourceValues[i] = jQuery(this).val();
                    });

                    // group of inputs, selects, etc that are to have values copied to them
                    var targetGroup = jQuery('#field_<?php echo $form_id; ?>_' + field.target + ' input, #field_<?php echo $form_id; ?>_' + field.target + ' select');

                    targetGroup.each(function(i){

                        var targetElem = jQuery(this);

                        // if overwrite is false and a value exists, skip
                        if( ! copyObj._overwrite && targetElem.val() )
                            return;

                        // if there is no source value for this element, skip
                        if(!sourceValues[i] || !sourceValues.join(' '))
                            return;

                        if(targetGroup.length > 1) {
                            targetElem.val(sourceValues[i]);
                        }
                        // if there is only one input, join the source values
                        else {
                            targetElem.val(sourceValues.join(' '));
                        }

                    });

                }

            }

            this.clearValues = function(elem) {

                var fieldId = jQuery(elem).parents('li.gwcopy').attr('id').replace('field_' + this._formId + '_', '');
                var fields = this._fields[fieldId];

                for(i in fields) {

                    var field = fields[i];
                    var targetGroup = jQuery('#field_<?php echo $form_id; ?>_' + field.target + ' input, #field_<?php echo $form_id; ?>_' + field.target + ' select');
                    var sourceValues = new Array();
                    var sourceGroup = jQuery('#field_<?php echo $form_id; ?>_' + field.source + ' input, #field_<?php echo $form_id; ?>_' + field.source + ' select');

                    sourceGroup.each(function(i){
                        // store the values in an array
                        sourceValues[i] = jQuery(this).val();
                    });

                    targetGroup.each(function(i){

                        var fieldValue = jQuery(this).val();

                        if(fieldValue == sourceValues[i])
                            jQuery(this).val('');

                    });

                }

            }

            this.init();

        }

        </script>

        <?php }

        $this->script_loaded = true;

        $script = 'new gwCopyObj(' . $form_id . ', ' . GFCommon::json_encode($copy_fields) . ', false);';

        GFFormDisplay::add_init_script($form_id, 'gwcopycat', GFFormDisplay::ON_PAGE_RENDER, $script);

        return $form;
    }

    function documentation() {
        return array( 'type' => 'url', 'value' => 'http://gravitywiz.com/documentation/gp-copy-cat/' );
    }

}