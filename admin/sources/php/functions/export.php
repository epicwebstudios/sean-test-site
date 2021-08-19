<?


	function csv_header( $filename ){
		
		$filename = slugify( $filename );
		
		if( substr($filename, -4) != '.csv' ){
			$filename .= '.csv';
		}
		
		header( 'Content-Type: text/csv' );
		header( 'Content-disposition: inline; filename="'.$filename.'"' );
	}
		
		
	function csv_format_text( $string ){
		$string = str_replace( '"', '""', $string );
		return '"'.$string.'"';
	}
	
	
	function csv_format_boolean( $boolean ){
		$result = 'No';
		if( $boolean ){ $result = 'Yes'; }
		return format_text( $result );
	}
		
		
	function csv_format_date_time( $timestamp ){
		$date = date( 'Y-m-d H:i:s', $timestamp );
		if( $timestamp == 0 ){
			return format_text( ' ' );
		}
		return $date;
	}
	
	
	function csv_format_date( $timestamp ){
		$date = date( 'Y-m-d', $timestamp );
		if( $timestamp == 0 ){
			return format_text( ' ' );
		}
		return $date;
	}
	
	
	function csv_format_time( $timestamp ){
		$date = date( 'H:i:s', $timestamp );
		if( $timestamp == 0 ){
			return format_text( ' ' );
		}
		return $date;
	}
	
	
	function csv_format_money( $value ){
		$value = number_format( $value, 2, '.', '' );
		$value = '$'.$value;
		return format_text( $value );
	}


