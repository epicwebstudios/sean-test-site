<?


	$items 		= array();
	$children 	= array();
	$allowed	= array();
	
	$rQ = mysql_query( "SELECT * FROM `admin_pages` ORDER BY `parent` ASC, `order` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		
		$items[$r['id']] = $r;
		$children[$r['parent']][] = $r['id'];
		
		if( $user['level'] == '1' ){
			$allowed[] = $r['id'];
		}
		
	}
	
	if( $user['level'] != '1' ){
		$rQ = mysql_query( "SELECT `page` FROM `admin_permissions` WHERE `level` = '".$user['level']."' ORDER BY `page` ASC" );
		while( $r = mysql_fetch_assoc($rQ) ){
			$allowed[] = $r['page'];
		}
	}
	
	
	function generate_menu( $parent, $items, $children, $allowed, $level = 0, $output = false ){
		
		$class = 'navigation_menu';
		if( $level > 0 ){ $class = 'dropdown level_'.$level; }
		
		$output .= '<div class="'.$class.'">';
		
			if( is_array($children[$parent]) ){
				foreach( $children[$parent] as $item ){
					if( in_array($item, $allowed) ){
						
						$id			= $items[$item]['id'];
						$name		= $items[$item]['name'];
						$link		= '#';
						$target		= '';
						$onclick 	= 'return false;';
					
						$class = 'item level_'.$level;
						if( is_array($children[$id]) > 0 ){
							$class .= ' has_children';
						}
						
						if( $items[$item]['external'] ){
							$link		= $items[$item]['link'];
							$target		= $items[$item]['target'];
							$onclick 	= '';
						} else if( $items[$item]['page'] ){
							$link		= '?a='.$id;
							$target		= '';
							$onclick 	= '';
						}
						
						$output .= '<div class="'.$class.'">';
							
							$output .= '<a href="'.$link.'" onclick="'.$onclick.'" target="'.$target.'" class="level_'.$level.'">';
								$output .= $name;
							$output .= '</a>';
							
							if( is_array($children[$id]) > 0 ){
								$output = generate_menu( $id, $items, $children, $allowed, ($level+1), $output );
							}
							
						$output .= '</div>';
					
					}
				}
			}
		
		$output .= '</div>';
		
		return $output;
		
	}
	
	
	echo generate_menu( 0, $items, $children, $allowed );


