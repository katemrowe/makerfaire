<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
	<meta charset="utf-8">
	<meta name="apple-itunes-app" content="app-id=463248665"/>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

	<?php
		// Make sure we stop indexing of any maker pages, the application forms, author pages or attachment pages
		if ( get_post_type() == 'maker' || is_page( array( 876, 877, 878, 371 ) ) || is_author() || is_attachment() ) {
			echo '<meta name="robots" content="noindex, follow">';
		}
	?>

	<meta name="description" content="<?php if ( is_single() ) {
				echo wp_trim_words( strip_shortcodes( get_the_content('...') ), 20 );
			} else {
				bloginfo( 'name' );
				echo " - ";
				bloginfo('description');
			}
	?>" />

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le styles -->

	<?php wp_head(); ?>
	<!-- Remarketing pixel -->

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

	<!-- TypeKit -->
	<link rel="stylesheet" href="http://use.typekit.com/c/4690c1/museo-slab:n8:n9:n1:n3,bebas-neue:n4,proxima-nova:n4:i4:n7:i7,museo-slab:n5.QL3:F:2,QL5:F:2,QL7:F:2,SKB:F:2,TGd:F:2,W0V:F:2,W0W:F:2,W0Y:F:2,W0Z:F:2,WH7:F:2/d?3bb2a6e53c9684ffdc9a98f6135b2a62e9fd3f37bbbb30d58844c72ca542eb12d9fc18cda0192bd960a04b65e2f2facc738d907514640137ac74942ecfe54dd35844bc349bb4c1279a7aaf8651616db7b59a075388454f5f4a07fb5c0b8f09dcccc3d70f9605ca7a1dbf9b12b3c351656254cd3fc59e92f2e542459e636860be01542f5c784cda4fe2fc310798ac7c1670eeda393aa990e8b58d73431e6bae280cf620ce09d0a49a9554ea7f25339dd274cf69ee61d55e93d9cb159fd2848203940e4eb67ad0455b5b574d1a27fec0ae65">
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

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
<header id="header" style="height:auto !important;">

<?php
  $menu_name = 'Main Navigation Version 2';
  $menu = wp_get_nav_menu_object( $menu_name );
  $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC', 'walker' => new Description_Walker ) );

?>
 
<nav class="navbar">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php bloginfo('url'); ?>"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" height="43" width="183" alt="Maker Faire Logo"></a>
		</div>
        	<div class="collapse navbar-collapse">
    		
    
<ul class="nav navbar-nav">
    <?php
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
 
    <li class="dropdown">
        <a href="<?php echo $link; ?>" <?php echo ($new_window!=''?'target="'.$new_window.'"':'');?> class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <?php echo $title; ?> 
            <span class="caret"></span>
        </a>
    <?php endif; ?>
 
        <?php if ( $parent_id == $item->menu_item_parent ): ?>
 
            <?php if ( !$submenu ): $submenu = true; ?>
            
            <div class="drop-holder">
                <div class="drop">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="drop-logo about">
                                	
                                </div>
                                <div class="column">
                                	<div class="top-holder">
                                    </div>
                                	<div class="col no-border">
                                        <ul class="sub-menu">
            <?php endif; ?>
                                            <li class="item <?php foreach ($classes as $class) {echo $class.' ';}; ?>">
                                                <a href="<?php echo $link; ?>" <?php echo ($new_window!=''?'target="'.$new_window.'"':'');?> class="title"><?php echo $title; ?></a>
                                                <div class="description"><?php echo $description; ?></div>
                                            </li>
            <?php if ( $menuitems[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ): ?>
                                        </ul>
                                    </div>
                                    <div class="col dinamic-content">
                                    	
                                    </div>
                                </div>
                        	</div>      
            			</div>
            		</div>
            	</div>
            </div>
            <?php $submenu = false; endif; ?>
 
        <?php endif; ?>
 	
    <?php if ( $menuitems[ $count + 1 ]->menu_item_parent != $parent_id ): ?>
    </li>                           
    <?php $submenu = false; endif; ?>
 	
<?php $count++; endforeach; ?>
 
</ul>

		</div>
	</div>
</nav>


</header>