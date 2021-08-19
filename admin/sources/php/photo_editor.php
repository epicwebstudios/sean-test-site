<?

ini_set("memory_limit","1000M");

function createImages($source, $tWidth, $mWidth, $fWidth) {

	// Get requested passthrough.
	$file['req'] = $source;
	
	// Set file information.
	$file['info'] = pathinfo($file['req']);
	$file['name'] = $file['info']['filename'];
	$file['ext'] = $file['info']['extension'];
	$file['mod'] = filemtime($file['req']);
	$file['prop'] = getimagesize($file['req']);
	$file['w'] = $file['prop'][0];
	$file['h'] = $file['prop'][1];
	$file['mime'] = $file['prop']['mime'];
	
	// Check for rotation
	$rotate = false;
	if( $file['mime'] == 'image/jpeg' ){
		$exif = exif_read_data($source);
		if( !empty($exif['Orientation']) ){
			switch( $exif['Orientation'] ){
				case 8:
					$rotate = '90';
					break;
				case 3:
					$rotate = '180';
					break;
				case 6:
					$rotate = '-90';
					break;
			}
		}
	}
	
	
	$path = BASE_DIR.'/uploads/photos/';
	if( !is_dir($path) ){ mkdir( $path ); }
	
	
	if(file_exists($file['req'])){
		
		if($file['mime'] == "image/jpeg") {
			$img = imagecreatefromjpeg($file['req']);
		} elseif($file['mime'] == "image/png") {
			$img = imagecreatefrompng($file['req']);
			imagealphablending($img, true);
			imagesavealpha($img, true);
		} elseif($file['mime'] == "image/gif") {
			$img = imagecreatefromgif($file['req']);
		}
		
		$filename = time()."_".$file['name'].".".$file['ext'];
		
		// Save Original
		
			$path = BASE_DIR.'/uploads/photos/o/';
			if( !is_dir($path) ){ mkdir( $path ); }
			$path = $path.$filename;
			
			copy($source, $path);
		
		// End Save Original
		
		
		// Start For Small
		
			$path = BASE_DIR.'/uploads/photos/s/';
			if( !is_dir($path) ){ mkdir( $path ); }
			$path = $path.$filename;
		
			$h = $tWidth;
			$w = $tWidth;
		
			if($file['w'] >= $file['h']){
				$new_width = $w;
				$new_height = (($file['h']/$file['w'])*$new_width);
				if($new_width > $file['w']){
					$new_width = $file['w'];
					$new_height = $file['h'];
				}
			} else {
				$new_height = $h;
				$new_width = (($file['w']/$file['h'])*$new_height);
				if($new_height > $file['h']){
					$new_width = $file['w'];
					$new_height = $file['h'];
				}
			}
		
			$output = imagecreatetruecolor($new_width, $new_height);
			imagealphablending($output, false);
			imagesavealpha($output, true);
			$color = imagecolorallocatealpha($output,255,255,255,127);
			imagefilledrectangle($output,0,0,$w,$h,$color);
			imagecolortransparent($output, $color);
			imagealphablending($output, true);
			imagesavealpha($output, true);
	
			imagecopyresampled($output, $img, 0, 0, 0, 0, $new_width, $new_height, $file['w'], $file['h']);
			imagealphablending($img, true);
			imagesavealpha($img, true);
			
			if( $rotate ){
				$output = imagerotate( $output, $rotate, 0 );
			}
							
			//header('Content-type: '.$file['mime']);
			if($file['mime'] == "image/jpeg") {
				imagejpeg($output, $path, 85);
			} elseif($file['mime'] == "image/png") {
				imagepng($output, $path, 9);
				imagealphablending($output, true);
				imagesavealpha($output, true);
			} elseif($file['mime'] == "image/gif") {
				imagegif($output, $path);
			}
			
			imagedestroy($output);
			
		// End For Small
		
		// Start For Medium
		
			$path = BASE_DIR.'/uploads/photos/m/';
			if( !is_dir($path) ){ mkdir( $path ); }
			$path = $path.$filename;
		
			$h = $mWidth;
			$w = $mWidth;
		
			if($file['w'] >= $file['h']){
				$new_width = $w;
				$new_height = (($file['h']/$file['w'])*$new_width);
				if($new_width > $file['w']){
					$new_width = $file['w'];
					$new_height = $file['h'];
				}
			} else {
				$new_height = $h;
				$new_width = (($file['w']/$file['h'])*$new_height);
				if($new_height > $file['h']){
					$new_width = $file['w'];
					$new_height = $file['h'];
				}
			}
		
			$output = imagecreatetruecolor($new_width, $new_height);
			imagealphablending($output, false);
			imagesavealpha($output, true);
			$color = imagecolorallocatealpha($output,255,255,255,127);
			imagefilledrectangle($output,0,0,$w,$h,$color);
			imagecolortransparent($output, $color);
			imagealphablending($output, true);
			imagesavealpha($output, true);
	
			imagecopyresampled($output, $img, 0, 0, 0, 0, $new_width, $new_height, $file['w'], $file['h']);
			imagealphablending($img, true);
			imagesavealpha($img, true);
			
			if( $rotate ){
				$output = imagerotate( $output, $rotate, 0 );
			}
							
			//header('Content-type: '.$file['mime']);
			if($file['mime'] == "image/jpeg") {
				imagejpeg($output, $path, 85);
			} elseif($file['mime'] == "image/png") {
				imagepng($output, $path, 9);
				imagealphablending($output, true);
				imagesavealpha($output, true);
			} elseif($file['mime'] == "image/gif") {
				imagegif($output, $path);
			}
			
			imagedestroy($output);
			
		// End For Medium
		
		// Start For Large
		
			$path = BASE_DIR.'/uploads/photos/l/';
			if( !is_dir($path) ){ mkdir( $path ); }
			$path = $path.$filename;
		
			$h = $fWidth;
			$w = $fWidth;
		
			if($file['w'] >= $file['h']){
				$new_width = $w;
				$new_height = (($file['h']/$file['w'])*$new_width);
				if($new_width > $file['w']){
					$new_width = $file['w'];
					$new_height = $file['h'];
				}
			} else {
				$new_height = $h;
				$new_width = (($file['w']/$file['h'])*$new_height);
				if($new_height > $file['h']){
					$new_width = $file['w'];
					$new_height = $file['h'];
				}
			}
		
			$output = imagecreatetruecolor($new_width, $new_height);
			imagealphablending($output, false);
			imagesavealpha($output, true);
			$color = imagecolorallocatealpha($output,255,255,255,127);
			imagefilledrectangle($output,0,0,$w,$h,$color);
			imagecolortransparent($output, $color);
			imagealphablending($output, true);
			imagesavealpha($output, true);
	
			imagecopyresampled($output, $img, 0, 0, 0, 0, $new_width, $new_height, $file['w'], $file['h']);
			imagealphablending($img, true);
			imagesavealpha($img, true);
			
			if( $rotate ){
				$output = imagerotate( $output, $rotate, 0 );
			}
							
			//header('Content-type: '.$file['mime']);
			if($file['mime'] == "image/jpeg") {
				imagejpeg($output, $path, 85);
			} elseif($file['mime'] == "image/png") {
				imagepng($output, $path, 9);
				imagealphablending($output, true);
				imagesavealpha($output, true);
			} elseif($file['mime'] == "image/gif") {
				imagegif($output, $path);
			}
			
			imagedestroy($output);
			
		// End For Large
		
		unlink($source);
		
		return $filename;
		
	} else {
		
		if( file_exists($source) ){
			unlink($source);
		}
	
		return "error";
	
	}
	
}
	
