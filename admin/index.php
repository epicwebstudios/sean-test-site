<?

	//---------------------------------------- 
	// epicPlatform
	// (c) Epic WebStudios LLC
	//----------------------------------------
	// For the latest releases, please visit:
	// http://epicwebstudios.com/platform
	//----------------------------------------
	
	define( 'ADMIN_DIR', __DIR__ );

	require_once ADMIN_DIR.'/sources/php/init.php';

	if( $success != 1 ){
		if( isLoggedIn() ){
			$user = getUser( $_COOKIE['admin_user'] );
			date_default_timezone_set( $user['timezone'] );
			log_activity();
			require_once ADMIN_DIR.'/sources/layout/wrapper.php'; 
		} else if( $_GET['a'] == 'reset' ){
			require_once ADMIN_DIR.'/sources/layout/reset-account.php'; 
		} else {
			file_get_contents( returnURL().'/cron/sync-accounts.php' );
			require_once ADMIN_DIR.'/sources/layout/login.php';
		}
	}

