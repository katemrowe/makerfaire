<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../wp-config.php';

  
	$host         = DB_HOST;
	$user         = DB_USER;
	$password     = DB_PASSWORD;
	$database     = DB_NAME;

	
	$con = mysql_connect($host,$user,$password);
	if(!$con){
	    die('No Database Connection: ' . mysql_error());
	}		
	$db_selected = mysql_select_db($database, $con);	
	if(!$db_selected){
	    die('No Database selected: ' . mysql_error());
	}	
		
		
?>
