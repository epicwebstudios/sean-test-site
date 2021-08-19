<?


	function clean_filename( $file ){
		$file = iconv( 'UTF-8', 'ASCII//TRANSLIT', $file );
		$file = trim( $file );
		$file = strtolower( $file );
		$file = preg_replace( "/[^A-Za-z0-9-._ ]/", '', $file );
		$file = str_replace( ' ', '-', $file );
		$file = preg_replace( '/-{2,}/','-', $file );
		return $file;
	}


	function config_base_dir(){
		$uploads_folder = config_uploads_folder();
		return ROOT_DIR.$uploads_folder;
	}
	

	function config_base_url(){
		$uploads_folder = config_uploads_folder();
		return SITE_URL.$uploads_folder;
	}


	function config_current_dir(){
		
		$uploads_folder = config_uploads_folder();
		
		if( ($_GET['file']) && (substr($_GET['file'],0,4) != 'blob') ){
			$folder 	= str_replace( '..'.$uploads_folder, '', $_GET['file'] );
			$folder 	= explode( '/', $folder );
			array_pop( $folder );
			$current_dir = BASE_DIR . implode( '/', $folder ) . '/';
			$current_dir = str_replace( '//', '/', $current_dir );
			return $current_dir;
		} else {
			return BASE_DIR;
		}
		
	}

	
	function config_current_file(){
		
		$uploads_folder = config_uploads_folder();
		
		if( ($_GET['file']) && (substr($_GET['file'],0,4) != 'blob') ){
			$folder 	= str_replace( '..'.$uploads_folder, '', $_GET['file'] );
			$folder 	= explode( '/', $folder );
			return end( $folder );
		} else {
			return false;
		}
	}


	function config_custom_icons(){
		
		$path = explode( '/admin', dirname(__FILE__) );
		$path = $path[0];
		require $path.'/sources/init/connect.php';
		
		$rQ = mysql_query( "SELECT * FROM `file_manager` ORDER BY `id` ASC", $connect );
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
		
		return array( 'omit_files' => $omit_files, 'custom_icons' => $custom_icons );
		
	}


	function config_description(){
		$desc = CALLBACK;
		$desc = str_replace( 'mceu_', '', $desc );
		$desc = str_replace( '-inp', '', $desc );
		$desc = intval( $desc );
		$desc = 'mceu_' . ( $desc + 1 );
		return $desc;
	}


	function config_display_type(){
		
		global $display_type;

		if( $_COOKIE['ep_file_manager_list_type'] ){
			return $_COOKIE['ep_file_manager_list_type'];
		}
		
		return $display_type;
		
	}


	function config_root_dir(){
		$path = explode( '/admin', dirname(__FILE__) );
		return $path[0];
	}


	function config_settings(){
		
		$path = explode( '/admin', dirname(__FILE__) );
		$path = $path[0];
		require $path.'/sources/init/connect.php';
		
		$r = mysql_fetch_assoc( mysql_query( "SELECT `file_browser` FROM `settings` WHERE `id` = '1' LIMIT 1", $connect ) );
		
		$settings = json_decode( $r['file_browser'], true );
		
		return $settings;
		
	}


	function config_uploads_folder(){
		
		global $uploads_folder;
		
		if( $_GET['directory'] ){
			$uploads_folder = $_GET['directory'];
		}

		if( substr($uploads_folder, 0, 1) != '/' ){
			$uploads_folder = '/'.$uploads_folder;
		}

		if( substr($uploads_folder, -1) != '/' ){
			$uploads_folder .= '/';
		}
		
		return $uploads_folder;
		
	}


	function ext_icon( $ext ){
		
		switch( $ext ){
			
			case 'bmp':
			case 'tiff':
			case 'svg':
				$icon = 'fas fa-file-image';
				break;
				
			case 'mov':
			case 'mpeg':
			case 'm4v':
			case 'mp4':
			case 'avi':
			case 'mpg':
			case 'flv':
			case 'webm':
				$icon = 'fas fa-file-video';
				break;
				
			case 'wma':
				$icon = 'fas fa-file-audio';
				break;
				
			case 'doc':
			case 'docx':
				$icon = 'fas fa-file-word';
				break;
				
			case 'pdf':
				$icon = 'fas fa-file-pdf';
				break;
				
			case 'xls':
			case 'xlsx':
				$icon = 'fas fa-file-spreadsheet';
				break;
				
			case 'rtf':
			case 'txt':
				$icon = 'fas fa-file-alt';
				break;
				
			case 'csv':
				$icon = 'fas fa-file-csv';
				break;
				
			case 'xml':
			case 'json':
				$icon = 'fas fa-file-code';
				break;
				
			case 'ppt':
			case 'pptx':
				$icon = 'fas fa-file-powerpoint';
				break;
				
			case 'psd':
			case 'ai':
			case 'zip':
				$icon = 'fas fa-file-archive';
				break;
				
			default:
				$icon = 'fas fa-file';
					
		}
		
		return $icon;
		
	}


	function ext_thumb( $filename ){
		
		$image_types = array( 'jpg', 'jpeg', 'png', 'gif' );
					
		$ext = get_extension( $filename );
		
		if( in_array($ext, $image_types) ){
			$filename = explode( '/uploads', $filename );
			$filename = '/uploads'.$filename[1];
			return $filename;
		} else {
			return false;
		}
		
	}


	function format_bytes( $size ){
		$units = array(' B', ' KB', ' MB', ' GB', ' TB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
		return round($size, 2).$units[$i];
	}


	function get_extension( $filename ){
		$ext = explode( '.', $filename );
		$ext = end( $ext );
		return $ext;
	}


	function get_file_url( $filename ){
		$url = $filename;
		$url = str_replace( BASE_DIR.'/', BASE_URL, $url );
		$url = str_replace( BASE_DIR, BASE_URL, $url );
		return $url;
	}


	function get_files( $directory, $type ){
		
		global $omit_files, $valid_types, $custom_icons;
		
		$files		= array();
		$folders	= array();
		$output 	= array();
		
		$dir = scandir( $directory );
		foreach( $dir as $f ){
			
			$filename = $directory.$f;
			
			if( ($f != '.') && ($f != '..') ){
				if( is_dir($filename) ){
					if( !in_array($filename, $omit_files) ){
						
						$icon 	= 'fas fa-folder';
						$style 	= '';
						$thumb	= false;
						
						if( $custom_icons[$filename]['icon'] ){
							$icon = $custom_icons[$filename]['icon'];
						}
						
						if( $custom_icons[$filename]['color'] ){
							$style = 'color: '.$custom_icons[$filename]['color'].';';
						}
						
						if( $custom_icons[$filename]['thumb'] ){
							$thumb = $custom_icons[$filename]['thumb'];
						}
						
						$folders[] = array(
							'file_name' => $f,
							'file_path'	=> $directory.$f,
							'file_url'	=> get_file_url( $filename ),
							'type'		=> 'folder',
							'icon'		=> $icon,
							'style'		=> $style,
							'thumb'		=> $thumb,
							'modified'	=> date( 'n/j/Y, g:i A', filemtime( $filename ) ),
							'size'		=> format_bytes( filesize( $filename ) ),
						);
						
					}
				} else {
					
					$ext = get_extension( $f );
					
					if( !in_array($filename, $omit_files) ){
						if( in_array( $ext, $valid_types[$type] ) ){
						
							$icon 	= ext_icon( $ext );
							$style 	= '';
							$thumb	= ext_thumb( $filename );

							if( $custom_icons[$filename]['icon'] ){
								$icon = $custom_icons[$filename]['icon'];
							}

							if( $custom_icons[$filename]['color'] ){
								$style = 'color: '.$custom_icons[$filename]['color'].';';
							}

							if( $custom_icons[$filename]['thumb'] ){
								$thumb = $custom_icons[$filename]['thumb'];
							}
							
							$files[] = array(
								'file_name' => $f,
								'file_path'	=> $directory.$f,
								'file_url'	=> get_file_url( $filename ),
								'type'		=> 'file',
								'icon'		=> $icon,
								'style'		=> $style,
								'thumb'		=> $thumb,
								'modified'	=> date( 'n/j/Y, g:i A', filemtime( $filename ) ),
								'size'		=> format_bytes( filesize( $filename ) ),
							);
							
						}
					}
					
				}
				
			}
				   
		}
		
		foreach( $folders as $f ){
			$output[] = $f;
		}
		
		foreach( $files as $f ){
			$output[] = $f;
		}
		
		return $output;
		
	}


	function site_url(){
		
		$path = explode( '/admin', dirname(__FILE__) );
		$path = $path[0];
		require $path.'/sources/init/connect.php';
		
		$info = mysql_fetch_assoc( mysql_query( "SELECT `url` FROM `settings` WHERE `id` = '1' LIMIT 1", $connect ) );
		
		return $info['url'];
		
	}


	function string_bool( $variable ){
		if( $variable ){
			return 'true';
		} else {
			return 'false';
		}
	}


	function upload_filename( $directory, $filename ){
		
		$file 	= $directory.$filename;
		
		if( ALLOW_OVERWRITE ){
			return $file;
		}
		
		$temp 	= explode( '.', $filename );
		$ext	= end( $temp );
		array_pop( $temp );
		$base	= implode( '.', $temp );
		$iter	= 1;
		
		
		while( file_exists($file) ){
			$filename 	= $base.'-'.$iter.'.'.$ext;
			$file 		= $directory.$filename;
			$iter++;
		}
		
		return $file;
		
	}


	function validate_login(){
		
		if(
			( !$_COOKIE['admin_user'] ) ||
			( $_COOKIE['admin_user'] == '' ) ||
			( !$_COOKIE['admin_pass'] ) ||
			( $_COOKIE['admin_pass'] == '' )
		){
			die( 'You do not have permission to access this resource. (Error code: 1)' );
		}
		
		$path = explode( '/admin', dirname(__FILE__) );
		$path = $path[0];
		require $path.'/sources/init/connect.php';
		
		$user = addcslashes( $_COOKIE['admin_user'], "'" );
		$pass = addcslashes( $_COOKIE['admin_pass'], "'" );
		
		$query = mysql_query( "SELECT `status` FROM `administrators` WHERE `id` = '".$user."' AND `password` = '".$pass."' LIMIT 1", $connect );
		
		if( mysql_num_rows($query) <= 0 ){
			die( 'You do not have permission to access this resource. (Error code: 2)' );
		}
		
		$r = mysql_fetch_assoc( $query );
		
		if( $r['status'] != '1' ){
			die( 'You do not have permission to access this resource. (Error code: 3)' );
		}
		
	}

