<?


	// Define typical global variables

		$admin_bar	= array();
		$settings 	= siteSettings();
		$system 	= systemInfo();
		$js         = array();
		$css        = array();


	// Pull in local site defined functions

		require __DIR__.'/functions.php';


	// Define site URL constants

		if( !defined('BASE_URL') ){
			define( 'BASE_URL', $settings['url'] );
		}

		if( !defined('URL') ){
			define( 'URL', $settings['url'] );
		}

	
	// Set site timezone, as set in Site Settings

		date_default_timezone_set( $settings['timezone'] );


	// Load all specified "preloading files"

		$preloaders = preloaders();
		foreach( $preloaders as $preloader ){
			require_once $preloader;
		}
	

	// Handle site offline setting
	
		if( $settings['offline'] == 1 ){
			require BASE_DIR.'/modules/errors/offline.php';
			die();
		}
	

	// Handle user blocked setting
	
		if( user_blocked() ){
			require BASE_DIR.'/modules/errors/blocked.php';
			die();
		}


	// Retrieve the information of the current requested page
	
		$page = getPage( $_GET['act'] );


	// Add default admin bar button
	
		add_to_admin_bar( 'Edit Page', '/admin/?a=13&act=edit&i='.$page['id'] );
	
	
	// Handle "page preview"

		if( $_POST['preview'] == '1' ) {
			header( 'X-XSS-Protection: 0' );
			$page = $_POST;
		}
	
	
	// If viewing a revision, pull the specific revision as $page

		if( $_GET['revision'] ){
			
			$info = mysql_fetch_assoc( mysql_query( "SELECT * FROM `revisions` WHERE `rev_key` = '".$_GET['revision']."' AND `table` = 'pages' LIMIT 1" ) );
			
			if( $info['id'] ){
				$page = json_decode( $info['records'], true );
			}
			
		}
	
	
	// Set the page title to the defined title for the individual page
	
		$page['title'] = getTitle( $page, $page['title'] );
	
	
	// Handle password protected pages

		if( isset($_POST['password_submit']) ){
			if( md5($_POST['password']) == $page['e_password'] ){
				setcookie( 'page_'.$page['id'], $page['e_password'], (time()+(86400*100)) );
				$url = returnURL(1);
				redirect( $url.$page['link'] );
			} else {
				$error_msg = 'The password you entered is incorrect.';
			}
		}
	

	// Define $request global
	
		$request = $_GET['act'];

		if( substr($request, -1) != '/' ){
			$request .= '/';
		}

		if( substr($request, 0, strlen($page['link'])) == $page['link'] ){
			$request = substr( $request, strlen($page['link']) );
		}

		$request = explode( '/', $request );

		foreach( $request as $k => $v ){
			if( $v == '' ){
				unset( $request[$k] );
			}
		}

		$pageInfo = $request;


	// Pull in local site defined overrides

		require __DIR__.'/overrides.php';
	
