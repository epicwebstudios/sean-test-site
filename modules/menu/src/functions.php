<?


	$menus		= kv_array( 'm_menus', 'id', 'name' );
	$items 		= array();
	$children 	= array();
	
	foreach( $menus as $key => $value ){
		$items[$key] = array();
	}
	
	
	$rQ = mysql_query( "SELECT * FROM `m_menu_items` WHERE `status` = '1' ORDER BY `parent_id` ASC, `order` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$items[$r['menu_id']][$r['id']] = $r;
		$children[$r['parent_id']][] = $r['id'];
	}
	
	
	function generate_menu( $menu_id, $show_mobile = false, $parent = 0, $level = 0, $output = false ){
		
		global $items, $children;
		
		if( $level > 0 ){ 
			$output .= '<div class="dropdown level_'.$level.'" data-level="'.$level.'">';
		}
		
			if( is_array($children[$parent]) ){
				foreach( $children[$parent] as $item ){
					
					$this_item 	= $items[$menu_id][$item];
					
					$id			= $this_item['id'];
					$label		= $this_item['label'];
					$link		= '#';
					$target		= false;
					$onclick 	= 'return false;';
				
					$class = 'level_'.$level;
					if( is_array($children[$id]) > 0 ){
						$class .= ' has_children';
					}
					
					if( $this_item['link_type'] == '1' ){
						$link 		= $this_item['url'];
						$target		= $this_item['target'];
						$onclick 	= false;
					} else if( $this_item['link_type'] == '2' ){
						$link 		= get_page_url( $this_item['ref_id'] );
						$target		= $this_item['target'];
						$onclick 	= false;
					}
					
					$show_item = false;
					
					if( $show_mobile ){
						$show_item = true;
					} else {
						if( $this_item['mobile_only'] == '0' ){
							$show_item = true;
						}
					}
					
					if( $show_item ){
					
						$output .= '<div class="item '.$class.'" data-level="'.$level.'" data-id="'.$id.'">';
							
							$output .= '<a';
								if( $link ){ $output .= ' href="'.$link.'"'; }
								if( $onclick ){ $output .= ' onclick="'.$onclick.'"'; }
								if( $target ){ $output .= ' target="'.$target.'"'; }
								if( $class ){ $output .= ' class="'.$class.'"'; }
								$output .= ' data-level="'.$level.'"';
								$output .= ' data-id="'.$id.'"';
							$output .= '>';
								$output .= $label;
							$output .= '</a>';
							
							if( is_array($children[$id]) > 0 ){
								$output = generate_menu( $menu_id, $show_mobile, $id, ($level+1), $output );
							}
							
						$output .= '</div>';
					
					}
					
				}
			}
		
		if( $level > 0 ){ 
			$output .= '</div>';
		}
		
		return $output;
		
	}
	
	
	function horizontal_menu( $menu_id ){
		echo '<div class="menu_module menu_'.$menu_id.' horizontal">';
			echo generate_menu( $menu_id );
		echo '</div>';
	}
	
	
	function vertical_menu( $menu_id ){
		echo '<div class="menu_module menu_'.$menu_id.' vertical">';
			echo generate_menu( $menu_id );
		echo '</div>';
	}
	
	
	function mobile_menu( $menu_id ){
		echo '<div class="menu_module menu_'.$menu_id.' mobile">';
			
			echo '<div class="close">';
				echo '<span class="fa fa-close"></span>';
			echo '</div>';
			
			echo '<div class="outer">';
				echo '<div class="inner">';
					echo generate_menu( $menu_id, true );
				echo '</div>';
			echo '</div>';
			
		echo '</div>';
	}
	
	