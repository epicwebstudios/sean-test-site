<?

	global $settings, $page, $request;
	
	
	$page_url 		= get_page_url( $page['id'] );
	$category_id	= $_GET['testimonial_category_id'];
	$display_type	= $_GET['testimonial_display_type'];
	
	
	if( $category_id ){
		$category = mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_testimonial_categories` WHERE `id` = '".$category_id."' LIMIT 1" ) );
	}
	
	
	if( $category['status'] == '1' ){
		
		
		if( $display_type == 'feed' ){
			require dirname( __FILE__ ).'/views/feed.php';
		} else {
			require dirname( __FILE__ ).'/views/display.php';
		}
	
	
	}
	

