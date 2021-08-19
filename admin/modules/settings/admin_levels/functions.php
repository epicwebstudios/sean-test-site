<?


	$pages = kv_array( $database[2], 'id', 'name' );
	
	
	function menu_items_array( $type, $parent_id = 0, $level = 0, $options = false, $parent_list = '' ){
	
		$line = '';
		for( $i=0; $i<$level; $i++ ){
			$line .= '&mdash;';
		}
		$line .= ' ';
		
		if( !$options ){
			if( $type == 'options' ){
				$options = array( 0 => 'No Parent' );
			} else {
				$options = array();
			}
		}
		
		if( $parent_id != '0' ){	
			if( $parent_list != '' ){ $parent_list .= ','; }
			$parent_list .= $parent_id;
		}
	
		$query = mysql_query( "SELECT * FROM `admin_pages` WHERE `parent` = '".$parent_id."' ORDER BY `order` ASC" );
		while( $info = mysql_fetch_assoc($query) ){
			
			if( $type == 'options' ){
				$options[$info['id']] = $line.$info['name'];
			} else if( $type == 'listing' ){
				
				if( $level == 0 ){
					$info['label'] = '<b>'.$info['name'].'</b>';
				} else {
					$info['label'] = $line.$info['name'];
				}
				
				$info['parent_list'] = $parent_list;
				
				$options[$info['id']] = $info;
				
			}
			
			$options = menu_items_array( $type, $info['id'], ($level+1), $options, $parent_list );
			
		}
		
		return $options;
		
	}

	



