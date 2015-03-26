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

// Double check again we have requested this file
if ( $type == 'maker' ) {

	// Set the query args.
	$search_criteria = array(
			"status" => "active",
			"field_filters" => array(
					"mode" => "any",
					array(
							"key" => "303",
							"operator" => "in", 
							"value" => array( "Accepted" )
					),
			)
	);
	$formids = array(20);
	$entries = GFAPI::get_entries($formids, $search_criteria);
	/*$args = array(
		'no_found_rows'  => true,
		'post_type' 	 => 'maker',
		'post_status' 	 => 'any',
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


	// Init the entities header
	$makers = array();

	// Loop through the posts
	foreach ( $entries as $entry ) {
		// REQUIRED: The maker ID
		$maker['id'] = $entry['id'];

		// REQUIRED: The maker name
		$makerfirstname1=$entry['160.3'];$makerlastname1=$entry['160.6'];
		
		$maker['name'] = $makerfirstname1.' '.$makerlastname1;

		// Maker Thumbnail and Large Images
		$maker_image = isset($entry['217']) ? $entry['217']  : null;
		$maker['thumb_img_url'] = esc_url( legacy_get_resized_remote_image_url( $maker_image, '80', '80' ) );
		$maker['large_image_url'] = esc_url( legacy_get_resized_remote_image_url( $maker_image, '600', '600' ) );;

		// Application ID this maker is assigned to
		// No longer have these
		//$maker['child_id_refs'] = array_unique( get_post_meta( absint( $post->ID ), 'mfei_record' ) );

		// Maker bio information
		$maker['description'] =isset($entry['234']) ? $entry['234']  : null;

		// Maker Video link
		$maker_video = isset($entry['32']) ? $entry['32']  : null;
		$maker['youtube_url'] = ( ! empty( $maker_video ) ) ? esc_url( $maker_video ) : null;

		// Maker Website link
		$maker_website = isset($entry['27']) ? $entry['27']  : null;
		$maker['website_url'] = ( ! empty( $maker_website ) ) ? esc_url( $maker_website ) : null;

		// Put the maker into our list of makers
		array_push( $makers, $maker );
	}

	// Merge the header and the entities
	$merged = array_merge( $header, array( 'entity' => $makers ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
}
