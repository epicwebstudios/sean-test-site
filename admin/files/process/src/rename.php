<?

	$directory 	= $_POST['directory'];
	$filename	= $_POST['filename'];
	$rename_to	= $_POST['rename_to'];
	$files 		= array();

	$old_file 	= $directory.$filename;
	$new_file	= $directory.$rename_to;

	if( ALLOW_RENAME ){
		if( file_exists($old_file) ){
			if( !file_exists($new_file) ){
				rename( $old_file, $new_file );
				echo 'OK';
			} else {
				echo 'ERROR';
			}
		}
	}
