<?

	global $user;
	

	// Processing for when "Save" has been clicked on Edit page.
	if( isset($_POST['edit_sub']) ){
		
		$values = array(
			'omit' 				=> $_POST['omit'],
			'disallow_index'	=> $_POST['disallow_index'],
			'icon' 				=> $_POST['icon'],
			'color'				=> $_POST['color'],
			'thumbnail'			=> $_POST['thumbnail'],
		);
		
		if( $values['icon'] != '' ){
			if(
				( substr($values['icon'], 0, 3) != 'fas' ) &&
				( substr($values['icon'], 0, 3) != 'far' ) &&
				( substr($values['icon'], 0, 3) != 'fal' ) &&
				( substr($values['icon'], 0, 3) != 'fad' )
			){
				$values['icon'] = 'fas '.$values['icon'];
			}
		}
		
		if( $values['thumbnail'] != '' ){
			if(
				( substr($values['thumbnail'], 0, 2) != '//' ) &&
				( substr($values['thumbnail'], 0, 8) != 'https://' ) &&
				( substr($values['thumbnail'], 0, 7) != 'http://' )
			){
				$values['thumbnail'] = '';
			}
		}
		
		if( 
			( $values['omit'] == '0' ) &&
			( $values['disallow_index'] == '0' ) &&
			( $values['icon'] == '' ) &&
			( $values['color'] == '' ) &&
			( $values['thumbnail'] == '' )
		){
			if( $_POST['id'] ){
				mysql_query( "DELETE FROM `file_manager` WHERE `id` = '".$_POST['id']."' LIMIT 1" );
			}
		} else {
		
			if( $_POST['id'] == '' ){
				$values['file_path'] = $_POST['file_path'];
				mysql_query( "INSERT INTO `file_manager` ".query_build_set( $values ) );
			} else {
				mysql_query( "UPDATE `file_manager` ".query_build_set( $values )." WHERE `id` = '".$_POST['id']."' LIMIT 1" );
			}

		}
			
		log_message( 'Settings have been updated successfully!', 'success', 'Settings Updated' );
		update_robots();

		echo '<script type="text/javascript">';
			echo "window.parent.get_directory();";
		echo '</script>';
		
	}

	
