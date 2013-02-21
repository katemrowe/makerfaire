<div class="clear"></div>

<div class="beige">

	<div class="container">
	
		<footer>

			<div class="row">

				<div class="span4" style="background-color:#e8f1f4;">

					<div class="fb-like-box" data-href="http://www.facebook.com/makerfaire" data-width="300" data-height="393" data-show-faces="true" data-stream="false" data-header="false"></div>
		
				</div><!--Facebook-->
				
				<div class="span4">
				
					<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
					<script>
					new TWTR.Widget({
					  version: 2,
					  type: 'search',
					  search: 'makerfaire',
					  interval: 30000,
					  title: 'Follow us on Twitter @makerfaire',
					  subject: 'Tweets about Maker Faire',
					  width: 298,
					  height: 300,
					  theme: {
						shell: {
						  background: '#e8f1f4',
						  color: '#3B5998'
						},
						tweets: {
						  background: '#e8f1f4',
						  color: '#6b6b6b',
						  links: '#81a6c8'
						}
					  },
					  features: {
						scrollbar: false,
						loop: true,
						live: true,
						behavior: 'default'
					  }
					}).render().start();
					</script>
				
				</div><!--Twitter-->
		
				<div class="span4">

						<?php get_template_part('feat_faires'); ?>
				
				</div>
							
			</div>
			
			<div class="row">
			
				<div class="span12">
			
					<ul class="nav nav-pills">
					
						<li><a href="http://makerfaire.com/makerfairehistory/">About</a></li>
						<li><a href="http://blog.makezine.com/tag/maker-faire/">Blog</a></li>
						<li><a href="http://makerfaire.com/contact/">Contact Us</a></li>
						<li><a href="http://makerfaire.com/newsletter/">Newsletter</a></li>
						<li><a href="http://makermedia.com/privacy/">Privacy Policy</a></li>
						<li><a href="http://makerfaire.com/sponsors/">Sponsors</a></li>
						<li><a href="http://makerfaire.com/be-a-maker/">Be a Maker</a></li>			
					</ul>
					
				</div>
				
				<div class="span12 center">
					<?php if ( function_exists('vip_powered_wpcom') ) { echo vip_powered_wpcom(4); } ?>
				</div>
			
			</div>
		</footer>
		
	</div>
	
</div>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tab.js"></script>
<script type="text/javascript">

	jQuery(document).ready(function(){

		jQuery('.dropdown-toggle').dropdown()
		jQuery('#north').tab('show')
		jQuery('#myModal').modal('hide')
		jQuery('.carousel').carousel({
			interval: 4000
		})
		jQuery('.sponsorCarousel').carousel({
			interval: 3000
		})
	});

</script>

<script type="text/javascript" charset="utf-8">
	jQuery.embedly.defaults['key'] = '899d8ef024274909b3fabb22f2f8ee24';
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
});
</script>

<?php wp_footer(); ?>

</body>
</html>