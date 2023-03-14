<?

	global $settings, $page, $request;
	
	
	require_once dirname( __FILE__ ).'/functions.php';
	
	
	$page_url 		= get_page_url( $page['id'] );
	$category_id	= $_GET['resources_category_id'];
	$display_type	= $_GET['resources_display_type'];
	
	
	if( $category_id ){
		$category = mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_resource_categories` WHERE `id` = '".$category_id."' LIMIT 1" ) );
	}
	
	
	if( $category['status'] == '1' ){
		
		
		$files = array();
		
		$rQ = mysql_query( "SELECT * FROM `m_resources` WHERE `category` = '".$category_id."' AND `status` = '1' ORDER BY `date` DESC" );
		while( $r = mysql_fetch_assoc($rQ) ){
		
			if( $r['link_type'] == '1' ){
				$url = returnURL().'/uploads/resources/'.$r['filename'];
				$icon = resource_icon( $r['filename'] );
			} else {
				$url = $r['url'];
				$icon = resource_icon( '.url' );
			}
			
			if( $r['description'] == '' ){
				$r['description'] = false;
			}
		
			$files[] = array(
				'id'			=> $r['id'],
				'name'			=> $r['name'],
				'description'	=> $r['description'],
				'date'			=> $r['date'],
				'icon'			=> $icon,
				'url'			=> $url,
			);
			
		}
		
		
		echo '<div class="resources_module" data-id="'.$category_id.'">';
		
			if( $display_type == 'grid' ){
				require BASE_DIR.'/templates/modules/resources/grid.php';
			} else if( $display_type == 'feed' ){
				require BASE_DIR.'/templates/modules/resources/feed.php';
			} else if( $display_type == 'table' ){
				require BASE_DIR.'/templates/modules/resources/table.php';
			}
		
		echo '</div>';
		
		
	}
	

