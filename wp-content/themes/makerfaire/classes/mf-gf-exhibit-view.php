<?php 
/**
 * Template Name: Maker Faire Entry Display
*/
get_header();

global $wp_query;
echo 'EntryID : ' . $wp_query->query_vars['entryid'];
echo '<br />';
echo 'MakerFaire : ' . $wp_query->query_vars['makerfaire'];
// ... more ...
get_footer();
?>