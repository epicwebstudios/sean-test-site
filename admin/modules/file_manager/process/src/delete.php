<?


	$directory 	= $_POST['directory'];
	$file_name	= $_POST['file'];
	$file 		= $directory.$file_name;
	$msg 		= '';


	if( ALLOW_DELETE ){
		if( file_exists($file) ){
			if( is_dir($file) ){
				if( rmdir($file) ){
					$msg .= 'OK';
				} else {
					$msg .= 'Folder "'.$file_name.'" could not be deleted.' . "\n";
					$msg .= 'Folders must be empty in order to be deleted.';
				}
			} else {
				if( unlink( $file ) ){
					$msg .= 'OK';
				} else {
					$msg .= 'File  "'.$file_name.'" could not be deleted.' . "\n";
					$msg .= 'Please try again.';
				}
			}
		} else {
			$msg .= 'File  "'.$file_name.'" could not be deleted.' . "\n";
			$msg .= 'This file has already been deleted or could not be found.';
		}
	} else {
		$msg .= 'File deletion is currently disabled.';
	}

	echo $msg;


