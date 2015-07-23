<?php


// Set our global Faire Variable. Use the slug of the taxonomy as the value.
define( 'MF_CURRENT_FAIRE', 'world-maker-faire-new-york-2014' );

// include maker-faire-forms plugin
require_once( TEMPLATEPATH. '/plugins/maker-faire-forms/maker-faire-forms.php' );

// include maker-faire-forms plugin
require_once( TEMPLATEPATH. '/plugins/public-pages/makers.php' );

// include maker-faire-forms plugin
require_once( TEMPLATEPATH. '/post-types/maker.php' );

// Markdown
require_once( TEMPLATEPATH. '/plugins/markdown/markdown.php' );

// Status Board
require_once( TEMPLATEPATH. '/plugins/status-board/status-board.php' );

// Current Faire Page
require_once( TEMPLATEPATH. '/plugins/admin-pages/current-faire/current-faire.php');

// Sponsor Carousel
include_once TEMPLATEPATH. '/plugins/public-pages/sponsor.php';

// Sponsor Carousel
include_once TEMPLATEPATH. '/plugins/instagram/instagram.php';

// Post Locker
//include_once dirname( __FILE__ ) . '/plugins/hide-post-locker/hide-post-locker.php';

// Blue Ribbons
include_once dirname( __FILE__ ) . '/plugins/blue-ribbons/blue-ribbons.php';

// White House
include_once dirname( __FILE__ ) . '/plugins/white-house/white-house.php';

// Load the settings field for the Applications API
include_once dirname( __FILE__ ) . '/api/admin-settings.php';

// Load the functions for the Applications API
include_once dirname( __FILE__ ) . '/api/v2/functions.php';

// Gravity Forms Specific Plugins and Classes
include_once TEMPLATEPATH. '/classes/gf-limit-checkboxes.php';
include_once TEMPLATEPATH. '/classes/gf-entry-sidebar.php';
include_once TEMPLATEPATH. '/classes/gf-entry-summary.php';
include_once TEMPLATEPATH. '/classes/gf-entry-notifications.php';
include_once TEMPLATEPATH. '/classes/gf-entry-datatables.php';
include_once TEMPLATEPATH. '/classes/gf-helper.php';
include_once TEMPLATEPATH. '/classes/makerfaire-helper.php';
include_once TEMPLATEPATH. '/classes/gf-jdb-helper.php';

// Legacy Helper Functions replacing VIP Wordpress.com calls
include_once TEMPLATEPATH. '/classes/legacy-helper.php';

//cron job
include_once TEMPLATEPATH. '/classes/cronJob.php';

require_once( 'taxonomies/type.php' );
require_once( 'taxonomies/sponsor-category.php' );
require_once( 'taxonomies/location.php' );
require_once( 'taxonomies/faire.php' );
require_once( 'taxonomies/location_category.php' );
require_once( 'taxonomies/makerfaire_category.php' );
require_once( 'taxonomies/group.php' );
require_once( 'plugins/post-types/event-items.php' );
require_once( 'post-types/sponsor.php' );
require_once( 'post-types/location.php' );
if ( defined( 'WP_CLI' ) && WP_CLI )
	require_once( 'plugins/wp-cli/wp-cli.php' );

// add post-thumbnails support to theme
add_theme_support( 'post-thumbnails' );
add_image_size( 'schedule-thumb', 140, 140, true );

// Define our current Version number using the stylesheet version
function my_wp_default_styles($styles)
{
	$my_theme = wp_get_theme();
	$my_version=  $my_theme->get( 'Version' );
	$styles->default_version=$my_version;
}
add_action("wp_default_styles","my_wp_default_styles");


/* Favicon in Header */
add_action('wp_head','my_custom_fav_ico');
function my_custom_fav_ico() {
	echo '<link rel="shortcut icon" href="'.get_stylesheet_directory_uri(). '/images/favicon.ico'.'" />';
}
/* Disable Conflicting Code using Filters */
add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );

/* Load up jQuery */
function make_enqueue_jquery() {
	// Styles
	wp_enqueue_style( 'make-gravityforms', get_stylesheet_directory_uri() . '/css/gravityforms.css' );
	wp_enqueue_style( 'make-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'make-bootstrapdialog', get_stylesheet_directory_uri() . '/css/bootstrap-dialog.min.css' );
	wp_enqueue_style( 'make-styles', get_stylesheet_directory_uri() . '/css/style.css' );
	wp_enqueue_style( 'ytv', get_stylesheet_directory_uri() . '/css/ytv.css' );
	wp_enqueue_style( 'bootgrid', get_stylesheet_directory_uri() . '/plugins/grid/jquery.bootgrid.min.css' );
	wp_enqueue_style( 'jquery-datetimepicker-css',  get_stylesheet_directory_uri() . '/css/jquery.datetimepicker.css' );
	wp_enqueue_style( 'mf-datatables', get_stylesheet_directory_uri() . '/css/mf-datatables.css' );
	
	// Scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-main', get_stylesheet_directory_uri() . '/js/jquery.main.js', array( 'jquery' ) );
	wp_enqueue_script( 'make-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'make-countdown', get_stylesheet_directory_uri() . '/js/jquery.countdown.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery_cookie',  get_stylesheet_directory_uri() . '/js/jquery.cookie.js', array( 'jquery' ), null );
	wp_enqueue_script( 'jquery-datetimepicker',  get_stylesheet_directory_uri() . '/js/jquery.datetimepicker.js', array( 'jquery' ), null );
	wp_enqueue_script( 'ytv', get_stylesheet_directory_uri() . '/js/ytv.js', array( 'jquery' ) );
	wp_enqueue_script( 'make-bootstrapdialog',  get_stylesheet_directory_uri() . '/js/bootstrap-dialog.min.js', array( 'jquery' ), null );
	//wp_enqueue_script( 'make-login-dialog',  get_stylesheet_directory_uri() . '/js/login.js', array( 'jquery' ), null );
	//wp_enqueue_script( 'make-confirmation-dialog',  get_stylesheet_directory_uri() . '/js/confirmation.js', array( 'jquery' ), null );
	wp_enqueue_script( 'make-gravityforms',  get_stylesheet_directory_uri() . '/js/gravityforms.js', array( 'jquery' ), null );
	wp_enqueue_script( 'bootgrid',  get_stylesheet_directory_uri() . '/plugins/grid/jquery.bootgrid.min.js', array( 'jquery' ), null );
	wp_enqueue_script( 'thickbox',null, array( 'jquery' ), null );
         wp_enqueue_script( 'faireSchedule',  get_stylesheet_directory_uri() . '/js/schedule.js', array( 'jquery' ), null ); 

    $translation_array = array('templateUrl' => get_stylesheet_directory_uri());
    wp_localize_script('jquery-main', 'object_name', $translation_array);
	
}
add_action( 'wp_enqueue_scripts', 'make_enqueue_jquery' );

function load_admin_scripts() {

	wp_enqueue_script('make-gravityforms-admin',  get_stylesheet_directory_uri() . '/js/gravityformsadmin.js', array('jquery', 'jquery-ui-tabs'));
	wp_enqueue_script( 'jquery-datetimepicker',  get_stylesheet_directory_uri() . '/js/jquery.datetimepicker.js', array( 'jquery' ), null );
	wp_enqueue_style('jquery-datetimepicker-css',  get_stylesheet_directory_uri() . '/css/jquery.datetimepicker.css');
        wp_enqueue_style('made-admin-style',  get_stylesheet_directory_uri() . '/css/make.admin.css');        
}
add_action( 'admin_enqueue_scripts', 'load_admin_scripts' );

// Add page visible to editors
function register_my_page(){

	add_menu_page( 'Entries Management', 'My Page', 'edit_others_posts', 'my_page_slug',  get_stylesheet_directory_uri() . 'plugins/entry_list.php'  );

}
add_action( 'admin_menu', 'register_my_page' );



/**
 * Allows us to clean the nasty garbled code that gets saved to the database for applications
 * Over time this function will phase out as we rebuild the form system
 * @param  String  $content The application content we want to clean. This should be looped through an array
 * @param  Boolean $report  Setting to true will remove any HTML formating we are correcting as we don't want that output to our reports
 * @return String
 *
 * @since L-Ron
 */
function mf_clean_content( $content, $report = false ) {
	$bad = array( '&#039;', "\'", '\"', '&#8217;', 'u2019', '&#38;', '&#038;', '&amp;', '&#34;', '&#034;', 'u201c', 'u201d', '&#8211;', '&lt;', '&#8230;', 'u00a0', 'u2013', '00ae', 'u016f', 'u0161', 'u00e1', 'u2122', 'u00a9' );
	$good = array( "'",     "'",  '"',  "'",       "'",     '&',     '&',      '&',     '"',     '"',      '"',     '"',     '–',       '>',    '...',     ' ',     '-',     '®',    'ů',     'š',     'á',		'™',	 '©' );

	// If we are are correct HTML, let's add that here as reports we don't want HTML shown in here
	if ( $report ) {
		array_push( $bad,  '<br />\rn', '<br />rn', '<br />nn', 'rnrn', '<br />', '\rn', '.rn' );
		array_push( $good, ' ',		    ' ',		' ',	    ' ',    ' ',      ' ',   ' ' );
	} else {
		array_push( $bad,  '<br />\rn',    '<br />rn',     '<br />nn',     'rnrn',         '.rn' );
		array_push( $good, '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '.<br /><br />' );
	}

	$cleaned = str_replace( $bad, $good, htmlspecialchars_decode( mf_convert_newlines( $content ) ) );

	return $cleaned;
}


function makerfaire_get_news() {
	$url = 'http://makezine.com/maker-faire-news/';
	$response = wp_remote_get( $url, 3, 60,  array( 'obey_cache_control_header' => false ) );
	$output = wp_remote_retrieve_body( $response );
	$cleaned_output = str_replace('?resize=130%2C130', '',$output);
	return $cleaned_output;
}

add_shortcode('news', 'makerfaire_get_news');

function makerfaire_get_beat() {
	$url = 'http://makezine.com/beat-reports/';
	$response = wp_remote_get( $url, 3, 60*60,  array( 'obey_cache_control_header' => false ) );
	$output = wp_remote_retrieve_body( $response );
	return $output;
}

add_shortcode('mf_beat_reports', 'makerfaire_get_beat');

function makerfaire_sidebar_news() {

	$url = 'http://makezine.com/maker-faire-news-sidebar/';
	$response = wp_remote_get( $url, 3, 60*60,  array( 'obey_cache_control_header' => false ) );
	$output = wp_remote_retrieve_body( $response );
	return $output;

}

function makerfaire_get_slider() {
	$url = 'http://makezine.com/maker-faire-featured-slider/';
	$response = wp_remote_get( $url, 3, 60,  array( 'obey_cache_control_header' => false ) );
	$output = wp_remote_retrieve_body( $response );
	return $output;
}
add_shortcode( 'mf-featured-slider', 'makerfaire_get_slider' );

/**
 * Make the 'accepted' status public so that forms can be shown
 *
 * @see http://vip-support.automattic.com/tickets/16382
 */
add_action( 'init', function() {
	global $wp_post_statuses;

	if ( isset( $wp_post_statuses['accepted'] ) )
		$wp_post_statuses['accepted']->public = true;

}, 400 );

function makerfaire_index_feed($n = 4) {
	$f = fetch_feed('http://makezine.com/tag/maker-faire/feed/');

	if(is_wp_error($f))
		return false;

	$max = $f->get_item_quantity($n);
	$fs  = $f->get_items(0, $max);

	$res = array();
	foreach($fs as $i)
	{
		$img = preg_match('/<img(.*?)src="(.*?)"(.*?)>/i', html_entity_decode($i->get_description()), $m);
		$res[] = array('i'=>$i, 'img'=>$m[0], 'src'=>$m[2]);
	}

	return $res;
}

function isc_register_menus() {
  register_nav_menus(
	array( 'header-menu' => __( 'Header Menu' ),
            'footer' => __( 'footer' ),
			'mf-admin-bayarea-register-menu' => __( 'MF BayArea Admin Bar' ),
                        'mf-admin-newyork-register-menu' => __( 'MF NewYork Admin Bar' ),
			'mobile-nav' => __( 'Mobile Navigation' ) )        
  );
}
add_action( 'init', 'isc_register_menus' );


function makerfaire_carousel_shortcode( $atts ) {
	extract( shortcode_atts( array( 'id' => 'biggins'), $atts ) );

	return 	'<a class="carousel-control left" href="#' . esc_attr( $id ) . '" data-slide="prev">
	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span></a>
			<a class="carousel-control right" href="#' . esc_attr( $id ) . '" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span></a>';
}
add_shortcode( 'arrows', 'makerfaire_carousel_shortcode' );

function makerfaire_data_toggle() {
	return '<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#ny2013">New York 2013</a></li>
		<li><a data-toggle="tab" href="#ba2013">Bay Area 2013</a></li>
		<li><a data-toggle="tab" href="#d2013">Detroit 2013</a></li>
		<li><a data-toggle="tab" href="#r2013">Rome 2013</a></li>
		<li><a data-toggle="tab" href="#ny2012">New York 2012</a></li>
		<li><a data-toggle="tab" href="#d2012">Detroit 2012</a></li>
		<li><a data-toggle="tab" href="#ba2012">Bay Area 2012</a></li>
		<li><a data-toggle="tab" href="#ny2011">New York 2011</a></li>
		<li><a data-toggle="tab" href="#d2011">Detroit 2011</a></li>
		<li><a data-toggle="tab" href="#ba2011">Bay Area 2011</a></li>
		<li><a data-toggle="tab" href="#ny2010">New York 2010</a></li>
		<li><a data-toggle="tab" href="#d2010">Detroit 2010</a></li>
		<li><a data-toggle="tab" href="#ba2010">Bay Area 2010</a></li>
		<li><a data-toggle="tab" href="#ba2009">Bay Area 2009</a></li>
		<li><a data-toggle="tab" href="#a2008">Austin 2008</a></li>
		<li><a data-toggle="tab" href="#ba2008">Bay Area 2008</a></li>
		<li><a data-toggle="tab" href="#a2007">Austin 2007</a></li>
	</ul>';
}

add_shortcode( 'tabs', 'makerfaire_data_toggle' );

function makerfaire_newsletter_shortcode() {

		$output = '<form class="form-horizontal" action="http://whatcounts.com/bin/listctrl" method="POST">
				<input type="hidden" name="slid" value="6B5869DC547D3D46E66DEF1987C64E7A" />
				<input type="hidden" name="cmd" value="subscribe" />
				<input type="hidden" name="custom_source" value="Newsletter Shortcode" /> 
				<input type="hidden" name="custom_incentive" value="none" /> 
				<input type="hidden" name="custom_url" value="' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '" />
				<input type="hidden" id="format_mime" name="format" value="mime" />
				<input type="hidden" name="goto" value="//makerfaire.com/thanks-for-signing-up" />
				<input type="hidden" name="custom_host" value="' . $_SERVER["HTTP_HOST"] . '" />
				<input type="hidden" name="errors_to" value="" />
				<fieldset>
					<div id="legend">
					  <legend>Sign up for the Maker Faire Newsletter</legend>
					</div>
					<div class="control-group">
					  <!-- Name -->
					  <label class="control-label" for="first">Name</label>
					  <div class="controls">
					  	<input class="formfield input-xlarge" name="first" required="required" type="text">
					  </div>
					</div>
					<div class="control-group">
					  <!-- Email -->
					  <label class="control-label" for="email">Email</label>
					  <div class="controls">
					  	<input class="formfield input-xlarge" name="email" required="required" type="email">
					  </div>
					</div>
					<div class="control-group">
					  <!-- Button -->
					  <div class="controls">
					    <button class="btn-cyan" type="submit">Subscribe</button>
					  </div>
					</div>
				</fieldset>
		    </form>';

	return $output;
}

add_shortcode( 'newsletter', 'makerfaire_newsletter_shortcode' );

/**
 * meet the makers 
 */
function makerfaire_meet_the_makers_shortcode($atts, $content = null) {
  extract( shortcode_atts( array(
	    'form_id' 	=> '',
	    'entry1_id'	=> '',
	    'entry1_description'	=> '',
	    'entry2_id'	=> '',
	    'entry2_description'	=> '',
	    'entry3_id'	=> '',
 	    'entry3_description'	=> ''
  ), $atts ) );

  $values = array();
    if (null != (esc_attr($entry1_id))) {
      $values[0] = $entries = GFAPI::get_entry(esc_attr($entry1_id)); 
      $entry1_description = isset($entry1_description) ? $entry1_description : $values[0]['151'];
    }
    if (null != (esc_attr($entry2_id))) {
      $values[1] = $entries = GFAPI::get_entry(esc_attr($entry2_id)); 
       $entry2_description = isset($entry2_description) ? $entry2_description : $values[1]['151'];
   }
    if (null != (esc_attr($entry3_id))) {
      $values[2] = $entries = GFAPI::get_entry(esc_attr($entry3_id)); 
       $entry3_description = isset($entry3_description) ? $entry3_description : $values[2]['151'];
   }

$output = '<div class="row filter-container mmakers">' 
          . ' <div class="col-xs-12 col-sm-8"><a href="/maker/entry/' . $values[0]['id'] . '" class="post">'
          . '   <img class="img-responsive" src="' . legacy_get_resized_remote_image_url($values[0]['22'],622,402) . '" alt="Featured Maker 1">'
          . '   <div class="text-box"><span class="section">' . $entry1_description . '</span></div></a>'
          . ' </div><div class="col-xs-12 col-sm-4">'
          . '   <a href="/maker/entry/' . $values[1]['id'] . '" class="post">'
          . '     <img class="img-responsive" src="' . legacy_get_resized_remote_image_url($values[1]['22'],622,402) . '" alt="Featured Maker 2">'
          . '     <div class="text-box"><span class="section">' . $entry2_description . '</span></div>'
          . '   </a>'
          . '   <a href="/maker/entry/' . $values[2]['id'] . '" class="post">'
          . '     <img class="img-responsive" src="' . legacy_get_resized_remote_image_url($values[2]['22'],622,402) . '" alt="Featured Maker 3">'
          . '     <div class="text-box"><span class="section">' . $entry3_description . '</span></div>'
          . '   </a>'
          . '</div></div>';
  
  return $output;
}

add_shortcode( 'mmakers', 'makerfaire_meet_the_makers_shortcode' );

/**
 * 3 Maker Faire tagged posts from Makezine - for homepage
 */

function get_first_image_url($html) {
            if (preg_match('/<img.+?src="(.+?)"/', $html, $matches)) {
              return $matches[1];
            }
}

function makerfaire_makezine_rss_news() {
    $url = 'http://makezine.com/tag/maker-faire/feed/';
    $rss = fetch_feed( $url);
    // Figure out how many total items there are, but limit it to 5. 
    $maxitems = $rss->get_item_quantity( 3 );
    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items( 0, $maxitems );

    //image #2
    $description=$rss_items[1]->get_description();
    $image = get_first_image_url($description);
    $description = strip_tags($description);
    $title =esc_html( $rss_items[1]->get_title() ); 
    $url=esc_url( $rss_items[1]->get_permalink());
	$output = '<div class="row filter-container mf-news">'
            . '<div class="col-xs-12 col-sm-4">'
            . '  <a href="'.$url.'" class="post">'
            . '    <img class="img-responsive" src="' . legacy_get_resized_remote_image_url($image,622,402) . '" alt="Featured Maker Faire post 1">'               
            . '    <div class="text-box"><span class="section">' . $title . '</span></div>'
            . '  </a>';

    //image #3
    $description=$rss_items[2]->get_description();
    $image = get_first_image_url($description);
    $description = strip_tags($description);
    $title =esc_html( $rss_items[2]->get_title() ); 
    $url=esc_url( $rss_items[2]->get_permalink());  
    $output .= '  <a href="'.$url . '" class="post">'
            . '    <img class="img-responsive" src="' . legacy_get_resized_remote_image_url($image,622,402) . '" alt="Featured Maker Faire post 2">'
            . '    <div class="text-box"><span class="section">' . $title . '</span></div>'
            . '  </a>'
            . '</div>';

    //image #1
    $description=$rss_items[0]->get_description();
    $image = get_first_image_url($description);
    $description = strip_tags($description);
    $title =esc_html( $rss_items[0]->get_title() ); 
    $url=esc_url( $rss_items[0]->get_permalink()); 
    $output .= ' <div class="col-xs-12 col-sm-8"><a href="' . $url. '" class="post">'
            . '  <img class="img-responsive" src="' . legacy_get_resized_remote_image_url($image,622,402) . '" alt="Featured Maker Faire post 3">'
            . '  <div class="text-box"><span class="section">' . $title . '</span></div></a>'
            . '</div>'
            . '</div>';
    RETURN $output;
}

add_shortcode( 'mf-news', 'makerfaire_makezine_rss_news' );


function makerfaire_featured_makers_shortcode($atts, $content = null) {
  extract( shortcode_atts( array(
	    'form_id' 	=> '',
	    'entry1_id'	=> '',
	    'entry2_id'	=> '',
	    'entry3_id'	=> ''
  ), $atts ) );

  $criteria = array(
     'field_filters' => array(
       array('key' => '304.1', 'value' => 'Featured Maker')
     )
  );

  $entries = GFAPI::get_entries(esc_attr($form_id), $criteria, null, array('offset' => 0, 'page_size' => 40));  
  $randEntry = array_rand($entries); 
  
  $output = '';
  return $output;
}
add_shortcode( 'fmakers', 'makerfaire_featured_makers_shortcode' );

/**
 * Modal Window Builder
 */
function make_modal_builder( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'launch' 	=> 'Launch Window',
		'title' 	=> 'Modal Title',
		'btn_class'	=> '',
		'embed'	=> ''
	), $atts ) );

	$number = mt_rand();
	$output = '<a class="btn  ' . esc_attr( $btn_class ) . '" data-toggle="modal" href="#modal-' . $number . '">' . esc_html( $launch ) . '</a>';
	$output .= '<div id="modal-' . $number . '" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	$output .= '	<div class="modal-header">';
	$output .= '		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
	$output .= '		<h3>' . esc_html( $title ) . '</h3>';
	$output .= '	</div>';
	$output .= '	<div class="modal-body">';
	if ( legacy_is_valid_domain( $embed,  array('fora.tv', 'ustream.com', 'ustream.tv' ) ) ) {
		$output .= '<iframe src="' . esc_url( $embed ) . '" width="530" height="320" frameborder="0"></iframe>';
	} else {
		$output .= ( !empty( $embed ) ) ? wp_oembed_get( esc_url( $embed ), array( 'width' => 530 ) ) : '';
	}
	$output .= 			wp_kses_post( $content );
	$output .= '	</div>';
	$output .= '	<div class="modal-footer">';
	$output .= '		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>';
	$output .= '	</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode( 'modal', 'make_modal_builder' );

function makerfaire_news_rss() { ?>
	<div class="newsies">
		<div class="news post">
			<h3 style="color: #fc040c;">
				<a href="http://makezine.com/tag/maker-faire/">Latest Maker Faire News</a>
			</h3>
			<?php
			$fs = makerfaire_index_feed();

			foreach($fs as $f) : $a = $f['i']->get_authors(); ?>
				<div class="row">
					<div class="col-md-2">
						<a href="<?php echo esc_url($f['i']->get_link()); ?>" title="<?php echo esc_attr($f['i']->get_title()); ?>"><img class="img-thumbnail faire-thumb " alt="<?php echo legacy_get_resized_remote_image_url(esc_attr($f['i']->get_title()),308,202); ?>" src="<?php echo esc_url($f['src']); ?>" /></a>
					</div>
					<div class="col-md-6">
					<h2><a href="<?php echo esc_url($f['i']->get_link()); ?>"><?php echo esc_html($f['i']->get_title()); ?></a></h2>
					<?php echo str_replace(array($f['img'], '<p><a href="'.$f['i']->get_link().'">Read the full article on MAKE</a></p>'), '', html_entity_decode(esc_html($f['i']->get_description()))); ?>
					
					<!-- READ FULL STORY BUTTON AND LINK
					 <p class="read_more" style="margin:10px 0"><strong>
					<a class="btn btn-primary btn-xs" href="<?php /*  echo esc_url($f['i']->get_link()); */ ?>">Read full story &raquo;</a></strong></p> 
					-->

					<!-- AUTHOR AND CATEGORY DESCRIPTIONS
					<ul class="unstyled">
						<li>Posted by <?php  /* echo esc_html($a[0]->name); ?> | <?php echo esc_html($f['i']->get_date()); ?></li>
						<li>Categories: <?php foreach($f['i']->get_categories() as $cat) : echo esc_html($cat->term.', '); endforeach; */ ?></li>
					</ul> 
					-->
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<h4><a href="http://makezine.com/tag/maker-faire/">Read More &rarr;</a></h4>
<?php }

function makerfaire_widgets_init() {

	register_sidebar( array(
		'name' => 'Maker Faire Calendar',
		'id' => 'home_right_1',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h4 class="more-faires">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'makerfaire_widgets_init' );


if ( function_exists( 'vip_redirects' ) ) {
	vip_redirects( array(
		'/mini/toolkit/'	=> 'https://www.dropbox.com/sh/ykbi3al0j4hatd2/hSN6Z9nXTU',
		'/alt'         => 'http://makerfaire.com/bayarea-2013/getting-to-maker-faire/'
	) );
}

function mf_quick_links_box() {
	add_meta_box( 'quickly', 'Quick Links', 'mf_quick_links', 'mf_form' );
}
// This function echoes the content of our meta box
// TODO: investigate if this function is deprecated??
function mf_quick_links() {
	$output = '<div id="project-id-search"><label for="project-id" class="screen-reader-text">Search by Project ID</label><input type="search" name="search-proj-id" id="project-id" /><input type="submit" value="Search by ID" id="search-submit" class="button" /></div><ul class="subsubsub">
		<li class="all"><a href="edit.php?post_type=mf_form" class="current">All</a> |</li>
		<li class="trash"><a href="edit.php?post_status=trash&amp;post_type=mf_form">Trash</a> |</li>
		<li class="proposed"><a href="edit.php?post_status=proposed&amp;post_type=mf_form" title="Application proposed; waiting for acceptance.">Proposed</a> |</li>
		<li class="waiting-for-info"><a href="edit.php?post_status=more-info&amp;post_type=mf_form" title="Question has been emailed to Maker, waiting for response.">Waiting for Info</a> |</li>
		<li class="accepted"><a href="edit.php?post_status=accepted&amp;post_type=mf_form" title="Application is accepted to Maker Faire.">Accepted</a> |</li>
		<li class="cancelled"><a href="edit.php?post_status=cancelled&amp;post_type=mf_form" title="Accepted application is cancelled; This project will not attend Maker Faire after all.">Cancelled</a> |</li>
		<li class="in-progress"><a href="edit.php?post_status=in-progress&amp;post_type=mf_form" title="">In Progress</a></li>
		<li class="in-progress"><a href="edit.php?post_status=wait-list&amp;post_type=mf_form" title="">Wait List</a></li>
	</ul>
	<div class="clear"></div>';
	echo $output;
}

if (is_admin())
	add_action('admin_menu', 'mf_quick_links_box');

function mf_clean_title( $title ) {
    $title = str_replace('&nbsp;', ' ', $title);
    return $title;
}
add_filter('the_title', 'mf_clean_title', 10, 2);


function mf_release_shortcode() {
	$request_id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : null);
	$output = '<iframe src="' . esc_url( 'http://db.makerfaire.com/pa/' .  $request_id ) . '" width="620" height="2000" scrolling="auto" frameborder="0"> [Your user agent does not support frames or is currently configured not to display frames.] </iframe>';
	return $output;
}

add_shortcode( 'release', 'mf_release_shortcode' );


add_filter( 'wp_kses_allowed_html', 'mf_allow_data_atts', 10, 2 );
function mf_allow_data_atts( $allowedposttags, $context ) {
	$tags = array( 'div', 'a', 'li' );
	$new_attributes = array( 'data-toggle' => true );

	foreach ( $tags as $tag ) {
		if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) )
			$allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
	}

	return $allowedposttags;
}


add_filter('tiny_mce_before_init', 'mf_filter_tiny_mce_before_init');
function mf_filter_tiny_mce_before_init( $options ) {

	if ( ! isset( $options['extended_valid_elements'] ) )
		$options['extended_valid_elements'] = '';

	$options['extended_valid_elements'] .= ',a[data*|class|id|style|href]';
	$options['extended_valid_elements'] .= ',li[data*|class|id|style]';
	$options['extended_valid_elements'] .= ',div[data*|class|id|style]';

	return $options;
}


function mf_allow_my_post_types( $allowed_post_types ) {
	$allowed_post_types[] = 'mf_form';
	return $allowed_post_types;
}

add_filter( 'rest_api_allowed_post_types', 'mf_allow_my_post_types');


add_filter( 'jetpack_open_graph_tags', function( $tags ) {
	global $post;
	if ($post->post_type == 'mf_form') {
		$json = json_decode( $post->post_content );
		$tags['og:description'] = $json->public_description;
	} else {
		setup_postdata($post);
		$tags['og:description'] = get_the_excerpt();
	}

	return $tags;
}, 10 );


/**
 * OBSOLETE: No longer using this functionality: Hide Maker Faire applications from past faires
 *
 * In the past, CS had a method for only selecting the current
 * faire for applications. We want to do the same here, and prevent
 * all applications from showing up in the edit screen.
 *
 * Have to use slug, RE: See http://core.trac.wordpress.org/ticket/13258
 *
 * @global $query
 *
 *
function mf_hide_faires( $query ) {
	if ( is_admin() && $query->is_main_query() ) {
		$tax_query = array(
			array(
				'taxonomy'	=> 'faire',
				'field'		=> 'slug',
				'terms'		=> MF_CURRENT_FAIRE,
				'operator'	=> 'IN',
			)
		);
		$query->set( 'tax_query', $tax_query );
	}
}

// add_action( 'pre_get_posts', 'mf_hide_faires' );
 * 
 */



/**
 * Counts the post numbers for the Dashboard.
 */
function mf_add_magazine_article_counts() {
		if ( !post_type_exists( 'mf_form' ) ) {
			 return;
		}

		$num_posts = wp_count_posts( 'mf_form' );
		$num = number_format_i18n( $num_posts->accepted );
		$text = _n( 'Application', 'Applications', intval($num_posts->accepted) );
		if ( current_user_can( 'edit_posts' ) ) {
			$url = admin_url( 'edit.php?post_type=mf_form' );
			$num = '<a href="'.$url.'">'.$num.'</a>';
			$text = '<a href="'.$url.'">'.$text.'</a>';
		}
		echo '<td class="first b b-mf_form">' . $num . '</td>';
		echo '<td class="t mf_form">' . $text . '</td>';

		echo '</tr>';

		if ($num_posts->proposed > 0) {
			$num = number_format_i18n( $num_posts->proposed );
			$text = _n( 'Applications Pending', 'Applications Pending', intval($num_posts->proposed) );
			if ( current_user_can( 'edit_posts' ) ) {
				$url = admin_url( 'edit.php?post_status=proposed&post_type=mf_form' );
				$num = '<a href="' . $url . '">' . $num . '</a>';
				$text = '<a href="' . $url . '">' . $text . '</a>';
			}
			echo '<td class="first b b-recipes">' . $num . '</td>';
			echo '<td class="t recipes">' . $text . '</td>';

			echo '</tr>';
		}
}

add_action('right_now_content_table_end', 'mf_add_magazine_article_counts');

function mf_send_hipchat_notification( $message = 'Default Message', $from = 'MakeBot' ) {
	$base 		= 'https://api.hipchat.com/v1/rooms/message';
	$auth_token = '9f4f9113e8eeb3754da520d295ca59';
	$room 		= 198932;
	$notify 	= 1;

	$opts = array(
		'auth_token'=> $auth_token,
		'room_id'	=> $room,
		'from' 		=> $from,
		'notify' 	=> $notify,
		'message'	=> urlencode( $message ),
		'color'		=> 'green'
	);

	$url = add_query_arg( $opts, $base );
	//Move to wp_remote_get 
	$request =   wp_remote_get($url);
	// Get the body of the response
	$json = wp_remote_retrieve_body( $request );
	//$json = wpcom_vip_file_get_contents( $url );
}

// Redirect mobile users on iOS or Android to their app stores if set.
function mf_page_redirect_to_app_stores() {
	if ( ! is_page( 'app' ) && function_exists( 'jetpack_is_mobile' ) )
		return;
	if ( class_exists( 'Jetpack' ) ) :
	
	$redirect_to = '';

 	if ( Jetpack_User_Agent_Info::is_iphone_or_ipod() )
		$redirect_to = 'https://itunes.apple.com/us/app/maker-faire-the-official-app/id641794889';
	elseif ( Jetpack_User_Agent_Info::is_android() )
		$redirect_to = 'https://play.google.com/store/apps/details?id=com.xomodigital.makerfaire';

	if ( ! empty( $redirect_to ) ) {
		wp_redirect( $redirect_to, 301 );  // Permanent redirect
		exit;
	}
	endif;
	
}
add_action( 'template_redirect', 'mf_page_redirect_to_app_stores' );


add_action( 'admin_head', 'make_cpt_icons' );
/**
 * Adds icons for the custom post types that are in the admin.
 */
function make_cpt_icons() { ?>
	<style type="text/css" media="screen">
		.icon16.icon-event-items:before,
		#adminmenu #menu-posts-event-items div.wp-menu-image:before {
			content: '\f145';
		}
		.icon16.icon-dashboard:before,
		#adminmenu #menu-dashboard div.wp-menu-image:before {
			content: '\f226';
		}
		.icon16.icon-post:before,
		#adminmenu #menu-posts div.wp-menu-image:before {
			content: '\f109';
		}
		.icon16.icon-media:before,
		#adminmenu #menu-media div.wp-menu-image:before {
			content: '\f104';
		}
		.icon16.icon-comments:before,
		#adminmenu #menu-comments div.wp-menu-image:before {
			content: '\f101';
		}
		.icon16.icon-page:before,
		#adminmenu #menu-pages div.wp-menu-image:before {
			content: '\f105';
		}
		.icon16.icon-post:before,
		#adminmenu #menu-posts-mf_form div.wp-menu-image:before {
			content: '\f116';
		}
		.icon16.icon-post:before,
		#adminmenu #menu-posts-maker div.wp-menu-image:before {
			content: '\f307';
		}
		.icon16.icon-appearance:before,
		#adminmenu #menu-appearance div.wp-menu-image:before {
			content: '\f100';
		}
		.icon16.icon-plugins:before,
		#adminmenu #menu-plugins div.wp-menu-image:before {
			content: '\f106';
		}
		.icon16.icon-users:before,
		#adminmenu #menu-users div.wp-menu-image:before {
			content: '\f110';
		}
		.icon16.icon-tools:before,
		#adminmenu #menu-tools div.wp-menu-image:before {
			content: '\f107';
		}
		.icon16.icon-settings:before,
		#adminmenu #menu-settings div.wp-menu-image:before {
			content: '\f111';
		}
	</style>
	
<?php
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
 }

/**
 * Adds footer copyright information
 */
function make_copyright_footer() { ?>
	<div class="col-xs-12 footer_copyright">
		<div class="text-center">
			<p class="muted"><small>Make: and Maker Faire are registered trademarks of Maker Media, Inc.</small></p>
			<p class="muted"><small>Copyright &copy; 2004-<?php echo date("Y") ?> Maker Media, Inc.  All rights reserved</small></p>
		</div>
	</div>
<?php }


/**
 * Redirects to the "Current Faire" page after an application is trashed
 * @return void
 *
 * @since Mechani-Kong
 */
function maker_faire_trashed_application_redirect() {
    $screen = get_current_screen();

    if ( 'edit-mf_form' == $screen->id && isset( $_GET['trashed'] ) && intval( $_GET['trashed'] ) > 0 ) {
        $redirect = add_query_arg( array(
        	'post_type' => 'mf_form',
        	'page' => 'current_faire'
        ) );

        wp_redirect( $redirect );
        exit();
    }
}
add_action( 'load-edit.php','maker_faire_trashed_application_redirect' );

function scriptLoaded(){
   document.write( myValue );
}

/**
 *  Check if input string is a valid YouTube URL
 *  and try to extract the YouTube Video ID from it.
 *  @author  Stephan Schmitz <eyecatchup@gmail.com>
 *  @param   $url   string   The string that shall be checked.
 *  @return  mixed           Returns YouTube Video ID, or (boolean) false.
 */        
function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'all',
	array(
	'labels' => array(
	'name' => __( 'All' ),
	'singular_name' => __( 'All' )
	),
	'public' => true,
	'has_archive' => true,
	)
	);
	register_post_type( 'in-progress',
	array(
	'labels' => array(
	'name' => __( 'In Progress' ),
	'singular_name' => __( 'In Progress' )
	),
	'public' => true,
	'has_archive' => true,
	)
	);
}


/**
 * Allow HTML in WordPress Custom Menu Descriptions
 *
 * Create HTML list of nav menu items and allow HTML tags.
 * Replacement for the native menu Walker, echoing the description.
 * This is the ONLY known way to display the Description field.
 *
 * @see http://wordpress.stackexchange.com/questions/51609/
 *
 */
    class Description_Walker extends Walker_Nav_Menu {

        function start_el(&$output, $item, $depth, $args)
        {
            $classes     = empty ( $item->classes ) ? array () : (array) $item->classes;

            $class_names = join(
                ' '
                ,   apply_filters(
                    'nav_menu_css_class'
                    ,   array_filter( $classes ), $item
                )
            );

            ! empty ( $class_names )
            and $class_names = ' class="'. esc_attr( $class_names ) . '"';

            // Build default menu items
            $output .= "<li id='menu-item-$item->ID' $class_names>";

            $attributes  = '';

            ! empty( $item->attr_title )
            and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
            ! empty( $item->target )
            and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
            ! empty( $item->xfn )
            and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
            ! empty( $item->url )
            and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

            // Build the description (you may need to change the depth to 0, 1, or 2)
            $description = ( ! empty ( $item->description ) and 1 == $depth )
                ? '<span class="nav_desc">'.  $item->description . '</span>' : '';

            $title = apply_filters( 'the_title', $item->title, $item->ID );

            $item_output = $args->before
                . "<a $attributes>"
                . $args->link_before
                . $title
                . '</a> '
                . $args->link_after
                . $description
                . $args->after;

            // Since $output is called by reference we don't need to return anything.
            $output .= apply_filters(
                'walker_nav_menu_start_el'
                ,   $item_output
                ,   $item
                ,   $depth
                ,   $args
            );
        }
    }
    // Allow HTML descriptions in WordPress Menu
    remove_filter( 'nav_menu_description', 'strip_tags' );
    add_filter( 'wp_setup_nav_menu_item', 'cus_wp_setup_nav_menu_item' );
    function cus_wp_setup_nav_menu_item( $menu_item ) {
        $menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
        return $menu_item;
    }
    //and then use this in your template:
    //wp_nav_menu( array( 'walker' => new Description_Walker ));




    /**
     * Fake KLogger class.
     *
     * @package
     **/
    class KLogger {
    
    	/**
    	 * Some constants relating to logging, used by GF.
    	 **/
    	CONST EMERGENCY = 'EMERGENCY';
    	CONST ALERT = 'ALERT';
    	CONST CRITICAL = 'CRITICAL';
    	CONST ERROR = 'ERROR';
    	CONST WARNING = 'WARNING';
    	CONST NOTICE = 'NOTICE';
    	CONST INFO = 'INFO';
    	CONST DEBUG = 'DEBUG';
    }
    /**
     * Kinda fake GFLogging class
     *
     * @package
     **/
    class GFLogging {
    
    	/**
    	 * A version integer.
    	 *
    	 * @var int
    	 **/
    	var $version;
    
    	/**
    	 * @access @static
    	 *
    	 * @return null
    	 */
    	static public function include_logger() {
    		// Not much happens here
    	}
    
    	/**
    	 * Log to PHP error log
    	 *
    	 * @return null
    	 */
    	static public function log_message( $slug, $message, $debug_level ) {
    		error_log( "GF LOG: $slug, $message, $debug_level" );
    	}
    }


/**
 * The Better Gallery shortcode, courtesy of WordPress Core
 *
 * Wanted to extend our Bootstrap Slideshow so that you could put in Post IDs and get back a slideshow.
 * Basically the same thing that the default slideshow does, so why not use that! Updated for Bootstrap 3!
 *
 * @since 1.0
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */
function make_new_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	
	$rand = mt_rand( 0, $id );

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	$output = '<div id="carousel-example-generic-' . $rand . '" class="carousel slide" data-interval="" data-ride="carousel"><div class="carousel-inner">';

	$i = 0;
	foreach( $attachments as $id => $attachment ) {
		$i++;
		if ($i == 1) {
			$output .= '<div class="item active">';	
		} else {
			$output .= '<div class="item">';
		}
		$output .= wp_get_attachment_link( $attachment->ID, sanitize_title_for_query( $size ) );
		if ( isset( $attachment->post_excerpt ) && ! empty( $attachment->post_excerpt ) ) {
			$attachment_caption = $attachment->post_excerpt;
		} elseif ( isset( $attachment->post_title ) && ! empty( $attachment->post_title ) ) {
			$attachment_caption = $attachment->post_title;
		} else {
			$attachment_caption = '';
		}
		if ( isset( $attachment_caption ) && ! empty( $attachment_caption ) ) {
			$output .= '<div class="carousel-caption">';
			$output .= '<h4>' . Markdown( wp_kses_post( $attachment_caption ) ) . '</h4>';
			$output .= '</div>';
			
		}
		$output .= '</div>';
		
	} //foreach
	$output .= '</div>
		<a class="left carousel-control" href="#carousel-example-generic-' . $rand . '" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic-' . $rand . '" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>';
	$output .= '<p class="pull-right"><span class="label viewall" style="cursor:pointer">View All</span></p>';
	$output .= '
		<script>
			jQuery(document).ready(function(){
				jQuery(".viewall").click(function() {
					jQuery(".carousel-inner").removeClass("carousel-inner");
					jQuery(".carousel-control").hide();
					googletag.pubads().refresh();
					ga(\'send\', \'pageview\');
					urlref = location.href;
					PARSELY.beacon.trackPageView({
						url: urlref,
						urlref: urlref,
						js: 1,
						action_name: "Next Slide"
					});
					jQuery(this).addClass(\'hide\');
					return true;
				})
			});
		</script>
	';
	$output .= '<div class="clearfix"></div>';
	return $output;
}

add_shortcode( 'new_gallery', 'make_new_gallery_shortcode' );

//add jquery for gravity forms
add_filter('gform_register_init_scripts', 'gform_addScript');
function gform_addScript($form) {    
    $script = '(function(){' .
        'jQuery("input[type=radio][name=input_1]").change(function(){
            if (jQuery(this).val().indexOf("Standard Presentation") > -1) {
                //disable "45 minutes" option
                jQuery("input[name=\'input_2.3\']").attr("disabled",true);
                //if option is already checked, uncheck it
                jQuery("input[name=\'input_2.3\']").attr("checked",false);
            }else{
                jQuery("input[name=\'input_2.3\']").attr("disabled",false);
            }
        });' .
    '})(jQuery);';
    
    GFFormDisplay::add_init_script($form['id'], 'formScript', GFFormDisplay::ON_PAGE_RENDER, $script);
    
    return $form;
}

/* This function checks if the entry-id set on the form is valid 
 * If it is, then it compares the entered email to see if it matches the previous 
 * one used on the entry. if it all passes, then they can move to the next step
 * otherwise it returns errors
 */
add_filter( 'gform_validation', 'custom_validation' );
function custom_validation( $validation_result ) {    
    $form = $validation_result['form'];
    
    // determine if entry-id and contact-email id's are in the submitted form 
    // and what their field id's are
    $entryID = get_value_by_label('entry-id', $form);
    $contact_email   = get_value_by_label('contact-email', $form);
    
    //make sure we are in the right form
    if(!empty($entryID) && !empty($contact_email)){
        $entryid        = rgpost( 'input_'. $entryID['id']) ;
        $sub_email      = rgpost( 'input_'. $contact_email['id'] ) ;
        
        //check if entry-id is valid
        $entry = GFAPI::get_entry( $entryid );
        if(is_array($entry)){                        
            //finding Field with ID of 1 and marking it as failed validation
            foreach( $form['fields'] as &$field ) {
               if ( $field->id == $contact_email['id']) {     //contact_email           
                    $entryForm = GFAPI::get_form( $entry['form_id']);
                    $ef_email = get_value_by_label('contact-email', $entryForm,$entry);                                        
                    $contactEmail = $ef_email['value'];
                            
                    if(strtolower($sub_email) != strtolower($contactEmail)){ 
                        // set the form validation to false
                        $validation_result['is_valid'] = false;
                        $field->failed_validation = true;
                        $field->validation_message = 'Email does not match contact email on the project';
                    }
                }
            }     
        }else{        
            // set the form validation to false
            $validation_result['is_valid'] = false;
            //finding Field with ID of 1 and marking it as failed validation
            foreach( $form['fields'] as &$field ) {
                if ( $field->id == $entryID['id']) {
                    // set the form validation to false
                    $validation_result['is_valid'] = false;
                    $field->failed_validation = true;
                    $field->validation_message = 'Invalid Project ID';  
                    break;
                }
            }     
        }
    }
     //Assign modified $form object back to the validation result
    $validation_result['form'] = $form;
    return $validation_result;
};
add_filter( 'gform_pre_render_35', 'populate_html' );
add_filter( 'gform_pre_render_36', 'populate_html' );
add_filter( 'gform_pre_render_37', 'populate_html' );
add_filter( 'gform_pre_render_38', 'populate_html' );
add_filter( 'gform_pre_render_39', 'populate_html' );

function populate_html( $form ) {
    //this is a 2-page form with the data from page one being displayed in an html field on page 2
    $current_page = GFFormDisplay::get_current_page( $form['id'] );
    $html_content = "The information you have submitted is as follows:<br/><ul>";
    if ( $current_page == 2 ) {       
       foreach ( $form['fields'] as &$field ) {
           if($field->inputName=='entry-id'){               
               $entry_id = rgpost( 'input_' . $field->id );
           }
       }
       
       $fieldIDarr['project-name']          = 151;
       $fieldIDarr['short-project-desc']    = 16;
       $fieldIDarr['exhibit-contain-fire']  = 83;
       $fieldIDarr['interactive-exhibit']   = 84;
       $fieldIDarr['fire-safety-issues']    = 85;
       //find the project name for submitted entry-id
       $entry = GFAPI::get_entry( $entry_id );
       foreach ( $form['fields'] as &$field ) {
           if(isset($fieldIDarr[$field->inputName])){
               $field->defaultValue = $entry[$fieldIDarr[$field->inputName]];  
           }           
       }
    }
    
    return($form);
}   
//when form is submitted, find the initial formid based on entry id and add the fields to that entry
add_action( 'gform_after_submission', 'GSP_after_submission', 10, 2 );
function GSP_after_submission($entry, $form ){    
    // update meta 
    $updateEntryID = get_value_by_label('entry-id', $form, $entry);  
    gform_update_meta( $entry['id'], 'entry_id', $updateEntryID['value'] );
}

//=============================================
// Return field ID number based on the 
// the Parameter Name for a specific form
//=============================================
function get_value_by_label($key, $form, $entry=array()) {
    $return = array();
    foreach ($form['fields'] as &$field) {    
        $lead_key = $field['inputName'];
        if ($lead_key == $key) {
            $return['id']    = $field['id'];
            if(!empty($entry)){
                $return['value'] = $entry[$field['id']];
            }else{
                $return['value']='';
            }
            return $return;
        }
    }
    return false;
}

/*
 * function to allow easier testing of forms by skipping pages and going 
 * directly to the page of the form you want to test 
 * To skip a page, simply append the ?form_page=2 parameter to the URL of any 
 * page on which you are displaying a Gravity Form
 */
add_filter("gform_pre_render", "gform_skip_page");
function gform_skip_page($form) {
    if(!rgpost("is_submit_{$form['id']}") && rgget('form_page') && is_user_logged_in())
        GFFormDisplay::$submission[$form['id']]["page_number"] = rgget('form_page');
    return $form;
}

/* This filter is triggered before the entry detail page is displayed in admin 
 * Using this to add class of entryStandout to specific fields 
 */
add_filter( 'gform_entry_field_value', 'entry_field_standout', 10, 4 );
function entry_field_standout( $value, $field, $lead, $form ) {
    //topics/category fields
    if ( $field['id'] != 64)
        return $value;
    
    $value = '<span class="entryStandout">'.$value.'</span>';
    return $value;
   
}

//ajax functionality to update the entry rating
function myajax_update_entry_rating() {
    global $wpdb;
    $entry_id = $_POST['rating_entry_id'];
    $rating   = $_POST['rating'];
    $user     = $_POST['rating_user'];
    
    //update user rating
    
    //if there is already a record for this user, update it.
    //else add it.
    $sql = "Insert into wp_rg_lead_rating (entry_id, user_id, rating) "
         . " values (".$entry_id.','.$user.','.$rating.")"
         . " on duplicate key update rating=".$rating.", ratingDate=now()";
    
    $wpdb->get_results($sql);
    
    //update the meta with the average rating
    $sql = "SELECT avg(rating) as rating FROM `wp_rg_lead_rating` where entry_id = ".$entry_id;
    $results = $wpdb->get_results($sql);
    $rating = round($results[0]->rating);
        
    gform_update_meta( $entry_id, 'entryRating', $rating );
    echo 'Your Rating Has Been Saved';
    // IMPORTANT: don't forget to "exit"
    exit;
}

add_action( 'wp_ajax_update-entry-rating', 'myajax_update_entry_rating' );

//adding new meta field to store the average rating
add_filter( 'gform_entry_meta', 'custom_entry_meta', 10, 2);
function custom_entry_meta($entry_meta, $form_id){
    //data will be stored with the meta key named score
    //label - entry list will use Score as the column header
    //is_numeric - used when sorting the entry list, indicates whether the data should be treated as numeric when sorting
    //is_default_column - when set to true automatically adds the column to the entry list, without having to edit and add the column for display
    //update_entry_meta_callback - indicates what function to call to update the entry meta upon form submission or editing an entry
    $entry_meta['entryRating'] = array(
        'label' => 'Rating',        
        'is_numeric' => true,
        'update_entry_meta_callback' => 'update_entry_meta', 
        'is_default_column' => true,
        'filter'    => array(
  			'operators' => array( 'is', 'isnot','<','>' ),
  			'choices'   => array(
  				array( 'value' => '0', 'text' => 'Unrated' ),
  				array( 'value' => '1', 'text' => '1 Stars' ),
  				array( 'value' => '2', 'text' => '2 Stars' ),
  				array( 'value' => '3', 'text' => '3 Stars' ),
                            array( 'value' => '4', 'text' => '4 Stars' ),
                            array( 'value' => '5', 'text' => '5 Stars' ),
  			)
  		)
    );
    
    //create new meta field to hold original entry id
    $entry_meta['entry_id'] = array(
        'label' => 'Original Entry ID',        
        'is_numeric' => true,
        
        'is_default_column' => false
    );
    return $entry_meta;
}

//set the default value for entry rating 
function update_entry_ID_meta( $key, $lead, $form ){
    //default entry_-_id
    //$value = '';
    return $value;
}

//set the default value for entry rating 
function update_entry_meta( $key, $lead, $form ){
    //default rating
    $value = '0';
    return $value;
}

//formats the ratings field that are displayed in the entries list
add_filter( 'gform_entries_field_value', 'format_ratings', 10, 3 );
function format_ratings( $value, $form_id, $field_id ) {   
    
    if($field_id=='entryRating'){
        if($value==0){
            return 'No Rating';            
        }else{
            return $value .' stars';
        }
    }
    return $value;
}

add_filter( 'gform_entries_column_filter', 'change_column_data', 10, 5 );
function change_column_data( $value, $form_id, $field_id, $entry, $query_string ) {
    //only change the data when form id is 1 and field id is 2
    if ( $form_id != 9) {
        return $value;
    }
    if($field_id == 'source_url'){
        $form = GFAPI::get_form( $entry['form_id'] );        
        return $form['title'];
    }
    return $value;
}

//add new submenu for our custom built list page
add_filter( 'gform_addon_navigation', 'add_menu_item' );
function add_menu_item( $menu_items ) {
    $menu_items[] = array( "name" => "mf_entries", "label" => "Entries", "callback" => "entries_list", "permission" => "edit_posts" );
    return $menu_items;
}

function entries_list(){    
    $view    = rgget( 'view' );
    $lead_id = rgget( 'lid' );

    if ( $view == 'mfentry' && ( rgget( 'lid' ) || ! rgblank( rgget( 'pos' ) ) ) ) {
            //require_once( GFCommon::get_base_path() . '/entry_detail.php' );
            include_once TEMPLATEPATH. '/classes/entry_detail_makerfaire.php';
            GFEntryDetail::lead_detail_page();
    } else if ( $view == 'entries' || empty( $view ) ) {
            include_once TEMPLATEPATH. '/classes/entry_list_makerfaire.php';
            if( !class_exists('GFEntryList')) { require_once(GFCommon::get_base_path() . "/entry_list.php"); }
            GFEntryList::all_leads_page();
    } else {
            $form_id = rgget( 'id' );
            do_action( 'gform_entries_view', $view, $form_id, $lead_id );
    }  
}

//remove old entries navigation
function remove_menu_links() {
    global $submenu;    
    foreach($submenu['gf_edit_forms'] as $key=>$item){
        if(in_array('gf_entries',$item)){              
            unset($submenu['gf_edit_forms'][$key]);
        }
    }     
}
add_action( 'admin_menu', 'remove_menu_links', 9999 );

/**
 * Redirect gravity form admin pages to the new makerfaire specific admin pages
 */
function redirect_gf_admin_pages(){
    global $pagenow;    
    
    /* Check current admin page. */
    if($pagenow == 'admin.php'){
        if(isset($_GET['page'])&&$_GET['page']=='gf_entries'){
            //include any parameters in the return URL
            $returnURL = '';
            foreach($_GET as $key=>$param){
                if($key!='page'){
                    if($key=='view' && $param == 'entry')  $param = 'mfentry';
                    $returnURL .= '&'.$key.'='.$param;
                }
            }
            wp_redirect(admin_url( 'admin.php' ) . "?page=mf_entries".$returnURL);
            exit;
        }
    }
}

add_action('admin_menu', 'redirect_gf_admin_pages');

