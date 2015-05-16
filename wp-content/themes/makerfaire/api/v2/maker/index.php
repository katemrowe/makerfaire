<?php
/**
 * v2 of the Maker Faire API - MAKER
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Maker data.
 *
 * @version 2.0
 */

// Stop any direct calls to this file
defined( 'ABSPATH' ) or die( 'This file cannot be called directly!' );
$type = ( ! empty( $_REQUEST['type'] ) ? sanitize_text_field( $_REQUEST['type'] ) : null );
$faire = ( ! empty( $_REQUEST['faire'] ) ? sanitize_text_field( $_REQUEST['faire'] ) : null );

// Double check again we have requested this file
if ( $type == 'maker' ) {

	
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$select_query = sprintf("SELECT `wp_mf_maker`.`lead_id`,
    `wp_mf_maker`.`First Name`,
    `wp_mf_maker`.`Last Name`,
    `wp_mf_maker`.`Bio`,
    `wp_mf_maker`.`Email`,
    `wp_mf_maker`.`OnsitePhone`,
    `wp_mf_maker`.`TWITTER`,
    `wp_mf_maker`.`SpecialRequest`,
    `wp_mf_maker`.`PresentationTitle`,
    `wp_mf_maker`.`PresentationType`,
    `wp_mf_maker`.`Name`,
    `wp_mf_maker`.`Location`,
    `wp_mf_maker`.`form_id`,
    `wp_mf_maker`.`maker_id`
	FROM `wp_mf_maker`
	INNER JOIN
    `wp_mf_faire` ON FIND_IN_SET(wp_mf_maker.form_id,
            `wp_mf_faire`.`form_ids`) > 0
        AND `wp_mf_faire`.`faire` = '$faire'
	INNER JOIN
	wp_rg_lead on wp_rg_lead.ID = `wp_mf_maker`.`lead_id` and wp_rg_lead.status = 'active'
	WHERE name != 'Contact' 
	and length(`FIRST NAME`) > 0
    and wp_mf_maker.`Status` = 'Accepted'");
	$mysqli->query("SET NAMES 'utf8'");
	$result = $mysqli->query ( $select_query );
	
	// Define the API header (specific for Eventbase)
	$header = array(
		'header' => array(
			'version' => esc_html( MF_EVENTBASE_API_VERSION ),
			'results' => intval( $query->post_count ),
		),
	);
	
	// Init the entities header
	$makers = array();

	// Loop through the posts
	while ( $row = $result->fetch_row () ) {
	
		//Check for null makers
		if (!isset($row['1'])) continue;
			
		// REQUIRED: The maker ID
		$maker['id'] = $row['13'];

		// REQUIRED: The maker name
		$maker['first_name']=$row['1'];
		$maker['last_name']=$row['2'];
		$maker['description']=$row['3'];
		$maker['email']=$row['4'];
		$maker['twitter']=$row['6'];
		
		$maker['name'] = $row['1'].' '.$row['2'];
		$maker['child_id_refs'] = array(); //array_unique( get_post_meta( absint( $post->ID ), 'mfei_record' ) );
		$maker['category_id'] = array('222'); //array_unique( get_post_meta( absint( $post->ID ), 'mfei_record' ) );
		
		// Application ID this maker is assigned to
		
		
		// No longer have these
		
		
		// Maker Thumbnail and Large Images
		//$maker_image = isset($entry['217']) ? $entry['217']  : null;
		//$maker['thumb_img_url'] = esc_url( legacy_get_resized_remote_image_url( $maker_image, '80', '80' ) );
		//$maker['large_image_url'] = esc_url( legacy_get_resized_remote_image_url( $maker_image, '600', '600' ) );;
		
		// Maker bio information
		//$maker['description'] =isset($entry['234']) ? $entry['234']  : null;

		// Maker Video link
		//$maker_video = isset($entry['32']) ? $entry['32']  : null;
		//$maker['youtube_url'] = ( ! empty( $maker_video ) ) ? esc_url( $maker_video ) : null;

		// Maker Website link
		//$maker_website = isset($entry['27']) ? $entry['27']  : null;
		//$maker['website_url'] = ( ! empty( $maker_website ) ) ? esc_url( $maker_website ) : null;

		// Put the maker into our list of makers
		array_push( $makers, $maker );
	}
	// Merge the header and the entities
	$merged = array_merge( $header, array( 'entity' => $makers ) );
	$json_results = json_encode( $merged );
	// Output the JSON
	echo $json_results;

	// Reset the Queryv
	wp_reset_postdata();
}
