<?php 
// BEGINING AMAZING HACKS
function maker_url_vars( $rules ) {
	$newrules = array();
	$newrules['maker/entry/(\d*)/?'] = 'index.php?post_type=page&pagename=entry-page-do-not-delete&e_id=$matches[1]';
	$newrules['([^/]*)/meet-the-makers/topics/([^/]*)/?'] = 'index.php?post_type=page&pagename=listing-page-do-not-delete&f=$matches[1]&t_slug=$matches[2]';
	return $newrules + $rules;
}

add_filter( 'rewrite_rules_array','maker_url_vars' );

add_action( 'wp_loaded','my_flush_rules' );

// flush_rules() if our rules are not yet included
function my_flush_rules(){
	$rules = get_option( 'rewrite_rules' );

	if ( ! isset( $rules['maker/entry/(\d*)/?'] ) || ! isset( $rules['([^/]*)/meet-the-makers/topics/([^/]*)/?'] )) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
	
}

add_filter( 'query_vars', 'my_query_vars' );
function my_query_vars( $query_vars ){
    $query_vars[] = 'e_id';
    $query_vars[] = 't_slug';
	$query_vars[] = 'f';
	return $query_vars;
}

// END AMAZING HACKS
