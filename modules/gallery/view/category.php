<?
	
	
	$stmt  = "";
	$stmt .= " SELECT * ";
	$stmt .= " FROM `m_photo_galleries` ";
	$stmt .= " WHERE `category` = '".$category_id."' ";
	$stmt .= " AND `status` = '1' ";
	$stmt .= " ORDER BY `order` ASC ";
	
		
	echo '<div class="gallery_module category" data-id="'.$category_id.'">';

		$query = mysql_query( $stmt );
		while( $r = mysql_fetch_assoc($query) ){
		
			$id				= $r['id'];
			$title 			= $r['name'] ?: 'Gallery '.$id;
			$link			= $page_url.'/'.$r['permalink'];
			$description	= $r['description'];
			$photo			= false;
			
			$default		= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_photo_photos` WHERE `gallery` = '".$r['id']."' ORDER BY `order` ASC LIMIT 1" ) );
			
			if( $default['filename'] )
				$photo = img_url( '/gallery/'.$default['filename'], 400, 400 );
			
			require BASE_DIR.'/templates/modules/gallery/category.php';
		
		}
		
	echo '</div>';
	
	
