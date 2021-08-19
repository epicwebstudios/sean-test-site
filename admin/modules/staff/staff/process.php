<?

	
	// Processing form elements that have been submitted.
	if( (isset($_POST['edit_sub'])) || (isset($_POST['add_sub'])) ){
	
		$id = $_POST['id'];
		
		
		// -- Set values
		
			$values = array(
				'category'		=> $_POST['category'],
				'permalink'		=> $_POST['permalink'],
				'first'			=> $_POST['first'],
				'middle'		=> $_POST['middle'],
				'last'			=> $_POST['last'],
				'position'		=> $_POST['position'],
				'department'	=> $_POST['department'],
				'email'			=> $_POST['email'],
				'phone'			=> $_POST['phone'],
				'fax'			=> $_POST['fax'],
				'bio'			=> $_POST['bio'],
				'social'		=> $_POST['social'],
				'photo'			=> process_file( 'photo', '/staff/' ),
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
			
			$values['name'] = $values['first'].' '.$values['middle'].' '.$values['last'];
			
			create_revision( $new_record, $database[0] );
			log_action( 'Added '.$item.' "'.$values[$log_item].'"' );
			log_message( 'The '.$item.' "'.$values[$log_item].'" has been added successfully. <a href="?a='.$_GET['a'].'&act=edit&i='.$new_record.'">Click here to edit the new '.$item.'</a>', 'success', $item_capital.' Added' ); 
	
			if( $allow_order ){
				reorder_all( $database[0], "`category` = '".$values['category']."'" );
			}
		
		} else {
			log_message( 'You do not have permission to add a '.$item.'.', 'error', 'Error' );
		}

	}
	
	
	// Processing for when "Save" has been clicked on Edit page.
	if( isset($_POST['edit_sub']) ){
		
		$record = get_item( $_POST['id'], $database[0] );
		
		if( ($record['id']) && ($allow_edit) ){
			
			if( $allow_order ){
				if( $values['category'] != $record['category'] ){
					$values['order'] == '999999';
				}
			}
			
			$set = query_build_set( $values );
			
			mysql_query( "UPDATE `".$database[0]."` ".$set." WHERE `id` = '".$id."' LIMIT 1" );
			
			$values['name'] = $values['first'].' '.$values['middle'].' '.$values['last'];
			
			reorder_all( $database[0], "`category` = '".$record['category']."'" );
			reorder_all( $database[0], "`category` = '".$values['category']."'" );
			
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
		$record['name'] = $record['first'].' '.$record['middle'].' '.$record['last'];
		
		if( ($record['id']) && ($allow_delete) ){
			
			$query = mysql_query( "DELETE FROM `".$database[0]."` WHERE `id` = '".$record['id']."' LIMIT 1" );
			
			log_action( 'Deleted '.$item.' "'.$record[$log_item].'"' );
			log_message( 'The '.$item.' "'.$record[$log_item].'" has been deleted successfully.', 'success', $item_capital.' Deleted' );
			
			if( $allow_order ){
				reorder_all( $database[0], "`category` = '".$record['category']."'" );
			}
			
		} else {
			log_message( 'Could not locate '.$item.' you attempted to delete or your do not have permission to delete this '.$item.'.', 'error', 'Error' );
		}
		
	}


	// This reorders a single record as requested.
	if( $_GET['act'] == 'order' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		$record['name'] = $record['first'].' '.$record['middle'].' '.$record['last'];
		
		if( ($allow_order) && ($record['id']) ){
			reorder_one( $database[0], $record['id'], $_GET['o'], "`category` = '".$record['category']."'" );
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




