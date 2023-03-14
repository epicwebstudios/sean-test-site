<?

	
	$categories = array();
	if( !$_GET['act'] ){ $categories[0] = 'All Categories'; }
	$rQ = mysql_query( "SELECT `id`, `name` FROM `".$database[1]."` ORDER BY `name` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$categories[$r['id']] = $r['name'];
	}


	$ratings = array(
		'1' 	=> 1,
		'1.5' 	=> 1.5,
		'2' 	=> 2,
		'2.5' 	=> 2.5,
		'3' 	=> 3,
		'3.5' 	=> 3.5,
		'4' 	=> 4,
		'4.5' 	=> 4.5,
		'5' 	=> 5,
	);


