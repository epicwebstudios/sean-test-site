<?
	
	
	if( $category_id ){
		$stmt = "SELECT `id` FROM `m_news_entries` WHERE `category` = '".$category_id."' AND `date` <= '".time()."' AND `status` = '1' ORDER BY `date` DESC";
	} else {
		$stmt = "SELECT `id` FROM `m_news_entries` WHERE `date` <= '".time()."' AND `status` = '1' ORDER BY `date` DESC";
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
		$stmt = "SELECT * FROM `m_news_entries` WHERE `category` = '".$category_id."' AND `date` <= '".time()."' AND `status` = '1' ORDER BY `date` DESC LIMIT ".$limit;
	} else {
		$stmt = "SELECT * FROM `m_news_entries` WHERE `date` <= '".time()."' AND `status` = '1' ORDER BY `date` DESC LIMIT ".$limit;
	}
	
		
	echo '<div class="news_module listing" data-id="'.$category_id.'">';
			
		require BASE_DIR.'/templates/modules/news/pagination.php';

		$query = mysql_query( $stmt );
		$latest_count = 0;
		if ($_GET['news_type'] && $_GET['news_type'] == 'latest') {
			while( $r = mysql_fetch_assoc($query) && $latest_count < 4 ){

				$id			= $r['id'];
				$title 		= $r['name'];
				$link		= $page_url.'/'.$r['permalink'];
				$date		= $r['date'];
				$summary	= $r['summary'];
				$photo		= false;
				
				$default	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_news_photos` WHERE `entry` = '".$r['id']."' ORDER BY `order` ASC LIMIT 1" ) );
				
				if( $default['filename'] ){
					$photo	= '/news/'.$default['filename'];
				}
				
				require BASE_DIR.'/templates/modules/news/listing.php';
				$latest_count++
			}
		} else {
			while( $r = mysql_fetch_assoc($query) ){
		
				$id			= $r['id'];
				$title 		= $r['name'];
				$link		= $page_url.'/'.$r['permalink'];
				$date		= $r['date'];
				$summary	= $r['summary'];
				$photo		= false;
				
				$default	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_news_photos` WHERE `entry` = '".$r['id']."' ORDER BY `order` ASC LIMIT 1" ) );
				
				if( $default['filename'] ){
					$photo	= '/news/'.$default['filename'];
				}
				
				require BASE_DIR.'/templates/modules/news/listing.php';
			
			}
		}
		
		require BASE_DIR.'/templates/modules/news/pagination.php';
		
	echo '</div>';


