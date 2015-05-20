
<footer id="footer" class="new-footer">
	<div class="container">
		<div class="row-fluid social-foot-desktop">
			<div class="span3 social-foot-col" >
				<a href="/"><img class="footer_logo" src="//cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" alt="Maker Faire Logo"></a>
				<ul class="unstyled">
					<li><a href="/makerfairehistory">About Maker Faire</a></li>
					<li><a href="/map">Find a Faire Near You</a></li>
					<li><a href="/maker-movement">Maker Movement</a></li>
					<li><a href="/be-a-maker">Be a Maker</a></li>
					<li><a href="https://help.makermedia.com/hc/en-us/categories/200333245-Maker-Faire" target="_blank">Maker Faire FAQs</a></li>
				</ul>
			</div>

			<div class="span3 social-foot-col" >
				<h4>Explore Making</h4>
				<ul class="unstyled">
					<li><a href="//makezine.com/blog" target="_blank">Make: News</a></li>
					<li><a href="/">Maker Faire</a></li>
					<li><a href="//www.makershed.com" target="_blank">Maker Shed</a></li>
					<li><a href="//makercon.com" target="_blank">MakerCon</a></li>
					<li><a href="//makercamp.com" target="_blank">Maker Camp</a></li>
				</ul>
			</div>
			<!-- div class="clearfix visible-phone"></div --><!-- Add this back in when site is responsive -->
			<div class="span3 social-foot-col">
				<h4>Our Company</h4>
				<ul class="unstyled">
					<li><a href="//makermedia.com" target="_blank">About Us</a></li>
					<li><a href="//makermedia.com/work-with-us/advertising" target="_blank">Advertise with Us</a></li>
					<li><a href="//makermedia.com/work-with-us/job-openings" target="_blank">Careers</a></li>
					<li><a href="//help.makermedia.com/hc/en-us" target="_blank">Help</a></li>
					<li><a href="//makermedia.com/privacy" target="_blank">Privacy</a></li>
				</ul>
			</div>

			<div class="span3 social-foot-col">
				<h4 class="stay-connected">Stay Connected</h4>
				<div class="social-profile-icons">
					<a class="sprite-facebook-32" href="//www.facebook.com/makerfaire" title="Facebook" target="_blank">
						<div class="social-profile-cont">	
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-twitter-32" href="//twitter.com/makerfaire" title="Twitter" target="_blank">
						<div class="social-profile-cont">	
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-pinterest-32" href="//www.pinterest.com/makemagazine/maker-faire/" title="Pinterest" target="_blank">
						<div class="social-profile-cont">	
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-googleplus-32" href="//plus.google.com/104410464300110463062/posts" rel="publisher" title="Google+" target="_blank">
						<div class="social-profile-cont">	
							<span class="sprite"></span>
						</div>
					</a>
				</div>
				<?php
					$isSecure = "http://";
					if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
						$isSecure = "https://";
					}
				?>
	    	    <form action="http://whatcounts.com/bin/listctrl" method="POST">
					<input type="hidden" name="slid" value="6B5869DC547D3D46E66DEF1987C64E7A" />
					<input type="hidden" name="cmd" value="subscribe" />
					<input type="hidden" name="custom_source" value="footer" /> 
					<input type="hidden" name="custom_incentive" value="none" /> 
					<input type="hidden" name="custom_url" value="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>" />
					<input type="hidden" id="format_mime" name="format" value="mime" />
					<input type="hidden" name="goto" value="//makerfaire.com/thanks-for-signing-up" />
					<input type="hidden" name="custom_host" value="<?php echo $_SERVER["HTTP_HOST"]; ?>" />
					<input type="hidden" name="errors_to" value="" />
					<div>
						<input name="email" placeholder="Enter your Email" required="required" type="text"><br>
						<input value="Sign Up for our Newsletter" class="btn-cyan" type="submit">
					</div>
			    </form>
			</div>
		</div><!-- END desktop row -->
		<!-- Add back in when the site is responsive -->
<!-- 		<div class="row social-foot-mobile">
			<div class="span12 social-foot-col">
				<h4 class="stay-connected">Stay Connected</h4>
				<div class="social-profile-icons">
					<a class="sprite-facebook-32" href="http://facebook.com/makemagazine" title="Facebook" target="_blank">
						<div class="social-profile-cont">	
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-twitter-32" href="http://twitter.com/make" title="Twitter" target="_blank">
						<div class="social-profile-cont">	
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-pinterest-32" href="http://pinterest.com/makemagazine/" title="Pinterest" target="_blank">
						<div class="social-profile-cont">	
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-googleplus-32" href="https://plus.google.com/+MAKE/posts" rel="publisher" title="Google+" target="_blank">
						<div class="social-profile-cont">	
							<span class="sprite"></span>
						</div>
					</a>
				</div>
				<?php
					$isSecure = "http://";
					if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
						$isSecure = "https://";
					}
				?>
	    	    <form action="http://whatcounts.com/bin/listctrl" method="POST">
					<input type="hidden" name="slid" value="6B5869DC547D3D46E66DEF1987C64E7A" />
					<input type="hidden" name="cmd" value="subscribe" />
					<input type="hidden" name="custom_source" value="footer" /> 
					<input type="hidden" name="custom_incentive" value="none" /> 
					<input type="hidden" name="custom_url" value="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>" />
					<input type="hidden" id="format_mime" name="format" value="mime" />
					<input type="hidden" name="goto" value="//makerfaire.com/thanks-for-signing-up" />
					<input type="hidden" name="custom_host" value="<?php echo $_SERVER["HTTP_HOST"]; ?>" />
					<input type="hidden" name="errors_to" value="" />
					<div>
						<input name="email" placeholder="Enter your Email" required="required" type="text"><br>
						<input value="Sign Up for our Newsletter" class="btn-cyan" type="submit">
					</div>
			    </form>
			</div>
			<div class="span12 accordion" id="accordionF">
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionF" href="#collapseOneF">
			        <h3>Make:</h3>
			      </a>
			    </div>
			    <div id="collapseOneF" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <ul class="nav nav-pills nav-stacked">
						<li><a href="//www.pubservice.com/MK/subscribe.aspx?PC=MK&PK=M3AMZB" target="_blank">Subscribe to Make:</a></li>
						<li><a href="/projects">Make: Projects</a></li>
						<li><a href="/weekendprojects">Weekedn Projects</a></li>
						<li><a href="/video">Make: Videos</a></li>
						<li><a href="/category/maker-pro">Maker Pro News</a></li>
					</ul>
			      </div>
			    </div>
			  </div>
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionF" href="#collapseTwoF">
			        <h3>Explore Making</h3>
			      </a>
			    </div>
			    <div id="collapseTwoF" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <ul class="nav nav-pills nav-stacked">
						<li><a href="/blog">Make: News</a></li>
						<li><a href="//makerfaire.com" target="_blank">Maker Faire</a></li>
						<li><a href="//www.makershed.com" target="_blank">Maker Shed</a></li>
						<li><a href="//makercon.com" target="_blank">MakerCon</a></li>
						<li><a href="//makercamp.com" target="_blank">Maker Camp</a></li>
					</ul>
			      </div>
			    </div>
			  </div>
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionF" href="#collapseThreeF">
			        <h3>Our Company</h3>
			      </a>
			    </div>
			    <div id="collapseThreeF" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <ul class="nav nav-pills nav-stacked">
						<li><a href="//makermedia.com" target="_blank">About Us</a></li>
						<li><a href="//makermedia.com/work-with-us/advertising" target="_blank">Advertise with Us</a></li>
						<li><a href="//makermedia.com/work-with-us/job-openings" target="_blank">Careers</a></li>
						<li><a href="//help.makermedia.com/hc/en-us" target="_blank">Help</a></li>
						<li><a href="//makermedia.com/privacy" target="_blank">Privacy</a></li>
					</ul>
			      </div>
			    </div>
			  </div>
			</div>
		</div><!-- End social-foot-mobile -->
	</div><!-- END container -->
	<?php echo make_copyright_footer(); ?>
</footer><!-- END new-footer -->

<script type="text/javascript">

	jQuery(document).ready(function(){

		jQuery('.dropdown-toggle').dropdown();
		jQuery('#north').tab('show');
		jQuery('#myModal').modal('hide');
		jQuery('#featuredMakers').carousel({
			interval: 5000
		});
                        jQuery('#mf-featured-slider').carousel({
                            interval: 8000
                        });
                        
		jQuery( ".carousel" ).each( function() {
	        jQuery(this).carousel({
			interval: 4000
			        });
	    });
		
	});

</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=216859768380573";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Quantcast Tag -->
<script type="text/javascript">
var _qevents = _qevents || [];

(function() {
var elem = document.createElement('script');
elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
elem.async = true;
elem.type = "text/javascript";
var scpt = document.getElementsByTagName('script')[0];
scpt.parentNode.insertBefore(elem, scpt);
})();

_qevents.push({
qacct:"p-c0y51yWFFvFCY"
});
</script>

<noscript>
<div style="display:none;">
<img src="//pixel.quantserve.com/pixel/p-c0y51yWFFvFCY.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>
<!-- End Quantcast tag -->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=131038253638769";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script type='text/javascript'>
(function (d, t) {
  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
  bh.type = 'text/javascript';
  bh.src = '//www.bugherd.com/sidebarv2.js?apikey=3pkvtpykrj9qwq4qt9rmuq';
  s.parentNode.insertBefore(bh, s);
  })(document, 'script');
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.wp-navigation a').addClass('btn');
	jQuery(".scroll").click(function(event){
		//prevent the default action for the click event
		event.preventDefault();

		//get the full url - like mysitecom/index.htm#home
		var full_url = this.href;

		//split the url by # and get the anchor target name - home in mysitecom/index.htm#home
		var parts = full_url.split("#");
		var trgt = parts[1];

		//get the top offset of the target anchor
		var target_offset = jQuery("#"+trgt).offset();
		var target_top = target_offset.top;

		//goto that anchor by setting the body scroll top to anchor top
		jQuery('html, body').animate({scrollTop:target_top - 50}, 1000);

	});
	var exists = jQuery('td.has-video').length;
	if ( exists === 0 ) {
		jQuery('td.no-video').remove();
	}
	jQuery('table.schedule').slideDown('slow');
});
</script>

<?php // Adding Crazy Egg tracking ?>
<script type="text/javascript">
setTimeout(function(){var a=document.createElement("script");
var b=document.getElementsByTagName("script")[0];
a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0013/2533.js?"+Math.floor(new Date().getTime()/3600000);
a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>

<!-- Start pop up modal for school page -->
<?php
if ( is_page( '459885' ) ) {
	echo '
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" type="text/css" media="screen" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
	<script>
	function getCookie(name) {
	    var dc = document.cookie; 
	    var prefix = name + "=";
	    var begin = dc.indexOf("; " + prefix);
	    if (begin == -1) {
	        begin = dc.indexOf(prefix);
	        if (begin != 0) return null;
	    } else {
	        begin += 2;
	        var end = document.cookie.indexOf(";", begin);
	        if (end == -1) {
	        end = dc.length;
	        }
	    }
	    return unescape(dc.substring(begin + prefix.length, end));
	}
	jQuery(function() {
	    if ( document.location.href.indexOf("campaign") > -1 ) {
	            var date = new Date();
	            date.setTime(date.getTime()+(60*24*60*60*1000));
	            date = date.toGMTString();
	            document.cookie="Newsletter-signup=; expires=" + date + "; path=/";
	    }
	});
	jQuery(function() {
	    var news_close = getCookie("Newsletter-closed");
	    var news_signup = getCookie("Newsletter-signup");

	    if ( news_signup == null ) {
	      if ( news_close == null ) {
	        jQuery(".fancybox").fancybox({
	            openEffect  : "fade",
	            closeEffect : "none",
	            autoSize : false,
	            width  : 500,
	            height  : 225,
	            beforeClose : function() {
		            var date = new Date();
		            date.setTime(date.getTime()+(7*24*60*60*1000));
		            date = date.toGMTString();
		            document.cookie="Newsletter-closed=; expires=" + date + "; path=/";
			  	},
			  	afterLoad   : function() {
                	this.content = this.content.html();
            	}
	        }).trigger("click");   

	        jQuery( ".newsletter-set-cookie" ).click(function() {
	            var date = new Date();
	            date.setTime(date.getTime()+(60*24*60*60*1000));
	            date = date.toGMTString();
	            document.cookie="Newsletter-signup=; expires=" + date + "; path=/";
	        });
	      }
	    }
	});
	jQuery(document).ready(function(){
		if(window.location.href.indexOf("?thankyou") > -1) {
			jQuery.fancybox("<h2>Thank you</h2><h3>for signing up.</h3>", {
			width: 500,
			height: 200,
			closeBtn : false,
			afterLoad: function() {
				setTimeout( function() {
					jQuery.fancybox.close();
				},
				3000); // 3 secs
			}
			});
		}
	});
	</script>
	<div class="fancybox" style="display:none;">
	    <h3>Yes, I\'m interested in the <br/>School Maker Faire Program.</h3>
		<form name="MailingList" action="http://whatcounts.com/bin/listctrl" method="POST">
			<input type=hidden name="slid" value="6B5869DC547D3D4637EA6E33C6C8170D" />
			<input type="hidden" name="cmd" value="subscribe" />
			<input type="hidden" name="custom_host" value="makerfaire.com" />
			<input type="hidden" name="custom_incentive" value="none" />
			<input type="hidden" name="custom_source" value="modal" />
			<input type="hidden" name="goto" value="http://makerfaire.com/global/school/?thankyou" />
			<input type="hidden" name="custom_url" value="makerfaire.com/global/school" />
			<label>Your Email:</label>
			<input type="email" id="titllrt-titllrt" name="email" required>
			<input type="submit" name="Submit" id="newsletter-set-cookie" value="Sign Me Up" class="btn-cyan btn-modal newsletter-set-cookie">
			<input type="hidden" id="format_mime" name="format" value="mime" />
		</form>
	</div>
	';
} ?>
<!-- End pop up modal for school page -->

<?php wp_footer(); ?>

</body>
</html>