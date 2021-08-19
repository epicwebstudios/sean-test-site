<?

	date_default_timezone_set( 'America/New_York' );

	require_once dirname( __FILE__ ).'/php54.compatibility.php';
	require_once dirname( __FILE__ ).'/mysql.compatibility.php';

	if( file_exists(dirname( __FILE__ ).'/db.config.php') ){
		
		require dirname( __FILE__ ).'/db.config.php';
		
		$connect = @mysql_connect( $db['host'], $db['user'], $db['pass'] ) or $connect = false;
		@mysql_select_db( $db['db'], $connect );
		
		if( !$connect ){
			require BASE_DIR.'/modules/errors/database.php';
			die();
		}
		
	} else {
		
		if( file_exists(BASE_DIR.'/install/') ){
			header( 'Location: install/' );
			die();
		} else {
			echo 'Installation file missing. Please <a href="https://www.epicwebstudios.com/support">contact us</a> for further support.';
			die();
		}
	
	}
	
