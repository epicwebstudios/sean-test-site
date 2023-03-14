<?


	//-----------------------------------------------
	// epicPlatform CMS
	// (c) Epic Web Studios LLC
	//-----------------------------------------------
	// For the latest releases, please visit:
	// https://github.com/epicwebstudios/epicPlatform
	//-----------------------------------------------


	// Set epicPlatform version.

		define( 'EP_VERSION', '3.9' );


	// Start session.

		if( session_status() === PHP_SESSION_NONE ){
			session_start();
		}


	// Enable debugging.

		if( ($_GET['debug'] == 1) || ($_GET['debug'] == 2) ){
			ini_set( 'display_errors', 1 );
		}

		if( $_GET['debug'] == 2 ){
			error_reporting(E_ALL);
		}


	// Set default timezone.

		date_default_timezone_set( 'America/New_York' );


	// Define constants.

		if( !defined('CORE_DIR') ){
			define( 'CORE_DIR', __DIR__ );
		}

		if( !defined('BASE_DIR') ){
			$path = explode( '/core', CORE_DIR );
			define( 'BASE_DIR', $path[0] );
		}

		if( !defined('ADMIN_DIR') ){
			define( 'ADMIN_DIR', BASE_DIR.'/admin' );
		}

		if( !defined('ADMIN_PANEL') ){
			define( 'ADMIN_PANEL', false );
		}

		if( !defined('IP_ADDRESS') ){
			if( $_SERVER['HTTP_X_FORWARDED_FOR'] ){
				define( 'IP_ADDRESS', $_SERVER['HTTP_X_FORWARDED_FOR'] );
			} else {
				define( 'IP_ADDRESS', $_SERVER['REMOTE_ADDR'] );
			}
		}


	// Force installation (if present).

		if( (file_exists(BASE_DIR.'/install/')) && (!file_exists(BASE_DIR.'/sources/php/db.config.php')) ){
			header( 'Location: install/' );
			die();
		}


	// Pull in any compatibility files.

		require_once CORE_DIR.'/php/functions/php.compatibility.php';
		require_once CORE_DIR.'/php/functions/mysql.compatibility.php';


	// Establish database connection.

		if( !file_exists(BASE_DIR.'/sources/php/db.config.php') ){
			require BASE_DIR.'/modules/errors/database.php';
			die();
		}

		require_once BASE_DIR.'/sources/php/db.config.php';
		
		$connect = @mysql_connect( $db['host'], $db['user'], $db['pass'] ) or $connect = false;
		
		if( !$connect ){
			require BASE_DIR.'/modules/errors/database.php';
			die();
		}

		@mysql_select_db( $db['db'], $connect );


	// Pull in functions and classes.

		require_once CORE_DIR.'/php/classes/csvexport.class.php';
		require_once CORE_DIR.'/php/classes/formfield.class.php';
		require_once CORE_DIR.'/php/classes/ico.class.php';
		require_once CORE_DIR.'/php/classes/mailer.class.php';
		require_once CORE_DIR.'/php/classes/search.class.php';
		require_once CORE_DIR.'/php/classes/searchcron.class.php';
		require_once CORE_DIR.'/php/classes/share.class.php';

		require_once CORE_DIR.'/php/functions/cms.php';
		require_once CORE_DIR.'/php/functions/curl.php';
		require_once CORE_DIR.'/php/functions/dates.php';
		require_once CORE_DIR.'/php/functions/helpers.php';
		require_once CORE_DIR.'/php/functions/mysql.php';
		require_once CORE_DIR.'/php/functions/validation.php';

		if( ADMIN_PANEL ){
			require_once CORE_DIR.'/php/functions/admin.php';
		}

	
	// Force removal of installation directory.

		remove_install_dir();

	
	// Generate global list of all CMS pages.

		$ep_pages = array();
		$rQ = mysql_query( "SELECT `id`, `link` FROM `pages` ORDER BY `id` ASC" );
		while( $r = mysql_fetch_assoc($rQ) ){
			if( $r['link'] == 'home' ){
				$ep_pages[$r['id']] = returnURL();
			} else {
				$ep_pages[$r['id']] = returnURL().'/'.$r['link'];
			}
		}

		global $ep_pages;

