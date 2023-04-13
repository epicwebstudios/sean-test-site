<?

	
	// Processing form elements that have been submitted.
	if( isset($_POST['edit_sub']) ){
	
		$id = $_POST['id'];
		$values = array();
		
		
		// -- Set values
		
        $values = array(
            'per_page'		=> $_POST['per_page'],
        );

        $share_options="";
        $share_options.= (!empty($_POST['facebook'])) ? $_POST['facebook']."," : "";
        $share_options.= (!empty($_POST['twitter'])) ? $_POST['twitter']."," : "";
        $share_options.= (!empty($_POST['linkedin'])) ? $_POST['linkedin']."," : "";
        $share_options.= (!empty($_POST['reddit'])) ? $_POST['reddit']."," : "";
        $share_options.= (!empty($_POST['pinterest'])) ? $_POST['pinterest']."," : "";
        $share_options.= (!empty($_POST['email'])) ? $_POST['email']."," : "";
        $share_options = trim($share_options,',');

        $values['share_options'] = $share_options;
		
		// -- End set values
		
		
		$set = query_build_set( $values );
		
		mysql_query( "UPDATE `".$database[0]."` ".$set." WHERE `id` = '".$id."' LIMIT 1" );
			
		log_action( 'Edited '.$item );
		log_message( $item_capital.' has been edited successfully.', 'success', $item_capital.' Edited' );
		
	}
	
	
?>




