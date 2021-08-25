<?
		
		
	$path = explode( '/install', dirname(__FILE__) );
	$path = $path[0];


	$output = array(
		'success' 	=> false,
		'progress'	=> 28,
		'next_step'	=> 2,
		'message' 	=> '',
		'html'		=> '',
	);
	
	
	require_once $path.'/sources/init/php54.compatibility.php';
	require_once $path.'/sources/init/mysql.compatibility.php';
	
	
	$host 		= $_POST['host'];
	$user 		= $_POST['username'];
	$pass 		= $_POST['password'];
	$database 	= $_POST['database'];
	
	
	if( 
		( $host != '' ) && 
		( $user != '' ) && 
		( $pass != '' ) && 
		( $database != '' )
	){
	
		$connect 	= @mysql_connect( $host, $user, $pass );
		$choose 	= @mysql_select_db( $database );
			
		if( ($connect) && ($choose) ){
			
			$path = explode( '/install', dirname(__FILE__) );
			$path = $path[0];
			$file = $path.'/sources/init/db.config.php';
			
			$contents  = '';
			$contents .= '<?' . "\n";
				$contents .= "\t" . '$'."db['host']".' = \''.$host.'\';' . "\n";
				$contents .= "\t" . '$'."db['user']".' = \''.$user.'\';' . "\n";
				$contents .= "\t" . '$'."db['pass']".' = \''.$pass.'\';' . "\n";
				$contents .= "\t" . '$'."db['db']".' = \''.$database.'\';' . "\n";
			$contents .= '' . "\n";
			
			file_put_contents( $file, $contents );
			
			$output['success'] = true;
			$output['html'] .= '<h3>Install Database</h3>';
			$output['html'] .= '<p>Your database connection information was saved correctly.</p>';
			$output['html'] .= '<p><b>We will now install your database and base information...</b></p>';
			$output['html'] .= '<p><input type="submit" value="Install Database"></p>';
		
		} else {
			if( !$connect ){
				$output['message'] .= '<div><b>The credentials you entered are invalid.</b></div>';
				$output['message'] .= '<div>We could not connect to your database.</div>';
				$output['message'] .= '<div>Please check your host, username, and password.</div>';
			} else {
				$output['message'] .= '<div>The login information you provided was correct, but <b>we could not connect to the specified database</b>.</div>';
				$output['message'] .= '<div>Please check your database name.</div>';
			}
		}
		
	} else {
		$output['message'] .= 'You must enter information for every field';
	}


	echo json_encode( $output );
	die();

