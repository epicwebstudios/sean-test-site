<?
	
	$r = mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_videos` WHERE `permalink` = '".$request[1]."' LIMIT 1" ) );
	
	if( ($r['status'] != '1') || ($r['date'] > time()) ){
		redirect( $page_url );
		die();
	}
	
	if ( $r['video_type'] == 1 ) {
		$vid_type = substr($r['video_upload'], -3);
		$video = '<video width="419" height="744" style="display: block; margin-left: auto; margin-right: auto;" preload="auto"
					controls="controls" data-mce-fragment="1" id="'.$r['id'].'">
					<source src="../uploads/videos/'.$r['video_upload'].'" type="video/'.$vid_type.'">
				</video>';
	} else {
		$video = $r['youtube_link'];
	}
	
	$c = mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_videos_categories` WHERE `id` = '".$r['category']."' LIMIT 1" ) );
	
	
	$category	= $c['name'];
	$id 		= $r['id'];
	$title		= $r['name'];
	$link		= $page_url.'/'.$r['permalink'];
	// $date		= $r['date'];
	// $entry		= $r['summary'];
	// $entry		= $r['entry'];
	$photos		= false;
	
	
	// $pQ = mysql_query( "SELECT * FROM `m_videos_photos` WHERE `entry` = '".$id."' ORDER BY `order` ASC" );
	// if( mysql_num_rows($pQ) > 0 ){
		
	// 	$photos = array();
		
	// 	while( $p = mysql_fetch_assoc($pQ) ){
			
	// 		if( !$photo ){
	// 			$photo = array(
	// 				'id'		=> $p['id'],
	// 				'filename' 	=> '/videos/'.$p['filename'],
	// 				'caption'	=> htmlentities( $p['caption'] ),
	// 			);
	// 		}
			
	// 		$photos[] = array(
	// 			'id'		=> $p['id'],
	// 			'filename' 	=> '/videos/'.$p['filename'],
	// 			'caption'	=> htmlentities( $p['caption'] ),
	// 		);
	// 	}
		
	// }
	
	
	echo '<div class="news_module full_entry">';
		require BASE_DIR.'/templates/modules/videos/entry.php';
	echo '</div>';
	


