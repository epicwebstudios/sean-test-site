<?

	$directory 	= $_POST['directory'];
	$field_name = 'file'; 

	if( ALLOW_FILE_UPLOAD ){
		if( isset($_FILES[$field_name]) ){

			$error 	= $_FILES[$field_name]['error'];
			
			{
				
				if( !is_array($_FILES[$field_name]['name']) ){
					
					$temp_file 		= $_FILES[$field_name]['tmp_name'];
					$old_file_name 	= $_FILES[$field_name]['name'];
					$new_file_name 	= clean_filename( $old_file_name );
					$ext			= get_extension( $new_file_name );
					
					if( in_array($ext, $valid_types['file']) ){
						$new_file_name 	= upload_filename( $directory, $new_file_name );
						move_uploaded_file( $temp_file, $new_file_name );
						echo 'OK';
					} else {
						echo '"'.$old_file_name.'" could not be uploaded. ".'.$ext.'" files are not allowed.';
					}
					
				} else {
					
					$count = count( $_FILES[$field_name]['name'] );
					
					for( $i=0; $i<$count; $i++ ) {
						
						$temp_file 		= $_FILES[$field_name]['tmp_name'][$i];
						$old_file_name 	= $_FILES[$field_name]['name'][$i];
						$new_file_name 	= clean_filename( $old_file_name );
						$ext			= get_extension( $new_file_name );
					
						if( in_array($ext, $valid_types['file']) ){
							$new_file_name 	= upload_filename( $directory, $new_file_name );
							move_uploaded_file( $temp_file, $new_file_name );
							echo 'OK';
						} else {
						echo '"'.$old_file_name.'" could not be uploaded. ".'.$ext.'" files are not allowed.';
						}
						
					}
					
				}
				
			}

		}
	}

	
