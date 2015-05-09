<?php
error_reporting( 'NONE' );
/**
 * v2 of the Maker Faire API - ENTITY
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Entity type for the mobile app. AKA the applications.
 *
 * @version 2.0
 */

// Stop any direct calls to this file
defined( 'ABSPATH' ) or die( 'This file cannot be called directly!' );
$type = ( ! empty( $_REQUEST['type'] ) ? sanitize_text_field( $_REQUEST['type'] ) : null );
$faire = ( ! empty( $_REQUEST['faire'] ) ? sanitize_text_field( $_REQUEST['faire'] ) : null );


// Double check again we have requested this file
if ( $type == 'entity' ) {

	// Set the query args.
	/*
	 * $args = array(
		'no_found_rows'	 => true,
		'post_type'		 => 'mf_form',
		'post_status'	 => 'accepted',
		'posts_per_page' => absint( MF_POSTS_PER_PAGE ),
		'faire'			 => sanitize_title( $faire ),
	);
	$query = new WP_Query( $args );
	*/

	// Define the API header (specific for Eventbase)
	$header = array(
		'header' => array(
			'version' => esc_html( MF_EVENTBASE_API_VERSION ),
			'results' => intval( $query->post_count ),
		),
	);

	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$select_query = sprintf("
SELECT `wp_gravityforms_entity_view`.`entry_id`,
    `wp_gravityforms_entity_view`.`Title`,
    `wp_gravityforms_entity_view`.`Description`,
    `wp_gravityforms_entity_view`.`URL`,
    `wp_gravityforms_entity_view`.`Categories`,
     maker.`exhibit_makers`,
    `wp_gravityforms_entity_view`.`THUMBPHOTO`,
    `wp_gravityforms_entity_view`.`PHOTO`
FROM
    `wp_gravityforms_entity_view`
        INNER JOIN
    (SELECT 
        GROUP_CONCAT(DISTINCT (`maker_id`)
                SEPARATOR ',') AS `exhibit_makers`,
            lead_id
    FROM
        wp_mf_maker
    WHERE
        `First Name` IS NOT NULL
    GROUP BY lead_id) maker ON `wp_gravityforms_entity_view`.`entry_ID` = maker.lead_id
        INNER JOIN
    `wp_mf_faire` ON FIND_IN_SET(wp_gravityforms_entity_view.form_id,
            `wp_mf_faire`.`form_ids`) > 0
        AND `wp_mf_faire`.`faire` = '$faire')");
 	$mysqli->query("SET NAMES 'utf8'");
	$result = $mysqli->query ( $select_query );
	
	// Initalize the app container
	$apps = array();

	// Loop through the posts
	while ( $row = $result->fetch_row () ) {
		// Store the app information
		//$app_data = json_decode( mf_clean_content( $post->post_content ) );

		// REQUIRED: Application ID
		$app['id'] = absint( $row[0]);

		// REQUIRED: Application name
		$app['name'] = html_entity_decode( $row[1], ENT_COMPAT, 'utf-8' );

		// Application Thumbnail and Large Images
		$app_image =$row[7];
		$app['thumb_img_url'] = esc_url( legacy_get_resized_remote_image_url( $app_image, '80', '80' ) );
		$app['large_image_url'] = esc_url( $app_image );
		// Should actually be this... Adding it in for the future.
		$app['large_img_url'] = esc_url( $app_image );

		// Application Locations
		$app['venue_id_ref'] = ''; //NOTE: Needs to be implemented $row[8];

		// Application Makers
		$app_id = $app['id'];// get the entity id

		$maker_ids = $row[5];

		$app['child_id_refs'] = ( ! empty( $maker_ids ) ) ? explode(',',$maker_ids) : null;

		// Application Categories
		$category_ids = $row[4];
		$app['category_id_refs'] = explode(',',$category_ids);

		// Application Description
		$app['description'] = $row[2];

		// Put the application into our list of apps
		array_push( $apps, $app );
	}

	// Merge the header and the entities
	$merged = array_merge( $header, array( 'entity' => $apps ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();

}