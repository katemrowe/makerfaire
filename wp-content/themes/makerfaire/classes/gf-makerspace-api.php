<?php
add_action( 'gform_after_submission', 'post_to_third_party', 10, 2 );
function post_to_third_party( $entry, $form ) {

	$post_url = 'http://thirdparty.com';
	$body = array(
			'first_name' => rgar( $entry, '1.3' ),
			'last_name' => rgar ( $entry, '1.6' ),
			'message' => rgar( $entry, '3' ),
	);

	$request = new WP_Http();
	$response = $request->post( $post_url, array( 'body' => $body ) );

}



function maker_space_api_request($endpoint, $method, $body, $api_key, $associative = true){
	$args = array(
			'method' => $method,
			'timeout' => 120,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(
					'Content-Type' => 'application/json'
			) ,
			'body' => $body
	);
	$response = wp_remote_post($endpoint, $args);
	if ($response['response']['code'] != 200) {
		echo "Error occured!";
		$response_body = $response['body'];
	}
	else {
		$response_body = $response['body'];
		return json_decode($response_body, $associative);
	}

}