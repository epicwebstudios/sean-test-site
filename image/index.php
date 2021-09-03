<?


	// Set base variables...
		$base_path 	= str_replace( '/'.basename(__DIR__), '', dirname(__FILE__) );
		$cache_path = dirname(__FILE__).'/cache';
		if( !is_dir($cache_path) ){ mkdir( $cache_path ); }
		$request 	= explode( '/', $_GET['act'] );


	// Set requested mode and dimensions...
		$mode	= $request[0];
		$width	= $request[1];
		$height	= $request[2];
		unset( $request[0], $request[1], $request[2] );
		
	
	// Check for valid $mode, otherwise set to size...
		switch( $mode ){
			
			case 'size':
			case 'scale':
			case 'cover':
				break;
				
			default:
				$mode = 'size';
				
		}
	
	
	// Set filenames...
		$file 		= implode( '/', $request );
		$base_file	= $base_path.'/uploads/'.$file;
		$file 		= basename( $file );
		if( file_exists($base_file) ){ $modified = filemtime( $base_file ); }
		$cache_file = $cache_path.'/'.$modified.'.'.$mode.'.'.$width.'.'.$height.'.'.$file;
		$extension	= explode( '.', $file );
		$extension	= strtolower( end( $file ) );


	// Check for SVG...
		if( file_exists($base_file) ){
			if( ($extension == 'svg') || (mime_content_type($base_file) == 'image/svg+xml') ){
				header( 'Content-type: image/svg+xml' );
				echo file_get_contents( $base_file );
				die();
			}
		}
		
	
	// Clear width/height if set to auto...	
		if( $width == 'auto' ){ unset( $width ); }
		if( $height == 'auto' ){ unset( $height ); }
	
	
	// Decision time...
		if( file_exists($cache_file) ){
			
			
			// Pull from cached file...
				$img_info 	= getimagesize( $cache_file );
				$img_mime	= $img_info['mime'];
				$img_data 	= file_get_contents( $cache_file );
				
				header( 'Content-type: '.$img_mime );
				echo $img_data;
				
				die();
			
			
		} else {
			if( file_exists($base_file) ){
				
				$valid_ext = array( 'gif', 'jpeg', 'jpg', 'png' );
				$ext = explode( '.', $file );
				$ext = strtolower( end( $ext ) );
				
				if( in_array($ext, $valid_ext) ){
			

					// Process new file and save as cached...
						$img_info 	= getimagesize( $base_file );
						$img_mime	= $img_info['mime'];
						$img_w		= $img_info[0];
						$img_h		= $img_info[1];
						$img_ratio	= ( $img_h / $img_w );
						
						$img_rotate	= false;
						if( $img_mime == 'image/jpeg' ){
							$exif 	= exif_read_data($base_file);
							if( !empty($exif['Orientation']) ){
								switch( $exif['Orientation'] ){
									case 8:
										$img_rotate = '90';
										break;
									case 3:
										$img_rotate = '180';
										break;
									case 6:
										$img_rotate = '-90';
										break;
								}
							}
						}
						
						if( $img_mime == 'image/jpeg' ){
							$img = imagecreatefromjpeg( $base_file );
						} else if( $img_mime == 'image/png' ){
							$img = imagecreatefrompng( $base_file );
							imagealphablending( $img, true );
							imagesavealpha( $img, true );
						} else if( $img_mime == 'image/gif' ){
							$img = imagecreatefromgif( $base_file );
						}
						
						
						if( (!$width) && (!$height) ){
							$width	= $img_w;
							$height	= $img_h;
						}
								
						if( !$width ){ $width = ( $height / $img_ratio ); }
						if( !$height ){ $height = ( $img_ratio * $width ); }
						
						$base_w = $width;
						$base_h = $height;
						
						
						// Mode: Size...
							if( $mode == 'size' ){
								
								if( $img_w > $img_h ){
									$height = ( $img_ratio * $width );
								} else {
									$width = ( $height / $img_ratio );
								}
								
								if( $width > $base_w ){
									$width = $width;
									$height = ( $img_ratio * $width );
								}
								
								if( $height > $base_h ){
									$height = $base_h;
									$width = ( $height / $img_ratio );
								}
								
								$render_w = $width;
								$render_h = $height;
								
								$img_x = 0;
								$img_y = 0;
								
							}
						
						
						// Mode: Scale...
							if( $mode == 'scale' ){
								
								if( $img_w > $img_h ){
									$height = ( $img_ratio * $width );
								} else {
									$width = ( $height / $img_ratio );
								}
								
								if( $width > $img_w ){
									$width = $img_w;
									$height = ( $img_ratio * $width );
								}
								
								if( $height > $img_h ){
									$height = $img_h;
									$width = ( $height / $img_ratio );
								}
								
								$render_w = $width;
								$render_h = $height;
								
								$img_x = 0;
								$img_y = 0;
								
							}
						
						
						// Mode: Cover...
							if( $mode == 'cover' ){
								
								$render_w = $width;
								$render_h = $height;
								
								if( $img_w > $img_h ){
									
									$width = ( $height / $img_ratio );
									
									if( $width < $render_w ){
										$width = $render_w;
										$height = ( $img_ratio * $width );
									}
								
								} else {
									
									$height = ( $img_ratio * $width );
									
									if( $height < $render_h ){
										$height = $render_h;
										$width = ( $height / $img_ratio );
									}
									
								}
								
								$img_x = ( ( $render_w - $width ) / 2 );
								$img_y = ( ( $render_h - $height ) / 2 );
								
							}
							
							
						// Do Rendering...
							$output = imagecreatetruecolor( $render_w, $render_h );
							imagealphablending( $output, false );
							imagesavealpha( $output, true );
							
							$color = imagecolorallocatealpha( $output, 255, 255, 255, 127 );
							imagefilledrectangle( $output, 0, 0, $width, $height, $color );
							imagecolortransparent( $output, $color );
							imagealphablending( $output, true );
							imagesavealpha( $output, true );
					
							imagecopyresampled( $output, $img, $img_x, $img_y, 0, 0, $width, $height, $img_w, $img_h );
							imagealphablending( $output, true );
							imagesavealpha( $output, true );
							imagealphablending( $img, true );
							imagesavealpha( $img, true );
							
							if( $img_rotate ){
								$output = imagerotate( $output, $img_rotate, 0 );
							}
							
							header( 'Content-Disposition: inline; filename="'.$file.'"' );
							header( 'Content-type: '.$img_mime );
							
							if( $img_mime == 'image/jpeg' ){
								imagejpeg( $output, $cache_file, 75 );
								imagejpeg( $output, NULL, 75 );
							} else if( $img_mime == 'image/png' ){
								imagepng( $output, $cache_file, 9 );
								imagepng( $output, NULL, 9 );
								imagealphablending( $output, true );
								imagesavealpha( $output, true );
							} else if( $img_mime == 'image/gif' ){
								imagegif( $output, $cache_file );
								imagegif( $output, NULL );
							}
							
							imagedestroy( $output );
							imagedestroy( $img );
							die();
				
				}
			}
		}


	// If all else fails, empty image...
		$blank 		= dirname(__FILE__).'/blank.png';
		$img_info 	= getimagesize( $blank );
		$img_mime	= $img_info['mime'];
		$img_data 	= file_get_contents( $blank );

		header( 'Content-type: '.$img_mime );
		echo $img_data;

		die();