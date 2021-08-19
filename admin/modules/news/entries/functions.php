<?

	
	$categories = array();
	if( !$_GET['act'] ){ $categories[0] = 'All Categories'; }
	$rQ = mysql_query( "SELECT `id`, `name` FROM `".$database[1]."` ORDER BY `name` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$categories[$r['id']] = $r['name'];
	}


