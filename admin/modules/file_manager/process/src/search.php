<?


	function string_search( $value ){
		
		$term = strtolower( $_POST['term'] );
		
		if( strlen($term) > 2 ){
			if( strpos($value, $term) !== false ){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}


	function build_file_list( $files = array(), $dir = BASE_DIR.'/uploads/' ){
		
		$directory = scandir( $dir );
		
		foreach( $directory as $f ){
			if( ($f != '.') && ($f != '..') ){
				
				$filename = $dir.$f;
				
				if( is_dir($filename) ){
					$filename .= '/';
					$files[] = $filename;
					$files = build_file_list( $files, $filename );
				} else {
					$files[] = $filename;
				}
				
			}
		}
		
		
		return $files;
		
	}


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


	$files 			= build_file_list();
	$results 		= array_filter( $files, 'string_search' );
	$folders 		= array();
	$files 			= array();
	$output			= array();
	$omit_files 	= array();
	$custom_icons 	= array();


	foreach( $results as $file ){
		
		if( substr($file, -1) == '/' ){
			$file = substr( $file, 0, (strlen($file)-1) );
		} 
		
		$file_path  = $file;
		$file		= explode( '/', $file );
		$file		= end( $file );
		$file_url	= str_replace( BASE_DIR, SITE_URL, $file_path );

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

			$folders[] = array(
				'file_type'	=> 'folder',
				'file_name' => $file,
				'file_path' => $file_path,
				'file_url'	=> '',
				'modified'	=> date( 'n/j/Y, g:i A', filemtime($file_path) ),
				'size'		=> format_bytes( filesize($file_path) ),
				'icon'		=> $icon,
				'color'		=> $color,
				'thumb'		=> $thumb,
				'omit'		=> $omit,
			);

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

			$files[] = array(
				'file_type' => 'file',
				'file_name' => $file,
				'file_path' => $file_path,
				'file_url'	=> $file_url,
				'modified'	=> date( 'n/j/Y, g:i A', filemtime($file_path) ),
				'size'		=> format_bytes( filesize($file_path) ),
				'icon'		=> $icon,
				'color'		=> $color,
				'thumb'		=> $thumb,
				'omit'		=> $omit,
			);

		}
		
	}


	foreach( $folders as $f ){
		$output[] = $f;
	}


	foreach( $files as $f ){
		$output[] = $f;
	}


	echo json_encode( $output );


