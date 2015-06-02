<?php


function custom_rewrite_tag() {
	add_rewrite_tag('%entryid%', '([^&]+)');
	add_rewrite_tag('%makerfaire%', '([^&]+)');
}
add_action('init', 'custom_rewrite_tag', 10, 0);

/* Gravity Forms Specific Helper calls*/


function add_grav_forms(){
	$role = get_role('editor');
	$role->add_cap('gform_full_access');
}
add_action('admin_init','add_grav_forms');

add_filter( 'gform_next_button', 'gform_next_button_markup' );
function gform_next_button_markup( $next_button ) {

	$next_button = '<span class="container-gnb">'. $next_button . '</span>';

	return $next_button;
}

add_filter( 'gform_previous_button', 'gform_previous_button_markup' );
function gform_previous_button_markup( $previous_button ) {

	$previous_button = '<span class="container-gpb">'. $previous_button . '</span>';

	return $previous_button;
}



//add_filter('gform_submit_button','form_submit_button');
//function form_submit_button($button){
//	return '<input id="gform_submit_button_' . $form['id'] . '" class="gform_button gform_submit_button button" type="submit" onclick="if(window["gf_submitting_' . $form['id'] . '"]){return false;} if( !jQuery("#gform_' . $form['id'] . '")[0].checkValidity || jQuery("#gform_' . $form['id'] . '")[0].checkValidity()){window["gf_submitting_' . $form['id'] . '"]=true;} " value="Submit">';
//}

/* Styles to adjust admin screen go here */
add_action( 'admin_head', 'remove_gf_form_toolbar' );

function remove_gf_form_toolbar(){ 
	?>
     <style>
      		#gf_form_toolbar li.gf_form_toolbar_editor {
		   	    display:none;
		    		}
		    		#gf_form_toolbar li.gf_form_toolbar_settings {
		    display:none;
		    		}
	 #notifications_container {
	 	display:none;
	 	}	    
	 	
	 	#entry_form div#submitdiv {
	 	display:none;
	 	}			
	 	.detail-view-print {
	 	margin-bottom: 20px;
	 	}
     </style>
<?php
}

add_action( 'admin_bar_menu', 'toolbar_link_to_mypage', 999 );

function toolbar_link_to_mypage( $wp_admin_bar ) {
$locations = get_registered_nav_menus();
$menus = wp_get_nav_menus();
$menu_locations = get_nav_menu_locations();

$location_id = 'mf-admin-bayarea-register-menu';

if (isset($menu_locations[ $location_id ])) {
	foreach ($menus as $menu) {
		// If the ID of this menu is the ID associated with the location we're searching for
		if ($menu->term_id == $menu_locations[ $location_id ]) {
			// This is the correct menu
			$menu_items = wp_get_nav_menu_items($menu);

		$args = array(
				'id'    => 'mf_admin_parent',
				'title' => 'MF Admin',
				'meta'  => array( 'class' => 'my-toolbar-page' ),
		);

		$wp_admin_bar->add_node( $args );

		$args = array(
		'id'    => 'mf_admin_parent_bayarea',
		'title' => 'Bay Area',
			'meta'  => array( 'class' => 'my-toolbar-page' ),
		'parent' => 'mf_admin_parent'
		);
                
		$wp_admin_bar->add_node( $args );

		foreach ( (array) $menu_items as $key => $menu_item ) {
			$args = array(
				'id'    => $menu_item->object_id,
				'title' => $menu_item->title,
				'href'  => $menu_item->url,
				'meta'  => array( 'class' => 'my-toolbar-page' ),
				'parent' => 'mf_admin_parent_bayarea'
			);
		
			$wp_admin_bar->add_node( $args );
			}
		}
	}
}


//new york
$location_id = 'mf-admin-newyork-register-menu';

if (isset($menu_locations[ $location_id ])) {
	foreach ($menus as $menu) {
		// If the ID of this menu is the ID associated with the location we're searching for
		if ($menu->term_id == $menu_locations[ $location_id ]) {
                    // This is the correct menu
                    $menu_items = wp_get_nav_menu_items($menu);

                    $args = array(
                                    'id'    => 'mf_admin_parent',
                                    'title' => 'MF Admin',
                                    'meta'  => array( 'class' => 'my-toolbar-page' ),
                    );

                    $wp_admin_bar->add_node( $args );

                    $args = array(
                    'id'    => 'mf_admin_parent_newyork',
                    'title' => 'New York',
                    'meta'  => array( 'class' => 'my-toolbar-page' ),
                    'parent' => 'mf_admin_parent'
                    );

                    $wp_admin_bar->add_node( $args );

                    foreach ( (array) $menu_items as $key => $menu_item ) {
                            $args = array(
                                    'id'    => $menu_item->object_id,
                                    'title' => $menu_item->title,
                                    'href'  => $menu_item->url,
                                    'meta'  => array( 'class' => 'my-toolbar-page' ),
                                    'parent' => 'mf_admin_parent_newyork'
                            );

                            $wp_admin_bar->add_node( $args );
                    }
		}
	}
}

//faire setup
$location_id = 'mf-admin-fairesetup-register-menu';

if (isset($menu_locations[ $location_id ])) {
	foreach ($menus as $menu) {
		// If the ID of this menu is the ID associated with the location we're searching for
		if ($menu->term_id == $menu_locations[ $location_id ]) {
			// This is the correct menu
			$menu_items = wp_get_nav_menu_items($menu);

			$args = array(
					'id'    => 'mf_admin_parent_fairesetup',
					'title' => 'Faire Setup',
					'meta'  => array( 'class' => 'my-toolbar-page' ),
					'parent' => 'mf_admin_parent'
			);

			$wp_admin_bar->add_node( $args );

			foreach ( (array) $menu_items as $key => $menu_item ) {
				$args = array(
						'id'    => $menu_item->object_id,
						'title' => $menu_item->title,
						'href'  => $menu_item->url,
						'meta'  => array( 'class' => 'my-toolbar-page' ),
						'parent' => 'mf_admin_parent_fairesetup'
				);

				$wp_admin_bar->add_node( $args );
			}
		}
	}
}
}

/*
 * After Submission Gravity Forms Action Handling
 */
add_action( 'gform_after_submission', 'post_to_jdb', 10, 2 );
function post_to_jdb( $entry, $form ) {
	error_log('$gravityforms_send_entry_to_jdb:'.$entry['id']);
	$result = GFJDBHELPER::gravityforms_send_entry_to_jdb($entry['id']);
	error_log('GFJDBHELPER:result:'.$result);
}

/*
 * After Note Added handle jdb sync
*/
add_action( 'gform_post_note_added', 'note_to_jdb', 10, 2 );
function note_to_jdb( $noteid,$entryid,$userid,$username,$note,$notetype ) {
	error_log('$GFJDBHELPER:gravityforms_send_note_to_jdb:result:'.$noteid);
	$result=GFJDBHELPER::gravityforms_send_note_to_jdb($entryid,$noteid,$note);
	error_log('GFJDBHELPER:gravityforms_send_note_to_jdb:result:'.$result);
	
}

