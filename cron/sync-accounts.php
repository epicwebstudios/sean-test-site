<?

	$path = explode( '/cron', dirname(__FILE__) );
	define( 'BASE_DIR', $path[0] );
	
	require_once BASE_DIR.'/sources/init/init.php';
	
	$url 	= 'http://in.epicwebstudios.com/sync/';
	$ch 	= curl_init();
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_URL, $url );
	$data 	= curl_exec( $ch );
	curl_close( $ch );
	
	if( $data ){
		
		$added 		= 0;
		$updated 	= 0;
		$raw 		= json_decode( $data, true );
		
		foreach( $raw['users'] as $user ){
			
			$query_string = '';
			
			foreach( $user as $key => $value ){
				if( $key != 'ews_id' ){
					$query_string .= ", `".$key."` = '".$value."'";
				}
			}
			
			$query_string = substr( $query_string, 2 );
			
			$check = mysql_num_rows( mysql_query( "SELECT `id` FROM `administrators` WHERE `ews_id` = '".$user['ews_id']."' LIMIT 1" ) );
			
			if( $check > 0){
				mysql_query( "UPDATE `administrators` SET ".$query_string." WHERE `ews_id` = '".$user['ews_id']."' LIMIT 1" );
				$updated++;
			} else {
				mysql_query( "INSERT INTO `administrators` SET `ews_id` = '".$user['ews_id']."', ".$query_string );
				$added++;
			}
			
		}
		
		mysql_query( "DELETE FROM `administrators` WHERE `ews_id` NOT IN (".$raw['list'].")" );
		$affected = mysql_affected_rows();
		
	}
	
