<?

	
	// Processing form elements that have been submitted.
	if( isset($_POST['edit_sub']) ){
		
		$path 	= BASE_DIR.'/admin/tmp/';
		$file 	= basename( $_FILES['package']['name'] );
		$target = $path.$file;
		
		if( !is_dir($path) ){
			mkdir( $path );
		}
		
		if( substr($file, -4) == '.zip' ){
			if( move_uploaded_file($_FILES['package']['tmp_name'], $target) ){
				
				$zip 	= new ZipArchive;
				$open 	= $zip->open( $target );
				if( $open === true ){
						
					$zip->extractTo( BASE_DIR.'/' );
					$zip->close();
					
					$message = 'The package <b>'.$file.'</b> has been uploaded and extracted successfully.';
						
					$sql_file = BASE_DIR.'/admin/tmp/install.sql';
					$php_file = BASE_DIR.'/admin/tmp/install.php';
						
					if( file_exists($sql_file) ){
						$message .= '<div><i>&mdash; <b>SQL</b> installation file executed.</i></div>';
						$sql_open = fopen( $sql_file, "r+" );
						$sql_contents = fread( $sql_open, filesize($sql_file) );
						require BASE_DIR.'/sources/init/db.config.php';
						$mysqli = new mysqli( $db['host'], $db['user'], $db['pass'], $db['db'] );
						$mysqli->multi_query($sql_contents);
						unlink( $sql_file );
					}
						
					if( file_exists($php_file) ){
						$message .= '<div><i>&mdash; <b>PHP</b> installation file executed.</i></div>';
						require $php_file;
						unlink( $php_file );
					}
					
					log_message( $message, 'success', 'Package Upload Successful' );
					
				} else {
					log_message( 'The package you uploaded could not be extracted. Please try again.', 'error', 'Extraction Error' );
				}
						
				if( file_exists($target) ){
					unlink( $target );
				}
				
			} else {
				log_message( 'The package you selected could not be uploaded. Please try again.', 'error', 'Upload Error' );
			}
		} else {
			log_message( 'You must select a ZIP package to upload.', 'error', 'Package Error' );
		}
		
	}
	
	
?>




