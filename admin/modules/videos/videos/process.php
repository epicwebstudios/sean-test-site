<?

	
	// Processing form elements that have been submitted.
	if( (isset($_POST['edit_sub'])) || (isset($_POST['add_sub'])) ){
	
		$id = $_POST['id'];
		
		// Set the table values for add / edit.
		
		$values = array(
			'name'		            => $_POST['name'],
			'status'	            => $_POST['status'],
			'video_upload'			=> process_file( 'video_upload', '/videos/' ),
			'permalink'				=> $_POST['permalink'],
			'banner_title'			=> $_POST['banner_title'],
			'banner_subtitle'		=> $_POST['banner_subtitle'],
			'video_type'			=> $_POST['video_type'],
			'youtube_link'			=> $_POST['youtube_link'],
			'order'					=> $_POST['order'],
			'description'			=> $_POST['description'],
			'vid_cat'				=> $_POST['vid_cat'],
		);

	}
	
	
	// Processing for when "Save" has been clicked on Add page.
	if( isset($_POST['add_sub']) ){
		
		if( $allow_add ){
		
			if( $allow_order ){
				$values['order'] = 999999;
			}
			
			mysql_query( "INSERT INTO `".$database[0]."` ".query_build_set( $values ) );
			$new_record = mysql_insert_id();
			
			create_revision( $new_record, $database[0] );
			log_action( 'Added '.$item.' "'.$values[$log_item].'"' );
			
			log_message(
				'The '.$item.' "'.$values[$log_item].'" has been added successfully. <a href="?a='.$_GET['a'].'&act=edit&i='.$new_record.'">Click here to edit the new '.$item.'</a>',
				'success',
				$item_capital.' Added'
			); 
	
			if( $allow_order ){
				reorder_all( $database[0] );
			}
		
		} else {
			log_message(
				'You do not have permission to add a '.$item.'.',
				'error',
				'Error'
			);
		}

	}
	
	
	// Processing for when "Save" has been clicked on Edit page.
	if( isset($_POST['edit_sub']) ){
		
		$record = get_item( $_POST['id'], $database[0] );
		
		if( ($record['id']) && ($allow_edit) ){
			
			mysql_query( "UPDATE `".$database[0]."` ".query_build_set( $values )." WHERE `id` = '".$id."' LIMIT 1" );
			
			create_revision( $id, $database[0] );
			log_action( 'Edited '.$item.' "'.$values[$log_item].'"' );
			log_message(
				'The '.$item.' "'.$values[$log_item].'" has been edited successfully.',
				'success',
				$item_capital.' Edited'
			);
		
		} else {
			log_message(
				'Could not locate '.$item.' you attempted to edit or your do not have permission to edit this '.$item.'.',
				'error',
				'Error'
			);
		}
		
	}
	

	// Processing for when "Delete" has been clicked.
	if( $_GET['act'] == 'delete' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		
		if( ($record['id']) && ($allow_delete) ){
			
			$query = mysql_query( "DELETE FROM `".$database[0]."` WHERE `id` = '".$record['id']."' LIMIT 1" );
			
			log_action( 'Deleted '.$item.' "'.$record[$log_item].'"' );
			log_message(
				'The '.$item.' "'.$record[$log_item].'" has been deleted successfully.',
				'success',
				$item_capital.' Deleted'
			);
			
			if( $allow_order ){
				reorder_all( $database[0] );
			}
			
		} else {
			log_message(
				'Could not locate '.$item.' you attempted to delete or your do not have permission to delete this '.$item.'.',
				'error',
				'Error'
			);
		}
		
	}


	// This reorders a single record as requested.
	if( $_GET['act'] == 'order' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		
		if( ($allow_order) && ($record['id']) ){
			reorder_one( $database[0], $record['id'], $_GET['o'] );
			log_action( 'Reordered '.$item.' "'.$record[$log_item].'"' );
			log_message(
				'The '.$item.' "'.$record[$log_item].'" has been reordered successfully.',
				'success',
				$item_capital.' Reordered'
			);
		} else {
			log_message(
				'Could not locate '.$item.' you attempted to reorder or your do not have permission to reorder this '.$item.'.',
				'error',
				'Error'
			);
		}
		
	}


	// This duplicates any specific record as requested.
	if( $_GET['act'] == 'duplicate' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		
		if( ($allow_duplicate) && ($record['id']) ){
			
			unset( $record['id'] );
			$base_name = $record[$log_item];
			$record[$log_item] .= ' (Duplicate)';
			
			if( $allow_order ){
				$record['order'] = 999999;
			}
			
			mysql_query( "INSERT INTO `".$database[0]."` ".query_build_set( $record ) );
			$new_record = mysql_insert_id();
			
			if( $allow_order ){
				reorder_all( $database[0] );
			}
			
			log_action( 'Duplicated '.$item.' "'.$base_name.'"' );
			redirect( '?a='.$_GET['a'].'&act=edit&i='.$new_record.'&duplicated=1' );
			
			die();
			
		} else {
			log_message(
				'Could not locate '.$item.' you attempted to duplicate or your do not have permission to duplicate this '.$item.'.',
				'error',
				'Error'
			);
		}
		
	}


	// Display successful duplication message, if duplicated.
	if( $_GET['duplicated'] == '1' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		$record[$log_item] = str_replace( ' (Duplicate)', '', $record[$log_item] );
		
		log_message(
			'The '.$item.' "'.$record[$log_item].'" has been duplicated successfully.',
			'success',
			$item_captial.' Duplicated'
		);
		
	}
	
	
