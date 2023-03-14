<?


	$system = systemInfo();
	
	
	$administrators = array();
	$rQ = mysql_query( "SELECT `id`, `first`, `last`, `username` FROM `administrators` ORDER BY `id` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		
		$administrators[$r['id']] = array(
			'id'		=> $r['id'],
			'name' 		=> $r['first'].' '.$r['last'],
			'username' 	=> $r['username'],
		);
		
	}
	
	
	$actions = array();
	$rQ = mysql_query( "SELECT `id`, `admin`, `action`, `date` FROM `admin_action_logs` ORDER BY `date` DESC LIMIT 10" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$actions[$r['id']] = array(
			'id'		=> $r['id'],
			'admin' 	=> $r['admin'],
			'action' 	=> $r['action'],
			'date'		=> $r['date'],
		);
	}
	
	
	$admin_pages = array();
	$rQ = mysql_query( "SELECT `id`, `name` FROM `admin_pages` ORDER BY `id` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$admin_pages[$r['id']] = array(
			'id'		=> $r['id'],
			'name' 		=> $r['name'],
		);
	}
	
	
	$timeout = ( time() - (86400 * 10) );
	$activity = array();
	$activity_admins = array();
	$rQ = mysql_query( "SELECT `admin`, `page`, `date` FROM `admin_activity` WHERE `date` >= '".$timeout."' ORDER BY `date` DESC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		
		if( !in_array($r['admin'], $activity_admins) ){
		
			$page = $r['page'];
			$page = explode( 'a=', $page );
			$page = explode( '&', $page[1] );
			$page = $page[0];
			
			$activity[] = array(
				'admin' => $r['admin'],
				'page'	=> $page,
				'date'	=> $r['date'],
			);
			
			$activity_admins[] = $r['admin'];
			
		}
		
	}

