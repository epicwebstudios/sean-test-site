<?
	
	require_once dirname( __FILE__ ).'/../src/init.php';
	require_once dirname( __FILE__ ).'/../src/functions.php';

	validate_login();

	$method = dirname( __FILE__ ).'/src/'.$_POST['method'].'.php';

	if( file_exists($method) ){
		require_once $method;
	}
