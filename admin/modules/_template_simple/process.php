<?

	
	// Processing form elements that have been submitted.
	if( isset($_POST['edit_sub']) ){
	
		$id = $_POST['id'];
		$values = array();
		
		
		// Set the table values for add / edit.
		
		$values = array(
			'name'		=> $_POST['name'],
			'image'		=> process_file( 'image' ),
			'status'	=> $_POST['status'],
		);
		
			
		mysql_query( "UPDATE `".$database[0]."` ".query_build_set( $values )." WHERE `id` = '".$id."' LIMIT 1" );
			
		log_action( 'Edited '.$item );
		
		log_message(
			$item_capital.' has been edited successfully.',
			'success',
			$item_capital.' Edited'
		);
		
	}
	
