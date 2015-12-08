
<?php
/*
* Template Name: Login Page
*/

 if(is_user_logged_in())
        return;

/**
 * Detect plugin. For use on Front End only.
 */
require_once( ABSPATH . 'wp-content/plugins/auth0/templates/login-form.php'); 
wp_enqueue_style( 'login-styles', get_stylesheet_directory_uri() . '/css/login-styles.css' );
	
get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content col-md-6">


<?php
// check for plugin using plugin name
if (function_exists('renderAuth0Form' ) ){
  renderAuth0Form();
       } 
else
    wp_login_form();

?>
                </div>
            <div class="content col-md-6">

                   Sign in to Maker Faire
</div><!--Content-->

	</div>

</div><!--Container-->

<?php get_footer(); ?>