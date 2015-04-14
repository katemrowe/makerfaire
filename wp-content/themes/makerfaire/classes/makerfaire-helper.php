<?php 
// BEGINING AMAZING HACKS
function maker_url_vars( $rules ) {
	$newrules = array();
	$newrules['bay-area-15/maker/entry/(\d*)/?'] = 'index.php?post_type=page&pagename=entry-page-do-not-delete&e_id=$matches[1]';
	$newrules['bay-area-2015/meet-the-makers/topics/([a-z0-9-]+$)/?'] = 'index.php?post_type=page&pagename=listing-page-do-not-delete&t_slug=$matches[1]';
	return $newrules + $rules;
}

add_filter( 'rewrite_rules_array','maker_url_vars' );

add_action( 'wp_loaded','my_flush_rules' );

// flush_rules() if our rules are not yet included
function my_flush_rules(){
	$rules = get_option( 'rewrite_rules' );

	if ( ! isset( $rules['bay-area-15/maker/entry/(\d*)/?'] ) ) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
	if ( ! isset( $rules['bay-area-2015/meet-the-makers/topics/([a-z0-9-]+$)/?'] ) ) {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
}

add_filter( 'query_vars', 'my_query_vars' );
function my_query_vars( $query_vars ){
    $query_vars[] = 'e_id';
    $query_vars[] = 't_slug';
	return $query_vars;
}

// END AMAZING HACKS
