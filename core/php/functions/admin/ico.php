<?


	/**
	 * Create manifest files for Android and Windows Tiles.
	 *
	 * @param int $time UNIX timestamp to use as a cache breaker.
	 * @param string $name Website or application name.
	 * @param string $theme_color HEX color code of the website / application.
	 *
	 * @return void
	 */
	
	function ico_manifests( $time, $name, $theme_color ){
		
		// Android Manifest
		
			$output = '';
			$output .= '{' . "\n";
			$output .= "\t" . '"name": "'.$name.'",' . "\n";
			$output .= "\t" . '"icons": [' . "\n";
			
			$output .= "\t" . "\t" . '{' . "\n";
			$output .= "\t" . "\t" . "\t" . '"src": "'.returnURL().'/uploads/ico/android-chrome-36x36.png",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"sizes": "36x36",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"type": "image/png"' . "\n";
			$output .= "\t" . "\t" . '},' . "\n";
			
			$output .= "\t" . "\t" . '{' . "\n";
			$output .= "\t" . "\t" . "\t" . '"src": "'.returnURL().'/uploads/ico/android-chrome-48x48.png",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"sizes": "48x48",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"type": "image/png"' . "\n";
			$output .= "\t" . "\t" . '},' . "\n";
			
			$output .= "\t" . "\t" . '{' . "\n";
			$output .= "\t" . "\t" . "\t" . '"src": "'.returnURL().'/uploads/ico/android-chrome-72x72.png",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"sizes": "72x72",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"type": "image/png"' . "\n";
			$output .= "\t" . "\t" . '},' . "\n";
			
			$output .= "\t" . "\t" . '{' . "\n";
			$output .= "\t" . "\t" . "\t" . '"src": "'.returnURL().'/uploads/ico/android-chrome-96x96.png",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"sizes": "96x96",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"type": "image/png"' . "\n";
			$output .= "\t" . "\t" . '},' . "\n";
			
			$output .= "\t" . "\t" . '{' . "\n";
			$output .= "\t" . "\t" . "\t" . '"src": "'.returnURL().'/uploads/ico/android-chrome-144x144.png",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"sizes": "144x144",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"type": "image/png"' . "\n";
			$output .= "\t" . "\t" . '},' . "\n";
			
			$output .= "\t" . "\t" . '{' . "\n";
			$output .= "\t" . "\t" . "\t" . '"src": "'.returnURL().'/uploads/ico/android-chrome-192x192.png",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"sizes": "192x192",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"type": "image/png"' . "\n";
			$output .= "\t" . "\t" . '},' . "\n";
			
			$output .= "\t" . "\t" . '{' . "\n";
			$output .= "\t" . "\t" . "\t" . '"src": "'.returnURL().'/uploads/ico/android-chrome-256x256.png",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"sizes": "256x256",' . "\n";
			$output .= "\t" . "\t" . "\t" . '"type": "image/png"' . "\n";
			$output .= "\t" . "\t" . '}' . "\n";
			
			$output .= "\t" . '],' . "\n";
			$output .= "\t" . '"theme_color": "'.$theme_color.'",' . "\n";
			$output .= "\t" . '"background_color": "'.$theme_color.'",' . "\n";
			$output .= "\t" . '"display": "standalone"' . "\n";
			$output .= '}';
		
			file_put_contents( BASE_DIR.'/manifest.json', $output );
		
		// Windows Tile
		
			$output = '';
			$output .= '<?xml version="1.0" encoding="utf-8"?>' . "\n";
			$output .= '<browserconfig>' . "\n";
			$output .= "\t" . '<msapplication>' . "\n";
			$output .= "\t" . "\t" . '<tile>' . "\n";
			$output .= "\t" . "\t" . "\t" . '<square150x150logo src="'.returnURL().'/uploads/ico/favicon-150x150.png?v='.$time.'"/>' . "\n";
			$output .= "\t" . "\t" . "\t" . '<TileColor>'.$theme_color.'</TileColor>' . "\n";
			$output .= "\t" . "\t" . '</tile>' . "\n";
			$output .= "\t" . '</msapplication>' . "\n";
			$output .= '</browserconfig>' . "\n";
		
			file_put_contents( BASE_DIR.'/browserconfig.xml', $output );
		
	}


	/**
	 * Create Favicon variations from base image.
	 *
	 * Allows you to quickly create all Favicon and shortcut icons from a base image
	 * for Web, iOS and Android.
	 *
	 * @param string $source Server path to base image
	 * @param string $theme_color HEX color code to use as background color (used on iOS icons)
	 *
	 * @return void
	 */
	
	function ico_generate( $source, $theme_color ){
		if( file_exists($source) ){
			
			if( !is_dir(BASE_DIR.'/uploads/ico/') ){
				mkdir( BASE_DIR.'/uploads/ico/' );
			}
			
			$ext = end( explode('.', $source) );
		
			if( $ext == 'png' ){
		
		
				// Generate PNG versions
			
					$file['prop'] 	= getimagesize( $source );
					$file['w'] 		= $file['prop'][0];
					$file['h'] 		= $file['prop'][1];
		
					$img = imagecreatefrompng( $source );
					imagealphablending( $img, true );
					imagesavealpha( $img, true );
					
					$sizes = array( 16, 32, 64, 150 );
					$and_sizes = array( 36, 48, 72, 96, 144, 180, 192, 256 );
					$ios_sizes = array( 57, 60, 72, 76, 114, 120, 144, 152, 180 );
					
					foreach( $sizes as $size ){
						
						$w = $size;
						$h = $size;
						$x = 0;
						$y = 0;
				
						$output = imagecreatetruecolor( $w, $h );
						imagealphablending( $output, false );
						imagesavealpha( $output, true );
						
						$color = imagecolorallocatealpha( $output, 255, 255, 255, 127 );
						imagefilledrectangle( $output, 0, 0, $w, $h, $color );
						imagecolortransparent( $output, $color );
						
						imagealphablending( $output, true );
						imagesavealpha( $output, true );
						
						imagecopyresampled( $output, $img, $x, $y, 0, 0, $w, $h, $file['w'], $file['h'] );
						imagealphablending( $img, true );
						imagesavealpha( $img, true );
						
						imagepng( $output, BASE_DIR.'/uploads/ico/favicon-'.$size.'x'.$size.'.png', 9 );
						imagealphablending( $output, true );
						imagesavealpha( $output, true );
							
						imagedestroy( $output );
						
					}
					
					foreach( $and_sizes as $size ){
						
						$w = $size;
						$h = $size;
						$x = 0;
						$y = 0;
				
						$output = imagecreatetruecolor( $w, $h );
						imagealphablending( $output, false );
						imagesavealpha( $output, true );
						
						$color = imagecolorallocatealpha( $output, 255, 255, 255, 127 );
						imagefilledrectangle( $output, 0, 0, $w, $h, $color );
						imagecolortransparent( $output, $color );
						
						imagealphablending( $output, true );
						imagesavealpha( $output, true );
						
						imagecopyresampled( $output, $img, $x, $y, 0, 0, $w, $h, $file['w'], $file['h'] );
						imagealphablending( $img, true );
						imagesavealpha( $img, true );
						
						imagepng( $output, BASE_DIR.'/uploads/ico/android-chrome-'.$size.'x'.$size.'.png', 9 );
						imagealphablending( $output, true );
						imagesavealpha( $output, true );
							
						imagedestroy( $output );
						
					}
					
					foreach( $ios_sizes as $size ){
						
						$w = $size;
						$h = $size;
						$x = 0;
						$y = 0;
				
						$output = imagecreatetruecolor( $w, $h );
						imagealphablending( $output, false );
						imagesavealpha( $output, true );
							
						$color = color_convert( $theme_color, 'hex', 'rgb' );
						$color = imagecolorallocate( $output, $color['r'], $color['g'], $color['b'] );
						imagefilledrectangle( $output, 0, 0, $w, $h, $color );
						
						imagealphablending( $output, true );
						imagesavealpha( $output, true );
						
						$padding = round(4*($w / 57));
						
						$w = ( $w - ($padding*2) );
						$h = ( $h - ($padding*2) );
						$x = $padding;
						$y = $padding;
						
						imagecopyresampled( $output, $img, $x, $y, 0, 0, $w, $h, $file['w'], $file['h'] );
						imagealphablending( $img, true );
						imagesavealpha( $img, true );
						
						if( $size == '180' ){
							imagepng( $output, BASE_DIR.'/uploads/ico/apple-touch-icon.png', 9 );
						}
						
						imagepng( $output, BASE_DIR.'/uploads/ico/apple-touch-icon-'.$size.'x'.$size.'.png', 9 );
						imagealphablending( $output, true );
						imagesavealpha( $output, true );
							
						imagedestroy( $output );
						
					}
					
					imagedestroy( $img );
					
		
				// Generate ICO version	
		
					$sizes = array(
						array( 16, 16 ),
						array( 24, 24 ),
						array( 32, 32 ),
						array( 48, 48 ),
						array( 64, 64 )
					);
		
					$ico = new PHP_ICO( $source, $sizes );
					$ico->save_ico( BASE_DIR.'/uploads/ico/favicon.ico' );
					
					
				// Copy files to root.
				
					copy( BASE_DIR.'/uploads/ico/favicon.ico', BASE_DIR.'/favicon.ico' );
					copy( BASE_DIR.'/uploads/ico/apple-touch-icon.png', BASE_DIR.'/apple-touch-icon.png' );
					copy( BASE_DIR.'/uploads/ico/apple-touch-icon.png', BASE_DIR.'/apple-touch-icon-precomposed.png' );
					
				
				unlink( $source );
				return $icon;
			
			}	
		}
		
		return false;
		
	}

