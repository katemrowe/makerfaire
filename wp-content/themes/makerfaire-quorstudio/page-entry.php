<?php
/**
 * Template Name: Entry
 *
 * @version 2.0
 */

  global $wp_query;
  $entryId = $wp_query->query_vars['e_id'];
  $entry = GFAPI::get_entry($entryId);
  
   get_header();
?>
<div style="margin-left: 100px">
<img src="<?php echo $entry['22']; ?>" style="width: 300px;"/>
<h1><?php echo $entry['151']; ?></h1>
<p>Homepage: <i><?php echo $entry['27']; ?></i></p>

<p><?php echo $entry['16']; ?></p>
</div>

 <?php get_footer(); ?>

