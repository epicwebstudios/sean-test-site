<?

	
	// Processing form elements that have been submitted.
	if( isset($_POST['edit_sub']) ){
	
		$id = $_POST['id'];
		$values = array();
		
		
		// -- Set values
		
			$values = array(
				'cache_refresh'	=> $_POST['cache_refresh'],
			);
		
		// -- End set values
		
		
		$set = query_build_set( $values );
			
		mysql_query( "UPDATE `".$database[0]."` ".$set." WHERE `id` = '".$id."' LIMIT 1" );
			
		log_action( 'Edited '.$item );
		log_message( $item_capital.' has been edited successfully.', 'success', $item_capital.' Edited' );
		
	}
	
	
?>




