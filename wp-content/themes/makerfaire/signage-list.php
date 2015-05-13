<?php // Template Name: Signage

if ( isset( $_GET['loc'] ) )
	$location = intval( $_GET['loc'] );

if ( ! isset( $_GET['description'] ) ) {
	$short_description = true;
} else {
	$short_description = false;
}


if ( isset( $_GET['day'] ) )
	$day = sanitize_title_for_query( $_GET['day'] );

if ( ! empty( $location ) )
	$term = get_term_by( 'name', $location, 'location' );

/**
 * Get our schedule stuff
 * @param  String $location [description]
 * @return [type]           [description]
 */
function get_schedule_list( $location, $short_description = false, $day_set = '' ) {

    global $wpdb;
        $output = '';
        //retrieve Data
        $sql = "select location.subarea,
		DATE_FORMAT(schedule.start_dt,'%h:%i %p') as 'Start Time',
		DATE_FORMAT(schedule.end_dt,'%h:%i %p') as 'End Time',
		DAYNAME(`schedule`.`start_dt`) AS `Day`,		
		maker_view.PresentationTitle as 'Exhibit'	
                
                from wp_mf_maker maker_view, wp_mf_schedule schedule, wp_mf_location location

                where   schedule.faire = 'BA15' AND
                        maker_view.lead_id   = schedule.entry_id AND
                        maker_view.Status    = 'Accepted' AND
                        maker_view.lead_id   = location.entry_id AND "
                .($day_set!=''?" DAYNAME(`schedule`.`start_dt`)='".ucfirst($day_set)."' AND":'').
                "       maker_view.Name = 'Contact'

                order by Day ASC, subarea ASC, schedule.start_dt ASC, schedule.end_dt ASC,  'Exhibit' ASC

";
        //echo $sql;
        $day = '';
        foreach( $wpdb->get_results($sql, ARRAY_A ) as $key=>$row) {
            if($day!=$row['Day']){
               $day=$row['Day']; 
               $output .= '<h2>'.$day.'</h2>';
            }
            
            $output .= '<table style="width:100%;">';

            $output .= '<tr>';
            $output .= '<td width="25%" style="padding:15px 0;" valign="top">';
            $output .= '<h4 style="margin-top:0;">' . $row['subarea'] . '</h4>';
            $output .= '<h2 style="font-size:.9em; color:#333; margin-top:3px;">' . $row['Start Time']  . ' &mdash; ' . $row['End Time']  . '</h2>';
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<h3 style="margin-top:0;">' . $row['Exhibit']  . '</h3>';
	
            $output .= '<tr><td colspan="2"><div style="border-bottom:2px solid #ccc;"></div></td></tr>';
            $output .= '</td>';
            $output .= '</tr>';
		
            $output .= '</table>';   
        }
            

	return $output;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Stage Signage - <?php echo sanitize_title( $location ); ?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<style>
			body { font-family: 'Benton Sans', Helvetica, sans-serif; }
			a { text-decoration:none; color:#000; }
			h1, h2, h3, h4 { margin:5px 0 0; }
		</style>
	</head>
	<body>
		<h1 style="font-size:2.2em; margin:31px 0 0; max-width:75%;"><?php echo get_the_title( $location ); ?></h1>
		<?php if ( ! empty( $term->description ) ) {
			echo '<div style="font-weight:normal; margin-top:-15px; margin-left:5px; text-decoration:italic;">' . Markdown( esc_html( $term->description ) ) . '</div>';
		} ?>
		<h2 style="position:absolute; top:16px; right:30px;"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" style="width:200px;" alt="" ></h2>
		<p></p>
		<p></p>
		<p></p>
		<?php echo get_schedule_list( $location, $short_description, $day ); ?>
	</body>
</html>
