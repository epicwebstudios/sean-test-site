<?
	
	
	if( $category_id ){
		$stmt = "SELECT `id` FROM `m_videos` WHERE `vid_cat` = '".$category_id."' AND `status` = 1";
	} else {
		$stmt = "SELECT `id` FROM `m_videos` WHERE `status` = 1";
	}
	
	
	$query 	= mysql_query( $stmt );
	$count 	= mysql_num_rows( $query );
	
	$pagination = array(
		'current' 	=> 1,
		'next'		=> false,
		'prev'		=> false,
		'count'		=> 1,
	);
	
	if( ($request[1] == 'page') && ($request[2]) ){
		$pagination['current'] = $request[2];
	}
	
	$pagination['count'] = ceil( $count / $module_settings['per_page'] );
	
	if( $pagination['count'] < 1 ){
		$pagination['count'] = 1;
	}
	
	if( $pagination['current'] > $pagination['count'] ){
		$pagination['current'] = $pagination['count'];
	}
	
	if( $pagination['current'] > 1 ){
		$pagination['prev'] = ( $pagination['current'] - 1 );
	}
	
	if( $pagination['current'] < $pagination['count'] ){
		$pagination['next'] = ( $pagination['current'] + 1 );
	}
	
	$limit = ( ($pagination['current'] - 1) * $module_settings['per_page'] ).', '.$module_settings['per_page'];
	
	if( $pagination['prev'] ){
		$pagination['prev'] = $page_url.'/page/'.$pagination['prev'];
	}
	
	if( $pagination['next'] ){
		$pagination['next'] = $page_url.'/page/'.$pagination['next'];
	}
	
	
	if( $category_id ){
		$stmt = "SELECT * FROM `m_videos` WHERE `vid_cat` = '".$category_id."' AND `status` = '1' LIMIT ".$limit;
	} else {
		$stmt = "SELECT * FROM `m_videos` WHERE `status` = '1' LIMIT ".$limit;
	}
	
		
	echo '<div class="news_module listing" data-id="'.$video_category_id.'">';
			
	if ($videos_latest)
		require BASE_DIR.'/templates/modules/videos/pagination.php';

		$query = mysql_query( $stmt );
		$latest_count = 0;
		if ($videos_latest == 1) {
			while( $r = mysql_fetch_assoc($query)){
				if ($latest_count < 3) {
					$id			= $r['id'];
					$title 		= $r['name'];
					$link		= $page_url.'/videos/'.$r['permalink'];
					$summary	= $r['banner_subtitle'];
					$photo		= false;
					$vt         = $r['video_type'];
					
					if ($vt == 1) {
						$default	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_videos` WHERE `video_upload` = '".$r['id']."' ORDER BY `order` ASC LIMIT 1" ) );
					} else {
						$default	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_videos` WHERE `youtube_link` = '".$r['id']."' ORDER BY `order` ASC LIMIT 1" ) );
					}
					
					if( $default['filename'] ){
						$photo	= '/videos/'.$default['filename'];
					}
					
					require BASE_DIR.'/templates/modules/videos/listing.php';
					$latest_count++;
				}
			}
		} else {
			while( $r = mysql_fetch_assoc($query) ){
		
				$id			= $r['id'];
				$title 		= $r['name'];
				$link		= $page_url.'/'.$r['permalink'];
				$summary	= $r['banner_subtitle'];
				$photo		= false;
				$vt         = $r['video_type'];
				
				if ($vt == 1) {
					$default	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_videos` WHERE `video_upload` = '".$r['id']."' ORDER BY `order` ASC LIMIT 1" ) );
				} else {
					$default	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_videos` WHERE `youtube_link` = '".$r['id']."' ORDER BY `order` ASC LIMIT 1" ) );
				}
				
				if( $default['filename'] ){
					$photo	= '/videos/'.$default['filename'];
				}
				
				require BASE_DIR.'/templates/modules/videos/listing.php';
			
			}
		}
		if ($videos_latest)
		require BASE_DIR.'/templates/modules/videos/pagination.php';
		
	echo '</div>';


