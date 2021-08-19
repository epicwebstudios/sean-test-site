<?


	$path = explode( '/admin', dirname(__FILE__) );
	define( 'BASE_DIR', $path[0] );

	require BASE_DIR.'/sources/init/init.php';

	if( (empty($_COOKIE['admin_user'])) || (empty($_COOKIE['admin_pass'])) ){
		die( 'You do not have permission to access this page.' );
	}

	$base 	= returnURL();
	$links 	= array();


	// Pages
	$rQ = mysql_query( "SELECT `name`, `link` FROM `pages` ORDER BY `name` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$links[] = array(
			'title' => $r['name'],
			'value'	=> $base.'/'.$r['link'],
		);
	}


	echo json_encode( $links );
	die();
