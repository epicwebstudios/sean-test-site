<?


	$directory 		= $_POST['directory'];
	$file_name		= clean_filename( $_POST['file'] );
	$file 			= $directory.$file_name;
	$msg 			= '';


	if( ALLOW_FOLDER_CREATION ){
		if( !file_exists($file) ){
			if( mkdir($file) ){
				$msg .= 'OK';
			} else {
				$msg .= 'Folder  "'.$file_name.'" could not be created.' . "\n";
				$msg .= 'Please try again.';
			}
		} else {
			$msg .= 'Folder  "'.$file_name.'" could not be created.' . "\n";
			$msg .= 'A folder already exists with this name.';
		}
	} else {
		$msg .= 'Folder creation is currently disabled.';
	}

	echo $msg;


