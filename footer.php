<div class="clear"></div>

<div class="beige">

	<div class="container">
	
		<footer>

			<div class="row">

				<div class="span4" style="background-color:#e8f1f4;">

					<div class="fb-like-box" data-href="http://www.facebook.com/worldmakerfaire" data-width="300" data-height="393" data-show-faces="true" data-stream="false" data-header="false"></div>
		
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
					
						<li><a href="http://makerfaire.com/about.html">About</a></li>
						<li><a href="http://blog.makezine.com/category/maker_faire/">Blog</a></li>
						<li><a href="http://makerfaire.com/contact.html">Contact Us</a></li>
						<li><a href="http://makezine.com/makerfaire/newsletter/index.html">Newsletter</a></li>
						<!--li><a href="http://makerfaire.com/faq.csp">FAQ</a></li-->
						<li><a href="http://oreilly.com/oreilly/privacy.html">Privacy Policy</a></li>
						<!--li><a href="http://makerfaire.com/bayarea/2012/jointhelist.html">Join the List</a></li-->
						<li><a href="http://makerfaire.com/sponsors/">Sponsors</a></li>
						<li><a href="http://makerfaire.com/be-a-maker.html">Be a Maker</a></li>			
						<li><a href="http://makerfaire.com/blue-ribbon/">Editor's Choice Blue Ribbon Winners</a></li>			
					</ul>
					
				</div>
			
			</div>
		</footer>
		
	</div>
	
</div>
<script src="http://makerfaire.com/new/js/bootstrap.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tab.js"></script>
<script type="text/javascript">

$('.dropdown-toggle').dropdown()
$('#north').tab('show')
$('#myModal').modal('hide')
$('.carousel').carousel({
  interval: 4000
})
$('.sponsorCarousel').carousel({
  interval: 3000
})


</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=216859768380573";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type='text/javascript' src='http://s0.wp.com/_static/??/wp-content/js/devicepx.js,/wp-content/themes/vip/plugins/lazy-load/js/jquery.sonar.min.js,/wp-content/themes/vip/plugins/lazy-load/js/lazy-load.js?m=1343162541j'></script>

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

<?php wp_footer(); ?>

</body>
</html>