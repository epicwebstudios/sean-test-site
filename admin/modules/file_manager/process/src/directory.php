<?

	$dir 			= $_POST['directory'];
	$sort_by		= $_POST['sort_by'];
	$sort_dir		= $_POST['sort_dir'];


	$folders 		= array();
	$sort_folders	= array();
	$files 			= array();
	$sort_files		= array();
	$output			= array();
	$omit_files 	= array();
	$custom_icons 	= array();


	$rQ = mysql_query( "SELECT * FROM `file_manager` ORDER BY `id` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		
		if( $r['omit'] ){
			$omit_files[] = $r['file_path'];
		}
		
		if( $r['icon'] || $r['color'] || $r['thumbnail'] ){
			
			$custom_icons[$r['file_path']] = array();
			
			if( $r['icon'] ){
				$custom_icons[$r['file_path']]['icon'] = $r['icon'];
			}
			
			if( $r['color'] ){
				$custom_icons[$r['file_path']]['color'] = $r['color'];
			}
			
			if( $r['thumbnail'] ){
				$custom_icons[$r['file_path']]['thumb'] = $r['thumbnail'];
			}
			
		}
		
	}


	$raw = scandir( $dir );
	foreach( $raw as $file ){
		if( ($file != '.') && ($file != '..') ){
			
			$file_path  = $dir.$file;
			$file_url	= str_replace( BASE_DIR, SITE_URL, $file_path );
			$file_time	= filemtime( $file_path );
			$file_size	= filesize( $file_path );
				
			$icon 	= '';
			$color	= '';
			$thumb 	= '';
			$omit	= false;
			
			if( in_array($file_path, $omit_files) ){
				$omit = true;
			}
			
			if( is_dir($file_path) ){
				
				$icon = 'fas fa-folder';
				
				if( is_array($custom_icons[$file_path]) ){
					$ref = $custom_icons[$file_path];
					if( $ref['icon'] ){ $icon = $ref['icon']; }
					if( $ref['color'] ){ $color = $ref['color']; }
					if( $ref['thumb'] ){ $thumb = $ref['thumb']; }
				}
				
				$folders[$file_path] = array(
					'file_type'	=> 'folder',
					'file_name' => $file,
					'file_path' => $file_path,
					'file_url'	=> '',
					'modified'	=> date( 'n/j/Y, g:i A', $file_time ),
					'size'		=> format_bytes( $file_size ),
					'icon'		=> $icon,
					'color'		=> $color,
					'thumb'		=> $thumb,
					'omit'		=> $omit,
				);
				
				if( $sort_by == 'name' ){ 		$sort_folders[$file_path] = $file; }
				if( $sort_by == 'modified' ){ 	$sort_folders[$file_path] = $file_time; }
				if( $sort_by == 'size' ){ 		$sort_folders[$file_path] = $file; }
				
			} else {
				
				if( fm_is_image($file_path) ){
					$thumb 	= $file_url;
				} else {
					$icon 	= fm_file_icon( $file_path );
				}
				
				if( is_array($custom_icons[$file_path]) ){
					$ref = $custom_icons[$file_path];
					if( $ref['icon'] ){ $icon = $ref['icon']; }
					if( $ref['color'] ){ $color = $ref['color']; }
					if( $ref['thumb'] ){ $thumb = $ref['thumb']; }
				}
				
				$files[$file_path] = array(
					'file_type' => 'file',
					'file_name' => $file,
					'file_path' => $file_path,
					'file_url'	=> $file_url,
					'modified'	=> date( 'n/j/Y, g:i A', $file_time ),
					'size'		=> format_bytes( $file_size ),
					'icon'		=> $icon,
					'color'		=> $color,
					'thumb'		=> $thumb,
					'omit'		=> $omit,
				);
				
				if( $sort_by == 'name' ){ 		$sort_files[$file_path] = $file; }
				if( $sort_by == 'modified' ){ 	$sort_files[$file_path] = $file_time; }
				if( $sort_by == 'size' ){ 		$sort_files[$file_path] = $file_size; }
				
			}
			
		}
	}


	if( $sort_dir == 'asc' ){
		asort( $sort_folders );
		asort( $sort_files );
	} else {
		arsort( $sort_folders );
		arsort( $sort_files );
	}


	foreach( $sort_folders as $key => $value ){
		$output[] = $folders[$key];
	}


	foreach( $sort_files as $key => $value ){
		$output[] = $files[$key];
	}


	echo json_encode( $output );


