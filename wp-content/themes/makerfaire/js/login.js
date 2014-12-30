/**
 * This script contains all the JavaScript that displays dialog on login
 *
 * @since  HAL 9000
 */


jQuery( document ).ready(function() {

	// Add our login/register links
	jQuery( '.main-nav' ).append( '<li class="user-creds login"><a href="#login">Login</a></li>' );

		// Listen for a click event to open the login screen
	jQuery( document ).on( 'click', '.user-creds.login', function( e ) {
		e.preventDefault();

		BootstrapDialog.show({
		    title: 'Update on Your Maker Media Profile',
		    cssClass: 'make-bootstrap-dialog',
		    message: 'We will be updating and improving the Call for Makers application process, including a simplified login, on this site in January 2015.  In the meantime, we have disabled the Login function that you normally access here. If you\'re already on the Call to Makers newsletter list, you will receive notification in email on when and how to submit your application for the next Bay Area Maker Faire in May 2015 or World Maker Faire in September 2015. \
		    	<br /><br />Not on the list? <br /><br /> \
		    	<br /> Sign up for Maker Faire news and updates here.<a href="http://makerfaire.com/newsletter/">http://makerfaire.com/newsletter/ </a> \
		    	<br /><br /> \
		    	For general questions about participating in an upcoming Maker Faire, please check out the Call to Makers FAQ here.<a href="http://makerfaire.com/call-for-makers/">http://makerfaire.com/call-for-makers/</a> <br/>',
		    buttons: [{
                label: 'Close',
                action: function(dialogItself){
                    dialogItself.close();
                }
		    }]
	});
	});

	

});


