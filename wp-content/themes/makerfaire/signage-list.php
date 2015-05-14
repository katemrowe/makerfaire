<?php // Template Name: Signage

if ( isset( $_GET['loc'] ) )
	$location = intval( $_GET['loc'] );

if ( ! isset( $_GET['description'] ) ) {
	$short_description = true;
} else {
	$short_description = false;
}

$orderBy = (isset( $_GET['orderBy'])?$_GET['orderBy']:'' );

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
    global $orderBy;
    global $wpdb;
        $output = '';
        //retrieve Data
        $sql = "select location.niceName, location.area,
		DATE_FORMAT(schedule.start_dt,'%h:%i %p') as 'Start Time',
		DATE_FORMAT(schedule.end_dt,'%h:%i %p') as 'End Time',
		DAYNAME(`schedule`.`start_dt`) AS `Day`,		
		maker_view.PresentationTitle as 'Exhibit',	
                (SELECT GROUP_CONCAT(DISTINCT concat(maker_view2.`First Name`, ' ', maker_view2.`Last Name`)  
                            ORDER BY maker_view2.Name SEPARATOR ', ') AS presenters
                        FROM wp_mf_maker maker_view2
                            where 	maker_view2.lead_id = maker_view.lead_id
        		and length(maker_view2.`First Name`) > 0
                           ORDER BY maker_view2.Name
                            ) as 'Presenters'
                from wp_mf_maker maker_view, wp_mf_schedule schedule, wp_mf_location location

                where   schedule.faire = 'BA15' AND
                        maker_view.lead_id   = schedule.entry_id AND
                        maker_view.Status    = 'Accepted' AND
                        maker_view.lead_id   = location.entry_id AND "
                .($day_set!=''?" DAYNAME(`schedule`.`start_dt`)='".ucfirst($day_set)."' AND":'').
                "       maker_view.Name = 'Contact'";
        if($orderBy=='time'){
            $sql .= " order by Day ASC, schedule.start_dt ASC, schedule.end_dt ASC, niceName ASC, 'Exhibit' ASC";            
        }else{
            $sql .= " order by niceName ASC, Day ASC, schedule.start_dt ASC, schedule.end_dt ASC,  'Exhibit' ASC";
        }
     
        //group by stage and date
        $dayOfWeek = '';
        $stage     = '';
        $stageArray = array('Midway: Meeting Pavilion: Center Stage'        =>'Center Stage',
                            'Expo: Center: Make: Live Stage'                =>'Make: Live',
                            'Expo: Center: Make: Electronics Stage'         =>'Make: Electronics',
                            'North Courtyard: Make: Science Stage'          =>'Make: Science',
                            'Midway: Grass M: Make: Education Stage'        =>'Make: Education',
                            'West Green: Grass K: Make: DIY Stage'          =>'Make: DIY',
                            'Show Barn: Homegrown Village: Maker Square Stage'          =>'Maker Square',
                            'Show Barn: Homegrown Village: Hands-On Homegrown Workshop' =>'Hands-On HomeGrown Village',
                            'South Lot: Center: Swap-O-Rama-Rama: Textile Talk Lounge'  =>'Textile Talk Lounge',
                            'Fiesta: Main Room: Tesla Stage'                =>'Tesla Stage',
                            'West Lot: Traveling Spectacular Stage'         =>'The Traveling Spectacular',
                            'West Lot: North: Coke Zero & Mentos Stage'     =>'Coke Zero & Mentos',
                            'Midway: Center: Pedal Powered Stage'           =>'Pedal Powered Stage',
                            'North Courtyard: Battle Pond'                 =>'Battle Pond',
                            'South Lot: South: Race Track'                  =>'Race Track',
                            'Expo: South Center: Game of Drones'            =>'Game of Drones',);
        foreach( $wpdb->get_results($sql, ARRAY_A ) as $key=>$row) {            
            if($orderBy=='time'){ //break by stage. day goes in h1
                $stage = $row['niceName'];
                if( $dayOfWeek!=$row['Day']){
                    //skip the page break after if this is the first time
                    if($dayOfWeek != '')    $output.= '<div style="page-break-after: always;"></div>';
                    $dayOfWeek=$row['Day']; 
                    
                    $output .='<h1 style="font-size:2.2em; margin:31px 0 0; max-width:75%;float:left">'.$dayOfWeek.'</h1>
                                <h2 style="float:right;margin-top:31px;"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" style="width:200px;" alt="" ></h2>
                                <p></p>
                                <p></p>
                                <p></p>';                    
               } 
            }else{
               if($stage!=$row['niceName']){                    
                   //skip the page break after if this is the first time 
                   if($stage != '')    $output.= '<div style="page-break-after: always;"></div>';
                    $stage = $row['niceName'];
                    $dayOfWeek=$row['Day']; 
                    
                    $output .='<h1 style="font-size:2.2em; margin:31px 0 0; max-width:75%;float:left">'.$stage.' ('.$row['area'].') </h1>
                                <h2 style="float:right;margin-top:31px;"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" style="width:200px;" alt="" ></h2>
                                <p></p>
                                <p></p>
                                <p></p>';
                    $output .= '<div style="clear:both"><h2>'.$dayOfWeek.'</h2></div>';
               } 
            }            
            
            $output .= '<table style="width:100%;">';

            $output .= '<tr>';
            $output .= '<td width="25%" style="padding:15px 0;" valign="top">';
           
            $output .= '<h2 style="font-size:.9em; color:#333; margin-top:3px;">' . $row['Start Time']  . ' &mdash; ' . $row['End Time']  . '</h2>';
            if($orderBy=='time')    {
                $output .= $stage.' ('.$row['area'].')' ;
            }
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<h3 style="margin-top:0;">' . $row['Exhibit']  . '</h3>';
	    $output .= $row['Presenters'];
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
		<?php echo get_schedule_list( $location, $short_description, $day ); ?>
	</body>
</html>
