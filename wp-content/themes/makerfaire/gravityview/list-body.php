<?php
/**
 * @file templates/list-body.php
 *
 * Display the entries loop when using a list layout
 *
 * @package GravityView
 * @subpackage GravityView/templates
 *
 * @global GravityView_View $this
 */


/**
 * @action `gravityview_list_body_before` Tap in before the entry loop has been displayed
 * @param GravityView_View $this The GravityView_View instance
 */
do_action( 'gravityview_list_body_before', $this );
$total = count($this->getEntries());
// There are no entries.
if( ! $total ) {

	?>
	<div class="gv-list-view gv-no-results">
		<div class="gv-list-view-title">
			<h3><?php echo gv_no_results(); ?></h3>
		</div>
	</div>
	<?php

} else {

	// There are entries. Loop through them.
	foreach ( $this->getEntries() as $entry ) {

		$this->setCurrentEntry( $entry );

	?>

		<div id="gv_list_<?php echo $entry['id']; ?>" class="maker-admin">

		<?php

		/**
		 * @action `gravityview_entry_before` Tap in before the the entry is displayed, inside the entry container
		 * @param array $entry Gravity Forms Entry array
		 * @param GravityView_View $this The GravityView_View instance
		 */
		do_action( 'gravityview_entry_before', $entry, $this );

		?>

		<?php if ( $this->getField('directory_list-title') || $this->getField('directory_list-subtitle') ): ?>

			<?php

			/**
			 * @action `gravityview_entry_title_before` Tap in before the the entry title is displayed
			 * @param array $entry Gravity Forms Entry array
			 * @param GravityView_View $this The GravityView_View instance
			 */
			do_action( 'gravityview_entry_title_before', $entry, $this );

			?>
			<div class="gv-list-view-title-maker-entry">
                                                               
				<?php if ( $this->getField('directory_list-title') ) {
					$i          = 0;
					$title_args = array(
						'entry'      => $entry,
						'form'       => $this->getForm(),
						'hide_empty' => $this->getAtts( 'hide_empty' ),
					);
                                        
                                        $imgDiv  = '<div class="entryImg">';
                                        $titleDiv = '<div class="entryData">';
                                        $dataDiv = '<div class="entryData">';
                                        
                                        
                                        
					foreach ( $this->getField( 'directory_list-title' ) as $field ) {                                            
						$title_args['field'] = $field;                                                
                                                if($field['id']==22){  //project photo           
                                                    $title_args['wpautop'] = true;
                                                    $imgDiv .= gravityview_field_output( $title_args );
                                                } elseif($field['id']==151){ //project name
                                                    $title_args['markup'] = '<span class="title">{{value}}</span>';
                                                    $titleDiv .=  gravityview_field_output( $title_args );
                                                    unset( $title_args['markup'] );
                                                } elseif($field['id']=='edit_link' || $field['id']=='cancel_link'){ //project name
                                                    $title_args['markup'] = '<span class="edit">{{value}}</span>';
                                                    $titleDiv .=  gravityview_field_output( $title_args );
                                                    unset( $title_args['markup'] );    
                                                } else { //project data
                                                    $title_args['markup'] = '<div>{{label}} {{value}}</div>';
                                                    $dataDiv .= gravityview_field_output( $title_args );
                                                    unset( $title_args['markup'] ); 
                                                }  
                                                
					}
				}
                                echo $imgDiv  . '</div>';
                                echo $titleDiv . '</div>';
                                echo $dataDiv . '</div>';
                                
				$this->renderZone('subtitle', array(
					'markup' => '<h4 id="{{ field_id }}" class="{{class}}">{{label}}{{value}}</h4>',
					'wrapper_class' => 'gv-list-view-subtitle',
				));
			?>
			</div>

			<?php

			/**
			 * @action `gravityview_entry_title_after` Tap in after the title block
			 * @param array $entry Gravity Forms Entry array
			 * @param GravityView_View $this The GravityView_View instance
			 */
			do_action( 'gravityview_entry_title_after', $entry, $this );

			?>

		<?php endif; ?>

		<div class="gv-grid gv-list-view-content">

			<?php

				/**
				 * @action `gravityview_entry_content_before` Tap in inside the View Content wrapper <div>
				 * @param array $entry Gravity Forms Entry array
				 * @param GravityView_View $this The GravityView_View instance
				 */
				do_action( 'gravityview_entry_content_before', $entry, $this );

				$this->renderZone('image', 'wrapper_class="gv-grid-col-1-3 gv-list-view-content-image"');

				$this->renderZone('description', array(
					'wrapper_class' => 'gv-grid-col-2-3 gv-list-view-content-description',
					'label_markup' => '<h4>{{label}}</h4>',
					'wpautop'      => true
				));

				$this->renderZone('content-attributes', array(
					'wrapper_class' => 'gv-list-view-content-attributes',
					'markup'     => '<p id="{{ field_id }}" class="{{class}}">{{label}}{{value}}</p>'
				));

				/**
				 * @action `gravityview_entry_content_after` Tap in at the end of the View Content wrapper <div>
				 * @param array $entry Gravity Forms Entry array
				 * @param GravityView_View $this The GravityView_View instance
				 */
				do_action( 'gravityview_entry_content_after', $entry, $this );

			?>

		</div>

		<?php

		// Is the footer configured?
		if ( $this->getField('directory_list-footer-left') || $this->getField('directory_list-footer-right') ) {

			/**
			 * @action `gravityview_entry_footer_before` Tap in before the footer wrapper
			 * @param array $entry Gravity Forms Entry array
			 * @param GravityView_View $this The GravityView_View instance
			 */
			do_action( 'gravityview_entry_footer_before', $entry, $this );

			?>

			<div class="gv-grid gv-list-view-footer">
				<div class="gv-grid-col-1-2 gv-left">
					<?php $this->renderZone('footer-left'); ?>
				</div>

				<div class="gv-grid-col-1-2 gv-right">
					<?php $this->renderZone('footer-right'); ?>
				</div>
			</div>

			<?php

			/**
			 * @action `gravityview_entry_footer_after` Tap in after the footer wrapper
			 * @param array $entry Gravity Forms Entry array
			 * @param GravityView_View $this The GravityView_View instance
			 */
			do_action( 'gravityview_entry_footer_after', $entry, $this );

		} // End if footer is configured


		/**
		 * @action `gravityview_entry_after` Tap in after the entry has been displayed, but before the container is closed
		 * @param array $entry Gravity Forms Entry array
		 * @param GravityView_View $this The GravityView_View instance
		 */
		do_action( 'gravityview_entry_after', $entry, $this );

		?>

		</div>
                <div class="modal" id="cancelEntry">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Cancel Exhibit ID: <span id="cancelEntryID" name="entryID"></span></h4>
                        </div>
                        <div class="modal-body">
                  <p>We are sorry to see you leave.  Please leave us a message as to why you are cancelling.</p><br/>

                  <textarea rows="4" cols="50" name="cancelReason"></textarea>
                    <br/><span id="cancelResponse"></span><br/>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" id="submitCancel">Submit</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
	<?php }

} // End if has entries

/**
 * @action `gravityview_list_body_after` Tap in after the entry loop has been displayed
 * @param GravityView_View $this The GravityView_View instance
 */
do_action( 'gravityview_list_body_after', $this );
