<?

	$directory 	= $_POST['directory'];
	$type		= $_POST['type'];
	$files 		= array();

	if( file_exists($directory) ){
		$files = get_files( $directory, $type );
	}

	echo json_encode( $files );
