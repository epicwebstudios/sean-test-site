<?


	function notification_popups(){
		
		$found = false;
		
		$stmt  = " ";
		$stmt .= " SELECT * ";
		$stmt .= " FROM `m_notification_popups` ";
		$stmt .= " WHERE `status` = '1' ";
		$stmt .= " ORDER BY `date_start` ASC ";
		
		$rQ = mysql_query( $stmt );
		while( $r = mysql_fetch_assoc($rQ) ){
			if( !$found ){
				
				$output = '';
				$show 	= true;

				if( ($r['date_start'] > 0) && ($r['date_start'] > time()) ){
					$show = false;
				}

				if( ($r['date_end'] > 0) && ($r['date_end'] < time()) ){
					$show = false;
				}
				
				if( $_COOKIE['ep_notification_popup_'.$r['id']] == '1' ){
					$show = false;
				}

				if( $show ){

					$found 			= true;
					$id 			= $r['id'];
					$display_type	= $r['display_type'];
					$bg_type 		= $r['bg_type'];
					$bg_color_1 	= $r['bg_color_1'];
					$bg_color_2 	= $r['bg_color_2'];
					$text_color 	= $r['text_color'];
					$close_btn_text = 'Close';
					$content 		= $r['content'];
					
					if( $r['close_btn_text'] ){
						$close_btn_text = $r['close_btn_text'];
					}
					
					if( $display_type == '0' ){
						$expires = ( time() + (86400 * 100) );
						$expires = ' expires='.date( 'D, j M Y H:i:s e', $expires ).'; ';
					} else {
						$expires = '';
					}

					$output .= "<style>";
						$output .= " .notification_popup#popup_".$id." .content { ";
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

					$output .= '<div class="fix notification_popup" id="popup_'.$id.'">';
						$output .= '<div class="abs content">';
							$output .= $content;
							$output .= '<p class="tc">';
								$output .= '<a href="#" onclick="close_notification_popup(); return false;" class="btn">'.$close_btn_text.'</a>';
							$output .= '</p>';
						$output .= '</div>';
					$output .= '</div>';
					
					$output .= '<script>';
					
						$output .= " var notification_popup_state = false; ";
					
						$output .= " function open_notification_popup(){ ";
							$output .= " notification_popup_state = true; ";
							$output .= " $( 'body' ).css( 'overflow', 'hidden' ); ";
							$output .= " $( '.notification_popup' ).fadeIn( 'fast' ); ";
						$output .= " } ";
					
						$output .= " function close_notification_popup(){ ";
							$output .= " notification_popup_state = false; ";
							$output .= " $( 'body' ).css( 'overflow', 'auto' ); ";
							$output .= " $( '.notification_popup' ).fadeOut( 'fast' ); ";
							$output .= " document.cookie = 'ep_notification_popup_".$id."=1; ".$expires." path=/'; ";
						$output .= " } ";
					
						$output .= " jQuery_defer( function(){ ";
							
							$output .= " setTimeout( function(){ open_notification_popup(); }, 1000 ); ";
					
							$output .= " $( document ).keyup( function(e){ ";
								$output .= " if( e.keyCode == 27 ){ ";
									$output .= " if( notification_popup_state ){ close_notification_popup(); } ";
								$output .= " } ";
							$output .= " }); ";
					
						$output .= " }); ";
					
					$output .= '</script>';

					echo $output;
				
				}
			}
			
		}
		
	}

