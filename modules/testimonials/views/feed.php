<?


	if( $category_id ){
		$stmt = "SELECT * FROM `m_testimonials` WHERE `category` = '".$category_id."' AND `status` = '1' ORDER BY RAND() LIMIT 1";
	} else {
		$stmt = "SELECT * FROM `m_testimonials` WHERE `status` = '1' ORDER BY RAND() LIMIT 1";
	}
	
	
	$query = mysql_query( $stmt );
	while( $r = mysql_fetch_assoc($query) ){
	
		$quote			= $r['quote'];
		$summary 		= nl2br( $r['summary'] );
		$rating 		= $r['rating'];
		$author			= false;
		$location		= false;
		$organization	= false;
		$misc			= false;
		$website		= false;
		
		if( $r['author'] ){
			$author	= $r['author'];
		}
		
		if( $r['location'] ){
			$location = $r['location'];
		}
		
		if( $r['organization'] ){
			$organization = $r['organization'];
		}
		
		if( $r['misc'] ){
			$misc = $r['misc'];
		}
		
		if( $r['website'] ){
			
			$website = $r['website'];
			
			if( $organization ){
				$organization = '<a href="'.$website.'" target="_blank">'.$organization.'</a>';
			} else if( $author ){
				$author = '<a href="'.$website.'" target="_blank">'.$author.'</a>';
			}
			
		}
		
		echo '<div class="testimonial_module feed">';
			
			require BASE_DIR.'/templates/modules/testimonials/feed.php';
			
		echo '</div>';
	
	}

