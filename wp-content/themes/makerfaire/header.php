<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en"  ng-app="ribbonApp">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
            
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-itunes-app" content="app-id=463248665"/>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? 'Make • Create • Craft • Build • Play' : wp_title(''); ?></title>

	<?php
		// Make sure we stop indexing of any maker pages, the application forms, author pages or attachment pages
		if ( get_post_type() == 'maker' || is_page( array( 876, 877, 878, 371 ) ) || is_author() || is_attachment() ) {
			echo '<meta name="robots" content="noindex, follow">';
		}
	?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le styles -->

	<?php wp_head(); ?>
	<!-- Remarketing pixel -->
        <!-- sumome -->
        <script src="//load.sumome.com/" data-sumo-site-id="3aa0a00731e2c63a4b3d480f0fef6df9476553c74fc88aa80b948e2a878b3d71" async="async"></script>
	<script type="text/javascript">
		adroll_adv_id = "QZ72KCGOPBGLLLPAE3SDSI";
		adroll_pix_id = "RGZKRB7CHJF5RBMNCUJREU";
		(function () {
		var oldonload = window.onload;
		window.onload = function(){
		   __adroll_loaded=true;
		   var scr = document.createElement("script");
		   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
		   scr.setAttribute('async', 'true');
		   scr.type = "text/javascript";
		   scr.src = host + "/j/roundtrip.js";
		   ((document.getElementsByTagName('head') || [null])[0] ||
		    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
		   if(oldonload){oldonload()}};
		}());
	</script>

	<?php get_template_part('dfp'); ?>

	<script>
		var _prum = [['id', '53fcea2fabe53d341d4ae0eb'],
		            ['mark', 'firstbyte', (new Date()).getTime()]];
		(function() {
		    var s = document.getElementsByTagName('script')[0]
		      , p = document.createElement('script');
		    p.async = 'async';
		    p.src = '//rum-static.pingdom.net/prum.min.js';
		    s.parentNode.insertBefore(p, s);
		})();
	</script>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-51157-7', 'auto');
		ga('send', 'pageview', {
 		'page': location.pathname + location.search  + location.hash
		});
	</script>

	<?php if ( is_404() ) : // Load this last. ?>
		<script>
			// Track our 404 errors and log them to GA
			ga('send', 'event', '404', 'URL', document.location.pathname + document.location.search);
		</script>
	<?php endif; ?>

	<script type="text/javascript">
		dataLayer = [];
	</script>
       </head>

<body id="bootstrap-js" <?php body_class('no-js'); ?>>
	
	<!-- Google Tag Manager MakerFaire -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PCDDDV"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-PCDDDV');</script>
	<!-- End Google Tag Manager -->

	<script type="text/javascript">document.body.className = document.body.className.replace('no-js','js');</script>
<!--
======
Topbar
======
-->
<!-- TOP BRAND BAR -->
<div class="hidden-xs top-header-bar-brand">
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-6 text-center">
        <p class="header-make-img"><a href="//makezine.com?utm_source=makerfaire.com&utm_medium=brand+bar&utm_campaign=explore+all+of+make" target="_blank">Explore all of <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/make_logo.png" alt="Make: Makezine Logo" /></a></p>
      </div>
      <div class="col-sm-3">
        <p class="header-sub-link pull-right"><a id="trigger-overlay" href="#">SUBSCRIBE </a></p>
      </div>
    </div>
  </div>   
</div>

<header id="header" class="quora">

<?php
  $menu_name = 'Main Navigation Version 2';
  $menu = wp_get_nav_menu_object( $menu_name );
  $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC', 'walker' => new Description_Walker ) );
?>
	<nav class="navbar navbar-default navbar-fixed-top visible-xs-block">
		<div class="container">
		    <div class="navbar-header">
		    	<a class="navbar-brand" href="<?php bloginfo('url'); ?>"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" height="43" width="183" alt="maker faire"></a>
				<button type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<?php

				//     echo '<li  class="dropdown '.$class.'"><a href="'.$parent['url'].'"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$parent['title'].'<span class="caret"></span></a>';
				//     if(is_array($parent)){
				//         echo '<ul class="dropdown-menu" role="menu">';
				//         foreach($parent as $key=>$child){
				//             if(is_array($child)  && $key!='classes'){
				//                 $class = '';
				//                 if(isset($child['classes']) && is_array($child['classes'])){
				//                     foreach($child['classes'] as $childClass){
				//                         $class .= $childClass;
				//                     }
				//                 }
				//                 echo '<li class="'.$class.'"><a href="'.$child['url'].'">'.$child['title'].'</a></li>';
				//             }
				//         }
				//         echo '</ul>';
				//     }
				//     echo '</li>';
				// }
				// echo '</ul>';

				$mobileNavName = 'mobile-nav';
				wp_nav_menu( array(
				        'theme_location' => '$mobileNavName',
				        'menu'            => 'Main Navigation Version 2 Mobile',
				        'container' => false
				) );
				?>

		      <div class="mobile-nav-social padtop padbottom">

		      	<span class="nav-follow-us text-muted padright">Follow us:</span>

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
			  </div>
		    </div>


		</div>
	</nav>

	<nav class="navbar hidden-xs">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php bloginfo('url'); ?>"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" height="43" width="183" alt="maker faire"></a>
			</div>

	        <div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
				    <?php
				    $menu_name = 'Main Navigation Version 2';
				    $count = 0;
				    $submenu = false;

				    foreach( $menuitems as $item ):
				            //4/23/15
				        $new_window     = (isset($item->target)?$item->target:'');
				        $link           = $item->url;
				        $title          = $item->title;
				        $classes        = $item->classes;
				        $description    = $item->description ;
				        // item does not have a parent so menu_item_parent equals 0 (false)
				        if ( !$item->menu_item_parent ):

				        // save this id for later comparison with sub-menu items
				        $parent_id = $item->ID;
				    ?>
				 
                                       <li class="<?php echo ($new_window!=''?'':'dropdown');?>">
				        <a href="<?php echo $link; ?>" <?php echo ($new_window!=''?'target="'.$new_window.'"':'');?> <?php echo ($new_window!=''?'':'class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"');?>>
				            <?php echo $title; ?> 
				            <span class="caret"></span>
				        </a>
				    <?php endif; ?>
				 
				    <?php if ( $parent_id == $item->menu_item_parent ): ?>
				 
				            <?php if ( !$submenu ): $submenu = true; ?>
				            
				            <div class="drop-holder">
				                <div class="drop">
				                    <div class="container">
				                        <div class="row padtop padbottom">
			                                <div class="col-sm-3 drop-logo about text-center padtop">
			                                	
			                                </div>
			                                <div class="col-sm-9 column padtop">
			                                	<div class="top-holder">
			                                    </div>
			                                	<div class="col-sm-9 col no-border">
			                                        <ul class="sub-menu">
			            	<?php endif; ?>
			                                            <li class="item <?php foreach ($classes as $class) {echo $class.' ';}; ?>">
			                                                <a href="<?php echo $link; ?>" <?php echo ($new_window!=''?'target="'.$new_window.'"':'');?> class="title"><?php echo $title; ?></a>
			                                                <div class="description"><?php echo $description; ?></div>
			                                            </li>
			            	<?php if ( $menuitems[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ): ?>
			                                        </ul>
			                                    </div>
			                                    <div class="col-sm-3 col dinamic-content"></div>
			                                </div>    
				            			</div>
				            		</div>
				            	</div>
				            </div>
				            <?php $submenu = false; endif; ?>
				 
				        <?php endif; ?>
				 	
				    <?php if ( (isset($menuitems[ $count + 1 ]->menu_item_parent))&&$menuitems[ $count + 1 ]->menu_item_parent != $parent_id ): ?>
				    </li>                           
				    <?php $submenu = false; endif; ?>
				 	
				<?php $count++; endforeach; ?>
				 
				</ul>
			</div>
		</div>
	</nav>
</header>