<?
		
		
	$path = explode( '/install', dirname(__FILE__) );
	$path = $path[0];


	$output = array(
		'success' 	=> true,
		'progress'	=> 14,
		'next_step'	=> 1,
		'message' 	=> '',
		'html'		=> '',
	);
	
	
	$output['html'] .= '<h3>Enter Your Database Credentials</h3>';
	$output['html'] .= '<div class="row"><input type="text" name="host" placeholder="MySQL Host" value="localhost"></div>';
	$output['html'] .= '<div class="row"><input type="text" name="database" placeholder="MySQL Database"></div>';
	$output['html'] .= '<div class="row"><input type="text" name="username" placeholder="MySQL Username"></div>';
	$output['html'] .= '<div class="row"><input type="text" name="password" placeholder="MySQL Password"></div>';
	$output['html'] .= '<p><input type="submit" value="Test &amp; Save Database Credentials"></p>';


	echo json_encode( $output );
	die();


