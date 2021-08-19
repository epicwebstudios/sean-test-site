<?

	
	// Processing form elements that have been submitted.
	if( (isset($_POST['edit_sub'])) || (isset($_POST['add_sub'])) ){
	
		$id = $_POST['id'];
		
		
		// -- Set values
		
			$values = array(
				'menu_id'		=> $_POST['menu_id'],
				'parent_id'		=> $_POST['parent_id_'.$_POST['menu_id']],
				'mobile_only'	=> process_checkbox( 'mobile_only' ),
				'label'			=> $_POST['label'],
				'link_type'		=> $_POST['link_type'],
				'ref_id'		=> $_POST['ref_id_'.$_POST['link_type']],
				'url'			=> $_POST['url'],
				'target'		=> $_POST['target'],
				'status'		=> $_POST['status'],
			);
		
		// -- End set values


	}
	
	
	// Processing for when "Save" has been clicked on Add page.
	if( isset($_POST['add_sub']) ){
		
		if( $allow_add ){
		
			if( $allow_order ){
				$values['order'] = 999999;
			}
			
			$set = query_build_set( $values );
			
			mysql_query( "INSERT INTO `".$database[0]."` ".$set );
			$new_record = mysql_insert_id();
			
			create_revision( $new_record, $database[0] );
			log_action( 'Added '.$item.' "'.$values[$log_item].'"' );
			log_message( 'The '.$item.' "'.$values[$log_item].'" has been added successfully. <a href="?a='.$_GET['a'].'&act=edit&i='.$new_record.'">Click here to edit the new '.$item.'</a>', 'success', $item_capital.' Added' ); 
	
			if( $allow_order ){
				reorder_all( $database[0], "`menu_id` = '".$values['menu_id']."' AND `parent_id` = '".$values['parent_id']."'" );
			}
		
		} else {
			log_message( 'You do not have permission to add a '.$item.'.', 'error', 'Error' );
		}

	}
	
	
	// Processing for when "Save" has been clicked on Edit page.
	if( isset($_POST['edit_sub']) ){
		
		$record = get_item( $_POST['id'], $database[0] );
		
		if( ($record['id']) && ($allow_edit) ){
			
			if( $record['menu_id'] != $values['menu_id'] ){
				update_menu_id( $record['id'], $values['menu_id'] );
				$values['order'] = 999999;
			}
			
			if( $record['parent_id'] != $values['parent_id'] ){
				$values['order'] = 999999;
			}
			
			$set = query_build_set( $values );
			mysql_query( "UPDATE `".$database[0]."` ".$set." WHERE `id` = '".$id."' LIMIT 1" );
			
			reorder_all( $database[0], "`menu_id` = '".$record['menu_id']."' AND `parent_id` = '".$record['parent_id']."'" );
			reorder_all( $database[0], "`menu_id` = '".$values['menu_id']."' AND `parent_id` = '".$values['parent_id']."'" );
			
			create_revision( $id, $database[0] );
			log_action( 'Edited '.$item.' "'.$values[$log_item].'"' );
			log_message( 'The '.$item.' "'.$values[$log_item].'" has been edited successfully.', 'success', $item_capital.' Edited' );
		
		} else {
			log_message( 'Could not locate '.$item.' you attempted to edit or your do not have permission to edit this '.$item.'.', 'error', 'Error' );
		}
		
	}
	

	// Processing for when "Delete" has been clicked.
	if( $_GET['act'] == 'delete' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		
		if( ($record['id']) && ($allow_delete) ){
			
			$query = mysql_query( "DELETE FROM `".$database[0]."` WHERE `id` = '".$record['id']."' LIMIT 1" );
			
			log_action( 'Deleted '.$item.' "'.$record[$log_item].'"' );
			log_message( 'The '.$item.' "'.$record[$log_item].'" has been deleted successfully.', 'success', $item_capital.' Deleted' );
			
			if( $allow_order ){
				reorder_all( $database[0], "`menu_id` = '".$record['menu_id']."' AND `parent_id` = '".$record['parent_id']."'" );
			}
			
		} else {
			log_message( 'Could not locate '.$item.' you attempted to delete or your do not have permission to delete this '.$item.'.', 'error', 'Error' );
		}
		
	}


	// This reorders a single record as requested.
	if( $_GET['act'] == 'order' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		
		if( ($allow_order) && ($record['id']) ){
			reorder_one( $database[0], $record['id'], $_GET['o'], "`menu_id` = '".$record['menu_id']."' AND `parent_id` = '".$record['parent_id']."'" );
			log_action( 'Re-ordered '.$item.' "'.$record[$log_item].'"' );
			log_message( 'The '.$item.' "'.$record[$log_item].'" has been re-ordered successfully.', 'success', $item_capital.' Re-ordered' );
		} else {
			log_message( 'Could not locate '.$item.' you attempted to re-order or your do not have permission to re-order this '.$item.'.', 'error', 'Error' );
		}
		
	}


	// This duplicates any specific record as requested.
	if( $_GET['act'] == 'duplicate' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		
		if( ($allow_duplicate) && ($record['id']) ){
			
			unset( $record['id'] );
			$base_name = $record[$log_item];
			$record[$log_item] .= ' (Duplicate)';
			
			$set = query_build_set( $record );
			
			mysql_query( "INSERT INTO `".$database[0]."` ".$set );
			$new_record = mysql_insert_id();
			log_action( 'Duplicated '.$item.' "'.$base_name.'"' );
			redirect( '?a='.$_GET['a'].'&act=edit&i='.$new_record.'&duplicated=1' );
			die();
			
		} else {
			log_message( 'Could not locate '.$item.' you attempted to duplicate or your do not have permission to duplicate this '.$item.'.', 'error', 'Error' );
		}
		
	}


	// Display successful duplication message, if duplicated.
	if( $_GET['duplicated'] == '1' ){
		$record = get_item( $_GET['i'], $database[0] );
		$record[$log_item] = str_replace( ' (Duplicate)', '', $record[$log_item] );
		log_message( 'The '.$item.' "'.$record[$log_item].'" has been duplicated successfully.', 'success', $item_captial.' Duplicated' );
	}
	
	
?>




