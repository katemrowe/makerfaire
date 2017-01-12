<?php

if ( ! class_exists( 'GFForms' ) ) {
	die();
}
if( !class_exists('GFEntryList')) { require_once(GFCommon::get_base_path() . "/entry_list.php"); }
class GFEntryDetail {

	function get_makerfaire_status_counts( $form_id ) {
		global $wpdb;
		$lead_details_table_name = RGFormsModel::get_lead_details_table_name();
		$sql             = $wpdb->prepare(
				"SELECT count(0) as entries,value as label FROM $lead_details_table_name
				where field_number='303'
				and form_id=%d
				group by value",
				$form_id
		);
	
		$results = $wpdb->get_results( $sql, ARRAY_A );
		return $results;
	
	}
	
	public static function lead_detail_page() {
		global $current_user;
		do_action( 'gform_admin_pre_render_action');
		
		if ( ! GFCommon::ensure_wp_version() ) {
			return;
		}
		
		/* Change Lead_ID Logic */
		if(isset($_GET['lid'])){
                    $lead_id = rgget( 'lid' );
                    if ( ! $lead_id ) {
                            $lead = ! empty( $leads ) ? $leads[0] : false;
                    } else {
                            $lead = GFAPI::get_entry( $lead_id );
                    }

                    if ( ! $lead ) {
                            _e( "Oops! We couldn't find your entry. Please try again", 'gravityforms' );

                            return;
                    }
                }
		echo GFCommon::get_remote_message();
		
                if(isset($_GET['lid'])){
                    //Change form from different ID
                    $form_id    =  isset($lead['form_id']) ? $lead['form_id'] : 0;
                    $form = RGFormsModel::get_form_meta($form_id);		
                    $form    = apply_filters( 'gform_admin_pre_render_' . $form['id'], apply_filters( 'gform_admin_pre_render', $form ) );
                }else{
                    $form    = RGFormsModel::get_form_meta( absint( $_GET['id'] ) );
                    $form_id = absint( $form['id'] );
                    $form    = apply_filters( 'gform_admin_pre_render_' . $form_id, apply_filters( 'gform_admin_pre_render', $form ) );                    
                }
                $lead_id = rgget( 'lid' );

		$filter = rgget( 'filter' );
		$status = in_array( $filter, array( 'trash', 'spam' ) ) ? $filter : 'active';

		$position       = rgget( 'pos' ) ? rgget( 'pos' ) : 0;
		$sort_direction = rgget( 'dir' ) ? rgget( 'dir' ) : 'DESC';

		$sort_field      = empty( $_GET['sort'] ) ? 0 : $_GET['sort'];
		$sort_field_meta = RGFormsModel::get_field( $form, $sort_field );
		$is_numeric      = $sort_field_meta['type'] == 'number';
		$all_forms      = empty( $_GET['allforms'] ) ? 0 : $_GET['allforms'];
		
		$star = $filter == 'star' ? 1 : null;
		$read = $filter == 'unread' ? 0 : null;

		$search_criteria['status'] = $status;

		if ( $star ) {
			$search_criteria['field_filters'][] = array( 'key' => 'is_starred', 'value' => (bool) $star );
		}
		if ( ! is_null( $read ) ) {
			$search_criteria['field_filters'][] = array( 'key' => 'is_read', 'value' => (bool) $read );
		}

		$search_field_id = rgget( 'field_id' );
                /*logic to allow multiple filters to be set */
                if(isset($_GET['filterField']) && is_array($_GET['filterField'])){
                    foreach($_GET['filterField'] as $key=>$value){
                        $filterValues = explode("|",$value);
                        $key             = $filterValues[0];
                        $search_operator = $filterValues[1];
                        $val             = $filterValues[2];     
                        if ( 'entry_id' == $key ) {
				//$key = 'id';
			}
			$filter_operator = empty( $search_operator ) ? 'is' : $search_operator;

			$field = GFFormsModel::get_field( $form, $key );
			if ( $field ) {
				$input_type = GFFormsModel::get_input_type( $field );
				if ( $field->type == 'product' && in_array( $input_type, array( 'radio', 'select' ) ) ) {
					$filter_operator = 'contains';
				}
			}

			$search_criteria['field_filters'][] = array(
				'key'      => $key,
				'operator' => $filter_operator,
				'value'    => $val,
			);
                    }
                } 
                /*
		if ( isset( $_GET['field_id'] ) && $_GET['field_id'] !== '' ) {
			$key            = $search_field_id;
			$val            = rgget( 's' );
			$strpos_row_key = strpos( $search_field_id, '|' );
			if ( $strpos_row_key !== false ) { //multi-row likert
				$key_array = explode( '|', $search_field_id );
				$key       = $key_array[0];
				$val       = $key_array[1] . ':' . $val;
			}

			$search_criteria['field_filters'][] = array(
				'key'      => $key,
				'operator' => rgempty( 'operator', $_GET ) ? 'is' : rgget( 'operator' ),
				'value'    => $val,
			);

			$type = rgget( 'type' );
			if ( empty( $type ) ) {
				if ( rgget( 'field_id' ) == '0' ) {
					$search_criteria['type'] = 'global';
				}
			}
		}*/

		$paging = array( 'offset' => $position, 'page_size' => 1 );

		if ( ! empty( $sort_field ) ) {
			$sorting = array( 'key' => $_GET['sort'], 'direction' => $sort_direction, 'is_numeric' => $is_numeric );
		} else {
			$sorting = array();
		}
		$total_count = 0;
                global $wpdb;
                $form_ids = $form_id; 
                $faire = (isset($_GET['faire'])?$_GET['faire']:'');
                if($faire != ''){
                    $form_id = 9;
                    //let's get the form id's for this faire
                    $sql = "select * from wp_mf_faire where faire='".$faire."'";                                    
                    $Fresults = $wpdb->get_results($sql); 
                    if(!empty($Fresults)){
                        $form_ids = explode(',', $Fresults[0]->form_ids);                        
                    }else{                        
                        $form_ids = 99999999;
                    }                    
                }
		$leads = GFAPI::get_entries( $form_ids, $search_criteria, $sorting, $paging, $total_count );
			
		$prev_pos = ! rgblank( $position ) && $position > 0 ? $position - 1 : false;
		$next_pos = ! rgblank( $position ) && $position < $total_count - 1 ? $position + 1 : false;

		// unread filter requires special handling for pagination since entries are filter out of the query as they are read
		if ( $filter == 'unread' ) {
			$next_pos = $position;

			if ( $next_pos + 1 == $total_count ) {
				$next_pos = false;
			}
		}

		if ( ! $lead_id ) {
			$lead = ! empty( $leads ) ? $leads[0] : false;
		} else {
			$lead = GFAPI::get_entry( $lead_id );
		}

		if ( ! $lead ) {
			_e( "Oops! We couldn't find your entry. Please try again", 'gravityforms' );

			return;
		}

		RGFormsModel::update_lead_property( $lead['id'], 'is_read', 1 );

		switch ( RGForms::post( 'action' ) ) {
			case 'update' :
				check_admin_referer( 'gforms_save_entry', 'gforms_save_entry' );
				//Loading files that have been uploaded to temp folder
				$files = GFCommon::json_decode( stripslashes( RGForms::post( 'gform_uploaded_files' ) ) );
				if ( ! is_array( $files ) ) {
					$files = array();
				}

				GFFormsModel::$uploaded_files[ $form_id ] = $files;
				GFFormsModel::save_lead( $form, $lead );

				do_action( 'gform_after_update_entry', $form, $lead['id'] );
				do_action( "gform_after_update_entry_{$form['id']}", $form, $lead['id'] );

				$lead = RGFormsModel::get_lead( $lead['id'] );
				$lead = GFFormsModel::set_entry_meta( $lead, $form );
				break;

			case 'add_note' :
				check_admin_referer( 'gforms_update_note', 'gforms_update_note' );
				$user_data = get_userdata( $current_user->ID );
				RGFormsModel::add_note( $lead['id'], $current_user->ID, $user_data->display_name, stripslashes( $_POST['new_note'] ) );

				//emailing notes if configured
				if ( rgpost( 'gentry_email_notes_to' ) ) {
					GFCommon::log_debug( 'GFEntryDetail::lead_detail_page(): Preparing to email entry notes.' );
					$email_to      = $_POST['gentry_email_notes_to'];
					$email_from    = $current_user->user_email;
					$email_subject = stripslashes( $_POST['gentry_email_subject'] );
					$body = stripslashes( $_POST['new_note'] );

					$headers = "From: \"$email_from\" <$email_from> \r\n";
					GFCommon::log_debug( "GFEntryDetail::lead_detail_page(): Emailing notes - TO: $email_to SUBJECT: $email_subject BODY: $body HEADERS: $headers" );
					$is_success  = wp_mail( $email_to, $email_subject, $body, $headers );
					$result = is_wp_error( $is_success ) ? $is_success->get_error_message() : $is_success;
					GFCommon::log_debug( "GFEntryDetail::lead_detail_page(): Result from wp_mail(): {$result}" );
					if ( ! is_wp_error( $is_success ) && $is_success ) {
						GFCommon::log_debug( 'GFEntryDetail::lead_detail_page(): Mail was passed from WordPress to the mail server.' );
					} else {
						GFCommon::log_error( 'GFEntryDetail::lead_detail_page(): The mail message was passed off to WordPress for processing, but WordPress was unable to send the message.' );
					}

					if ( has_filter( 'phpmailer_init' ) ) {
						GFCommon::log_debug( __METHOD__ . '(): The WordPress phpmailer_init hook has been detected, usually used by SMTP plugins, it can impact mail delivery.' );
					}

					do_action( 'gform_post_send_entry_note', $result, $email_to, $email_from, $email_subject, $body, $form, $lead );
				}
				break;

			case 'add_quick_note' :
				check_admin_referer( 'gforms_save_entry', 'gforms_save_entry' );
				$user_data = get_userdata( $current_user->ID );
				RGFormsModel::add_note( $lead['id'], $current_user->ID, $user_data->display_name, stripslashes( $_POST['quick_note'] ) );
				break;

			case 'bulk' :
				check_admin_referer( 'gforms_update_note', 'gforms_update_note' );
				if ( $_POST['bulk_action'] == 'delete' ) {
					if ( ! GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
						die( __( "You don't have adequate permission to delete notes.", 'gravityforms' ) );
					}
					RGFormsModel::delete_notes( $_POST['note'] );
				}
				break;

			case 'trash' :
				check_admin_referer( 'gforms_save_entry', 'gforms_save_entry' );
				RGFormsModel::update_lead_property( $lead['id'], 'status', 'trash' );
				$lead = RGFormsModel::get_lead( $lead['id'] );
				break;

			case 'restore' :
			case 'unspam' :
				check_admin_referer( 'gforms_save_entry', 'gforms_save_entry' );
				RGFormsModel::update_lead_property( $lead['id'], 'status', 'active' );
				$lead = RGFormsModel::get_lead( $lead['id'] );
				break;

			case 'spam' :
				check_admin_referer( 'gforms_save_entry', 'gforms_save_entry' );
				RGFormsModel::update_lead_property( $lead['id'], 'status', 'spam' );
				$lead = RGFormsModel::get_lead( $lead['id'] );
				break;

			case 'delete' :
				check_admin_referer( 'gforms_save_entry', 'gforms_save_entry' );
				if ( ! GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
					die( __( "You don't have adequate permission to delete entries.", 'gravityforms' ) );
				}
				RGFormsModel::delete_lead( $lead['id'] );
				?>
				<script type="text/javascript">
					document.location.href = '<?php echo 'admin.php?page=gf_entries&view=entries&id=' . absint( $form['id'] )?>';
				</script>
				<?php

				break;
		}

		$mode = empty( $_POST['screen_mode'] ) ? 'view' : $_POST['screen_mode'];
		?>
		<link rel="stylesheet" href="<?php echo GFCommon::get_base_url() ?>/css/admin.css" />
		<script type="text/javascript">

			jQuery(document).ready(function () {
				toggleNotificationOverride(true);
				jQuery('#gform_update_button').prop('disabled', false);
			});

			function DeleteFile(leadId, fieldId, deleteButton) {
				if (confirm(<?php _e( "'Would you like to delete this file? \'Cancel\' to stop. \'OK\' to delete'", 'gravityforms' ); ?>)) {
					var fileIndex = jQuery(deleteButton).parent().index();
					var mysack = new sack("<?php echo admin_url( 'admin-ajax.php' )?>");
					mysack.execute = 1;
					mysack.method = 'POST';
					mysack.setVar("action", "rg_delete_file");
					mysack.setVar("rg_delete_file", "<?php echo wp_create_nonce( 'rg_delete_file' ) ?>");
					mysack.setVar("lead_id", leadId);
					mysack.setVar("field_id", fieldId);
					mysack.setVar("file_index", fileIndex);
					mysack.onError = function () {
						alert('<?php echo esc_js( __( 'Ajax error while deleting field.', 'gravityforms' ) ) ?>')
					};
					mysack.runAJAX();

					return true;
				}
			}

			function EndDeleteFile(fieldId, fileIndex) {
				var previewFileSelector = "#preview_existing_files_" + fieldId + " .ginput_preview";
				var $previewFiles = jQuery(previewFileSelector);
				var rr = $previewFiles.eq(fileIndex);
				$previewFiles.eq(fileIndex).remove();
				var $visiblePreviewFields = jQuery(previewFileSelector);
				if ($visiblePreviewFields.length == 0) {
					jQuery('#preview_' + fieldId).hide();
					jQuery('#upload_' + fieldId).show('slow');
				}
			}

			function ToggleShowEmptyFields() {
				if (jQuery("#gentry_display_empty_fields").is(":checked")) {
					createCookie("gf_display_empty_fields", true, 10000);
					document.location = document.location.href;
				}
				else {
					eraseCookie("gf_display_empty_fields");
					document.location = document.location.href;
				}
			}

			function createCookie(name, value, days) {
				if (days) {
					var date = new Date();
					date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
					var expires = "; expires=" + date.toGMTString();
				}
				else var expires = "";
				document.cookie = name + "=" + value + expires + "; path=/";
			}

			function eraseCookie(name) {
				createCookie(name, "", -1);
			}

			function ResendNotifications() {

				var selectedNotifications = new Array();
				jQuery(".gform_notifications:checked").each(function () {
					selectedNotifications.push(jQuery(this).val());
				});

				var sendTo = jQuery('#notification_override_email').val();

				if (selectedNotifications.length <= 0) {
					displayMessage("<?php _e( 'You must select at least one type of notification to resend.', 'gravityforms' ); ?>", 'error', '#notifications_container');
					return;
				}

				jQuery('#please_wait_container').fadeIn();

				jQuery.post(ajaxurl, {
						action                 : "gf_resend_notifications",
						gf_resend_notifications: '<?php echo wp_create_nonce( 'gf_resend_notifications' ); ?>',
						notifications          : jQuery.toJSON(selectedNotifications),
						sendTo                 : sendTo,
						leadIds                : '<?php echo $lead['id']; ?>',
						formId                 : '<?php echo $form['id']; ?>'
					},
					function (response) {
						if (response) {
							displayMessage(response, "error", "#notifications_container");
						} else {
							displayMessage("<?php _e( 'Notifications were resent successfully.', 'gravityforms' ); ?>", "updated", "#notifications_container");

							// reset UI
							jQuery(".gform_notifications").attr('checked', false);
							jQuery('#notification_override_email').val('');
						}

						jQuery('#please_wait_container').hide();
						setTimeout(function () {
							jQuery('#notifications_container').find('.message').slideUp();
						}, 5000);
					}
				);

			}

			function displayMessage(message, messageClass, container) {

				jQuery(container).find('.message').hide().html(message).attr('class', 'message ' + messageClass).slideDown();

			}

			function toggleNotificationOverride(isInit) {

				if (isInit)
					jQuery('#notification_override_email').val('');

				if (jQuery(".gform_notifications:checked").length > 0) {
					jQuery('#notifications_override_settings').slideDown();
				}
				else {
					jQuery('#notifications_override_settings').slideUp(function () {
						jQuery('#notification_override_email').val('');
					});
				}
			}

		</script>

		<form method="post" id="entry_form" enctype='multipart/form-data'>
		<?php wp_nonce_field( 'gforms_save_entry', 'gforms_save_entry' ) ?>
		<input type="hidden" name="action" id="action" value="" />
		<input type="hidden" name="screen_mode" id="screen_mode" value="<?php echo esc_attr( rgpost( 'screen_mode' ) ) ?>" />

		<div class="wrap gf_entry_wrap">
		<h2 class="gf_admin_page_title">
			<span><?php echo __( 'Entry #', 'gravityforms' ) . absint( $lead['id'] ); ?></span><span class="gf_admin_page_subtitle"><span class="gf_admin_page_formid">ID: <?php echo $form['id']; ?></span><span class='gf_admin_page_formname'><?php _e( 'Form Name', 'gravityforms' ) ?>: <?php echo $form['title'];
				$gf_entry_locking = new GFEntryLocking();
				$gf_entry_locking->lock_info( $lead_id ); ?>
				</span>
				<?php $statuscount=get_makerfaire_status_counts( $form['id'] );
				 foreach($statuscount as $statuscount){                                        
                                     ?><span class="gf_admin_page_formname"><?php echo  $statuscount['label'];?>
					(<?php echo  $statuscount['entries'];?>)</span><?php }?>
				</span></h2>
		<?php if ( isset( $_GET['pos'] ) ) { ?>
			<div class="gf_entry_detail_pagination">
				<ul>
					<li class="gf_entry_count">
						<span>entry <strong><?php echo $position + 1; ?></strong> of <strong><?php echo $total_count; ?></strong></span>
					</li>
					<li class="gf_entry_prev gf_entry_pagination"><?php echo GFEntryDetail::entry_detail_pagination_link( $prev_pos, 'Previous Entry', 'gf_entry_prev_link', 'fa fa-arrow-circle-o-left' ); ?></li>
					<li class="gf_entry_next gf_entry_pagination"><?php echo GFEntryDetail::entry_detail_pagination_link( $next_pos, 'Next Entry', 'gf_entry_next_link', 'fa fa-arrow-circle-o-right' ); ?></li>
				</ul>
                            <?php                            
                            $outputVar = '';
                            if(isset($_GET['filterField'])){
                                foreach($_GET['filterField'] as $newValue){
                                    $outputVar .= '&filterField[]='.$newValue;
                                }
                            }
                            $outputURL = admin_url( 'admin.php' ) . "?page=mf_entries&view=entries&id=".$form_id . $outputVar;
                            if(isset($_GET['sort']))    $outputURL .= '&sort='.rgget('sort');
                            if(isset($_GET['filter']))  $outputURL .= '&filter='.rgget( 'filter' );
                            if(isset($_GET['dir']))     $outputURL .= '&dir='.rgget( 'dir' );
                            if(isset($_GET['star']))    $outputURL .= '&star='.rgget( 'star' );
                            if(isset($_GET['read']))    $outputURL .= '&read='.rgget( 'read' );
                            if(isset($_GET['paged']))   $outputURL .= '&paged='.rgget( 'paged' );
                            if(isset($_GET['faire']))   $outputURL .= '&faire='.rgget( 'faire' );
                                    ?>
			<a href="<?php echo $outputURL;?>">Return to entries list</a>
                        </div>
		<?php } ?>
                    
		<?php RGForms::top_toolbar() ?>

		<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div id="side-info-column" class="inner-sidebar">
		<?php do_action( 'gform_entry_detail_sidebar_before', $form, $lead ); ?>

		<!-- INFO BOX -->
		<div id="submitdiv" class="stuffbox">
			<h3>
				<span class="hndle"><?php _e( 'Entry', 'gravityforms' ); ?></span>
			</h3>

			<div class="inside">
				<div id="submitcomment" class="submitbox">
					<div id="minor-publishing" style="padding:10px;">
						<?php _e( 'Submitted on', 'gravityforms' ); ?>: <?php echo esc_html( GFCommon::format_date( $lead['date_created'], false, 'Y/m/d' ) ) ?>
						
						
					</div>
					<div id="major-publishing-actions">
						<div id="delete-action">
							<?php
							switch ( $lead['status'] ) {
								case 'spam' :
									if ( GFCommon::spam_enabled( $form['id'] ) ) {
										?>
										<a onclick="jQuery('#action').val('unspam'); jQuery('#entry_form').submit()" href="#"><?php _e( 'Not Spam', 'gravityforms' ) ?></a>
										<?php
										echo GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ? '|' : '';
									}
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
										<a class="submitdelete deletion" onclick="if ( confirm('<?php _e( "You are about to delete this entry. \'Cancel\' to stop, \'OK\' to delete.", 'gravityforms' ) ?>') ) {jQuery('#action').val('delete'); jQuery('#entry_form').submit(); return true;} return false;" href="#"><?php _e( 'Delete Permanently', 'gravityforms' ) ?></a>
									<?php
									}

									break;

								case 'trash' :
									?>
									<a onclick="jQuery('#action').val('restore'); jQuery('#entry_form').submit()" href="#"><?php _e( 'Restore', 'gravityforms' ) ?></a>
									<?php
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
										|
										<a class="submitdelete deletion" onclick="if ( confirm('<?php _e( "You are about to delete this entry. \'Cancel\' to stop, \'OK\' to delete.", 'gravityforms' ) ?>') ) {jQuery('#action').val('delete'); jQuery('#entry_form').submit(); return true;} return false;" href="#"><?php _e( 'Delete Permanently', 'gravityforms' ) ?></a>
									<?php
									}

									break;

								default :
									if ( GFCommon::current_user_can_any( 'gravityforms_delete_entries' ) ) {
										?>
										<a class="submitdelete deletion" onclick="jQuery('#action').val('trash'); jQuery('#entry_form').submit()" href="#"><?php _e( 'Move to Trash', 'gravityforms' ) ?></a>
										<?php
										echo GFCommon::spam_enabled( $form['id'] ) ? '|' : '';
									}
									if ( GFCommon::spam_enabled( $form['id'] ) ) {
										?>
										<a class="submitdelete deletion" onclick="jQuery('#action').val('spam'); jQuery('#entry_form').submit()" href="#"><?php _e( 'Mark as Spam', 'gravityforms' ) ?></a>
									<?php
									}
							}

							?>
						</div>
						<div id="publishing-action">
							<?php
							if ( GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) && $lead['status'] != 'trash' ) {
								$button_text      = $mode == 'view' ? __( 'Edit', 'gravityforms' ) : __( 'Update', 'gravityforms' );
								$disabled         = $mode == 'view' ? '' : ' disabled="disabled" ';
								$update_button_id = $mode == 'view' ? 'gform_edit_button' : 'gform_update_button';
								$button_click     = $mode == 'view' ? "jQuery('#screen_mode').val('edit');" : "jQuery('#action').val('update'); jQuery('#screen_mode').val('view');";
								$update_button    = '<input id="' . $update_button_id . '" ' . $disabled . ' class="button button-large button-primary" type="submit" tabindex="4" value="' . $button_text . '" name="save" onclick="' . $button_click . '"/>';
								echo apply_filters( 'gform_entrydetail_update_button', $update_button );
								if ( $mode == 'edit' ) {
									echo '&nbsp;&nbsp;<input class="button button-large" type="submit" tabindex="5" value="' . __( 'Cancel', 'gravityforms' ) . '" name="cancel" onclick="jQuery(\'#screen_mode\').val(\'view\');"/>';
								}
							}
							?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>

		<?php
		if ( ! empty( $lead['payment_status'] ) && ! apply_filters( 'gform_enable_entry_info_payment_details', true, $lead ) ) {
			self::payment_details_box( $lead, $form );
		}
		?>

		<?php do_action( 'gform_entry_detail_sidebar_middle', $form, $lead ); ?>

		<?php if ( GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) { ?>
			<!-- start notifications -->
			<div class="postbox" id="notifications_container">
				<h3 style="cursor:default;"><span><?php _e( 'Notifications', 'gravityforms' ); ?></span></h3>

				<div class="inside">
					<div class="message" style="display:none; padding:10px; margin:10px 0px;"></div>
					<div>
						<?php

						$notifications = GFCommon::get_notifications('form_submission', $form);

						if ( ! is_array( $notifications ) || count( $form['notifications'] ) <= 0 ) {
							?>
							<p class="description"><?php _e( 'You cannot resend notifications for this entry because this form does not currently have any notifications configured.', 'gravityforms' ); ?></p>

							<a href="<?php echo admin_url( "admin.php?page=gf_edit_forms&view=settings&subview=notification&id={$form['id']}" ) ?>" class="button"><?php _e( 'Configure Notifications', 'gravityforms' ) ?></a>
						<?php
						} else {
							foreach ( $notifications as $notification ) {
								?>
								<input type="checkbox" class="gform_notifications" value="<?php echo $notification['id'] ?>" id="notification_<?php echo $notification['id'] ?>" onclick="toggleNotificationOverride();" />
								<label for="notification_<?php echo $notification['id'] ?>"><?php echo $notification['name'] ?></label>
								<br /><br />
							<?php
							}
							?>

							<div id="notifications_override_settings" style="display:none;">

								<p class="description" style="padding-top:0; margin-top:0; width:99%;">You may override the default notification settings
									by entering a comma delimited list of emails to which the selected notifications should be sent.</p>
								<label for="notification_override_email"><?php _e( 'Send To', 'gravityforms' ); ?> <?php gform_tooltip( 'notification_override_email' ) ?></label><br />
								<input type="text" name="notification_override_email" id="notification_override_email" style="width:99%;" />
								<br /><br />

							</div>

							<input type="button" name="notification_resend" value="<?php _e( 'Resend Notifications', 'gravityforms' ) ?>" class="button" style="" onclick="ResendNotifications();" />
							<span id="please_wait_container" style="display:none; margin-left: 5px;">

											<i class='gficon-gravityforms-spinner-icon gficon-spin'></i> <?php _e( 'Resending...', 'gravityforms' ); ?>
                                        </span>
						<?php
						}
						?>

					</div>
				</div>
			</div>
			<!-- / end notifications -->
		<?php } ?>

		<!-- begin print button -->
		<div class="detail-view-print">
			<a href="javascript:;" onclick="var notes_qs = jQuery('#gform_print_notes').is(':checked') ? '&notes=1' : ''; var url='<?php echo trailingslashit( site_url() ) ?>?gf_page=print-entry&fid=<?php echo $form['id'] ?>&lid=<?php echo $lead['id'] ?>' + notes_qs; window.open (url,'printwindow');" class="button"><?php _e( 'Print', 'gravityforms' ) ?></a>
			<?php if ( GFCommon::current_user_can_any( 'gravityforms_view_entry_notes' ) ) { ?>
				<input type="checkbox" name="print_notes" value="print_notes" checked="checked" id="gform_print_notes" />
				<label for="print_notes"><?php _e( 'include notes', 'gravityforms' ) ?></label>
			<?php } ?>
		</div>
		<!-- end print button -->
		<?php do_action( 'gform_entry_detail_sidebar_after', $form, $lead ); ?>
		</div>

		<div id="post-body" class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">
				<?php

				do_action( 'gform_entry_detail_content_before', $form, $lead );

				if ( $mode == 'view' ) {
					self::lead_detail_grid( $form, $lead, true );
				} else {
					self::lead_detail_edit( $form, $lead );
				}

				do_action( 'gform_entry_detail', $form, $lead );

				
				do_action( 'gform_entry_detail_content_after', $form, $lead );
				?>
			</div>
		</div>
		</div>
		</div>
		</form>
		<?php

		if ( rgpost( 'action' ) == 'update' ) {
			?>
			<div class="updated fade" style="padding:6px;">
				<?php _e( 'Entry Updated.', 'gravityforms' ); ?>
			</div>
		<?php
		}
	}

	public static function lead_detail_edit( $form, $lead ) {
		$form    = apply_filters( 'gform_admin_pre_render_' . $form['id'], apply_filters( 'gform_admin_pre_render', $form ) );
		$form_id = $form['id'];
		?>
		<div class="postbox">
			<h3>
				<label for="name"><?php _e( 'Details', 'gravityforms' ); ?></label>
			</h3>

			<div class="inside">
				<table class="form-table entry-details">
					<tbody>
					<?php
					foreach ( $form['fields'] as $field ) {
						$field_id = $field->id;
						switch ( RGFormsModel::get_input_type( $field ) ) {
							case 'section' :
								?>
								<tr valign="top">
									<td class="detail-view">
										<div style="margin-bottom:10px; border-bottom:1px dotted #ccc;">
											<h2 class="detail_gsection_title"><?php echo esc_html( GFCommon::get_label( $field ) ) ?></h2>
										</div>
									</td>
								</tr>
								<?php

								break;

							case 'captcha':
							case 'html':
							case 'password':
								//ignore certain fields
								break;

							default :
								$value   = RGFormsModel::get_lead_field_value( $lead, $field );
								$td_id   = 'field_' . $form_id . '_' . $field_id;
								$content = "<tr valign='top'><td class='detail-view' id='{$td_id}'><label class='detail-label'>" . esc_html( GFCommon::get_label( $field ) ) . '</label>' .
									GFCommon::get_field_input( $field, $value, $lead['id'], $form_id, $form ) . '</td></tr>';

								$content = apply_filters( 'gform_field_content', $content, $field, $value, $lead['id'], $form['id'] );

								echo $content;
								break;
						}
					}
					?>
					</tbody>
				</table>
				<br />

				<div class="gform_footer">
					<input type="hidden" name="gform_unique_id" value="" />
					<input type="hidden" name="gform_uploaded_files" id='gform_uploaded_files_<?php echo $form_id; ?>' value="" />
				</div>
			</div>
		</div>
	<?php
	}

	public static function notes_grid( $notes, $is_editable, $emails = null, $subject = '' ) {
		if ( sizeof( $notes ) > 0 && $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
			?>
			<div class="alignleft actions" style="padding:3px 0;">
				<label class="hidden" for="bulk_action"><?php _e( ' Bulk action', 'gravityforms' ) ?></label>
				<select name="bulk_action" id="bulk_action">
					<option value=''><?php _e( ' Bulk action ', 'gravityforms' ) ?></option>
					<option value='delete'><?php _e( 'Delete', 'gravityforms' ) ?></option>
				</select>
				<?php
				$apply_button = '<input type="submit" class="button" value="' . __( 'Apply', 'gravityforms' ) . '" onclick="jQuery(\'#action\').val(\'bulk\');" style="width: 50px;" />';
				echo apply_filters( 'gform_notes_apply_button', $apply_button );
				?>
			</div>
		<?php
		}
		?>
		<table class="widefat fixed entry-detail-notes" cellspacing="0">
			<?php
			if ( ! $is_editable ) {
				?>
				<thead>
				<tr>
					<th id="notes">Notes</th>
				</tr>
				</thead>
			<?php
			}
			?>
			<tbody id="the-comment-list" class="list:comment">
			<?php
			$count = 0;
			$notes_count = sizeof( $notes );
			foreach ( $notes as $note ) {
				$count ++;
				$is_last = $count >= $notes_count ? true : false;
				?>
				<tr valign="top">
					<?php
					if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
					?>
					<th class="check-column" scope="row" style="padding:9px 3px 0 0">
						<input type="checkbox" value="<?php echo $note->id ?>" name="note[]" />
					</th>
					<td colspan="2">
						<?php
						}
						else {
						?>
					<td class="entry-detail-note<?php echo $is_last ? ' lastrow' : '' ?>">
						<?php
						}
						$class = $note->note_type ? " gforms_note_{$note->note_type}" : '';
						?>
						<div style="margin-top:4px;">
							<div class="note-avatar"><?php echo apply_filters( 'gform_notes_avatar', get_avatar( $note->user_id, 48 ), $note ); ?></div>
							<h6 class="note-author"><?php echo esc_html( $note->user_name ) ?></h6>
							<p class="note-email">
								<a href="mailto:<?php echo esc_attr( $note->user_email ) ?>"><?php echo esc_html( $note->user_email ) ?></a><br />
								<?php _e( 'added on', 'gravityforms' ); ?> <?php echo esc_html( GFCommon::format_date( $note->date_created, false ) ) ?>
							</p>
						</div>
						<div class="detail-note-content<?php echo $class ?>"><?php echo esc_html( $note->value ) ?></div>
					</td>

				</tr>
			<?php
			}
			if ( $is_editable && GFCommon::current_user_can_any( 'gravityforms_edit_entry_notes' ) ) {
				?>
				<tr>
					<td colspan="3" style="padding:10px;" class="lastrow">
						<textarea name="new_note" style="width:100%; height:50px; margin-bottom:4px;"></textarea>
						<?php
						$note_button = '<input type="submit" name="add_note" value="' . __( 'Add Note', 'gravityforms' ) . '" class="button" style="width:auto;padding-bottom:2px;" onclick="jQuery(\'#action\').val(\'add_note\');"/>';
						echo apply_filters( 'gform_addnote_button', $note_button );

						if ( ! empty( $emails ) ) {
							?>
							&nbsp;&nbsp;
							<span>
                                <select name="gentry_email_notes_to" onchange="if(jQuery(this).val() != '') {jQuery('#gentry_email_subject_container').css('display', 'inline');} else{jQuery('#gentry_email_subject_container').css('display', 'none');}">
									<option value=""><?php _e( 'Also email this note to', 'gravityforms' ) ?></option>
									<?php foreach ( $emails as $email ) { ?>
										<option value="<?php echo $email ?>"><?php echo $email ?></option>
									<?php } ?>
								</select>
                                &nbsp;&nbsp;

                                <span id='gentry_email_subject_container' style="display:none;">
                                    <label for="gentry_email_subject"><?php _e( 'Subject:', 'gravityforms' ) ?></label>
                                    <input type="text" name="gentry_email_subject" id="gentry_email_subject" value="" style="width:35%" />
                                </span>
                            </span>
						<?php } ?>
					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	<?php
	}

	public static function lead_detail_grid( $form, $lead, $allow_display_empty_fields = false ) {
		$form_id              = $form['id'];

		$display_empty_fields = false;
		if ( $allow_display_empty_fields ) {
			$display_empty_fields = rgget( 'gf_display_empty_fields', $_COOKIE );
		}

		$display_empty_fields = apply_filters( 'gform_entry_detail_grid_display_empty_fields', $display_empty_fields, $form, $lead );

		?>
		<table cellspacing="0" class="widefat fixed entry-detail-view">
			<thead>
			<tr>
				<th id="details">
					<?php
					$title = sprintf( '%s : %s %s', $form['title'], __( 'Entry # ', 'gravityforms' ), $lead['id'] );
					echo apply_filters( 'gform_entry_detail_title', $title, $form, $lead );
					?>
				</th>
				<th style="width:140px; font-size:10px; text-align: right;">
					<?php
					if ( $allow_display_empty_fields ) {
						?>
						<input type="checkbox" id="gentry_display_empty_fields" <?php echo $display_empty_fields ? "checked='checked'" : '' ?> onclick="ToggleShowEmptyFields();" />&nbsp;&nbsp;
						<label for="gentry_display_empty_fields"><?php _e( 'show empty fields', 'gravityforms' ) ?></label>
					<?php
					}
					?>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$count = 0;
			$field_count = sizeof( $form['fields'] );
			$has_product_fields = false;
			foreach ( $form['fields'] as $field ) {
				switch ( RGFormsModel::get_input_type( $field ) ) {
					case 'section' :
						if ( ! GFCommon::is_section_empty( $field, $form, $lead ) || $display_empty_fields ) {
							$count ++;
							$is_last = $count >= $field_count ? true : false;
							?>
							<tr>
								<td colspan="2" class="entry-view-section-break<?php echo $is_last ? ' lastrow' : '' ?>"><?php echo esc_html( GFCommon::get_label( $field ) ) ?></td>
							</tr>
						<?php
						}
						break;

					case 'captcha':
					case 'html':
					case 'password':
					case 'page':
						//ignore captcha, html, password, page field
						break;


					default :
						//ignore product fields as they will be grouped together at the end of the grid
						if ( GFCommon::is_product_field( $field->type ) ) {
							$has_product_fields = true;
							continue;
						}

						$value         = RGFormsModel::get_lead_field_value( $lead, $field );
						$display_value = GFCommon::get_lead_field_display( $field, $value, $lead['currency'] );

						$display_value = apply_filters( 'gform_entry_field_value', $display_value, $field, $lead, $form );

						if ( $display_empty_fields || ! empty( $display_value ) || $display_value === '0' ) {
							$count ++;
							$is_last  = $count >= $field_count && ! $has_product_fields ? true : false;
							$last_row = $is_last ? ' lastrow' : '';

							$display_value = empty( $display_value ) && $display_value !== '0' ? '&nbsp;' : $display_value;

							$content = '
                                <tr>
                                    <td colspan="2" class="entry-view-field-name">' . esc_html( GFCommon::get_label( $field ) ) . '</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="entry-view-field-value' . $last_row . '">' . $display_value . '</td>
                                </tr>';

							$content = apply_filters( 'gform_field_content', $content, $field, $value, $lead['id'], $form['id'] );

							echo $content;

						}
						break;
				}
			}

			$products = array();
			if ( $has_product_fields ) {
				$products = GFCommon::get_product_fields( $form, $lead );
				if ( ! empty( $products['products'] ) ) {
					?>
					<tr>
						<td colspan="2" class="entry-view-field-name"><?php echo apply_filters( "gform_order_label_{$form['id']}", apply_filters( 'gform_order_label', __( 'Order', 'gravityforms' ), $form['id'] ), $form['id'] ) ?></td>
					</tr>
					<tr>
						<td colspan="2" class="entry-view-field-value lastrow">
							<table class="entry-products" cellspacing="0" width="97%">
								<colgroup>
									<col class="entry-products-col1" />
									<col class="entry-products-col2" />
									<col class="entry-products-col3" />
									<col class="entry-products-col4" />
								</colgroup>
								<thead>
								<th scope="col"><?php echo apply_filters( "gform_product_{$form_id}", apply_filters( 'gform_product', __( 'Product', 'gravityforms' ), $form_id ), $form_id ) ?></th>
								<th scope="col" class="textcenter"><?php echo apply_filters( "gform_product_qty_{$form_id}", apply_filters( 'gform_product_qty', __( 'Qty', 'gravityforms' ), $form_id ), $form_id ) ?></th>
								<th scope="col"><?php echo apply_filters( "gform_product_unitprice_{$form_id}", apply_filters( 'gform_product_unitprice', __( 'Unit Price', 'gravityforms' ), $form_id ), $form_id ) ?></th>
								<th scope="col"><?php echo apply_filters( "gform_product_price_{$form_id}", apply_filters( 'gform_product_price', __( 'Price', 'gravityforms' ), $form_id ), $form_id ) ?></th>
								</thead>
								<tbody>
								<?php

								$total = 0;
								foreach ( $products['products'] as $product ) {
									?>
									<tr>
										<td>
											<div class="product_name"><?php echo $product['name'] ?></div>
											<ul class="product_options">
												<?php
												$price = GFCommon::to_number( $product['price'] );
												if ( is_array( rgar( $product, 'options' ) ) ) {
													$count = sizeof( $product['options'] );
													$index = 1;
													foreach ( $product['options'] as $option ) {
														$price += GFCommon::to_number( $option['price'] );
														$class = $index == $count ? " class='lastitem'" : '';
														$index ++;
														?>
														<li<?php echo $class ?>><?php echo $option['option_label'] ?></li>
													<?php
													}
												}
												$subtotal = floatval( $product['quantity'] ) * $price;
												$total += $subtotal;
												?>
											</ul>
										</td>
										<td class="textcenter"><?php echo $product['quantity'] ?></td>
										<td><?php echo GFCommon::to_money( $price, $lead['currency'] ) ?></td>
										<td><?php echo GFCommon::to_money( $subtotal, $lead['currency'] ) ?></td>
									</tr>
								<?php
								}
								$total += floatval( $products['shipping']['price'] );
								?>
								</tbody>
								<tfoot>
								<?php
								if ( ! empty( $products['shipping']['name'] ) ) {
									?>
									<tr>
										<td colspan="2" rowspan="2" class="emptycell">&nbsp;</td>
										<td class="textright shipping"><?php echo $products['shipping']['name'] ?></td>
										<td class="shipping_amount"><?php echo GFCommon::to_money( $products['shipping']['price'], $lead['currency'] ) ?>&nbsp;</td>
									</tr>
								<?php
								}
								?>
								<tr>
									<?php
									if ( empty( $products['shipping']['name'] ) ) {
										?>
										<td colspan="2" class="emptycell">&nbsp;</td>
									<?php
									}
									?>
									<td class="textright grandtotal"><?php _e( 'Total', 'gravityforms' ) ?></td>
									<td class="grandtotal_amount"><?php echo GFCommon::to_money( $total, $lead['currency'] ) ?></td>
								</tr>
								</tfoot>
							</table>
						</td>
					</tr>

				<?php
				}
			}
			?>
			</tbody>
		</table>
	<?php
	}

	public static function entry_detail_pagination_link( $pos, $label = '', $class = '', $icon = '' ) {

		$href = ! rgblank( $pos ) ? 'href="' . add_query_arg( array( 'pos' => $pos ), remove_query_arg( array( 'pos', 'lid' ) ) ) . '"' : '';
		$class .= ' gf_entry_pagination_link';
		$class .= $pos !== false ? ' gf_entry_pagination_link_active' : ' gf_entry_pagination_link_inactive';

		return '<a ' . $href . ' class="' . $class . '" title="' . $label . '"><i class="fa-lg ' . $icon . '"></i></a></li>';
	}

	public static function payment_details_box( $lead, $form )
	{
		?>
		<!-- PAYMENT BOX -->
		<div id="submitdiv" class="stuffbox">
			<h3>
                <span
					class="hndle"><?php echo $lead['transaction_type'] == 2 ? __( 'Subscription Details', 'gravityforms' ) : __( 'Payment Details', 'gravityforms' ); ?></span>
			</h3>

			<div class="inside">
				<div id="submitcomment" class="submitbox">
					<div id="minor-publishing" style="padding:10px;">
						<?php
						$payment_status = apply_filters( 'gform_payment_status', $lead['payment_status'], $form, $lead );
						if ( ! empty( $payment_status ) ){
							?>
							<div id="gf_payment_status" class="gf_payment_detail">
								<?php echo __( 'Status', 'gravityforms' ) ?>:
								<span id="gform_payment_status"><?php echo $payment_status?></span>
							</div>

							<?php

							$payment_date = apply_filters( 'gform_payment_date', GFCommon::format_date( $lead['payment_date'], false, 'Y/m/d', $lead['transaction_type'] != 2 ), $form, $lead );
							if ( ! empty( $payment_date ) ) {
								?>
								<div id="gf_payment_date" class="gf_payment_detail">
									<?php echo $lead['transaction_type'] == 2 ? __( 'Start Date', 'gravityforms' ) : __( 'Date', 'gravityforms' ) ?>:
									<span id='gform_payment_date'><?php echo $payment_date?></span>
								</div>
							<?php
							}

							$transaction_id = apply_filters( 'gform_payment_transaction_id', $lead['transaction_id'], $form, $lead );
							if ( ! empty( $transaction_id ) ) {
								?>
								<div id="gf_payment_transaction_id" class="gf_payment_detail">
									<?php echo $lead['transaction_type'] == 2 ? __( 'Subscription Id', 'gravityforms' ) : __( 'Transaction Id', 'gravityforms' ); ?>:
									<span id='gform_payment_transaction_id'><?php echo $transaction_id?></span>
								</div>
							<?php
							}

							$payment_amount = apply_filters( 'gform_payment_amount', GFCommon::to_money( $lead['payment_amount'], $lead['currency'] ), $form, $lead );
							if ( ! rgblank( $payment_amount ) ) {
								?>
								<div id="gf_payment_amount" class="gf_payment_detail">
									<?php echo $lead['transaction_type'] == 2 ? __( 'Recurring Amount', 'gravityforms' ) : __( 'Amount', 'gravityforms' ); ?>:
									<span id='gform_payment_amount'><?php echo  $payment_amount?></span>
								</div>
							<?php
							}
						}
						do_action( 'gform_payment_details', $form['id'], $lead );

						?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}