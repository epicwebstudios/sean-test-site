<?

	global $settings, $page, $request;
	
	
	$page_url 		= get_page_url( $page['id'] );
	$category_id	= $category_id ?? false;
	$testimonial_id	= $testimonial_id ?? false;
	$display_type	= $display_type ?? false;
	$use_slider	    = isset($use_slider) && $use_slider;
	
	
	if( $category_id ){
		$category = mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_testimonial_categories` WHERE `id` = '".$category_id."' LIMIT 1" ) );
	}
	
	
	if( $category_id && $category['status'] == '1' ){
		
		
		if( $display_type == 'feed' ){
			require dirname( __FILE__ ).'/views/feed.php';
		} else {
			require dirname(__FILE__).'/views/single.php';
		}
	
	
	} elseif ($testimonial_id) {

		$testimonial = mysql_fetch_assoc(mysql_query("SELECT * FROM `m_testimonials` WHERE `id` = '$testimonial_id' LIMIT 1"));

		if ($testimonial) {
			$category = mysql_fetch_assoc(mysql_query("SELECT * FROM `m_testimonial_categories` WHERE `id` = '$testimonial[category]' LIMIT 1"));

			if ($category['status'] == 1)
				require dirname(__FILE__).'/views/single.php';
		}
	}

	unset($category_id);
	unset($display_type);
	unset($use_slider);