<?


	$directory 		= $_POST['directory'];
	$o_file_name	= $_POST['file'];
	$n_file_name	= clean_filename( $_POST['rename_to'] );
	$o_file 		= $directory.$o_file_name;
	$n_file			= $directory.$n_file_name;
	$msg 			= '';


	if( ALLOW_RENAME ){
		if( file_exists($o_file) ){
			if( !file_exists($n_file) ){
				if( rename($o_file, $n_file) ){
					$msg .= 'OK';
				} else {
					$msg .= 'File  "'.$o_file_name.'" could not be renamed.' . "\n";
					$msg .= 'Please try again.';
				}
			} else {
				$msg .= 'File "'.$o_file_name.'" could not be renamed to "'.$n_file_name.'".' . "\n";
				$msg .= 'A file or folder already exists with this name.';
			}
		} else {
			$msg .= 'File  "'.$o_file_name.'" could not be renamed.' . "\n";
			$msg .= 'This file or folder has been deleted or could not be found.';
		}
	} else {
		$msg .= 'File renaming is currently disabled.';
	}

	echo $msg;


