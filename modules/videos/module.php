<?


	global $settings, $page, $request;
    // require BASE_DIR.'/sources/php/share.class.php';
	
	$page_url 			= get_page_url( $page['id'] );
	$module_settings 	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_videos_settings` WHERE `id` = '1' LIMIT 1" ) );
	$category_id 	= $_GET['video_category_id'];
	
	
	if( $category_id ){
		$category = mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_videos_categories` WHERE `id` = '".$category_id."' LIMIT 1" ) );
	}
	
	
	if( $category['status'] == '1' ){

		
		
		if( (!$request[1]) || ($request[1] == 'page') ){
			require_once dirname( __FILE__ ).'/view/listing.php';
		} else {
			require_once dirname( __FILE__ ).'/view/entry.php';	
		}
	
	
	}
	


