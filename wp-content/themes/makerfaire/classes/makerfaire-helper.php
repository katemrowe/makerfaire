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


/**
 * The new and improved schedule by location shortcode.
 *
 * We wanted a better code base that is more maintainable and performant that also supports our new location architecture.
 * To use, pass in the location_id attribute in the shortcode with the locations ID along with what faire you want applications from. Passing the faire is necessary for future archiving.
 * From there we'll query all events for each day and cache them.
 * Now we'll loop through each day spitting out all applications scheduled for those days from 10am to closing of that day.
 *
 * @param  array $atts The attributes being passed through the shortcode
 * @return string
 */
function mf_display_schedule_by_area( $atts ) {
	global $mfform;

	/*$data = shortcode_atts( array(
			'area' 	=> '',
			'subarea' 	=> '',
			'faire'			=> '',
	), $atts );
	*/
	// Get the faire date array. If the
	$faire = $atts['faire'];
	$area =$atts['area'] ;
	$subarea = htmlspecialchars_decode($atts['subarea']);
	
	$subarea_clean_name = strtolower(str_replace('&','',(str_replace(' ', '', str_replace(':','',$subarea )))));
	// Make sure we actually passed a valid faire...
	//if ( empty( $faire_date ) )
	//	return '<h3>Not a valid faire!</h3>';

	// Get the location object.
	//$location = get_post( absint( $data['location_id'] ) );
	//$sunday_schedule = get_mf_schedule_by_faire($faire, 'Sunday', $area);
	
	// Get Friday events by location
	$friday = wp_cache_get( $faire . '_friday_schedule_'.$area.'_'.$subarea_clean_name, 'area' );
	if ( $friday === false ) {
		$friday = get_mf_schedule_by_faire($faire, 'Friday', $area, $subarea);
		wp_cache_set( $faire . '_friday_schedule_'.$area.'_'.$subarea_clean_name , $friday, 'area', 300 );
	}

	// Get Saturday events by location
	$saturday = wp_cache_get( $faire . '_saturday_schedule_'.$area.'_'.$subarea_clean_name , 'area' );
	if ( $saturday === false  ) {
		$saturday = get_mf_schedule_by_faire($faire, 'Saturday', $area, $subarea);
		wp_cache_set( $faire . '_saturday_schedule_'.$area.'_'.$subarea_clean_name , $saturday, 'area', 300 );
	}
	// Get Saturday events by location
	$sunday = wp_cache_get( $faire . '_sunday_schedule_'.$area.'_'.$subarea_clean_name , 'area' );
	if ( $sunday === false  ) {
		$sunday = get_mf_schedule_by_faire($faire, 'Sunday', $area, $subarea);
		wp_cache_set( $faire . '_sunday_schedule_'.$area.'_'.$subarea_clean_name , $sunday, 'area', 300 );
	}

	
	//$output = '<div class="row"><div class="span4"><h2><a href="' . esc_url( get_permalink( absint( $data['area'] ) ) . '?faire=' . $data['faire'] ) . '">' . $subarea_array[2] . '</a></h2></div> <div class="span1 pull-right" style="position:relative; top:7px;"><a href="#" onclick="window.print();return false;"><img src="' . get_stylesheet_directory_uri() . '/images/print-ico.png" alt="Print this schedule" /></a></div></div>';
        $output = '<div class="row">'
                . '<ul id="tabs" class="nav nav-tabs">||navtabs||</ul>'
                . '<div class="span1 pull-right" style="position:relative; top:25px;"><a href="#" onclick="window.print();return false;"><img src="' . get_stylesheet_directory_uri() . '/images/print-ico.png" alt="Print this schedule" /></a></div></div>';    
	
	// Let's loop through each day and spit out a schedule?
	$days = array( 'saturday', 'sunday' );
        
        $output .= ' <div class="tab-content">';
        //$first sets the first day to active
        //at the end of the first day loop we set $first to blank
        $first = 'active';
	foreach ( $days as 	 $day ) {
		if ( count(${ $day }) > 0 ) {
                       $navTabs .= '<li class="'.$first.'"><a href="#'.str_replace(' ', '', $subarea_clean_name).esc_attr( $day ).'" data-toggle="tab">'.esc_attr( $day ).'</a></li>';                       
                        
                                
                        // Start the schedule
			$output .= '<div id="' . str_replace(' ', '', $subarea_clean_name).esc_attr( $day ) . '" class="tab-pane fade in '.$first.'">';
                        $output .= '<table id="' . esc_attr( $day ) . '" class="table table-bordered table-schedule">';
			//$output .= '<thead><tr><th colspan="2">' . $day  . '</th></tr></thead>';
			//$output .= '<thead><tr><th colspan="2">' . esc_html( date( 'l dS, Y', strtotime( $scheduleditem['start_time']  ) ) ) . '</th></tr></thead>';

			// Loop through the events and get the applications
			//while ( ${ $day }->have_posts() ) : ${ $day }->the_post();
			foreach( ${ $day } as $scheduleditem ) :
			
			$event_id = $scheduleditem['id'];
			//$meta = get_post_meta( absint( get_the_ID() ) );
			//$app_obj = get_post( absint( $meta['mfei_record'][0] ) );
			//$app = json_decode( mf_convert_newlines( str_replace( "\'", "'", $app_obj->post_content ) ) );

			$output .= '<tr>';
			$output .= '<td width="200" style="max-width:200px;" class="dateTime">';
			$output .= '<h4 style="font-weight:bold">' . esc_html($scheduleditem['day'] ) . '</h4>';
			$output .= '<p>' . esc_html(  date('h:i A',strtotime($scheduleditem['time_start']))) . ' &mdash; ' . esc_html(  date('h:i A', strtotime($scheduleditem['time_end'])) ) . '</p>';
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
			$output .= '</td><td>';
			$output .= '<h4><a href="/maker/entry/' .  $scheduleditem['id'] . '">' . $scheduleditem['name']  . '</a></h4>';

			// Presenter Name(s)
				$output .= '<h4 class="maker-name">' . $scheduleditem['maker_list'] . '</h4>';
            // Application Descriptions
			$description =  $scheduleditem['project_description'];
			if ( ! empty( $description ) )
				$output .=   $description ;

			// Add our video link for video coverage
			/*if ( ! empty( $meta['mfei_coverage'][0] ) )
				$output .= '<p><a href="' . esc_url( $meta['mfei_coverage'][0] ) . '" class="btn btn-mini btn-primary">Watch Video</a></p>';
			*/
			$output .= '</td>';
			$output .= '</tr>';
			endforeach;

			$output .= '</table></div>';
			$first = '';
		} 
	}
        $output .='</div>';
        $output = str_replace('||navtabs||', $navTabs, $output);
	return $output;
}
add_shortcode('mf_schedule_by_area', 'mf_display_schedule_by_area');

function get_mf_schedule_by_faire ($faire, $day, $area, $subarea)
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
        INNER JOIN
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
        Name != 'Contact'
    GROUP BY lead_id) AS `makerlist` ON `wp_mf_schedule`.entry_id = `makerlist`.lead_id
WHERE `wp_mf_schedule`.faire = '%s' 
			and DAYNAME(`wp_mf_schedule`.`start_dt`) = '%s'
			and `wp_mf_location`.`area` = '%s'
			and `wp_mf_location`.`subarea` like '%s'
		order by `wp_mf_schedule`.`start_dt`
		",$faire,$day,$area,$subarea);

$result = $mysqli->query( $select_query );
// Initalize the schedule container
$schedules = array();

// Loop through the posts
while ( $row = $result->fetch_row () ) {
	// Return some post meta
	$entry_id = $row[1];
	$app_id = $entry_id;
	$day = $row[6];
	$start = strtotime($row[4]);
	$stop = strtotime($row[5]);
	//$dates = mf_get_faire_date( $faire );

	// REQUIRED: Schedule ID
	$schedule['id'] = $entry_id;
	$schedule_name = isset ( $row[10] ) ? $row[10] : '';
	$project_photo =  isset ( $row[7] ) ? $row[7] : '';
	$maker_photo =  isset ( $row[27] ) ? $row[27] : '';
	
	// REQUIED: Application title paired to scheduled item
	$schedule['name'] = html_entity_decode( $schedule_name , ENT_COMPAT, 'utf-8' );
	$schedule['time_start'] = date( DATE_ATOM, strtotime( '0 hour',  $start ) );
	$schedule['time_end'] = date( DATE_ATOM, strtotime( '0 hour', $stop ) );
	$schedule['day'] = $day;
	$schedule['project_description'] = isset ( $row[11] ) ? $row[11] : '';
	
	//ORIGINAL CALL
	//$schedule['time_start'] = date( DATE_ATOM, strtotime( '-1 hour', strtotime( $dates[$day] . $start . $dates['time_zone'] ) ) );
	//$schedule['time_end'] = date( DATE_ATOM, strtotime( '-1 hour', strtotime( $dates[$day] . $stop . $dates['time_zone'] ) ) );
	// Rename the field, keeping 'time_end' to ensure this works.
	$schedule['time_stop'] = date( DATE_ATOM, strtotime( '0 hour', $stop ) );
    $schedule['first_name'] = $row[28];
    $schedule['last_name'] = $row[29];
	// REQUIRED: Venue ID reference
	$schedule['venue_id_ref'] = $row[11];

	// Schedule thumbnails. Nothing more than images from the application it is tied to
	//$post_content = json_decode( mf_clean_content( get_page( absint( $app_id ) )->post_content ) );
	$app_image = (isset($maker_photo)) ? $maker_photo : $project_photo;
	$schedule['thumb_img_url'] = esc_url( legacy_get_resized_remote_image_url( $app_image, '80', '80' ) );
	$schedule['large_img_url'] = esc_url( legacy_get_resized_remote_image_url( $app_image, '600', '600' ) );


	// A list of applications assigned to this event (should only be one really...)
	$schedule['entity_id_refs'] = array( absint( $entry_id) );

	// Application Makers

	$schedule['maker_id_refs'] = ( ! empty( $row[25] ) ) ? $row[25] : null;
	$schedule['maker_list'] = ( ! empty( $row[26] ) ) ? $row[26] : null;
	
	$maker_ids = array();

	// Put the application into our list of schedules
	array_push( $schedules, $schedule );
	
}
return $schedules;
}


