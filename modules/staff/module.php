<?

	global $settings, $page, $request;
	
	
	$page_url 		= get_page_url( $page['id'] );
	$category_id	= $_GET['staff_category_id'];
	
	
	if( $category_id ){
		$category = mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_staff_categories` WHERE `id` = '".$category_id."' LIMIT 1" ) );
	}
	
	
	if( $category['status'] == '1' ){
	
	
		if( !$request[1] ){
			require dirname( __FILE__ ).'/views/listing.php';
		} else {
			require dirname( __FILE__ ).'/views/profile.php';
		}
	
	
	}
	

