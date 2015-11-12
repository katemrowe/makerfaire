<?php

function global_maker_faire_post_type_init() {
	register_post_type( 'global-maker-faire', array(
		'hierarchical'      => true,
		'public'	   => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'supports'          => array( 'title', 'editor', 'page-attributes', 'revisions', 'excerpt' ),
		'has_archive'       => true,
		'query_var'         => true,
		'rewrite'           => true,
		'taxonomies'		=> array( 'faire' ),
		'labels'            => array(
			'name'                => __( 'Global Maker Faire', 'makerfaire' ),
			'singular_name'       => __( 'Global Maker Faire', 'makerfaire' ),
			'all_items'           => __( 'Global Maker Faires', 'makerfaire' ),
			'new_item'            => __( 'New Global Maker Faire', 'makerfaire' ),
			'add_new'             => __( 'Add New', 'makerfaire' ),
			'add_new_item'        => __( 'Add New Global Maker Faire', 'makerfaire' ),
			'edit_item'           => __( 'Edit Global Maker Faire', 'makerfaire' ),
			'view_item'           => __( 'View Global Maker Faire', 'makerfaire' ),
			'search_items'        => __( 'Search Faires', 'makerfaire' ),
			'not_found'           => __( 'No Faires found', 'makerfaire' ),
			'not_found_in_trash'  => __( 'No Faires found in trash', 'makerfaire' ),
			'parent_item_colon'   => __( 'Parent Faires', 'makerfaire' ),
			'menu_name'           => __( 'Global Maker Faires', 'makerfaire' ),
		),
	) );
}

add_action( 'init', 'global_maker_faire_post_type_init' );
