/**
 * Custom js script loaded on Views edit screen (admin)
 *
 * @package   GravityView
 * @license   GPL2+
 * @author    Katz Web Services, Inc.
 * @link      http://gravityview.co
 * @copyright Copyright 2014, Katz Web Services, Inc.
 *
 * @since 1.0.0
 */


(function( $ ) {

var gvDataTablesExt = {
	init: function() {

		$('#gravityview_directory_template').change( gvDataTablesExt.showMetabox ).change();

		$('#datatables_settingstabletools, #datatables_settingsscroller').change( gvDataTablesExt.showGroupOptions ).change();

		$('#datatables_settingsscroller').change( gvDataTablesExt.toggleNonCompatible ).change();

	},

	showMetabox: function() {
		var template = $('#gravityview_directory_template').val();
		if( 'datatables_table' === template ) {
			$('#gravityview_datatables_settings').slideDown( 'fast' );
		} else {
			$('#gravityview_datatables_settings').slideUp( 'fast' );
		}
	},

	showGroupOptions: function() {
		var _this = $(this);
		if( _this.is(':checked') ) {
			_this.parents('tr').siblings().fadeIn();
		} else {
			_this.parents('tr').siblings().hide();
		}
	},

	toggleNonCompatible: function() {
		var _this = $(this),
			fixedCB = $('#datatables_settingsfixedheader, #datatables_settingsfixedcolumns');


		if( _this.is(':checked') ) {
			fixedCB.prop( 'checked', null ).parents('table').hide();
		} else {
			fixedCB.parents('table').fadeIn();
		}
	}

};



$(document).ready( function() {
	gvDataTablesExt.init();
});


}(jQuery));
