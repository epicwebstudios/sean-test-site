<?

	define( 'ADMIN_PANEL', true );

	$path = explode( '/admin', __DIR__ );
	define( 'CORE_DIR', $path[0].'/core' );
	require_once CORE_DIR.'/core.php';

	require dirname( __FILE__ ).'/functions.php';
	require dirname( __FILE__ ).'/../settings.php';


	define( 'SITE_URL', returnURL() );


	if( $_GET['method'] ){
		$_POST['method'] = $_GET['method'];
	}


	if( isLoggedIn() ){

		$method = dirname( __FILE__ ).'/src/'.$_POST['method'].'.php';

		if( file_exists($method) ){
			require_once $method;
		}
		
	}


