<?php
/**
 * v2 of the Maker Faire API - SCHEDULE
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Schedule data.
 *
 * @version 2.0
 */

// Stop any direct calls to this file
defined( 'ABSPATH' ) or die( 'This file cannot be called directly!' );

$type = ( ! empty( $_REQUEST['type'] ) ? sanitize_text_field( $_REQUEST['type'] ) : null );
$faire = ( ! empty( $_REQUEST['faire'] ) ? sanitize_text_field( $_REQUEST['faire'] ) : null );
// Double check again we have requested this file
if ( $type == 'schedule' ) {
	$header = array(
			'header' => array(
					'version' => esc_html( MF_EVENTBASE_API_VERSION ),
					'results' => intval( $query->post_count ),
			),
	);
	
	$faire = sanitize_title( $faire );
	
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$select_query = sprintf("SELECT `wp_mf_schedule`.`ID`,
    `wp_mf_schedule`.`entry_id`,
    `wp_mf_schedule`.`location_id`,
    `wp_mf_schedule`.`faire`,
    `wp_mf_schedule`.`start_dt`,
    `wp_mf_schedule`.`end_dt`,
    `wp_mf_schedule`.`day`,
    `wp_mf_api_entity`.`large_image_url`,
    `wp_mf_api_entity`.`thumb_image_url`,
    `wp_mf_api_entity`.`category_id`,
    `wp_mf_api_entity`.`project_title`,
    `wp_mf_api_venue`.ID,
    `wp_mf_location`.`entry_id`,
    `wp_mf_location`.`faire`,
    `wp_mf_location`.`area`,
    `wp_mf_location`.`subarea`,
    `wp_mf_location`.`location`,
    `wp_mf_location`.`latitude`,
    `wp_mf_location`.`longitude`,
    `wp_mf_location`.`location_element_id`,
    `wp_mf_faire_area`.`ID`,
    `wp_mf_faire_area`.`faire_id`,
    `wp_mf_faire_area`.`area`,
	`wp_mf_api_entity`.`child_id_ref`
	FROM `wp_mf_schedule` 
    inner  join `wp_mf_api_entity` on `wp_mf_schedule`.entry_id=`wp_mf_api_entity`.ID
    inner join `wp_mf_location` on `wp_mf_schedule`.entry_id=`wp_mf_location`.entry_id
    inner join `wp_mf_faire_area` on `wp_mf_faire_area`.area=`wp_mf_location`.area
	inner join `wp_mf_faire_subarea` on `wp_mf_faire_subarea`.subarea=`wp_mf_location`.subarea
    inner join `wp_mf_api_venue` on `wp_mf_faire_area`.ID=`wp_mf_api_venue`.area_id and `wp_mf_faire_subarea`.ID=`wp_mf_api_venue`.subarea_id
	 inner join `wp_gravityforms_entity_view` on `wp_mf_schedule`.entry_id=`wp_gravityforms_entity_view`.entry_id AND  `wp_gravityforms_entity_view`.status = 'Accepted'
        AND  `wp_gravityforms_entity_view`.entry_status = 'active'
   		WHERE `wp_mf_schedule`.faire = '$faire' ");
 	$mysqli->query("SET NAMES 'utf8'");
 	
	$result = $mysqli->query ( $select_query );
	// Initalize the schedule container
	$schedules = array();

	// Loop through the posts
	while ( $row = $result->fetch_row () ) {
	
		// Return some post meta
		$schedule_id = $row[0];
		$entry_id = $row[1];
		$app_id = $entry_id;
		$day = $row[6];
		$start = strtotime($row[4]);
		$stop = strtotime($row[5]);
		//$dates = mf_get_faire_date( $faire );

		// REQUIRED: Schedule ID
		$schedule['id'] = $schedule_id;
		$schedule_name = isset ( $row[10] ) ? $row[10] : '';
		$project_photo =  isset ( $row[7] ) ? $row[7] : '';
		// REQUIED: Application title paired to scheduled item
		$schedule['name'] = html_entity_decode( $schedule_name , ENT_COMPAT, 'utf-8' );
		$schedule['time_start'] = date( DATE_ATOM, strtotime( '+7 hour',  $start ) );
		$schedule['time_end'] = date( DATE_ATOM, strtotime( '+7 hour', $stop ) );
		
		//ORIGINAL CALL
		//$schedule['time_start'] = date( DATE_ATOM, strtotime( '-1 hour', strtotime( $dates[$day] . $start . $dates['time_zone'] ) ) );
		//$schedule['time_end'] = date( DATE_ATOM, strtotime( '-1 hour', strtotime( $dates[$day] . $stop . $dates['time_zone'] ) ) );
		// Rename the field, keeping 'time_end' to ensure this works.
		$schedule['time_stop'] = date( DATE_ATOM, strtotime( '+7 hour', $stop ) );
			
               //bad hack to convert to gmt time
              /*  $schedule['time_start'] = str_replace('+00:00', '-07:00', $schedule['time_start']);
                $schedule['time_end'] = str_replace('+00:00', '-07:00', $schedule['time_end']);
                $schedule['time_stop'] = str_replace('+00:00', '-07:00', $schedule['time_stop']);
              */  
		// REQUIRED: Venue ID reference
		$schedule['venue_id_ref'] = $row[11];

		// Schedule thumbnails. Nothing more than images from the application it is tied to
		//$post_content = json_decode( mf_clean_content( get_page( absint( $app_id ) )->post_content ) );
		$app_image = $project_photo;

		$schedule['thumb_img_url'] = esc_url( legacy_get_resized_remote_image_url( $app_image, '80', '80' ) );
		$schedule['large_img_url'] = esc_url( legacy_get_resized_remote_image_url( $app_image, '600', '600' ) );

		$maker_ids = explode(',',$row[23]);
		
		// A list of applications assigned to this event (should only be one really...)
		$schedule['entity_id_refs'] = $maker_ids = array_merge(array( $entry_id),$maker_ids);

		// Application Makers
		$schedule['maker_id_refs'] = $maker_ids;

		
		
		// Put the application into our list of schedules
		array_push( $schedules, $schedule );
	}

	// Merge the header and the entities
	$merged = array_merge( $header, array( 'schedule' => $schedules ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();

}