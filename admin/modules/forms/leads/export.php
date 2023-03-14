<?


	$path = explode( '/admin', dirname(__FILE__) );
	define( 'BASE_DIR', $path[0] );


	require_once BASE_DIR.'/sources/init/connect.php';
	require_once BASE_DIR.'/sources/init/global.php';
	require_once BASE_DIR.'/sources/php/functions.php';
	require_once BASE_DIR.'/admin/sources/php/functions.php';
	require_once dirname( __FILE__ ).'/config.php';
	require_once dirname( __FILE__ ).'/functions.php';
	
	
	if( !isLoggedIn() ){
		die( 'You do not have permission to access this page.' );
	}
	
	
	if( $_GET['i'] == '' ){
		die( 'You must specify a form to export' );
	}
	
	
	$form = mysql_fetch_assoc( mysql_query( "SELECT * FROM `".$database[1]."` WHERE `id` = '".$_GET['i']."' LIMIT 1" ) );


