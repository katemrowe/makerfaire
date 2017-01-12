<?php
/**
 * Plugin Name: GP Preview Submission
 * Plugin URI: http://gravitywiz.com/
 * Description: Add a simple submission preview to allow users to confirm their submission is correct before submitting the form.
 * Version: 1.1.5
 * Author: David Smith
 * Author URI: http://gravitywiz.com
 * License: GPL2
 * Perk: True
 */

/**
 * Saftey net for individual perks that are active when core Gravity Perks plugin is inactive.
 */
$gw_perk_file = __FILE__;
if( ! require_once( dirname( $gw_perk_file ) . '/includes/safetynet.php' ) )
    return;

class GP_Preview_Submission extends GWPerk {

    public $version = '1.1.5';
    public $min_gravity_perks_version = '1.2';
    public $min_gravity_forms_version = '1.8';
    public $min_wp_version = '3.7';

    private static $instance = null;

    public static function get_instance( $perk_file ) {
        if( null == self::$instance )
            self::$instance = new self( $perk_file );
        return self::$instance;
    }

    public function init() {

        $this->include_snippet();

        add_action( 'gform_editor_js', array( $this, 'add_merge_tag_support' ) );

    }

    function include_snippet() {

        if( class_exists( 'GWPreviewConfirmation' ) ) {
            if( is_user_logged_in() ) {
                $message = 'You are including the <a href="http://gravitywiz.com/better-pre-submission-confirmation/">GWPreviewConfirmation snippet</a>.
                            The <b>GP Preview Submission</b> perk loads the latest version of this snippet. Please remove your copy of this snippet.';
                $message_function = create_function( '', 'GWPerks::display_admin_message(\'<p>' . $message . '</p>\', \'error\');' );
                add_action( 'admin_notices', $message_function );
            }
        } else {
            require_once( 'includes/gw-gravity-forms-preview-confirmation.php' );
        }

    }

    function documentation() {
        return array(
            'type'  => 'url',
            'value' => 'http://gravitywiz.com/documentation/gp-preview-submission/'
        );
    }

    /**
     * Adds field merge tags to the merge tag drop downs.
     */
    function add_merge_tag_support() {
        ?>

        <script type="text/javascript">

            var gppsDoingMergeTags = false;

            gform.addFilter( 'gform_merge_tags', 'gppsMergeTags' );

            function gppsMergeTags( mergeTags, elementId, hideAllFields, excludeFieldTypes, isPrepop, option ) {

                if( gppsDoingMergeTags )
                    return mergeTags;

                if( elementId == 'field_content' )
                    hideAllFields = false;

                gppsDoingMergeTags = true;
                var allTags = gfMergeTags.getMergeTags( form.fields, elementId, hideAllFields, excludeFieldTypes, false, option );
                gppsDoingMergeTags = false;

                for( var key in allTags ) {

                    if( ! allTags.hasOwnProperty( key ) || jQuery.inArray( key, [ 'required', 'optional', 'pricing' ] ) == -1 || allTags[key].tags.length <= 0 )
                        continue;

                    var tags = allTags[key].tags,
                        newTags = [];

                    for( var i = 0; i < tags.length; i++ ) {

                        var fieldId = gppsGetFieldIdByTag( tags[i].tag );
                        if( ! fieldId )
                            continue;

                        var field = GetFieldById( fieldId ),
                            selField = GetSelectedField(),
                            fieldPageNumber = field.pageNumber,
                            selFieldPageNumber = selField.pageNumber;

                        // leave the field if it is on a previous page
                        if( selFieldPageNumber > fieldPageNumber )
                            newTags.push( tags[i] );

                    }

                    allTags[key].tags = newTags;

                }

                return allTags;
            }

            function gppsGetFieldIdByTag( tag ) {

                var tag = jQuery.trim( Copy( tag ) );
                tag = tag.substring( 1, tag.length - 1 );

                var bits = tag.split( ':' );
                var fieldId = parseInt( bits[bits.length - 1] );

                return isNaN( fieldId ) || fieldId === 0 ? false : fieldId;
            }

        </script>

        <?php
    }

    function has_any_merge_tag( $string ) {
        return preg_match_all( '/{.+}/', $string, $matches, PREG_SET_ORDER );
    }

}

function gp_preview_submission() {
    return GP_Preview_Submission::get_instance( null );
}