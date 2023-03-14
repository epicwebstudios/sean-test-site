<?


	function resource_icon( $filename ){
		$array = explode( '.', $filename );
		$ext = end( $array );
		$ext = strtolower( $ext );
		
		switch( $ext ){
			
			case 'pdf':
				$icon = 'fa-file-pdf-o';
				break;
			
			case 'mp3':
			case 'wav':
				$icon = 'fa-file-audio-o';
				break;
				
			case 'csv':
			case 'xls':
			case 'xlsx':
				$icon = 'fa-file-excel-o';
				break;
				
			case 'doc':
			case 'docx':
				$icon = 'fa-file-word-o';
				break;
				
			case 'ppt':
			case 'pptx':
				$icon = 'fa-file-powerpoint-o';
				break;
				
			case 'gif':
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'bmp':
			case 'ai':
			case 'psd':
				$icon = 'fa-file-image-o';
				break;
				
			case 'mp4':
			case 'mov':
				$icon = 'fa-file-video-o';
				break;
				
			case 'php':
			case 'html':
			case 'txt':
				$icon = 'fa-file-code-o';
				break;
				
			case 'zip':
			case 'rar':
				$icon = 'fa-file-archive-o';
				break;
				
			case 'url':
				$icon = 'fa-globe';
				break;
		
			default:
				$icon = 'fa-file-o';
		
		}
		
		return $icon;
		
	}


