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
	// NOTE: For next year address Sponsors.
	//The sql here is hardcoded for specific id's because of an issue with sponsors not being correctly added.
	$select_query = sprintf("
SELECT `wp_gravityforms_entity_view`.`entry_id`,
    `wp_gravityforms_entity_view`.`Title`,
    `wp_gravityforms_entity_view`.`Description`,
    `wp_gravityforms_entity_view`.`URL`,
    `wp_gravityforms_entity_view`.`Categories`,
     maker.`exhibit_makers`,
    `wp_gravityforms_entity_view`.`THUMBPHOTO`,
    `wp_gravityforms_entity_view`.`PHOTO`,
  	 `wp_mf_api_venue`.ID
FROM
    `wp_gravityforms_entity_view`
	left outer join `wp_mf_location` on wp_gravityforms_entity_view.entry_id = wp_mf_location.entry_id
	left outer join `wp_mf_faire_subarea` on wp_mf_location.subarea = wp_mf_faire_subarea.subarea
	left outer join `wp_mf_api_venue` on `wp_mf_api_venue`.`subarea_id` = `wp_mf_faire_subarea`.ID 
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
			AND  `wp_gravityforms_entity_view`.status = 'Accepted'
        AND  `wp_gravityforms_entity_view`.entry_status = 'active'
        AND `wp_mf_faire`.`faire` = '$faire'
		AND `wp_gravityforms_entity_view`.`entry_id` not IN ( '50281',
'51263',
'51491',
'51378',
'51481',
'51313',
'51409',
'51480',
'51492',
'51430',
'51471',
'51391',
'51472',
'51427',
'50048',
'51319',
'50545',
'51365',
'51349',
'51346',
'51286',
'50303',
'51357',
'51332',
'50125',
'51336',
'51301',
'51493',
'51356',
'51468',
'51326',
'51287',
'51461',
'51314',
'51384',
'51474',
'50830',
'50133',
'51411',
'51289',
'51315',
'51458',
'50315',
'51469',
'51368',
'51277',
'51497',
'51485',
'50052',
'51490',
'51419',
'51433',
'51500',
'51267',
'51483',
'51470',
'51331',
'51476',
'50686',
'51329',
'51399',
'51477',
'51344',
'51325',
'51337',
'51320',
'51505',
'51352',
'51400',
'51499',
'50892',
'51322',
'51447',
'50386',
'51375',
'51350',
'50818',
'51478',
'51360',
'51423',
'51498',
'51345',
'50129',
'51396',
'51364',
'51495',
'50288',
'50392',
'51434',
'51371',
'51422',
'51405',
'51406',
'51388',
'51372',
'51431',
'51489',
'50243',
'50650',
'51501',
'51303',
'51479',
'51359',
'51462',
'51376',
'51278',
'51487',
'50612',
'51377',
'50591',
'50520',
'51488',
'51374')
UNION ALL
SELECT `wp_gravityforms_entity_view`.`entry_id`,
    `wp_gravityforms_entity_view`.`Title`,
    `wp_gravityforms_entity_view`.`Description`,
    `wp_gravityforms_entity_view`.`URL`,
    CONCAT(`wp_gravityforms_entity_view`.`Categories`,',333'),
     '',
    `wp_gravityforms_entity_view`.`THUMBPHOTO`,
    `wp_gravityforms_entity_view`.`PHOTO`,
  	 `wp_mf_api_venue`.ID
FROM
    `wp_gravityforms_entity_view`
	left outer join `wp_mf_location` on wp_gravityforms_entity_view.entry_id = wp_mf_location.entry_id
	left outer join `wp_mf_faire_subarea` on wp_mf_location.subarea = wp_mf_faire_subarea.subarea
	left outer join `wp_mf_api_venue` on `wp_mf_api_venue`.`subarea_id` = `wp_mf_faire_subarea`.ID 
    where
         `wp_gravityforms_entity_view`.`entry_id` IN ( '50281',
'51263',
'51491',
'51378',
'51481',
'51313',
'51409',
'51480',
'51492',
'51430',
'51471',
'51391',
'51472',
'51427',
'50048',
'51319',
'50545',
'51365',
'51349',
'51346',
'51286',
'50303',
'51357',
'51332',
'50125',
'51336',
'51301',
'51493',
'51356',
'51468',
'51326',
'51287',
'51461',
'51314',
'51384',
'51474',
'50830',
'50133',
'51411',
'51289',
'51315',
'51458',
'50315',
'51469',
'51368',
'51277',
'51497',
'51485',
'50052',
'51490',
'51419',
'51433',
'51500',
'51267',
'51483',
'51470',
'51331',
'51476',
'50686',
'51329',
'51399',
'51477',
'51344',
'51325',
'51337',
'51320',
'51505',
'51352',
'51400',
'51499',
'50892',
'51322',
'51447',
'50386',
'51375',
'51350',
'50818',
'51478',
'51360',
'51423',
'51498',
'51345',
'50129',
'51396',
'51364',
'51495',
'50288',
'50392',
'51434',
'51371',
'51422',
'51405',
'51406',
'51388',
'51372',
'51431',
'51489',
'50243',
'50650',
'51501',
'51303',
'51479',
'51359',
'51462',
'51376',
'51278',
'51487',
'50612',
'51377',
'50591',
'50520',
'51488',
'51374')
        
        ");
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
		$app['venue_id_ref'] =  $row[8];

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