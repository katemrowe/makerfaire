
<?php
/*
 * Template Name: Login Page
 */
// Get the action
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : 'signin';

//Skip if user is logged in.
if (is_user_logged_in() && $action == 'logout')
{
    wp_logout();
    wp_redirect(home_url());
}


//Enqueue Login Style
wp_enqueue_style('login-styles', get_stylesheet_directory_uri() . '/css/login-styles.css');

//Setup dynamic message area depeding on modes or referrer
$loginmessage = 'Sign In';
if (strpos(wp_referer_field(),'edit-entry') > 0)
        $loginmessage = 'Sign in to submit or manage<br /> your entries.';
if ($mode == "reset")
        $loginmessage = "Change your password";

//Wordpress header and Theme header call
get_header();

?>
<style>

</style>

<div class="clear"></div>

<div class="container">

    <div class="row padbottom padtop vertical-align">
        <div class="col-md-2 col-md-offset-2">
            <?php
            /**
             * Detect Auth0 plugin. 
             */
            renderAuth0Form(false, array( "mode" => $mode));
            ?>
        </div>
        <div class="col-md-offset-2">
            <div> 
            <ul class="list-unstyled">
                <li><?php echo $loginmessage; ?></li>
		<li class="mftagline padtop">
                <img style="width: auto; height: 58px; margin-right:10px;" src="http://makerfaire.com/wp-content/uploads/2015/05/makey-lg-01.png">The Maker Faire Team
                </li>	</ul>
            </div>
        </div>
     </div>
</div><!--Container-->

<?php wp_footer();


/* Page specific functions */
function renderAuth0Form($canShowLegacyLogin = true, $specialSettings = array())
{
    
    if (!$canShowLegacyLogin || !isset($_GET['wle'])) {
        //Require auth0
        require_once( ABSPATH . 'wp-content/plugins/auth0/templates/auth0-login-form.php');

    }else{
        add_action('login_footer', array('WP_Auth0', 'render_back_to_auth0'));
        add_action('woocommerce_after_customer_login_form', array('WP_Auth0', 'render_back_to_auth0'));
    }
}
?>