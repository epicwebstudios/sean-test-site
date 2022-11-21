<?


	// Disable XSS protection

		header( 'X-XSS-Protection: 0' );


	// Define typical global variables

		$system 	= systemInfo();
		$settings	= siteSettings();
		$messages 	= array();


	// Dark mode toggling

		$dm_params = array();
		foreach( $_GET as $k => $v ){ if( $k != 'set_dark_mode' ){ $dm_params[$k] = $v; } }

		if( $_GET['set_dark_mode'] != '' ){
			setcookie( 'ews_dark_mode', $_GET['set_dark_mode'], (time()+(180*86400)), '/' );
			header( 'Location: ?'.http_build_query($dm_params) );
			die();
		}

	
	// Force site URL
	
		$site_domain 	= $settings['url'];
		$site_domain 	= str_replace( '://', '++', $site_domain );
		$parts			= explode( '/', $site_domain );
		$site_domain 	= str_replace( '++', '://', $parts[0] );
		
		$url = 'http://';
		if( $_SERVER['HTTPS'] == 'on' ){ $url = 'https://'; }
		$url .= $_SERVER['HTTP_HOST'];
	
		if( $site_domain != $url ){
			header( 'Location: '.$site_domain.$_SERVER['REQUEST_URI'] );
		}

