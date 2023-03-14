<?


	function check_redirect(){

		$location = '';
	
		if( $_GET['act'] ){
			$page = strtolower( $_GET['act'] );
		} else { 
			$page = 'home';
		}
	
		if( substr($page, -1) == '/' ){
			$page = substr( $page, 0, (strlen($page)-1) );
		}
	
		$query = mysql_query( "SELECT * FROM `301_redirects` WHERE `request` = '".$page."' AND `status` = '1' LIMIT 1" );
		if( mysql_num_rows($query) > 0 ){
			
			$redirect = mysql_fetch_assoc($query);
			
			if( $redirect['type'] == '1' ){
				$method = "307 Temporary Redirect";
			} else {
				$method = "301 Moved Permanently";
			}
			
			if( $redirect['redirect_type'] == '1' ){
				$location = $redirect['url'];
			} else {
				$location = get_page_url( $redirect['page'] );
			}
		}
	
		if( $location ){
			header ( 'HTTP/1.1 '.$method );
			header ( 'Location: '.$location );
			die();
		}
	
	}
	
	
	check_redirect();
	
