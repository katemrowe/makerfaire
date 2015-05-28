<?php 
// BEGINING AMAZING HACKS
function maker_url_vars( $rules ) {
	$newrules = array();
	$newrules['maker/entry/(\d*)/?'] = 'index.php?post_type=page&pagename=entry-page-do-not-delete&e_id=$matches[1]';
	$newrules['([^\/]*)/meet-the-makers/topics/([^\/]*)/([0-9]{1,})/?$'] = 'index.php?post_type=page&pagename=listing-page-do-not-delete&f=$matches[1]&t_slug=$matches[2]&offset=$matches[3]';
	$newrules['([^\/]*)/meet-the-makers/search/([0-9]{1,})/?$'] = 'index.php?post_type=page&pagename=search-results-page-do-not-delete&f=$matches[1]&offset=$matches[2]';
	$newrules['([^\/]*)/meet-the-makers/topics/([^\/]*)/?$'] = 'index.php?offset=1&post_type=page&pagename=listing-page-do-not-delete&f=$matches[1]&t_slug=$matches[2]';
	$newrules['([^\/]*)/meet-the-makers/search/?$'] = 'index.php?offset=1&post_type=page&pagename=search-results-page-do-not-delete&f=$matches[1]';
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
	$query_vars[] = 's_keyword';
	$query_vars[] = 'offset';
	$query_vars[] = 'f';
	return $query_vars;
}

// END AMAZING HACKS


function get_mf_schedule_by_faire ($faire)
{
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}


	$select_query = sprintf("SELECT DISTINCT
	    `wp_mf_schedule`.`ID`,
	    `wp_mf_schedule`.`entry_id`,
	    `wp_mf_schedule`.`location_id`,
	    `wp_mf_schedule`.`faire`,
	    `wp_mf_schedule`.`start_dt`,
	    `wp_mf_schedule`.`end_dt`,
	    DAYNAME(`wp_mf_schedule`.`start_dt`) AS `day`,
	    `wp_gravityforms_entity_view`.`Photo`,
	    `wp_gravityforms_entity_view`.`ThumbPhoto`,
	    `wp_gravityforms_entity_view`.`Categories`,
	    `wp_gravityforms_entity_view`.`Title`,
	    `wp_gravityforms_entity_view`.`Description`,
	    `wp_mf_location`.`faire`,
	    `wp_mf_location`.`area`,
	    `wp_mf_location`.`subarea`,
	    `wp_mf_location`.`location`,
	    `wp_mf_location`.`latitude`,
	    `wp_mf_location`.`longitude`,
	    `wp_mf_location`.`location_element_id`,
	    `wp_gravityforms_entity_view`.`entry_status`,
	    makerlist.Makers,
	    `wp_mf_maker`.photo,
	    `wp_mf_maker`.`First Name` AS first_name,
	    `wp_mf_maker`.`Last Name` AS last_name
	FROM
	    `wp_mf_schedule`
	        INNER JOIN
	    `wp_gravityforms_entity_view` ON `wp_mf_schedule`.entry_id = `wp_gravityforms_entity_view`.entry_id
	        AND `wp_gravityforms_entity_view`.`entry_status` = 'active'
	        left outer JOIN
	    `wp_mf_maker` ON `wp_mf_schedule`.entry_id = `wp_mf_maker`.lead_id
	        AND wp_mf_maker.name = 'Presenter'
	        left outer JOIN
	    `wp_mf_location` ON `wp_mf_schedule`.entry_id = `wp_mf_location`.entry_id
	        INNER JOIN
	    (SELECT
	        lead_id,
	            GROUP_CONCAT(DISTINCT CONCAT(wp_mf_maker.`FIRST NAME`, ' ', wp_mf_maker.`LAST NAME`)
	                SEPARATOR ', ') AS Makers
	    FROM
	        `wp_mf_maker`
	    WHERE
	        Name != 'Contact' and length(`FIRST NAME`) > 0 and length(`LAST NAME`) > 0
	    GROUP BY lead_id) AS `makerlist` ON `wp_mf_schedule`.entry_id = `makerlist`.lead_id
		WHERE `wp_mf_schedule`.faire = '%s' 
			order by `wp_mf_location`.`area`,
		    `wp_mf_location`.`subarea`,
		    `wp_mf_schedule`.`start_dt`
		",$faire);
	$mysqli->set_charset("utf8");
	$result = $mysqli->query( $select_query );
	// Initalize the schedule container
	$schedules = array();
	$current_area='';
	$current_subarea='';
	$current_day='';
	$subarea_clean_name = '';
	$section_head='';
	$subarea_head='';
	$subarea_tabs_head='';
	$subarea_tabs_content='';
	$subarea_tabs_footer='';
	$section_content='';
	$section_footer='';
	$subarea_footer='';
	$section='';
	$output = '';
	$output_head='<div id="scheduleTab" class="tabbable tabs-left">
	<div class="tab-content">';
	$output_footer='</div></div>';
	
	// Loop through the posts
	while ( $row = $result->fetch_row () ) {
		$new_area=$row[13];
		$new_subarea=$row[14];
		$new_day=$row[6];
		$subarea_clean_name = strtolower(str_replace('&','',(str_replace(' ', '', str_replace(':','',$new_day )))));
		
		//Check to see if the day has moved on.
		if ($new_subarea != $current_subarea) {
				$current_subarea = $new_subarea;
				$current_day = $new_day;
				
				$output .= $subarea_head.$subarea_tabs_head.$subarea_tabs_content.$subarea_tabs_footer.$section.$subarea_footer;
				$subarea_head = '<div class="tab-pane" id="'.$subarea_clean_name.'">';
				$subarea_footer = '</div>';
				$subarea_tabs_head = '<div class="row">
							::before
						<ul id="tabs" class="nav nav-tabs">';
				$subarea_tabs_footer = '</ul></div>';
				$section='';
				$subarea_tabs_content = '';
				
				
				
			}
			if ($new_day != $current_day) {
				$current_day = $new_day;
				$section .= $section_head.$section_content.$section_footer;
				$section_head = '<li><a href="#'.str_replace(' ', '', $subarea_clean_name).esc_attr( $current_day ).'" data-toggle="tab">'.esc_attr( $current_day ).'</a></li>';
				$section_head .= '<div id="' . str_replace(' ', '', $subarea_clean_name).esc_attr( $current_day ) . '" class="tab-pane fade in ">';
				$section_head .= '<table id="' . esc_attr( $current_day ) . '" class="table table-bordered table-schedule">';
				$section_footer = '</table>';
				$section_content = '';
				$subarea_tabs_content .= '<li class="active"><a data-toggle="tab" href="#'.str_replace(' ', '', $subarea_clean_name).esc_attr( $current_day).'">'.esc_attr($current_day ).'</a></li>';
			}	
			// Return some post meta
			$entry_id = $row[1];
			/*
			$app_id = $entry_id;
			$day = $row[6];
			$start = strtotime($row[4]);
			$stop = strtotime($row[5]);
			//$dates = mf_get_faire_date( $faire );
	
			// REQUIRED: Schedule ID
			$schedule['id'] = $entry_id;
			$schedule_name = isset ( $row[10] ) ? $row[10] : '';
			$project_photo =  isset ( $row[7] ) ? $row[7] : '';
			$maker_photo =  isset ( $row[21] ) ? $row[21] : '';
			$schedule['name'] = html_entity_decode( $schedule_name , ENT_COMPAT, 'utf-8' );
			$schedule['time_start'] = date( DATE_ATOM, strtotime( '0 hour',  $start ) );
			$schedule['time_end'] = date( DATE_ATOM, strtotime( '0 hour', $stop ) );
			$schedule['day'] = $day;
			$schedule['project_description'] = isset ( $row[11] ) ? $row[11] : '';
			$schedule['time_stop'] = date( DATE_ATOM, strtotime( '0 hour', $stop ) );
			$schedule['first_name'] = $row[22];
			$schedule['last_name'] = $row[23];
			if($maker_photo == NULL) $maker_photo ='';
			$app_image = (isset($maker_photo) && trim($maker_photo)!='' && $maker_photo!= NULL? $maker_photo : $project_photo);
			$schedule['thumb_img_url'] = esc_url( legacy_get_resized_remote_image_url( $app_image, '80', '80' ) );
			$schedule['large_img_url'] = esc_url( legacy_get_resized_remote_image_url( $app_image, '600', '600' ) );
			$schedule['maker_list'] = ( ! empty( $row[20] ) ) ? $row[20] : null;
			
			$event_id = $scheduleditem['id'];
			$section_content .= '<tr>';
			$section_content .= '<td width="200" style="max-width:200px;" class="dateTime">';
			$section_content .= '<h4 style="font-weight:bold">' . esc_html($scheduleditem['day'] ) . '</h4>';
			$section_content .= '<p>' . esc_html(  date('h:i A',strtotime($scheduleditem['time_start']))) . ' &mdash; ' . esc_html(  date('h:i A', strtotime($scheduleditem['time_end'])) ) . '</p>';
			if ( isset( $scheduleditem['large_img_url'] ) || isset( $scheduleditem['thumb_img_url'] )  ) {
				$output .= '<div class="pull-left thumbnail">';
				// We may want to over ride the photo of an application on the schedule page by checking if there is a featured image on the event item
				if (  $scheduleditem['thumb_img_url'] ) {
					$output .= '<a href="/maker/entry/' .  $scheduleditem['id'] . '"><img src="' . legacy_get_resized_remote_image_url( $scheduleditem['thumb_img_url'], 140, 140 ) . '" alt="' . esc_attr(  $scheduleditem['thumb_img_url'] ) . '" width="140" height="140"></a>';
			
				}
				else {
			
					$output .= '<a href="/maker/entry/' .  $scheduleditem['id'] . '"><img src="' . legacy_get_resized_remote_image_url( $scheduleditem['large_img_url'], 140, 140 ) . '" alt="' . esc_attr(  $scheduleditem['thumb_img_url'] ) . '" width="140" height="140"></a>';
				}
				$output .= '</div>';
			}
			$section_content .= '</td><td>';
			$section_content .= '<h4><a href="/maker/entry/' .  $scheduleditem['id'] . '">' . $scheduleditem['name']  . '</a></h4>';
			
			// Presenter Name(s)
			$section_content .= '<h4 class="maker-name">' . $scheduleditem['maker_list'] . '</h4>';
			// Application Descriptions
			$description =  $scheduleditem['project_description'];
			if ( ! empty( $description ) )
				$section_content .=   $description ;
			
			$section_content .= '</td>';
			$section_content .= '</tr>';
			*/
			$section_content .= '<tr><td>'.$entry_id.'</td></tr>';
		}
	return $output_head.$output.$output_footer;
}


add_shortcode('mf_schedule_by_faire', 'mf_display_schedule_by_faire');
function mf_display_schedule_by_faire( $atts ) {
		global $mfform;
	
		/*$data = shortcode_atts( array(
		 'area' 	=> '',
				'subarea' 	=> '',
				'faire'			=> '',
		), $atts );
		*/
		// Get the faire date array. If the
		$faire = $atts['faire'];

		
		// Get Friday events by location
		$schedule = wp_cache_get( $faire . '_schedule_', 'schedule' );
		if ( $schedule === false ) {
			$schedule = get_mf_schedule_by_faire($faire);
			wp_cache_set(  $faire . '_schedule_', 'schedule', 3000 );
		}
	
		
		return $schedule;
	}

