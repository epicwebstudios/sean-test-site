<?


	$template_dir	= BASE_DIR.'/templates/';
	$template_files = array();
	
	$files = scandir( $template_dir );
	foreach( $files as $file ){
		if( !is_dir($template_dir.$file) ){
			$template_files[$file] = $file;
		}
	}
	
	
	$blocks = kv_array( $database[2], 'id', 'name' );


