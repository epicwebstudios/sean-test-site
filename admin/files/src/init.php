<?

	$site_root = explode( '/admin', dirname(__FILE__) );
	define( 'SITE_ROOT', $site_root[0] );

	require_once SITE_ROOT.'/core/php/functions/mysql.compatibility.php';
	require_once SITE_ROOT.'/sources/php/db.config.php';

	$connect = @mysql_connect( $db['host'], $db['user'], $db['pass'] ) or $connect = false;
	@mysql_select_db( $db['db'], $connect );

	require_once __DIR__.'/../config.php';
	require_once __DIR__.'/functions.php';

	// Get settings...

		$settings = config_settings();

		$display_type = $settings['display_type'];

		$allow_folder_creation	= false;
		$allow_file_upload		= false;
		$allow_rename			= false;
		$allow_delete			= false;
		$allow_overwrite		= false;

		if( $settings['allow_folder_creation'] ){ $allow_folder_creation = true; }
		if( $settings['allow_file_upload'] ){ $allow_file_upload = true; }
		if( $settings['allow_rename'] ){ $allow_rename = true; }
		if( $settings['allow_delete'] ){ $allow_delete = true; }
		if( $settings['allow_overwrite'] ){ $allow_overwrite = true; }
		
		$valid_types = array( 'image' => array(), 'media' => array(), 'file' => array() );

		$types = $settings['image_types'];
		$types = explode( ',', $types );
		foreach( $types as $type ){
			$type = trim( $type );
			$valid_types['image'][] = $type;
		}

		$types = $settings['media_types'];
		$types = explode( ',', $types );
		foreach( $types as $type ){
			$type = trim( $type );
			$valid_types['media'][] = $type;
		}

		$types = $settings['file_types'];
		$types = explode( ',', $types );
		foreach( $types as $type ){
			$type = trim( $type );
			$valid_types['file'][] = $type;
		}

		$valid_types['file'] = array_merge( $valid_types['image'], $valid_types['media'], $valid_types['file'] );
	
		$custom = config_custom_icons();

		$omit_files 	= $custom['omit_files'];
		$custom_icons 	= $custom['custom_icons'];

	// ---------------

	define( 'SITE_URL', 				site_url() );
	define( 'BROWSER_URL', 				SITE_URL.'/admin/files/' );
	define( 'BROWSER_TYPE', 			$_GET['type'] );
	define( 'CALLBACK', 				$_GET['callback'] );
	define( 'DISPLAY_TYPE', 			config_display_type() );
	define( 'ROOT_DIR', 				config_root_dir() );
	define( 'BASE_DIR', 				config_base_dir() );
	define( 'BASE_URL', 				config_base_url() );
	define( 'DESCRIPTION', 				config_description() );
	define( 'CURRENT_DIR', 				config_current_dir() );
	define( 'CURRENT_FILE', 			config_current_file() );
	define( 'ALLOW_FOLDER_CREATION',	$allow_folder_creation );
	define( 'ALLOW_FILE_UPLOAD', 		$allow_file_upload );
	define( 'ALLOW_RENAME', 			$allow_rename );
	define( 'ALLOW_DELETE', 			$allow_delete );
	define( 'ALLOW_OVERWRITE',			$allow_overwrite );


	if( !file_exists(BASE_DIR) ){
		$error = 'The default directory ('.BASE_DIR.') does not exist and could not be loaded.';
		require dirname( __FILE__ ).'/error.php';
		die();
	}

