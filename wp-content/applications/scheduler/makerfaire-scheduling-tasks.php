<?php
use Kendo\Template;
error_reporting ( E_ALL );
ini_set ( 'display_errors', '1' );

require_once ("../../../wp-load.php");
require_once '../lib/Kendo/Autoload.php';

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	header ( 'Content-Type: application/json' );
	
	$request = json_decode ( file_get_contents ( 'php://input' ) );
	$result = readWithAssociation ( 'NY15', '' );
	echo json_encode ( $result ['data'], JSON_NUMERIC_CHECK );
	
	exit ();
}
elseif ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	header ( 'Content-Type: application/json' );

	$request = json_decode ( file_get_contents ( 'php://input' ) );
	$type = $_GET['type'];
	
	switch ($type) {
		case 'create' :
				
			$subareaid = $request->SubareaID;
			$start = date ( 'Y-m-d H:i:s', strtotime ( $request->Start ) );
			$end = date ( 'Y-m-d H:i:s', strtotime ( $request->End ) );
			$entries = $request->Entries [0];
			$result = add_entry_schedule ( 'NY15', $subareaid, $start, $end, $entries );
			// $result=1 ; // $result = $result->createWithAssociation('Meetings', 'MeetingAttendees', $columns, $request->models, 'MeetingID', array('Attendees' => 'AttendeeID'));
			break;
		case 'update' :
			$locationID = $request->locationID;
			remove_entry_schedule($locationID);
			$subareaid = $request->SubareaID;
			$start = date ( 'Y-m-d H:i:s', strtotime ( $request->Start ) );
			$end = date ( 'Y-m-d H:i:s', strtotime ( $request->End ) );
			$entries = $request->Entries [0];
			$result = add_entry_schedule ( 'NY15', $subareaid, $start, $end, $entries );
			break;
		case 'destroy' :
			$locationID = $request->locationID;
			remove_entry_schedule($locationID);
			$result = $locationID;
			break;
		default :
			break;
	}

	echo json_encode ( $result, JSON_NUMERIC_CHECK );

	exit ();
}

/* Modify Set Entry Status */
function add_entry_schedule($faire_id, $subarea_id, $entry_schedule_start, $entry_schedule_end, $entry_info_entry_id) {
	// $entry_schedule_change = (isset($_POST['entry_schedule_change']) ? $_POST['entry_schedule_change'] : '');
	// $entry_schedule_start = (isset($_POST['datetimepickerstart']) ? $_POST['datetimepickerstart'] : '');
	// $entry_schedule_end = (isset($_POST['datetimepickerend']) ? $_POST['datetimepickerend'] : '');
	// $entry_info_entry_id = (isset($_POST['entry_info_entry_id']) ? $_POST['entry_info_entry_id'] : '');
	
	// location fields
	$location_id = 'NULL';
	$entry_location_subarea_change = add_entry_location ( $entry_info_entry_id, $subarea_id, $location_id );
	
	// $form_id=$lead['form_id'];
	
	// set the location
	$mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$insert_query = sprintf ( "INSERT INTO `wp_mf_schedule`
					(`entry_id`,
					location_id,
					`faire`,
					`start_dt`,
					`end_dt`)
					SELECT $entry_info_entry_id,$location_id,wp_mf_faire.faire,'$entry_schedule_start', '$entry_schedule_end'
					from wp_mf_faire where faire= '$faire_id'
					" );
	
	// MySqli Insert Query
	$insert_row = $mysqli->query ( $insert_query );
	if ($insert_row) {
		$result_id = $mysqli->insert_id;
	} else {
		echo ('Error :' . $insert_query . ':(' . $mysqli->errno . ') ' . $mysqli->error);
	}
	;
	
	return $result_id;
}

/* Modify Set Entry Status */
function remove_entry_schedule($schedule_id) {
	$mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$delete_query = sprintf ( "   DELETE s,l
      FROM `wp_mf_schedule` s
      JOIN 
		 wp_mf_location l ON  l.entry_id = s.`entry_id`
	           AND s.location_id = l.ID
     WHERE s.`ID` = $schedule_id" );
		// MySqli Insert Query
		$mysqlresults = $mysqli->query ( $delete_query );
		if ($mysqlresults) {
			$result_id = $schedule_id;
		} else {
			echo ('Error :' . $delete_query . ':(' . $mysqli->errno . ') ' . $mysqli->error);
		}
		;
		return $result_id;
}

function read_schedule($faire_id, $subarea_id, &$total) {
	$mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$select_query = sprintf ( "SELECT 
	    `wp_mf_schedule`.`ID`,
	    `wp_mf_schedule`.`entry_id`,
	    location.subarea_id,
	    `wp_mf_schedule`.`faire`,
	   `wp_mf_schedule`.`start_dt`,
	    `wp_mf_schedule`.`end_dt`
	FROM
	    `wp_mf_schedule`
			JOIN 
		 wp_mf_location location ON  location.entry_id = `wp_mf_schedule`.`entry_id`
	           AND wp_mf_schedule.location_id = location.ID
	        JOIN
	    wp_mf_faire ON wp_mf_schedule.faire = wp_mf_faire.faire
	WHERE
	    wp_mf_faire.faire = '$faire_id'
	ORDER BY  start_dt ASC" );
	$total = 0;
	$result = $mysqli->query ( $select_query );
	$schedule_entries = array ();
	if ($result) {
		while ( $row = $result->fetch_assoc () ) {
			$total ++;
			// order entries by subarea(stage), then date
			$stage = $row ['subarea_id'];
			$start_dt =  new DateTime(@$row ['start_dt']);
			// $start_dt_formatted = date('Y/j/n h:i:s A',$start_dt);
			$end_dt = new DateTime(@$row ['end_dt']);
			$schedule_entry_id = $row ['ID'];
			$entry_ids = array (
					$row ['entry_id'] 
			);
			// build array
			/*$schedule_entries [] = array (
					'locationID' => $schedule_entry_id,
					'start' => $start_dt,
					'end' => $end_dt,
					'isAllDay' => false,
					'description' => '',
					'recurrenceId' => null,
					'recurrenceRule' => null,
					'recurrenceException' => null,
					'ownerID' => 2,
					'title' => 'Test',
					'subareaId' => $stage,
					'entries' => $entry_ids 
			);
			*/
$schedule_entries [] = array (
		'locationID' => $schedule_entry_id,
		'Start' => $start_dt->format(DateTime::ISO8601),
		'End' => $end_dt->format(DateTime::ISO8601),
		'IsAllDay' => false,
		'SubareaID' => $stage,
		'Entries' => $entry_ids,
		'Title' => '');
		}
	} else {
		echo ('Error :' . $select_query . ':(' . $mysqli->errno . ') ' . $mysqli->error);
	}
	;
	
	return $schedule_entries;
}
/* Modify Set Entry Status */
function add_entry_location($entry_id, $subarea_id, &$location_id = '') {
	$entry_info_entry_id = $entry_id;
	
	$mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	$insert_query = sprintf ( "
				INSERT INTO `wp_mf_location`
				(`entry_id`,
				`subarea_id`,
				`location`,
				`location_element_id`)
				Select $entry_info_entry_id
				,$subarea_id
				,''
				,3;" );
	// MySqli Insert Query
	$insert_row = $mysqli->query ( $insert_query );
	if ($insert_row) {
		$result_id = $mysqli->insert_id;
	} else {
		echo ('Error :' . $insert_query . ':(' . $mysqli->errno . ') ' . $mysqli->error);
	}
	;
	$location_id = $result_id;
}
function readWithAssociation($faire_id, $subarea_id) {
	$result = array ();
	$total = 0;
	$schedule_entries = read_schedule ( $faire_id, $subarea_id, $total );
	$result ['total'] = $total;
	$result ['data'] = $schedule_entries;
	
	return $result;
}

?>