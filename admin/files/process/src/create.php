<?

	$directory	= $_POST['directory'];
	$filename	= clean_filename( $_POST['filename'] );

	$folder = $directory.$filename;

	if( ALLOW_FOLDER_CREATION ){
		if( file_exists($folder) ){
			echo 'ERROR';
		} else {
			mkdir( $folder );
			echo 'OK';
		}
	} else {
		echo 'ERROR';
	}

	
