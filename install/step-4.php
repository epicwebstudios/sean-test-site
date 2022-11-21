<?
		
		
	$path = explode( '/install', dirname(__FILE__) );
	$path = $path[0];


	$output = array(
		'success' 	=> false,
		'progress'	=> 70,
		'next_step'	=> 5,
		'message' 	=> '',
		'html'		=> '',
	);
	
	
	require_once $path.'/sources/php/db.config.php';
	$connect = @mysql_connect( $db['host'], $db['user'], $db['pass'] ) or $connect = false;
	@mysql_select_db( $db['db'], $connect );

	
	$url 	= addcslashes( $_POST['url'], "'" );
	$name 	= addcslashes( $_POST['name'], "'" );
	$title 	= addcslashes( $_POST['title'], "'" );
	
	if( ($url != '') && ($name != '') && ($title != '') ){
		
		mysql_query( "UPDATE `settings` SET `url` = '".$url."', `name` = '".$name."', `title` = '".$title."' WHERE `id` = '1' LIMIT 1" );
		
		if( mysql_error() ){
			$output['message'] .= 'Error: '.mysql_error();
		} else {
	
			$output['success'] = true;
			
			$output['html'] .= '<h3>Website Information Saved</h3>';
			$output['html'] .= '<p>Your new website information was successfully saved.</p>';
			$output['html'] .= '<p><b>We will now update your robots and setup some configuration...</b></p>';
			$output['html'] .= '<p><input type="submit" value="Setup Robots &amp; Configuration"></p>';
		
		}
	
	} else {
		$output['message'] .= 'You must enter information for every field';
	}


	echo json_encode( $output );
	die();

