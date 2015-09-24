<?php // Template Name: Signage
$location = '';
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
        $faire = (isset($_GET['faire'])?$_GET['faire']:'ny15');
        //$faire = 'ny15'; //need to have this field passed in as a parameter.  default to newest faire?
        $sql ="SELECT  DAYNAME(schedule.start_dt) as Day,
                       DATE_FORMAT(schedule.start_dt,'%h:%i %p') as 'Start Time',
                       DATE_FORMAT(schedule.end_dt,'%h:%i %p') as 'End Time',                    
                       if(subarea.niceName = '' or subarea.niceName is null,subarea.subarea,subarea.niceName) as nicename, area.area, entity.presentation_title as 'Exhibit',
                    (select  group_concat( distinct concat(maker.`FIRST NAME`,' ',maker.`LAST NAME`) separator ', ') as Makers
                        from    wp_mf_maker maker, 
                                wp_mf_maker_to_entity maker_to_entity
                        where   schedule.entry_id           = maker_to_entity.entity_id  AND
                                maker_to_entity.maker_id = maker.maker_id AND
                                maker_to_entity.maker_type != 'Contact' 
                        group by maker.lead_id
                    ) as Presenters        

            FROM    wp_mf_schedule schedule, 
                    wp_mf_entity entity, 
                    wp_mf_location location, 
                    wp_mf_faire_subarea subarea, 
                    wp_mf_faire_area area

            where   schedule.faire          = '".$faire."' 
                    AND schedule.entry_id   = entity.lead_id 
                    AND entity.status       = 'Accepted' 
                    and schedule.location_id=location.ID
                    and location.entry_id   = schedule.entry_id
                    and subarea.id          = location.subarea_id
                    and area.id             = subarea.area_id"                    
                    .($day_set!=''?" and DAYNAME(`schedule`.`start_dt`)='".ucfirst($day_set)."'":'');    
            
        if($orderBy=='time'){
            $sql .= " order by schedule.start_dt ASC, schedule.end_dt ASC, subarea.nicename ASC, 'Exhibit' ASC";            
        }else{
            $sql .= " order by subarea.nicename ASC, schedule.start_dt ASC, schedule.end_dt ASC,  'Exhibit' ASC";
        }
        
        //group by stage and date
        $dayOfWeek = '';
        $stage     = '';
 
        foreach( $wpdb->get_results($sql, ARRAY_A ) as $key=>$row) {            
            if($orderBy=='time'){ //break by stage. day goes in h1
                $stage = $row['nicename'];
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
               if($stage!=$row['nicename'] || $dayOfWeek!=$row['Day']){                    
                   //skip the page break after if this is the first time 
                   if($stage != '')    $output.= '<div style="page-break-after: always;"></div>';
                    $stage = $row['nicename'];
                    $dayOfWeek=$row['Day']; 
                    
                    $output .='<h1 style="font-size:2.2em; margin:31px 0 0; max-width:75%;float:left">'.$stage.' <small>('.$row['area'].')</small> </h1>
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
