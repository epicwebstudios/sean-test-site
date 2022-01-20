<?


	function listing_columns( $columns, $allow_order, $allow_duplicate, $allow_edit, $allow_delete, $filter_list = false, $auto_size = true ){
		
		$default_width = 940;
		$preset_width = 0;
		$column_count = count( $columns );
		
		if( $allow_order ){ $default_width = ( $default_width - 50 ); }
		if( $allow_duplicate ){ $default_width = ( $default_width - 55 ); }
		if( $allow_edit ){ $default_width = ( $default_width - 20 ); }
		if( $allow_delete ){ $default_width = ( $default_width - 35 ); }
		
		foreach( $columns as $column ){
			if( $column['width'] > 0 ){
				$preset_width = ( $preset_width + $column['width'] );
				$column_count--;
			}
		}
		
		$default_width = ( $default_width - $preset_width );
		$default_width = ( $default_width / $column_count );
		
		$sorted_desc 	= '<span class="fa fa-sort-alpha-desc" title="Sorted descendingly (Z to A)"></span>';
		$sorted_asc 	= '<span class="fa fa-sort-alpha-asc" title="Sorted ascendingly (A to Z)"></span>';
		
		if( is_array($columns) ){
			foreach( $columns as $column ){
			
				$width = 'min-width: '.$default_width.'px;';
				$title = $column['title'];
				$sort_by = false;
				$sort_dir = false;
				$sort_img = '';
				
				if( $column['width'] > 0 ){
					$width = 'width: '.$column['width'].'px;';
				}
				
				if( $column['sort'] ){
					
					$url = '?a='.$_GET['a'];
					if( $filter_list ){
						$url .= filter_string( $filter_list, 'sb,d', false );
					}
					
					$sort_by = $column['sort'];
					$sort_dir = 'asc';
					
					$url .= '&sb='.$sort_by;
					
					if( $_GET['sb'] == $sort_by ){
						if( $_GET['d'] == 'asc' ){
							$sort_img = $sorted_asc;
							$sort_dir = 'desc';
						} else {
							$sort_img = $sorted_desc;
							$sort_dir = 'asc';
						}
					}
					
					$url .= '&d='.$sort_dir;
					
					$title = '<a href="'.$url.'">'.$title.'</a>';
					
				}
				
				echo '<td class="category" '.($auto_size ? 'style="'.$width : '').'">';
					echo $title.' '.$sort_img;
				echo '</td>';
						
			}
		}
		
		

		if( $allow_order ){
			
			$url = '?a='.$_GET['a'];
			if( $filter_list ){
				$url .= filter_string( $filter_list, 'sb,d', false );
			}
					
			$sort_by = 'order';	
			$sort_dir = 'asc';
					
			$url .= '&sb='.$sort_by;
			
			if( $_GET['sb'] == $sort_by ){
				if( $_GET['d'] == 'asc' ){
					$sort_img = $sorted_asc;
					$sort_dir = 'desc';
				} else {
					$sort_img = $sorted_desc;
					$sort_dir = 'asc';
				}
			}
			
            echo '<td class="category" style="width: 50px;" align="center">';
				echo '<a href="'.$url.'">Order</a> '.$sort_img;
			echo '</td>';
		}
			
		if( $allow_duplicate ){
            echo '<td class="category" style="width: 55px;" align="center">';
            	echo 'Duplicate';
            echo '</td>';
		}
            
		if( $allow_edit ){
            echo '<td class="category" style="width: 20px;" align="center">';
            	echo 'Edit';
            echo '</td>';
		}
            
		if( $allow_delete ){
            echo '<td class="category" style="width: 35px;" align="center">';
            	echo 'Delete';
            echo '</td>';
		}
		
	}
	
	
	function listing_pagination_count( $stmt, $page_limit ){
	
		$pages = array();
		$pages['records'] 		= mysql_num_rows( mysql_query($stmt) );
		$pages['count'] 		= ceil( $pages['records'] / $page_limit );
		$pages['current'] 		= intval( $_GET['p'] );
		$pages['previous'] 		= false;
		$pages['next'] 			= false;
		$pages['limit'] 		= '0, '.$page_limit;
		$pages['start'] 		= 1;
		$pages['end'] 			= $page_limit;
		
		if( $pages['count'] < 1 ){
			$pages['count'] 	= 1;
		}
		
		if( $pages['current'] < 1 ){ 
			$pages['current'] 	= 1;
		}
		
		if( $pages['current'] > $pages['count'] ){ 
			$pages['current'] 	= $pages['count'];
		}
		
		if( $pages['current'] > 1 ){
			$pages['previous'] 	= ( $pages['current'] - 1 );
			$pages['limit'] 	= ( ($pages['current'] - 1) * $page_limit ).', '.$page_limit;
			$pages['start'] 	= ( (($pages['current'] - 1) * $page_limit) + 1 );
			$pages['end'] 		= ( $pages['current'] * $page_limit );
		}
		
		if( $pages['current'] < $pages['count'] ){
			$pages['next'] 		= ( $pages['current'] + 1 );
		}
		
		if( $pages['end'] > $pages['records'] ){
			$pages['end'] = $pages['records'];
		}
	
		return $pages;
		
	}
	
	
	function listing_pagination( $pages, $search, $filter_list, $position = 'bottom' ){
		
		$base_url = '?a='.$_GET['a'];
		
?>

    <table class="page_nav">
        <tr>
            <td class="left">          	
                
                <? if( $position == 'top' ){ ?>
                
                    <? if( count($search) > 0 ){ ?>
                        <form onsubmit="return false;">
                            
                            <input
                                type="text"
                                id="search_field"
                                value="<? echo $_GET['s']; ?>"
                                placeholder="Search..."
                                size="30"
                            />
                            
                            &nbsp;
                            
                            <input
                                type="submit"
                                value="Search"
                                onclick="if( $('#search_field').val() != '') { window.location='<? echo $base_url; filter_string( $filter_list, 's', true ); ?>&s=' + $('#search_field').val(); }"
                            />
                            
                            <? if( $_GET['s'] ){ ?>
                                
                                &nbsp;
                                
                                <input
                                    type="button"
                                    value="Clear Search"
                                    onclick="window.location = '<? echo $base_url; ?>';"
                                />
                                
                            <? } ?>
                            
                        </form>
                    <? } ?>
                
                <? } ?>
                
            </td>
            <td class="right">
                
                <? if( $pages['records'] ){ ?>
                    Displaying <? echo $pages['start']; ?> - <? echo $pages['end']; ?> (of <? echo $pages['records']; ?>)
                <? } else { ?>
                    No records to display
                <? } ?>
                
                &nbsp;&nbsp;
    
                <input 
                    type="button" 
                    value="Refresh" 
                    title="Refresh" 
                    onclick="window.location = '<? echo $base_url; filter_string( $filter_list, false, true ); ?>';" 
                /> 
    
                &nbsp;&nbsp;
                
                <input 
                    type="button" 
                    value="&laquo;" 
                    title="First Page" 
                    <? if( $pages['previous'] ){ ?>
                        onclick="window.location = '<? echo $base_url; filter_string( $filter_list, 'p', true ); ?>';"
                    <? } else { ?>
                        disabled
                    <? } ?>
                />
    
                &nbsp;&nbsp;
                
                <input 
                    type="button" 
                    value="&lsaquo;" 
                    title="Previous Page" 
                    <? if( $pages['previous'] ){ ?>
                    	<? if( $pages['previous'] == '1' ){ ?>
                        	onclick="window.location = '<? echo $base_url; filter_string( $filter_list, 'p', true ); ?>';"
                        <? } else { ?>
                        	onclick="window.location = '<? echo $base_url; filter_string( $filter_list, 'p', true ); ?>&p=<? echo $pages['previous']; ?>';"
                        <? } ?>
                    <? } else { ?>
                        disabled
                    <? } ?>
                />
    
                &nbsp;&nbsp;
            
                Page 
                <select name="page" onchange="window.location = '<? echo $base_url; filter_string( $filter_list, 'p', true ); ?>' + this.options[this.selectedIndex].value;">
                    <? 
                        for( $p=1; $p <= $pages['count']; $p++ ){
                            
                            $value = '&p='.$p;
                            $selected = '';
                            
							if( $p == 1 ){ 
								$value = '';
							}
							
                            if( $p == $pages['current'] ){
								$selected = 'selected';
							}
                            
                            echo '<option value="'.$value.'" '.$selected.'>'.$p.'</option>';
                             
                        }
                    ?>
                </select> 
                of <? echo $pages['count']; ?>
            
                &nbsp;&nbsp;
    
                <input 
                    type="button" 
                    value="&rsaquo;" 
                    title="Next Page"
                    <? if( $pages['next'] ){ ?>
                        onclick="window.location = '<? echo $base_url; filter_string( $filter_list, 'p', true ); ?>&p=<? echo $pages['next']; ?>';"
                    <? } else { ?>
                        disabled
                    <? } ?>
                />
                
                &nbsp;&nbsp;
                
                <input 
                    type="button" 
                    value="&raquo;" 
                    title="Last Page" 
                    <? if( $pages['next'] ){ ?>
                        onclick="window.location = '<? echo $base_url; filter_string( $filter_list, 'p', true ); ?>&p=<? echo $pages['count']; ?>';" 
                    <? } else { ?>
                        disabled
                    <? } ?>
                />
    
            </td>
        </tr>
	</table>
    
<?
	}

    /**
     * Returns HTML table of recommended banner dimensions
     * @return string
     */
    function render_banner_dimensions() {
        $output = '';

        $dimensions = fetch_all("SELECT `id`, `name`, `banner_dimensions` FROM `page_templates`");

        if ($dimensions) {
            $output .= '<table class="recommended-banner-dimensions">';
            $output .= '<tbody>';
            $output .= '<tr><td colspan="2"><b>Recommended Dimensions</b></td></tr>';

            foreach ($dimensions as $dimension) {

                if ($dimension['banner_dimensions']) {
                    $the_dimensions = json_decode($dimension['banner_dimensions'], true);

                    $output .= '<tr><td>'.$dimension['name'].': </td>';
                    $output .= '<td>'.$the_dimensions['width'].'x'.$the_dimensions['height'].'</td></tr>';
                }
            }

            $output .= '</tbody>';
            $output .= '</table>';
        }

        return $output;
    }