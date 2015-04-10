<div class="clear"></div>

<footer id="footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12">
						<div class="logo"><a href="<?php echo site_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" height="43" width="183" alt=""></a></div>
					</div>
				</div>

                <div class="row">
                    <div class="col-xs-9">
                        <?php wp_nav_menu('footer'); ?>
                    </div>
                    <div class="col-xs-3">
                        <div class="email-holder">
                            <h2>Stay in the Loop</h2>
                            <form class="form-inline" action="http://makermedia.createsend.com/t/r/s/jjuruj/" method="post" id="subForm">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter your email" class="form-control" name="cm-jjuruj-jjuruj" id="jjuruj-jjuruj">
                                </div>
                                <button type="submit" class="btn btn-info"  value="Go!" class="btn" onclick="ga('send', 'event', 'Newsletter Sub', 'Join', jQuery('[name|=cm]').serialize().replace(/&amp;/g, ' ') );">Get the news</button>
                            </form>
                            <p>This will subscribe you to our events newsletter. Find more cool newsletters you can subscribe to <a href="#">here</a>!</p>
                        </div>
                    </div>
                </div>


				<div class="row">
					<div class="col-xs-12">
						<p class="copyright">Make: and Maker Faire are registered trademarks of Maker Media, Inc. Copyright o 2004-2015 Maker Media, Inc. All rights reserved</p>
					</div>
				</div>
			</div>
		</footer>
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
		jQuery('.carousel').carousel({
			interval: 4000
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

<?php wp_footer(); ?>

</body>
</html>
