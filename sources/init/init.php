<?


	if (session_status() === PHP_SESSION_NONE)
		session_start();


	$path = explode( '/sources', dirname(__FILE__) );
	$path = $path[0];
	define( 'BASE_DIR', $path );


	require_once BASE_DIR."/sources/init/connect.php";
	require_once BASE_DIR."/sources/init/global.php";
	require_once BASE_DIR."/sources/php/functions.php";


	define( 'BASE_URL', $settings['url'] );
	define( 'URL', $settings['url'] );
		

	date_default_timezone_set( $settings['timezone'] );


	$preloaders = preloaders();
	foreach( $preloaders as $preloader ){
		require_once $preloader;
	}


	// Retrieve the information of the current called page.
	$page = getPage( $_GET['act'] );


	// Add default admin bar button
	add_to_admin_bar( 'Edit Page', '/admin/?a=13&act=edit&i='.$page['id'] );
	
	
	// Handle page preview
	if( $_POST['preview'] == '1' ) {
		header( 'X-XSS-Protection: 0' );
		$page = $_POST;
	}
	
	
	if( $_GET['revision'] ){
		$info = mysql_fetch_assoc( mysql_query( "SELECT * FROM `revisions` WHERE `rev_key` = '".$_GET['revision']."' AND `table` = 'pages' LIMIT 1" ) );
		if( $info['id'] ){ $page = json_decode( $info['records'], true ); }
	}
	
	
	// Set the page title to the defined title for the individual page.
	$page['title'] = getTitle( $page, $page['title'] );
	
	
	// This checks any forms that have been submitted on password protected pages. If correct, it sets the cookie and reloads the page.
	if( isset($_POST['password_submit']) ){
		
		$password = $_POST['password'];
		
		if( md5($password) == $page['e_password'] ){
			
			setcookie( 'page_'.$page['id'], $page['e_password'], (time()+(86400*100)) );
			$url = returnURL(1);
			redirect( $url.$page['link'] );
			
		} else {
			
			$error_msg = 'The password you entered is incorrect.';
			
		}
		
	}
	
	
	if( $settings['offline'] == 1 ){
		require BASE_DIR.'/modules/errors/offline.php';
		die();
	}
	
	
	if( user_blocked() ){
		require BASE_DIR.'/modules/errors/blocked.php';
		die();
	}
	
	
	
	$request = $_GET['act'];
	
	if( substr($request, -1) != '/' ){
		$request .= '/';
	}
	
	$request = str_replace( $page['link'].'/', '/', $request );
	$request = explode("/", $request);
	unset( $request[0] );
	
	$pageInfo = $request;


	require BASE_DIR.'/sources/init/overrides.php';
	
