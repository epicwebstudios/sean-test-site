<?


	header( 'X-XSS-Protection: 0' );


	// -- Start Dark Mode Toggling

		$dm_params = array();
		foreach( $_GET as $k => $v ){ if( $k != 'set_dark_mode' ){ $dm_params[$k] = $v; } }

		if( $_GET['set_dark_mode'] != '' ){
			setcookie( 'ews_dark_mode', $_GET['set_dark_mode'], (time()+(180*86400)), '/' );
			header( 'Location: ?'.http_build_query($dm_params) );
			die();
		}

	// -- End Dark Mode Toggling


	if( session_status() === PHP_SESSION_NONE ){
		session_start();
	}

	$path = explode( '/admin', __DIR__ );
	define( 'BASE_DIR', $path[0] );
	
	require_once BASE_DIR.'/sources/init/connect.php';
	require_once BASE_DIR.'/sources/init/global.php';
	require_once ADMIN_DIR.'/sources/php/functions.php';
	require_once ADMIN_DIR.'/sources/php/photo_editor.php';
	
	// Force Site URL
	
		$site_domain 	= $settings['url'];
		$site_domain 	= str_replace( '://', '++', $site_domain );
		$parts			= explode( '/', $site_domain );
		$site_domain 	= str_replace( '++', '://', $parts[0] );
		
		$url = 'http://';
		if( $_SERVER['HTTPS'] == 'on' ){
			$url = 'https://';
		}
		$url .= $_SERVER['HTTP_HOST'];
	
		if( $site_domain != $url ){
			header( 'Location: '.$site_domain.$_SERVER['REQUEST_URI'] );
		}
	
	$system 	= systemInfo();
	$messages 	= array();

