<?

	$directory 	= $_POST['directory'];
	$filename	= $_POST['filename'];
	$files 		= array();

	$file = $directory.$filename;

	if( ALLOW_DELETE ){
		if( file_exists($file) ){
			if( is_dir($file) ){
				if( rmdir($file) ){
					echo 'OK';
				} else {
					echo 'ERROR';
				}
			} else {
				unlink( $file );
				echo 'OK';
			}
		}
	}

	
