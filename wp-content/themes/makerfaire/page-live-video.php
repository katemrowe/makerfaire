<?php
	/*
	Template name: Live Video
	*/
	get_header(); ?>
<div class="clear"></div>
<div class="container live-page">
	<div class="row" style="margin-bottom:0px;padding-bottom:0px;">
		<div class="col-xs-7">
			<div class="row">
				<div class="col-xs-12">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<h2 style="font-size:14px;color:#333;margin-top:0px;">Saturday 10am-8pm PT | Sunday 10am-6pm PT</h2>
				</div>
			</div>
		</div>
		<div class="col-xs-2">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/robot.png" width="auto" alt="makey robot" />
		</div>
		<div class="col-xs-3 social">
			<div class="social-foot-col">
				<div class="social-profile-icons">
					<a class="sprite-facebook-32" href="//www.facebook.com/sharer/sharer.php?u=http://makerfaire.com/live" title="Facebook" target="_blank">
						<div class="social-profile-cont">
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-twitter-32" href="https://twitter.com/home?status=http://makerfaire.com/live" title="Twitter" target="_blank">
						<div class="social-profile-cont">
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-pinterest-32" href="https://pinterest.com/pin/create/button/?url=http://makerfaire.com/live/&media=http://makerfaire.com/wp-content/themes/makerfaire/images/robot.png&description=May%2016-17,%202015%20The%20Make:%20Video%20Team%20takes%20you%20to%20Maker%20Faire%20at%20the%20San%20Mateo%20County%20Fairgrounds.%20We'll%20be%20wandering,%20wondering,%20exploring,%20making%20stuff,%20connecting%20and%20being%20amazed%20the%20whole%20weekend.%20(But%20it's%20NOT%20as%20good%20as%20being%20there...)" title="Pinterest" target="_blank">
						<div class="social-profile-cont">
							<span class="sprite"></span>
						</div>
					</a>
					<a class="sprite-googleplus-32" href="//plus.google.com/share?url=http://makerfaire.com/live" rel="publisher" title="Google+" target="_blank">
						<div class="social-profile-cont">
							<span class="sprite"></span>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<?php the_content(); ?>
			</article>
			<?php endwhile; ?>
			<?php else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
			<div class="clearfix">&nbsp;</div>
		</div>
	</div>
</div>
<div class="flag-border"></div>
<div class="live-archive">
	<div class="container live-page">
		<div class="row modal-fix padtop">
			<div class="content col-xs-12">
				<h2>Make: Editors Report fom Maker Faire</h2>
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal1" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/ForzIQZy5ZA/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Big Makey Flyover </h3>
						<p>&nbsp;</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel" style="color:#000">Maker Faire Bay Area 2015 1</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal1').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=MNWV0b237do&index=1&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal1').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal2" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/Xgwqy2lJ3_g/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Making with Microsoft</h3>
						<p>Microsoft's Tony Goodhew chats about the Microsoft booth.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel2" style="color:#000">Maker Faire Bay Area 2015 2</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal2').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=Xgwqy2lJ3_g&index=2&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal2').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal3" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/81kJuLI94O0/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Unnecessarily High Five </h3>
						<p>Celebrate the universal love of high-fiving with this sensor-equipped high-five rig.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel3" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal3').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=81kJuLI94O0&index=3&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal3').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row 2-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal4" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/fxHyAgybbZs/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">The New Beaglebone Green </h3>
						<p>We talk to Jason Krinder of Beagleboard.org about the new Beaglebone Green. The new board is a clone of the Beaglebone Black produced by Seeed Studio based on the original open hardware design.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal4" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel4" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal4').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=fxHyAgybbZs&index=4&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal4').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal5" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/H3sWm-OOjYk/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Kraut Source </h3>
						<p>Karen Diggs' company Kraut Source sells fermenting kits. All of her products are sustainably made and expertly crafted. They each help you create any fermented food product you can think of.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal5" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel5" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal5').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=H3sWm-OOjYk&index=5&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal5').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal6" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/eJxZtn2gdT0/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Succulent Wine Cork from UC Davis </h3>
						<p>Succulent Wine Cork From UC Davis making people aware of the drought.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal6" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel6" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal6').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=eJxZtn2gdT0&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us&index=6" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal6').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row 3-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal7" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/rLC8G7fM9PA/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Building Projects with Cypress PSoC </h3>
						<p>We talk to Gagan Luthra from Cypress Semiconductor about Cypress PSoC, the differences between it and a standard microcontroller, their development kits and the Cypress PSoC Challenge.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal7" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel7" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal7').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=rLC8G7fM9PA&index=7&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal7').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal8" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/JGBzHCmAPI0/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Laney College Dodecahedron </h3>
						<p>Learn how Laney College created a giant plywood geodesic structure.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal8" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel8" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal8').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=JGBzHCmAPI0&index=8&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal8').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal9" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/gFCPnohdz-c/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Mole-a-Whack </h3>
						<p>Contestants - i.e. kids - build their own cardboard buttons and tap them for points, while trying to avoid the whack of a mole - it's Whack-a-Mole, but in reverse.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal9" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel9" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal9').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=gFCPnohdz-c&index=9&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal9').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row 4-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal10" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/bHa97MYju9I/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Anouk's Bubble Dress and Limited Edition Pink Teensy</h3>
						<p>During MakerCon we caught up with Anouk Wipprecht in the Maker Media Lab, who was furiously working to complete her latest work — the Bubble Gum Dress — in time for Maker Faire Bay Area.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal10" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel10" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal10').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=bHa97MYju9I&index=10&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal10').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal11" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/hVHPsIiBVpk/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Denny the Urban Bike</h3>
						<p>During MakerCon we caught up with Anouk Wipprecht in the Maker Media Lab, who was furiously working to complete her latest work — the Bubble Gum Dress — in time for Maker Faire Bay Area.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal11" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel11" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal11').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=hVHPsIiBVpk&index=11&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal11').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal12" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/2HW1YUT1CMw/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">The KaLEDoscope</h3>
						<p>The KaLEDoscope inserts the crowd into the performance.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal12" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel12" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal12').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=2HW1YUT1CMw&index=12&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal12').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row 5-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal13" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/BaJczW6HgUU/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Rubens' Organ</h3>
						<p>When one Rubens' tube isn't enough, you need a Rubens' organ!</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal13" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel13" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal13').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=BaJczW6HgUU&index=13&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal13').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal14" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/b2fRyiC8JKg/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Tensegrity Sculptures and Furniture </h3>
						<p>Robby Cuthbert shows off his unique sculptures and furniture that rely on tension to hold together.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal14" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel14" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal14').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=b2fRyiC8JKg&index=14&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal14').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
										<div class="col-md-4">
						<a href="#myModal15" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/85PVwyqkOdk/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">DF Robot: Drive the Future </h3>
						<p>We caught up w/ Hector from DF Robot to learn about their booth and how they help make making easier.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal15" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel15" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal15').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=85PVwyqkOdk&index=15&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal15').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row 6-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal16" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/0bFHzlEYdAg/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Rube Goldberg's Paintball </h3>
						<p>Maker Kids, a makerspace for kids in Toronto, brought all the fixins for kids to build their own Rube Goldberg contraptions , made to fire paintballs.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal16" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel16" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal16').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=0bFHzlEYdAg&index=16&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal16').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal17" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/8hsorBt59NE/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Bot Bash Party </h3>
						<p>Zachary from the Bot Bash Party service shows us their flea-weight battling robots, and unveils their plans for a Bot Bash Summer Program.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal17" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel17" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal17').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=8hsorBt59NE&index=17&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal17').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
										<div class="col-md-4">
						<a href="#myModal18" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/2DxGPWJBB_M/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">A First Look at the Mosaic </h3>
						<p>The Mosaic</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal18" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel18" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal18').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=2DxGPWJBB_M&index=18&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal18').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row 7-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal19" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/-Z6qYhwIN6U/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Auto-Aligning Router </h3>
						<p>The self-aligning hand router formerly known as Taktia is renamed Shaper, while getting 2-depth and a slick new case.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal19" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel19" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal19').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=-Z6qYhwIN6U&index=19&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal19').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal20" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/inJNN6WibxM/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Megabots - Giant Humanoid Combat Robots </h3>
						<p>Megabots are chasing the dream of bringing giant humanoid combat robots to life. Their early build, shown here, moves about on tank treads and fires giant paintballs.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal20" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel20" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal20').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=inJNN6WibxM&index=20&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal20').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal21" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/0UVn3QaI3zc/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">The Prototype Pebble Smartstrap in Public </h3>
						<p>We talk to Pebble about their new watch, the Pebble Time, and the dueling sumo bots you can control with it.
We also see Seeed Studio's Xadow-based Smartstrap for the very first time in public.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal21" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel21" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal21').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=0UVn3QaI3zc&index=21&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal21').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row 8-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal22" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/ByOAkOnS7O4/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">eBike Battery Watchdog </h3>
						<p>Charles "Chuck" Swiger, the winner of the first-ever PSoC Challenge. The contest challenged Makers to design IoT projects using the newly released PSoC 4 BLE Pioneer Kit. Ten Maker prujects competed for one grand prize, $2,500. A few travel here to Maker Faire Bay Area.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal22" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel22" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal22').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=ByOAkOnS7O4&index=22&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal22').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal23" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/njlz6NfXxjM/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Connecting Coffee and Wine with ARMs </h3>
						<p>We talk to Zach Shelby from ARM about the Internet of Things and he shows off his in-house team's project , an mbed connected espresso machine, as well as an internet connected wine rack made by  a partner company.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal23" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel23" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal23').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=njlz6NfXxjM&index=23&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal23').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal24" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/HyWn4_22cN8/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Making with the Sprout by HP </h3>
						<p>We check in with Sheau-Lan from the Sprout team to see how the Sprout is inspiring makers to learn and create.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal24" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel24" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal24').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=HyWn4_22cN8&index=24&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal24').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row 9-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal25" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/4enXl57BjG8/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Modern Day Player Piano </h3>
						<p>Ramon shows off his modern day player piano. Some new technology grafted to the existing player mechanisms allow Ramon to play a multitude of songs, often drawing a crowd.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal25" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel25" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal25').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=4enXl57BjG8&index=25&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal25').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal26" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/fgquWO_D-_8/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Controlling the IoT with Facebook </h3>
						<p>We talk to George Yakoleve from Facebook about Parse for IoT, a new SDK supporting both Arduio and Raspberry Pi, as well as targeting selected RTOS platforms.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal26" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel26" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal26').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=fgquWO_D-_8&index=26&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal26').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal27" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/2dcPd_H9gnQ/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">The littleBits Analog Arcade Machine </h3>
						<p>We talked to Kristin Salomon and Paul Rothman from littleBits about the littleBits module system, BitLabs, and the towering analog arcade machine they've brought here to the Faire.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal27" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel27" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal27').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=2dcPd_H9gnQ&index=27&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal27').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
				<!-- new row  10-->
				<div class="row" style="margin-bottom: 30px;">
					<div class="col-md-4">
						<a href="#myModal28" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/jOUALurj5P4/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Talking Arduino Zero with Atmel </h3>
						<p>We talk to Atmel's Wizard of Make, Bob Martin, about the Arduino Zero.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal28" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel28" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal28').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=jOUALurj5P4&index=28&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal28').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal29" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/Zhu4JWEMlwg/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">Printables for 3D Warehouse </h3>
						<p>Sketchup and Materialise team up to allow for automatic, 3D-printable .stl generation for your sketchup designs.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal29" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal29').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=Zhu4JWEMlwg&index=29&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModal29').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
					<div class="col-md-4">
						<a href="#myModal30" role="button" class="modal-archive" data-toggle="modal">
						<img class="img-responsive" src="http://img.youtube.com/vi/ER6FJgY-iFI/0.jpg" alt="" />
						<h3 style="font-size: 18px; margin-top: 12px;">CoasterDad is Selling His Coaster </h3>
						<p>Instead of taking it home from Maker Faire, Will Pemble put his backyard roller coaster on Ebay.</p></a>
					</div>
					<!-- Video Modal  One-->
					<div id="myModal30" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel30" style="color:#000">Maker Faire Bay Area 2015</h3>
						</div>
						<div class="modal-body">
							<script>
								jQuery('#myModal30').on('show', function () { 
								 jQuery('div.modal-body').html('<iframe src="https://www.youtube.com/embed/watch?v=ER6FJgY-iFI&index=30&list=PLwhkA66li5vC06gyQNvo6I6nd9AXjN5us" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');  
								});
								jQuery('#myModa30').on('hide', function () {
								 jQuery('div.modal-body').html('');
								});
							</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="flag-border"></div>
<!-- Sponsor carusel section-->
<div class="sponsors-wrap">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 sponsor-carousel-holder">
				<div class="head-box">
					<div class="title">
						<h1>Bay Area Maker Faire Sponsors <mark><a href="/bay-area-2015/sponsors/">Become a sponsor</a></mark></h1>
					</div>
					<div class="open-close">
						<a class="opener" href="#"><span class="selected">Silversmith</span><i class="icon-arrow-right"></i></a>
						<div class="slide">
							<ul class="tabset">
								<li class="active"><a href="#tab2">Goldsmith</a></li>
								<li><a href="#tab1">Silversmith</a></li>
								<li><a href="#tab3">Coppersmith</a></li>
								<!-- <li><a href="#tab4">Media</a></li>
									<li><a href="#tab4">Presenting</a></li> -->
							</ul>
						</div>
					</div>
				</div>
				<div class="sponsor-carousel">
					<div class="mask">
						<div class="slideset">
							<div class="slide">
								<?php echo mf_sponsor_list('Goldsmith Sponsor') ?>
							</div>
							<div class="slide">
								<?php echo mf_sponsor_list('Silversmith Sponsor') ?>
							</div>
							<div class="slide">
								<?php echo mf_sponsor_list('Coppersmith Sponsor') ?>
							</div>
							<!--
								<div class="slide">
								<?php // echo mf_sponsor_list('Media Sponsor') ?>
								</div>
								<div class="slide">
								<?php // echo mf_sponsor_list('Presenting Sponsor') ?>
								</div>
								-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End of Sponsor carousel section--> 
<!--End  Container-->
<?php get_footer(); ?>
