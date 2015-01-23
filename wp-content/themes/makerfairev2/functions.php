<?php

// Set our global Faire Variable. Use the slug of the taxonomy as the value.
//define( 'MF_CURRENT_FAIRE', 'world-maker-faire-new-york-2014' );


// include maker-faire-forms plugin
//require_once( TEMPLATEPATH. '/plugins/maker-faire-forms/maker-faire-forms.php' );

// include maker-faire-forms plugin
//require_once( TEMPLATEPATH. '/plugins/public-pages/makers.php' );
/*
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
*/
// Gravity Forms Specific Plugins and Classes
include_once TEMPLATEPATH. '/classes/gf-limit-checkboxes.php';
include_once TEMPLATEPATH. '/classes/gf-admin-metaboxes.php';

// Legacy Helper Functions replacing VIP Wordpress.com calls
include_once TEMPLATEPATH. '/classes/legacy-helper.php';
/*

require_once( 'taxonomies/type.php' );
require_once( 'taxonomies/sponsor-category.php' );
require_once( 'taxonomies/location.php' );
require_once( 'taxonomies/faire.php' );
require_once( 'taxonomies/location_category.php' );
require_once( 'taxonomies/group.php' );
require_once( 'plugins/post-types/event-items.php' );
require_once( 'post-types/sponsor.php' );
require_once( 'post-types/location.php' );
if ( defined( 'WP_CLI' ) && WP_CLI )
	require_once( 'plugins/wp-cli/wp-cli.php' );
/*
if ( function_exists( 'wpcom_vip_load_plugin' ) ) {
	wpcom_vip_load_plugin( 'easy-custom-fields' );
}

// load edit-flow plugin
if ( function_exists( 'wpcom_vip_load_plugin' ) ) {
	wpcom_vip_load_plugin( 'edit-flow' );
}
*/
// add post-thumbnails support to theme
add_theme_support( 'post-thumbnails' );
add_image_size( 'schedule-thumb', 140, 140, true );
/*
if ( function_exists( 'wpcom_vip_enable_opengraph' ) ) {
	wpcom_vip_enable_opengraph();
}

if ( function_exists( 'vip_contrib_add_upload_cap' ) ) {
	vip_contrib_add_upload_cap();
}

if ( function_exists( 'wpcom_vip_sharing_twitter_via' ) ) {
	wpcom_vip_sharing_twitter_via( 'make' );
}
*/

// Defer jQuery Parsing using the HTML5 defer property
/*if (!(is_admin() )) {
    function defer_parsing_of_js ( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        // return "$url' defer ";
        return "$url' defer onload='";
    }
    add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
}

/* Favicon in Header */
add_action('wp_head','my_custom_fav_ico');
function my_custom_fav_ico() {
	echo '<link rel="shortcut icon" href="'.get_stylesheet_directory_uri(). '/images/favicon.ico'.'" />';
}

function make_enqueue_jquery() {
	// Styles
	wp_enqueue_style( 'make-gravityforms', get_stylesheet_directory_uri() . '/css/gravityforms.css' );
	wp_enqueue_style( 'make-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( 'make-bootstrapdialog', get_stylesheet_directory_uri() . '/css/bootstrap-dialog.min.css' );
	wp_enqueue_style( 'make-styles', get_stylesheet_directory_uri() . '/css/style.css' );
	wp_enqueue_style( 'ytv', get_stylesheet_directory_uri() . '/css/ytv.css' );

	// Scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'make-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'make-countdown', get_stylesheet_directory_uri() . '/js/jquery.countdown.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery_cookie',  get_stylesheet_directory_uri() . '/js/jquery.cookie.js', array( 'jquery' ), null );
	wp_enqueue_script( 'ytv', get_stylesheet_directory_uri() . '/js/ytv.js', array( 'jquery' ) );
	wp_enqueue_script( 'make-bootstrapdialog',  get_stylesheet_directory_uri() . '/js/bootstrap-dialog.min.js', array( 'jquery' ), null );
	wp_enqueue_script( 'make-login-dialog',  get_stylesheet_directory_uri() . '/js/login.js', array( 'jquery' ), null );
	//wp_enqueue_script( 'make-confirmation-dialog',  get_stylesheet_directory_uri() . '/js/confirmation.js', array( 'jquery' ), null );
	wp_enqueue_script( 'make-gravityforms',  get_stylesheet_directory_uri() . '/js/gravityforms.js', array( 'jquery' ), null );
	
	
}
add_action( 'wp_enqueue_scripts', 'make_enqueue_jquery' );

function load_admin_scripts() {
    wp_enqueue_script('make-gravityforms-admin',  get_stylesheet_directory_uri() . '/js/gravityformsadmin.js');
}
add_action( 'admin_enqueue_scripts', 'load_admin_scripts' );




	