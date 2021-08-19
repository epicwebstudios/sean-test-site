<?
	
	
	$stmt  = "";
	$stmt .= " SELECT * ";
	$stmt .= " FROM `m_photo_photos` ";
	$stmt .= " WHERE `gallery` = '".$gallery_id."' ";
	$stmt .= " ORDER BY `order` ASC ";
	
		
	echo '<div class="gallery_module gallery">';
		
		if( $category_id ){
			$gallery = mysql_fetch_assoc( mysql_query( "SELECT `name` FROM `m_photo_galleries` WHERE `id` = '".$gallery_id."' LIMIT 1" ) );
			
			if (!$page['banner'])
				echo '<h1>'.$gallery['name'].'</h1>';
		}

		$query = mysql_query( $stmt );
		while( $r = mysql_fetch_assoc($query) ){
		
			$id			= $r['id'];
			$photo		= '/gallery/'.$r['filename'];
			$caption	= $r['caption'];
			
			require BASE_DIR.'/templates/modules/gallery/gallery.php';
		
		}
		
		if( $category_id ){
			
			$category = mysql_fetch_assoc( mysql_query( "SELECT `name` FROM `m_photo_categories` WHERE `id` = '".$category_id."' LIMIT 1" ) );
			
			echo '<p class="tc">';
				echo '<a href="'.$page_url.'" class="btn">Return to '.$category['name'].'</a>';
			echo '</p>';
			
		}
		
	echo '</div>';


