<?php
	/*
	Template name: Slideshow
	*/
	get_header(); ?>
<div class="clear"></div>
<div class="container live-page">
	<div class="row" style="margin-bottom:0px;padding-bottom:0px;">
		<div class="col-xs-8">
			<div class="row">
				<div class="col-xs-12">
					<h1 style="margin-top:0px;">
						Day One: First Friday @ Maker Faire
					</h1>
				</div>
			</div>
		</div>
		<div class="col-xs-2">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/robot.png" width="auto" alt="makey robot" />
		</div>
		<div class="col-xs-2">
			<a class="btn btn-danger pull-right" href="//mfba2015.eventbrite.com/" target="_blank">BUY TICKETS</a>
		</div>
	</div>
	<div class="row">
		<div class="content col-xs-12">
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
<div style="height:23px;background-repeat: repeat-x;background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/bg-border.png'); " >
</div>
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
<!--end of Sponsor carusel section--> 
<!-- <div style="background-color: #075c78;color:#fff;padding-bottom:30px;font-size:12px;">
	<div class="container live-archive" >
		<h2>Make: Editors Report fom Maker Faire</h2>
	
			<div class="row" style="margin-bottom:30px;">
				<div class="col-md-4">
					<a href="#"><img class ="img-responsive" src="http://img.youtube.com/vi/be2k5b_4YBc/0.jpg" alt="" /></a>
					<h3 style="font-size:18px;margin-top:12px;">Denny the Urban Bike</h3>
					<p>App c# jQuery page speed dom python html markdown javascript tablet hosting bootstrap yaml FTP puppet sql page dom css TCP. </p>
				</div>
				<div class="col-md-4">
					<a href="#"><img class ="img-responsive" src="http://img.youtube.com/vi/be2k5b_4YBc/0.jpg" alt="" /></a>
					<h3 style="font-size:18px;margin-top:12px;">Botfactory and Squink and Bay Area Maker</h3>
					<p>App c# jQuery page speed dom python html markdown javascript tablet hosting bootstrap yaml FTP puppet sql page dom css TCP. </p>
	
				</div>
				<div class="col-md-4">
					<a href="#"><img class ="img-responsive" src="http://img.youtube.com/vi/be2k5b_4YBc/0.jpg" alt="" /></a>
					<h3 style="font-size:18px;margin-top:12px;">Denny the Urban Bike</h3>
					<p>App c# jQuery page speed dom python html markdown javascript tablet hosting bootstrap yaml FTP puppet sql page dom css TCP. </p>
				</div>
			</div> 
			<!-- new row-->
<!-- 			<div class="row" style="margin-bottom:30px;">
	<div class="col-md-4">
		<a href="#"><img class ="img-responsive" src="http://img.youtube.com/vi/be2k5b_4YBc/0.jpg" alt="" /></a>
		<h3 style="font-size:18px;margin-top:12px;">Denny the Urban Bike</h3>
		<p>App c# jQuery page speed dom python html markdown javascript tablet hosting bootstrap yaml FTP puppet sql page dom css TCP. </p>
	</div>
	<div class="col-md-4">
		<a href="#"><img class ="img-responsive" src="http://img.youtube.com/vi/be2k5b_4YBc/0.jpg" alt="" /></a>
		<h3 style="font-size:18px;margin-top:12px;">Botfactory and Squink and Bay Area Maker</h3>
		<p>App c# jQuery page speed dom python html markdown javascript tablet hosting bootstrap yaml FTP puppet sql page dom css TCP. </p>
	
	</div>
	<div class="col-md-4">
		<a href="#"><img class ="img-responsive" src="http://img.youtube.com/vi/be2k5b_4YBc/0.jpg" alt="" /></a>
		<h3 style="font-size:18px;margin-top:12px;">Denny the Urban Bike</h3>
		<p>App c# jQuery page speed dom python html markdown javascript tablet hosting bootstrap yaml FTP puppet sql page dom css TCP. </p>
	</div>
	</div>
	
	
	</div>
	</div>
	</div>
	<!--Container-->
<?php get_footer(); ?>
