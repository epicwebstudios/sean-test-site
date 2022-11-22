<?


	//-----------------------------------------------
	// epicPlatform CMS
	// (c) Epic Web Studios LLC
	//-----------------------------------------------
	// For the latest releases, please visit:
	// https://github.com/epicwebstudios/epicPlatform
	//-----------------------------------------------


	define( 'ADMIN_PANEL', true );

	$path = explode( '/admin', __DIR__ );
	define( 'CORE_DIR', $path[0].'/core' );

	require_once CORE_DIR.'/core.php';
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
			
			if( $mfa_login ){
				require_once ADMIN_DIR.'/sources/layout/mfa-login.php';
			} else {
				file_get_contents( returnURL().'/cron/sync-accounts.php' );
				require_once ADMIN_DIR.'/sources/layout/login.php';
			}
			
		}
		
	}

