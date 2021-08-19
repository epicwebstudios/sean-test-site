<?

	
	// Processing form elements that have been submitted.
	if( isset($_POST['edit_sub']) ){
	
		$content = $_POST['content'];
		file_put_contents( BASE_DIR.'/.htaccess', strip_all_slashes($content) );
			
		log_action( 'Edited '.$item );
		log_message( $item_capital.' has been edited successfully.', 'success', $item_capital.' Edited' );
		
	}
	
	
?>




