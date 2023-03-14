<?

	
	$forms = array( 0 => 'All Forms' );
	$rQ = mysql_query( "SELECT `id`, `name` FROM `".$database[1]."` ORDER BY `name` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$forms[$r['id']] = $r['name'];
	}


