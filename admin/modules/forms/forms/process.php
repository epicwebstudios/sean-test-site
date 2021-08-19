<?

	
	// Processing form elements that have been submitted.
	if( (isset($_POST['edit_sub'])) || (isset($_POST['add_sub'])) ){
	
		$id = $_POST['id'];
		
		
		// -- Set values
		
			$values = array(
				'name'			        => $_POST['name'],
				'button_text'	        => $_POST['button_text'],
				'log_field'		        => $_POST['log_field'],
				'description'	        => $_POST['description'],
				'thank_you'		        => $_POST['thank_you'],
				'email_to'		        => $_POST['email_to'],
				'lead_capture'	        => $_POST['lead_capture'],
				'status'		        => $_POST['status'],
                'recaptcha'             => $_POST['recaptcha'],
                'recaptcha_site_key'    => $_POST['recaptcha_site_key'],
                'recaptcha_secret_key'  => $_POST['recaptcha_secret_key']
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
				reorder_all( $database[0] );
			}
		
		} else {
			log_message( 'You do not have permission to add a '.$item.'.', 'error', 'Error' );
		}

	}
	
	
	// Processing for when "Save" has been clicked on Edit page.
	if( isset($_POST['edit_sub']) ){
		
		$record = get_item( $_POST['id'], $database[0] );
		
		if( ($record['id']) && ($allow_edit) ){
			
			$set = query_build_set( $values );
			
			mysql_query( "UPDATE `".$database[0]."` ".$set." WHERE `id` = '".$id."' LIMIT 1" );
			
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
				reorder_all( $database[0] );
			}
			
		} else {
			log_message( 'Could not locate '.$item.' you attempted to delete or your do not have permission to delete this '.$item.'.', 'error', 'Error' );
		}
		
	}


	// This reorders a single record as requested.
	if( $_GET['act'] == 'order' ){
		
		$record = get_item( $_GET['i'], $database[0] );
		
		if( ($allow_order) && ($record['id']) ){
			reorder_one( $database[0], $record['id'], $_GET['o'] );
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
			
			$values = $record;
			unset( $values['id'] );
			$values[$log_item] .= ' (Duplicate)';
			
			$set = query_build_set( $values );
			mysql_query( "INSERT INTO `".$database[0]."` ".$set );
			$new_record = mysql_insert_id();
			
			$rQ = mysql_query( "SELECT * FROM `".$database[1]."` WHERE `form` = '".$record['id']."' ORDER BY `id` ASC" );
			while( $r = mysql_fetch_assoc($rQ) ){
				
				$values = $r;
				unset( $values['id'] );
				$values['form'] = $new_record;
				
				$set = query_build_set( $values );
				mysql_query( "INSERT INTO `".$database[1]."` ".$set );
				
			}
			
			log_action( 'Duplicated '.$item.' "'.$record['name'].'"' );
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




