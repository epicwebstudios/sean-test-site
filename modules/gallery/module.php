<?


	global $settings, $page, $request;
	
	
	$page_url 			= get_page_url( $page['id'] );
	$category_id 		= $_GET['gallery_category_id'];
	$gallery_id 		= $_GET['gallery_id'];
	
	
	if( $gallery_id ){
		require_once dirname( __FILE__ ).'/view/gallery.php';
	} else if( $category_id ){
		if( $request[1] ){
			
			$gallery = mysql_fetch_assoc( mysql_query( "SELECT `id` FROM `m_photo_galleries` WHERE `permalink` = '".$request[1]."' AND `status` = '1' LIMIT 1" ) );
			
			if( $gallery['id'] ){
				$gallery_id = $gallery['id'];
				require_once dirname( __FILE__ ).'/view/gallery.php';
			} else {
				redirect( $page_url );
				die();
			}
			
		} else {
			require_once dirname( __FILE__ ).'/view/category.php';
		}
	}
	


