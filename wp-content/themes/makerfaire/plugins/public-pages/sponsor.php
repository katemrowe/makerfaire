<?php
/**
 * Sponsor Functions
 */
function mf_sponsor_carousel( $category_name ) {
	// Get all of the sponsor from the links
	$sponsors = get_bookmarks( array( 'orderby' => 'name', 'category_name' => $category_name ) );

	// Split them into chucks of two
	$sponsors = array_chunk( $sponsors, 2, true );

	// Get the output started.
	$output = '';

	// Loop through each block of sponsors
	foreach ($sponsors as $idx => $sponsor) {
		if ( $idx == 0 ) {
			$output .= '<div class="item active">';
		} else {
			$output .= '<div class="item">';
		}
		$output .= '<div class="row">';

		// Loop through the individual sponsors
		foreach ($sponsor as $spon) {
			$output .= '<div class="col-md-6"><div class="thumb"><a href="' . esc_url( $spon->link_url ) . '"><img src="' . legacy_get_resized_remote_image_url( $spon->link_image, 125, 105 ) . '" alt="' . esc_attr( $spon->link_name ) . '"></a></div></div>';
		}
		$output .= '</div></div>';
	}

	return $output;
}

function mf_sponsor_list( $category_name, $slug ) {
    $category = array();
        $slugData = get_term_by( 'name', $category_name, 'link_category', OBJECT );
        $category[] = $slugData->term_id;
    
        $slugData = get_term_by( 'slug', $slug, 'link_category', OBJECT );
        $category[] = $slugData->term_id;
        
        $searchCat = implode(",",$category);
        $objects = get_objects_in_term($searchCat,'link_category');
        $sponsors = get_bookmarks(array('include' => $objects,'orderby' => 'name', 'limit' => 40  ));
        //var_dump($objects);
	// Get all of the sponsor from the links
        //$sponsors = wp_list_bookmarks( array( 'orderby' => 'name', 'category' => $searchCat, 'limit' => 40 ) );
	//$sponsors = get_bookmarks( array( 'orderby' => 'name', 'category' => $searchCat, 'limit' => 40 ) );

	// Split them into chucks of two
	// $sponsors = array_chunk( $sponsors, 2, true );

	// Get the output started.
	$output = '<ul>';

	// Loop through each block of sponsors
	foreach ($sponsors as $idx => $spon) {
		//foreach ($sponsor as $spon) {
		   $output .= '<li><a href="' . esc_url( $spon->link_url ) . '"><img src="' . legacy_get_resized_remote_image_url( $spon->link_image, 125, 105 ) . '" alt=""></a></li>';
		//}
	}

	$output .= '</ul>';
	return $output;
}
