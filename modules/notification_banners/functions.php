<?


	function notification_banners(){
		
		$stmt  = " ";
		$stmt .= " SELECT * ";
		$stmt .= " FROM `m_notification_banners` ";
		$stmt .= " WHERE `status` = '1' ";
		$stmt .= " ORDER BY `date_start` ASC ";
		
		$rQ = mysql_query( $stmt );
		while( $r = mysql_fetch_assoc($rQ) ){
			
			$output = '';
			$show 	= true;
			
			if( ($r['date_start'] > 0) && ($r['date_start'] > time()) ){
				$show = false;
			}
			
			if( ($r['date_end'] > 0) && ($r['date_end'] < time()) ){
				$show = false;
			}
			
			if( $show ){
				
				$id 		= $r['id'];
				$bg_type 	= $r['bg_type'];
				$bg_color_1 = $r['bg_color_1'];
				$bg_color_2 = $r['bg_color_2'];
				$text_color = $r['text_color'];
				$content 	= $r['content'];
				
				$output .= "<style>";
					$output .= " .notification_banner#banner_".$id." { ";
						if( $bg_type == '0' ){
							if( $bg_color_1 ){
								$output .= " background-color: ".$bg_color_1."; ";
							}
						} else {
							if( ($bg_color_1) && ($bg_color_2) ){
								$output .= " background-image: linear-gradient(to right, ".$bg_color_1.", ".$bg_color_2." ); ";
							}
						}
						if( $text_color ){
							$output .= " color: ".$text_color."; ";
						}
					$output .= " } ";
				$output .= "</style>";
				
				$output .= '<div class="tc notification_banner" id="banner_'.$id.'">';
					$output .= $content;
				$output .= '</div>';
				
				echo $output;
				
			}
			
		}
		
	}

