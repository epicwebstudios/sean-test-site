<?


	$path = explode( '/admin', dirname(__FILE__) );
	define( 'BASE_DIR', $path[0] );
	
	include BASE_DIR.'/sources/init/connect.php';
	require BASE_DIR.'/sources/init/global.php';
	require BASE_DIR.'/admin/sources/php/functions.php';
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


