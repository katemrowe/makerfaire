<?php

function makerfaire_category_init() {
	register_taxonomy( 'makerfaire_category', array( 'post', 'page' ), array(
		'hierarchical'            => true,
		'public'                  => true,
		'show_in_nav_menus'       => true,
		'show_ui'                 => true,
		'query_var'               => 'makerfaire_category',
		'rewrite'                 => true,
		'capabilities'            => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'                  => array(
			'name'                       =>  __( 'makerfaire categories', 'makerfaire' ),
			'singular_name'              =>  __( 'makerfaire category', 'makerfaire' ),
			'search_items'               =>  __( 'Search makerfaire categories', 'makerfaire' ),
			'popular_items'              =>  __( 'Popular makerfaire categories', 'makerfaire' ),
			'all_items'                  =>  __( 'All makerfaire categories', 'makerfaire' ),
			'parent_item'                =>  __( 'Parent makerfaire category', 'makerfaire' ),
			'parent_item_colon'          =>  __( 'Parent makerfaire category:', 'makerfaire' ),
			'edit_item'                  =>  __( 'Edit makerfaire category', 'makerfaire' ),
			'update_item'                =>  __( 'Update makerfaire category', 'makerfaire' ),
			'add_new_item'               =>  __( 'New makerfaire category', 'makerfaire' ),
			'new_item_name'              =>  __( 'New makerfaire category', 'makerfaire' ),
			'separate_items_with_commas' =>  __( 'makerfaire categories separated by comma', 'makerfaire' ),
			'add_or_remove_items'        =>  __( 'Add or remove makerfaire categories', 'makerfaire' ),
			'choose_from_most_used'      =>  __( 'Choose from the most used makerfaire categories', 'makerfaire' ),
			'menu_name'                  =>  __( 'makerfaire categories', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'makerfaire_category_init' );
