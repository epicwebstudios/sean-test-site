<?

	//---------------------------------------- 
	// epicPlatform
	// (c) Epic WebStudios LLC
	//----------------------------------------
	// For the latest releases, please visit:
	// http://epicwebstudios.com/platform
	//----------------------------------------

	header( 'X-XSS-Protection: 0' );

	if (session_status() === PHP_SESSION_NONE)
		session_start();
	
	define( 'ADMIN_DIR', __DIR__ );
	$path = explode( '/admin', __DIR__ );
	$path = $path[0];
	define( 'BASE_DIR', $path );
	
	include BASE_DIR.'/sources/init/connect.php';
	require BASE_DIR.'/sources/init/global.php';
	require ADMIN_DIR.'/sources/php/functions.php';
	require ADMIN_DIR.'/sources/php/photo_editor.php';
	
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

	if( $success != 1 ){
		if( isLoggedIn() ){
			$user = getUser( $_COOKIE['admin_user'] );
			date_default_timezone_set( $user['timezone'] );
			log_activity();
			require ADMIN_DIR.'/sources/layout/wrapper.php'; 
		} else if( $_GET['a'] == 'reset' ){
			require ADMIN_DIR.'/sources/layout/reset-account.php'; 
		} else {
			file_get_contents( returnURL().'/cron/sync-accounts.php' );
			require ADMIN_DIR.'/sources/layout/login.php';
		}
	}

?>

