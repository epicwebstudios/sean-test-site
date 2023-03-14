<?
	
	$fm_settings = mysql_fetch_assoc( mysql_query( "SELECT `file_browser` FROM `settings` WHERE `id` = '1' LIMIT 1" ) );
	$fm_settings = json_decode( $fm_settings['file_browser'], true );

	$display_type = $fm_settings['display_type'];

	$allow_folder_creation	= false;
	$allow_file_upload		= false;
	$allow_rename			= false;
	$allow_delete			= false;
	$allow_overwrite		= false;

	if( $fm_settings['allow_folder_creation'] ){ $allow_folder_creation = true; }
	if( $fm_settings['allow_file_upload'] ){ $allow_file_upload = true; }
	if( $fm_settings['allow_rename'] ){ $allow_rename = true; }
	if( $fm_settings['allow_delete'] ){ $allow_delete = true; }
	if( $fm_settings['allow_overwrite'] ){ $allow_overwrite = true; }

	define( 'ALLOW_FOLDER_CREATION',	$allow_folder_creation );
	define( 'ALLOW_FILE_UPLOAD', 		$allow_file_upload );
	define( 'ALLOW_RENAME', 			$allow_rename );
	define( 'ALLOW_DELETE', 			$allow_delete );
	define( 'ALLOW_OVERWRITE',			$allow_overwrite );

	$valid_types = array( 'image' => array(), 'media' => array(), 'file' => array() );

	$types = $fm_settings['image_types'];
	$types = explode( ',', $types );
	foreach( $types as $type ){
		$type = trim( $type );
		$valid_types['image'][] = $type;
	}

	$types = $fm_settings['media_types'];
	$types = explode( ',', $types );
	foreach( $types as $type ){
		$type = trim( $type );
		$valid_types['media'][] = $type;
	}

	$types = $fm_settings['file_types'];
	$types = explode( ',', $types );
	foreach( $types as $type ){
		$type = trim( $type );
		$valid_types['file'][] = $type;
	}

	$valid_types['file'] = array_merge( $valid_types['image'], $valid_types['media'], $valid_types['file'] );

