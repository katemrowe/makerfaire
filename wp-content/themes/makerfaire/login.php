
<?php
/*
 * Template Name: Login Page
 */

//Skip if user is logged in.
if (is_user_logged_in())
    return;

//Require auth0
    require_once( ABSPATH . 'wp-content/plugins/auth0/templates/login-form.php');

//Enqueue Login Style
wp_enqueue_style('login-styles', get_stylesheet_directory_uri() . '/css/login-styles.css');

$loginmessage = 'Sign in.';
if (strpos(wp_referer_field(),'edit-entry') > 0)
        $loginmessage = 'Sign in to submit or manage<br /> your applications.';

get_header();

?>
<style>
  .vertical-align {
    display: flex;
    align-items: center;
}
#a0-lock.a0-theme-default .a0-panel .a0-icon-container
{
    height:10px;
}
.mftagline {
color: #3FAFED;
font-size: 18px
}
</style>

<div class="clear"></div>

<div class="container">

    <div class="row padbottom padtop vertical-align">
        <div class="col-md-2 col-md-offset-2">
            <?php
            /**
             * Detect Auth0 plugin. 
             */
                renderAuth0Form();
            ?>
        </div>
        <div class="col-md-offset-2">
            <div> 
            <ul class="list-unstyled">
                <li><?php echo $loginmessage; ?></li>
		<li class="mftagline padtop">
                <img style="width: auto; height: 58px;" src="http://makerfaire.com/wp-content/uploads/2015/05/makey-lg-01.png">The MakerFaire Team
                </li>	</ul>
            </div>
        </div>
     </div>
</div><!--Container-->

<?php wp_footer(); ?>