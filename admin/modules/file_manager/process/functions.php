<?


	function fm_get_extension( $file ){
		$parts = explode( '.', $file );
		return end( $parts );
	}


	function fm_is_image( $file ){
		$valid 	= array( 'jpg', 'gif', 'png', 'webm' );
		$ext	= fm_get_extension( $file );
		if( in_array($ext, $valid) ){
			return true;
		}
		return false;
	}


	function fm_file_icon( $file ){
		
		$ext	= fm_get_extension( $file );
		
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


	function fm_upload_filename( $directory, $filename ){
		
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


