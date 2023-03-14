<?


	if( isset($_POST['revert_sub']) ){
	
		$id = $_POST['id'];
			
		$revision 	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `".$database[0]."` WHERE `id` = '".$id."' LIMIT 1" ) );
		$records 	= json_decode( $revision['records'], true );
		
		$rQ = mysql_query( "SELECT * FROM `".$revision['table']."` WHERE `id` = '".$revision['p_id']."' LIMIT 1" );
		if( mysql_num_rows($rQ) > 0 ){
			
			$r = mysql_fetch_assoc( $rQ );
			create_revision( $r, $revision['table'] );
			
			unset( $records['id'] );
			$set = query_build_set( $records );
			mysql_query( "UPDATE `".$revision['table']."` ".$set." WHERE `id` = '".$revision['p_id']."' LIMIT 1" );
		
			log_message(
				'The current record has been restored to this revision.',
				'success',
				'Record Reverted to Revision'
			);
			
		} else {
			
			$set = query_build_set( $records );
			mysql_query( "INSERT INTO `".$revision['table']."` ".$set );
		
			log_message(
				'The previously deleted record has been restored to this revision.',
				'success',
				'Record Reverted to Revision'
			);
		
		}
	
	}
	
	