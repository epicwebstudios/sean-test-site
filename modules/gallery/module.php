<?
	global $settings, $page, $request;

	$page_url       = get_page_url( $page['id'] );
	$category_id    = $category_id ?? false;
	$gallery_id     = $gallery_id ?? false;
	$use_slider     = isset($use_slider) && $use_slider;
	
	if( $gallery_id ){
		require dirname( __FILE__ ).'/view/gallery.php';
	} else if( $category_id ){
		if( $request[1] ){
			
			$gallery = mysql_fetch_assoc( mysql_query( "SELECT `id` FROM `m_photo_galleries` WHERE `permalink` = '".$request[1]."' AND `status` = '1' LIMIT 1" ) );
			
			if( $gallery['id'] ){
				$gallery_id = $gallery['id'];
				require dirname( __FILE__ ).'/view/gallery.php';
			} else {
				redirect( $page_url );
				die();
			}
			
		} else {
			require dirname( __FILE__ ).'/view/category.php';
		}
	}

	unset($category_id);
	unset($display_type);
	unset($use_slider);