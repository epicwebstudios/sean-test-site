<?

	
	$administrators = array( 0 => 'All Users');
	$active_admins	= array();
	
	$rQ = mysql_query( "SELECT `id`, `username`, `first`, `last`, `status` FROM `".$database[1]."` ORDER BY `first` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$name = $r['first'].' '.$r['last'].' ('.$r['username'].')';
		$administrators[$r['id']] = $name;
	}


