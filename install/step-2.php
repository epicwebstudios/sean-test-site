<?
		
		
	$path = explode( '/install', dirname(__FILE__) );
	$path = $path[0];


	$output = array(
		'success' 	=> false,
		'progress'	=> 42,
		'next_step'	=> 3,
		'message' 	=> '',
		'html'		=> '',
	);
	
	
	require_once $path.'/sources/php/db.config.php';
	
	
	$sql 	= file_get_contents( dirname(__FILE__).'/install.sql' );
	$mysqli = new mysqli( $db['host'], $db['user'], $db['pass'], $db['db'] );
	
	
	if( $mysqli->multi_query($sql) ){
		
		$output['success'] = true;
		
		$output['html'] .= '<h3>Database Installed Successfully</h3>';
		$output['html'] .= '<p>Your database was successfully installed on the server.</p>';
		$output['html'] .= '<p><b>We will now format some of your folders and files...</b></p>';
		$output['html'] .= '<p><input type="submit" value="Format Folders &amp; Files"></p>';
		
	} else {
		$output['message'] .= '<div><b>The database did not install correctly.</b></div>';
		$output['message'] .= '<div>Error: '.$mysqli->error.'</div>';
	}


	echo json_encode( $output );
	die();

