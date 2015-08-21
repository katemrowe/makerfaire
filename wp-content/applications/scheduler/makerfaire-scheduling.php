<?php
use Kendo\Template;
error_reporting ( E_ALL );
ini_set ( 'display_errors', '1' );

require_once ("../../../wp-load.php");
require_once '../lib/Kendo/Autoload.php';
$faire_id = isset($_GET['faire_id']) ? $_GET['faire_id']  : $faire_id;
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	header ( 'Content-Type: application/json' );
	
	$request = json_decode ( file_get_contents ( 'php://input' ) );
	// $result = new SchedulerDataSourceResult('sqlite:..//sample.db');
	$type = $_POST ['type'];
	switch ($type) {
		case 'create' :
			
			$subareaid = $request->SubareaID;
			$start = date ( 'Y-m-d H:i:s', strtotime ( $request->Start ) );
			$end = date ( 'Y-m-d H:i:s', strtotime ( $request->End ) );
			$entries = $request->Entries [0];
			$result = add_entry_schedule ( $faire_id, $subareaid, $start, $end, $entries );
			// $result=1 ; // $result = $result->createWithAssociation('Meetings', 'MeetingAttendees', $columns, $request->models, 'MeetingID', array('Attendees' => 'AttendeeID'));
			break;
		case 'update' :
			$result = 1; // $result = $result->updateWithAssociation('Meetings', 'MeetingAttendees', $columns, $request->models, 'MeetingID', array('Attendees' => 'AttendeeID'));
			break;
		case 'destroy' :
			$result = 1; // $result = $result->destroyWithAssociation('Meetings', 'MeetingAttendees', $request->models, 'MeetingID');
			break;
		default :
			$result = readWithAssociation ( $faire_id, '' );
			break;
	}
	
	echo json_encode ( $result ['data'], JSON_NUMERIC_CHECK );
	
	exit ();
}

?>

<?php
require_once '../include/header.php';
?>
<form>
<div class="k-floatwrap k-header k-scheduler-toolbar">
<?php
$locations_array = get_entry_locations ( $faire_id );
	
$select = new \Kendo\UI\MultiSelect('locationfilters');
$select->dataSource ( $locations_array )
->change('onChange')
->dataTextField ( 'text' )
->dataValueField ( 'value' )
->placeholder ( 'Filter location ...' );;

echo $select->render();

?>
</div>
<?php
$scheduler = create_makerfaire_scheduler ( $faire_id );
echo $scheduler->render ();
?>

<script>
    $(document).ready(function() {
        // create ComboBox from select HTML element
        var input = $("#input").data("kendoComboBox");
        var select = $("#select").data("kendoComboBox");

        $("#get").click(function() {
            alert('Thank you! Your Choice is:\n\nFabric ID: '+input.value()+' and Size: '+select.value());
        });
    });
</script>
<script id="presentation-template" type="text/x-kendo-template">
    <p>#: JSON.stringify(entries) #</p>
</script>
<!-- begin#woahbar -->
<div class="woahbar" style="display: none;">
	<span> <a class="woahbar-link" href="/wp-admin/">Back to wp-admin</a>
	</span> <a class="close-notify" onclick="woahbar_hide();"> <img
		class="woahbar-up-arrow"
		src="/wp-content/applications/woahbar/woahbar-up-arrow.png" /></a>
</div>
<div class="woahbar-stub" style="display: none;">
	<a class="show-notify" onclick="woahbar_show();"> <img
		class="woahbar-down-arrow"
		src="/wp-content/applications/woahbar/woahbar-down-arrow.png" />
	</a>
</div>
<style>
/*
        Use the DejaVu Sans font for display and embedding in the PDF file.
        The standard PDF fonts have no support for Unicode characters.
    */
.k-scheduler {
	font-family: "DejaVu Sans", "Arial", sans-serif;
}

/* Hide toolbar, navigation and footer during export */
.woahbar,.k-pdf-export .k-scheduler-toolbar,.k-pdf-export .k-scheduler-navigation .k-nav-today,.k-pdf-export .k-scheduler-navigation .k-nav-prev,.k-pdf-export .k-scheduler-navigation .k-nav-next,.k-pdf-export .k-scheduler-footer
	{
	display: none;
}
</style>

<!-- Load Pako ZLIB library to enable PDF compression -->
<script src="../content/shared/js/pako.min.js"></script>
<style>
.k-scheduler-layout {
	table-layout: fixed;
}

.k-scheduler-layout>tbody>tr>td:first-child {
	width: 80px;
}

/* .k-scheduler-content .k-scheduler-table,.k-scheduler-header .k-scheduler-table
	{
	 width: 3000px ;
} 
*/

</style>
<script>
function onChange(e) {
    if ("kendoConsole" in window) {
    	 var multiSelect = $("#locationfilters").data("kendoMultiSelect");
         var checked = multiSelect.value();
    		  kendoConsole.log("event: select (" + checked + ")" );

         var multiSelect = $("#locationfilters").data("kendoMultiSelect");
	     var checked = multiSelect.value();

		 var filter = {
		    logic: "or",
		    filters: $.map(checked, function(value) {
		      return {
		        operator: "eq",
		        field: "value",
		        value: value
		      };
		    })
		  };
		   
		  var scheduler = $("#scheduler").data("kendoScheduler"); 
		  //filter the resource data source
		  scheduler.resources[0].dataSource.filter(filter); 
		   
		  scheduler.view(scheduler.view().name); //refresh the currunt view 
		}

};
</script>
<!-- end#woahbar -->
<?php
// require_once '../include/footer.php';
function get_entry_locations($faire_id) {
	$mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$locations = array ();
	
	$result = $mysqli->query ( "SELECT 	 `wp_mf_faire_subarea`.`id`,
			`wp_mf_faire_subarea`.`subarea`
			FROM  wp_mf_faire_subarea, wp_mf_faire_area, wp_mf_faire
			where faire='$faire_id'
			and   wp_mf_faire_subarea.area_id = wp_mf_faire_area.ID
			and   wp_mf_faire_area.faire_id   = wp_mf_faire.ID" ) or trigger_error ( $mysqli->error );
	
	if ($result) {
		while ( $row = $result->fetch_row () ) {
			$subarea = $row [1];
			$subarea_id = $row [0];
			
			$locations [] = array (
					'text' => $subarea,
					'value' => $subarea_id,
					'color' => '#6eb3fa' 
			);
		}
	}
	// Create Update button for sidebar entry management
	return $locations;
}
function get_entries($faire_id) {
	$mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$entries = array ();
	
	$result = $mysqli->query ( "SELECT lead_id,presentation_title ,status
				FROM wp_mf_entity
				where faire='$faire_id'" ) or trigger_error ( $mysqli->error );
	
	if ($result) {
		while ( $row = $result->fetch_row () ) {
			$entry = preg_replace ( "/[^A-Za-z0-9 ]/", '', $row [1] );
			$entry_id = $row [0];
			$entry_status = $row [2];
			$entry_color = status_to_color ( $entry_status );
			$entry_title = "$entry_id ($entry - $entry_status)";
			$entries [] = array (
					'text' => $entry_title,
					'value' => $entry_id,
					'color' => $entry_color 
			);
		}
	}
	// Create Update button for sidebar entry management
	return $entries;
}
function status_to_color($entry_status) {
	$result = '';
	switch ($entry_status) {
		case 'Accepted' :
			$result = '#90EE90'; // $result = $result->createWithAssociation('Meetings', 'MeetingAttendees', $columns, $request->models, 'MeetingID', array('Attendees' => 'AttendeeID'));
			break;
		case 'Proposed' :
		case 'Wait List' :
			$result = '#FAFAD2'; // $result = $result->updateWithAssociation('Meetings', 'MeetingAttendees', $columns, $request->models, 'MeetingID', array('Attendees' => 'AttendeeID'));
			break;
		case 'Cancelled' :
		case 'No Show' :
		case 'Rejected' :
			$result = '#F08080'; // $result = $result->destroyWithAssociation('Meetings', 'MeetingAttendees', $request->models, 'MeetingID');
			break;
		default :
			$result = '#E0FFFF'; // $result = $result->readWithAssociation('Meetings', 'MeetingAttendees', 'MeetingID', array('AttendeeID' => 'Attendees'), array('MeetingID', 'RoomID'), $request);
			break;
	}
	
	return $result;
}


function create_makerfaire_scheduler($faire_id) {
	$transport = new \Kendo\Data\DataSourceTransport ();
	
	$create = new \Kendo\Data\DataSourceTransportCreate ();
	
	$create->url ( 'makerfaire-scheduling-tasks.php?type=create' )->contentType ( 'application/json' )->type ( 'POST' )->dataType('json');
	
	$read = new \Kendo\Data\DataSourceTransportRead ();
	
	$read->url ( 'makerfaire-scheduling-tasks.php?type=read' )->contentType ( 'application/json' )->type ( 'GET' )->dataType('json');
	
	$update = new \Kendo\Data\DataSourceTransportUpdate ();
	
	$update->url ( 'makerfaire-scheduling-tasks.php?type=update' )->contentType ( 'application/json' )->type ( 'POST' )->dataType('json');
	
	$destroy = new \Kendo\Data\DataSourceTransportDestroy ();
	
	$destroy->url ( 'makerfaire-scheduling-tasks.php?type=destroy' )->contentType ( 'application/json' )->type ( 'POST' )->dataType('json');
	
	$transport->create ( $create )->read ( $read )->update ( $update )->destroy ( $destroy )->parameterMap ( 'function(data) {
              return kendo.stringify(data);
          }' );
	
	$model = new \Kendo\Data\DataSourceSchemaModel ();
	
	$locationIdField = new \Kendo\Data\DataSourceSchemaModelField ( 'locationID' );
	$locationIdField->type ( 'number' )->from ( 'locationID' )->nullable ( true );
	
	$titleField = new \Kendo\Data\DataSourceSchemaModelField ( 'title' );
	$titleField->from ( 'Title' )->defaultValue ( 'No title' )->validation ( array (
			'required' => false 
	) );
	
	$startField = new \Kendo\Data\DataSourceSchemaModelField ( 'start' );
	$startField->type ( 'date' )->from ( 'Start' );
	
	$endField = new \Kendo\Data\DataSourceSchemaModelField ( 'end' );
	$endField->type ( 'date' )->from ( 'End' );
	
	$isAllDayField = new \Kendo\Data\DataSourceSchemaModelField ( 'isAllDay' );
	$isAllDayField->type ( 'boolean' )->from ( 'IsAllDay' );
		
	$subareaIdField = new \Kendo\Data\DataSourceSchemaModelField ( 'subareaId' );
	$subareaIdField->from ( 'SubareaID' )->nullable ( true );
	
	$entriesField = new \Kendo\Data\DataSourceSchemaModelField ( 'entries' );
	$entriesField->from ( 'Entries' )->nullable ( true );
	
	$model->id ( 'locationID' )->addField ( $locationIdField )->addField ( $titleField )->addField ( $startField )->addField ( $endField )->addField ( $isAllDayField )->addField ( $subareaIdField )->addField ( $entriesField );
	
	$schema = new \Kendo\Data\DataSourceSchema ();
	$schema->model ( $model );
	
	$dataSource = new \Kendo\Data\DataSource ();
	/*
	 * $schedule_entries = read_schedule($faire_id,''); echo print_r($schedule_entries);
	 */
	

	
	$dataSource->transport ( $transport )->schema ( $schema )->batch ( false )->data ( $schedule_entries );
	
	$subareasResource = new \Kendo\UI\SchedulerResource ();
	$locations_array = get_entry_locations ( $faire_id );
	
	$subareasResource->field ( 'subareaId' )->title ( 'Stage' )->name ( 'Stages' )->dataSource ( $locations_array );
	
	$entries = get_entries ( $faire_id );
	$entriesResource = new \Kendo\UI\SchedulerResource ();
	$entriesResource->field ( 'entries' )->title ( 'Presenter' )->multiple ( true )->name ( 'Presenters' )->dataSource ( $entries );
	
	$pdf = new \Kendo\UI\SchedulerPdf ();
	$pdf->fileName ( 'Kendo UI Scheduler Export.pdf' )->proxyURL ( 'makerfaire-scheduling.php?type=save' );
	
	$scheduler = new \Kendo\UI\Scheduler ( 'scheduler' );
	
	$scheduler->eventTemplateId ( 'presentation-template' )
		//->editable(array('update' => 'true','template'=>'customEditorTemplate'))
		->timezone('America/New_York')
		->date(new DateTime ( '2015/9/25  7:00', new DateTimeZone ( 'America/New_York' ) ) )->height ( 900 )->pdf ( $pdf )->addToolbarItem ( new \Kendo\UI\SchedulerToolbarItem ( 'pdf' ) )->addResource ( $subareasResource, $entriesResource )->group ( array (
			'resources' => array (
					'Stages' 
			) 
	) )->addView ( array (
			'type' => 'day',
			'majorTick' => 30,
			'startTime' => new DateTime ( '2015/9/25 7:00', new DateTimeZone ( 'America/New_York' ) ) 
	), array (
			'type' => 'workWeek',
			'majorTick' => 30,
			'selected' => true,
			'workWeekStart' => 5,
			'workWeekEnd' => 7,
			'startTime' => new DateTime ( '2015/9/25 7:00', new DateTimeZone ( 'America/New_York' ) ) 
	), 'agenda' )->dataSource ( $dataSource );
	
	return $scheduler;
}
function debug_to_console($data) {
	if (is_array ( $data ))
		$output = "<script>console.log( 'Debug Objects: " . implode ( ',', $data ) . "' );</script>";
	else
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
	
		echo $output;
}


?>