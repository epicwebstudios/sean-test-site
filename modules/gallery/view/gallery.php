<?
	
	
	$stmt = "
		SELECT *
	    FROM `m_photo_photos`
	    WHERE
	        `gallery` = '$gallery_id' AND
	        `status` = 1
	    ORDER BY `order` ASC";

	$classes = array(
		'gallery_module',
		'gallery',
	);

	if ($use_slider)
		$classes[] = 'slider';
		
	echo sprintf('<div class="%1$s" data-id="%2$s">', implode(' ', $classes), $gallery_id);
		
		if( $category_id ){
			$gallery = mysql_fetch_assoc( mysql_query( "SELECT `name` FROM `m_photo_galleries` WHERE `id` = '$gallery_id' LIMIT 1" ) );
			
			if (!$page['banner'])
				echo '<h1>'.$gallery['name'].'</h1>';
		}

		$query = mysql_query( $stmt );
		while( $r = mysql_fetch_assoc($query) ){
		
			$id			= $r['id'];
			$photo		= img_url( '/gallery/'.$r['filename'], 400, 400 );
			$photo_l    = img_url( '/gallery/'.$r['filename'], 1000, 1000 );
			$caption	= $r['caption'] ?: 'Photo '.$id;

			require BASE_DIR.'/templates/modules/gallery/gallery.php';
		
		}

		if( $category_id ){
			
			$category = mysql_fetch_assoc( mysql_query( "SELECT `name` FROM `m_photo_categories` WHERE `id` = '$category_id' LIMIT 1" ) );
			
			echo '<p class="tc">';
				echo '<a href="'.$page_url.'" class="btn">Return to '.$category['name'].'</a>';
			echo '</p>';
			
		}
		
	echo '</div>';

	if ($use_slider) {
		echo '<script>';
		include BASE_DIR.'/templates/modules/gallery/src/js/slider.js.php';
		echo '</script>';
	}