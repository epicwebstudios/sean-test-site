<?


	/**
	 * Set CSV file download header.
	 *
	 * @param string $filename Desired filename.
	 *
	 * @return void
	 */

	function csv_header( $filename ){
		
		$filename = slugify( $filename );
		
		if( substr($filename, -4) != '.csv' ){
			$filename .= '.csv';
		}
		
		header( 'Content-Type: text/csv' );
		header( 'Content-disposition: inline; filename="'.$filename.'"' );
	}


	/**
	 * Format string as CSV text value.
	 *
	 * @param string $string Value to format.
	 *
	 * @return $string Formatted value.
	 */
		
	function csv_format_text( $string ){
		$string = str_replace( '"', '""', $string );
		return '"'.$string.'"';
	}


	/**
	 * Format string as CSV boolean value.
	 *
	 * @param bool $boolean Value to format.
	 *
	 * @return $string Formatted value.
	 */
	
	function csv_format_boolean( $boolean ){
		$result = 'No';
		if( $boolean ){ $result = 'Yes'; }
		return format_text( $result );
	}


	/**
	 * Format UNIX timestamp as CSV date/time value.
	 *
	 * @param int $timestamp UNIX timestamp to format.
	 *
	 * @return $string Formatted value.
	 */
		
	function csv_format_date_time( $timestamp ){
		$date = date( 'Y-m-d H:i:s', $timestamp );
		if( $timestamp == 0 ){
			return format_text( ' ' );
		}
		return $date;
	}


	/**
	 * Format UNIX timestamp as CSV date value.
	 *
	 * @param int $timestamp UNIX timestamp to format.
	 *
	 * @return $string Formatted value.
	 */
	
	function csv_format_date( $timestamp ){
		$date = date( 'Y-m-d', $timestamp );
		if( $timestamp == 0 ){
			return format_text( ' ' );
		}
		return $date;
	}


	/**
	 * Format UNIX timestamp as CSV time value.
	 *
	 * @param int $timestamp UNIX timestamp to format.
	 *
	 * @return $string Formatted value.
	 */
	
	function csv_format_time( $timestamp ){
		$date = date( 'H:i:s', $timestamp );
		if( $timestamp == 0 ){
			return format_text( ' ' );
		}
		return $date;
	}


	/**
	 * Format a value as CSV monetary value.
	 *
	 * @param mixed $value Amount to format.
	 *
	 * @return $string Formatted value.
	 */
	
	function csv_format_money( $value ){
		$value = number_format( $value, 2, '.', '' );
		$value = '$'.$value;
		return format_text( $value );
	}


