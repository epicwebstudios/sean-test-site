<?


	$locations = array();
	$rQ = mysql_query( "SELECT * FROM `m_locations` WHERE `status` = '1' ORDER BY `id` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		if( !is_array($locations['default']) ){
			$locations['default'] = $r;
		}
		$locations[$r['id']] = $r;
	}


	function location_info( $id = false ){
		
		global $locations;
		
		if( $id ){
			return $locations[$id];
		} else {
			return $locations['default'];
		}
		
	}
	
	function location_name( $id = false ){
		$info = location_info( $id );
		return $info['name'];
	}
	
	function location_address( $id = false ){
		$info = location_info( $id );
		return $info['address'];
	}
	
	function location_address_2( $id = false ){
		$info = location_info( $id );
		return $info['address_2'];
	}
	
	function location_city( $id = false ){
		$info = location_info( $id );
		return $info['city'];
	}
	
	function location_state( $id = false ){
		$info = location_info( $id );
		return $info['state'];
	}
	
	function location_zip( $id = false ){
		
		$info = location_info( $id );
		return $info['zip'];
		
	}
	
	function location_phone( $id = false ){
		
		$info = location_info( $id );
		
		if( $info['phone'] ){
			return $info['phone'];
		} else {
			return false;
		}
		
	}
	
	function location_fax( $id = false ){
		
		$info = location_info( $id );
		
		if( $info['fax'] ){
			return $info['fax'];
		} else {
			return false;
		}
		
	}
	
	function location_tollfree( $id = false ){
		
		$info = location_info( $id );
		
		if( $info['tollfree'] ){
			return $info['tollfree'];
		} else {
			return false;
		}
		
	}
	
	function location_email( $id = false ){
		
		$info = location_info( $id );
		
		if( $info['email'] ){
			return encode_email( $info['email'] );
		} else {
			return false;
		}
		
	}
	
	function location_mailto( $id = false, $text = false ){
		
		$info = location_info( $id );
		
		$output = '';
		
		if( $info['email'] ){
			$output .= '<a href="mailto:'.encode_email( $info['email'] ).'">';
				if( $text ){
					$output .= $text;
				} else {
					$output .= encode_email( $info['email'] );
				}
			$output .= '</a>';
			return $output;
		} else {
			return false;
		}
		
	}
	
	function location_map_link( $id = false ){
		
		$info = location_info( $id );
		
		$addr_str = $info['address'].", ".$info['city'].", ".$info['state']." ".$info['zip'];
		$addr_str = str_replace(" ", "+", $addr_str);
		
		$link = "//www.google.com/maps/place/".$addr_str."/";
		
		return $link;
		
	}
	
	function location_dir_link( $id = false ){
		
		$info = location_info( $id );
		
		$addr_str = $info['address'].", ".$info['city'].", ".$info['state']." ".$info['zip'];
		$addr_str = str_replace(" ", "+", $addr_str);
		
		$link = "//www.google.com/maps/dir//".$addr_str."/";
		
		return $link;
		
	}
	
	function location_map_image( $id = false, $color = 'blue', $type = 'roadmap', $zoom = '12', $size = '600x600' ){
		
		$info = location_info( $id );
		
		$addr_str = $info['address'].", ".$info['city'].", ".$info['state']." ".$info['zip'];
		$addr_str = str_replace(" ", "+", $addr_str);
		
		$url  = '//maps.google.com/maps/api/staticmap?';
		$url .= '&zoom='.$zoom;
		$url .= '&size='.$size;
		$url .= '&scale=2';
		$url .= '&maptype='.$type;
		$url .= '&sensor=false';
		$url .= '&markers=color:blue|label:-|'.$addr_str;
		
		return $url;
		
	}

	function location_hours( $id = false ){
	    
		$output = array(
			'all' 		=> array( 1 => false, 2 => false, 3 => false, 4 => false, 5 => false, 6 => false, 7 => false ),
			'today' 	=> false,
			'currently' => false,
		);
		
		$info 		= location_info( $id );
		
		$days 		= array( 1 => 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
		$days_abbr 	= array( 1 => 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun' );
	   
	    $hours 		= json_decode( $info['hours'], true );
		$dow		= date( 'N' );
		
		if( $hours[$dow]['type'] == '0' ){
			
			$output['currently'] = 'Closed';
			
			$output['today'] = array(
				'day'		=> $days[$dow],
				'day_abbr'	=> $days_abbr[$dow],
				'closed' 	=> true,
				'open'		=> false,
				'close'		=> false,
				'text'		=> false,
			);
			
		} else if( $hours[$dow]['type'] == '1' ){
			
			$open = strtotime( 'Today, '.$hours[$dow]['open'] );
			$close = strtotime( 'Today, '.$hours[$dow]['close'] );
			
			if( $close <= time() ){
				$output['currently'] = 'Closed';
			} else if( $open >= time() ){
				$output['currently'] = 'Opens at '.$hours[$dow]['open'];
			} else {
				$output['currently'] = 'Open';
			}
			
			$output['today'] = array(
				'day'		=> $days[$dow],
				'day_abbr'	=> $days_abbr[$dow],
				'closed' 	=> false,
				'open'		=> $hours[$dow]['open'],
				'close'		=> $hours[$dow]['close'],
				'text'		=> false,
			);
			
		} else if( $hours[$dow]['type'] == '2' ){
			
			$output['currently'] = $hours[$dow]['text'];
			
			$output['today'] = array(
				'day'		=> $days[$dow],
				'day_abbr'	=> $days_abbr[$dow],
				'closed' 	=> false,
				'open'		=> false,
				'close'		=> false,
				'text'		=> $hours[$dow]['text'],
			);
			
		}
		
		foreach( $hours as $dow => $value ){
			
			$closed = false;
			$open 	= false;
			$close 	= false;
			$text 	= false;
			
			if( $value['type'] == '0' ){ 
				$closed = true;
			}
			
			if( $value['type'] == '1' ){
				$open 	= $value['open'];
				$close	= $value['close'];
			}
			
			if( $hours[$dow]['type'] == '2' ){
				$text 	= $value['text'];
			}
			
			$output['all'][$dow] = array(
				'day'		=> $days[$dow],
				'day_abbr'	=> $days_abbr[$dow],
				'closed' 	=> $closed,
				'open'		=> $open,
				'close'		=> $close,
				'text'		=> $text,
			);
		}
		
		return $output;
		
    }

