<?


	$menus = kv_array( $database[1], 'id', 'name' );
	
	
	$link_types = array(
		0 => array( 'name' => 'Do Not Link', 	'table' => false, 	'id' => false, 	'label' => false ),
		1 => array( 'name' => 'External URL', 	'table' => false, 	'id' => false, 	'label' => false ),
		2 => array( 'name' => 'Internal Page', 	'table' => 'pages', 'id' => 'id', 	'label' => 'name' ),
	);
	
	
	$link_type_options = array();
	foreach( $link_types as $key => $value ){
		$link_type_options[$key] = $value['name'];
	}
	
	
	function menu_items_array( $menu_id, $type, $parent_id = 0, $level = 0, $options = false ){
	
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
	
		$query = mysql_query( "SELECT * FROM `m_menu_items` WHERE `menu_id` = '".$menu_id."' AND `parent_id` = '".$parent_id."' ORDER BY `order` ASC" );
		while( $info = mysql_fetch_assoc($query) ){
			
			if( $type == 'options' ){
				$options[$info['id']] = $line.$info['label'];
			} else if( $type == 'listing' ){
				if( $level == 0 ){
					$info['label'] = '<b>'.$info['label'].'</b>';
				} else {
					$info['label'] = $line.$info['label'];
				}
				$options[$info['id']] = $info;
			}
			
			$options = menu_items_array( $menu_id, $type, $info['id'], ($level+1), $options );
			
		}
		
		return $options;
		
	}
	
	
	function update_menu_id( $item_id, $menu_id ){
		mysql_query( "UPDATE `m_menu_items` SET `menu_id` = '".$menu_id."' WHERE `id` = '".$item_id."'" );
		$rQ = mysql_query( "SELECT `id` FROM `m_menu_items` WHERE `parent_id` = '".$item_id."' ORDER BY `id` ASC" );
		if( mysql_num_rows($rQ) > 0 ){
			while( $r = mysql_fetch_assoc($rQ) ){
				update_menu_id( $r['id'], $menu_id );
			}
		}
	}

