<?
	

	/**
	 * Add a JavaScript alert()
	 *
	 * @param string $message Message to use within alert.
	 *
	 * @return void
	 */
	
	function alert( $message ){
		echo "<script>alert('".addcslashes( $message, "'" )."');</script>";
	}
	

	/**
	 * Add a key/value pair to the beginning of an existing array.
	 *
	 * @param array $array Array to append to
	 * @param mixed $key New element key.
	 * @param mixed $value New element value.
	 *
	 * @return array Altered array.
	 */

	function array_prepend( $array, $key, $value = false ){
		
		$output = array();
		
		if( $value ){
			$output[$key] = $value;
		} else {
			$output[] = $value;
		}
		
		if( is_array($array) ){
			foreach( $array as $k => $v ){
				$output[$k] = $v;
			}
		}
		
		return $output;
		
	}
	

	/**
	 * Find out if array contains a specific value.
	 *
	 * @param array $array Array to search.
	 * @param string $search Value to search for.
	 *
	 * @return bool Result of search.
	 */

	function array_str_contains( $array, $search ){
		
		foreach( $array as $item ){
			if( str_contains($search, $item) ){
				return true;
			}
		}

		return false;
		
    }
	

	/**
	 * Clean and format a filename.
	 *
	 * @param string $file Filename to clean.
	 *
	 * @return string Cleaned filename.
	 */

	function clean_filename( $file ){
		$file = iconv( 'UTF-8', 'ASCII//TRANSLIT', $file );
		$file = trim( $file );
		$file = strtolower( $file );
		$file = preg_replace( "/[^A-Za-z0-9-._ ]/", '', $file );
		$file = str_replace( ' ', '-', $file );
		$file = preg_replace( '/-{2,}/','-', $file );
		return $file;
	}


	/**
	 * Redirect user to URL after specified number of seconds using JavaScript.
	 *
	 * @param string $url URL to redirect user to.
	 * @param int $seconds Optional. Number of seconds to delay prior to redirection.
	 *
	 * @return void
	 */
	
	function delay( $url, $seconds = 5 ){
		$seconds = ( $seconds * 1000 );
		echo "<script>setTimeout('window.location=".$url.";', ".$seconds.")</script>";
	}


	/**
	 * Convert plain text e-mail address to ASCII character representation.
	 *
	 * Can be used to obfuscate e-mail addresses on pages in code to make
	 * it less likely to be scraped by data scrapers, but appears normally
	 * to any given user.
	 *
	 * @param string $email E-mail address to convert.
	 *
	 * @return string Resulting email conversion.
	 */
	
	function encode_email( $email ) {
		
		$output = '';
		
		for( $i=0; $i<strlen($email); $i++ ){ 
			$output .= '&#'.ord($email[$i]).';'; 
		}
		
		return $output;
		
	}


	/**
	 * Convert all array values to an htmlentities() version.
	 *
	 * Can be used to convert an array to make instantly usable in HTML attributes.
	 *
	 * @param array $array Array to convert.
	 * @param array $omit Record keys to omit from conversion.
	 *
	 * @return array Resulting array conversion.
	 */
	
	function entities( $array, $omit = array() ){
		if( is_array($array) ){
			foreach( $array as $key => $value ){
				if( !in_array($key, $omit) ){
					$array[$key] = htmlentities( $array[$key] );
				}
			}
		} else {
			$array = htmlentities( $array );
		}
		return $array;
	}


	/**
	 * Force currently requested URL to end in a trailing slash.
	 *
	 * If the URL requested does not end in a trailing slash, this function will redirect
	 * users to the "correct" version of the URL.
	 *
	 * @param bool $temporary Optional. If true, a 302 redirect is used, otherwise 301 redirect. Defaults to false.
	 *
	 * @return void
	 */

	function force_trailing_slash( $temporary = false ){
		
		if( substr($_SERVER['SCRIPT_URL'], -1) != '/' ){
		
			if( ($_SERVER['HTTPS']) || ($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ){
				$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_URL'].'/';
			} else {
				$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_URL'].'/';
			}
			
			$params = array();
			
			foreach( $_GET as $k => $v ){
				if( $k != 'act' ){
					$params[] = $k.'='.$v;
				}
			}
			
			$params = implode( '&', $params );
			
			if( $params != '' ){
				$url .= '?'.$params;
			}
			
			if( $temporary ){
				header( 'Location: '.$url );
				die();
			} else {
				header( 'Location: '.$url, true, 301 );
				die();
			}
			
		}
		
		return;
		
	}


	/**
	 * Convert filesize bytes to friendly, common value.
	 *
	 * @param int $size Byte count.
	 *
	 * @return string Converted file size.
	 */

	function format_bytes( $size ){
		$units = array(' B', ' KB', ' MB', ' GB', ' TB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
		return round($size, 2).$units[$i];
	}


	/**
	 * Generate a random, hash key.
	 *
	 * @param int $size Optional. The length of the key to generate. Defaults to 15 characters.
	 *
	 * @return string Generated key.
	 */

	function generate_key( $size = 15 ){
			
		$key = '';
		$key .= time();
		$key .= uniqid();
		$key .= $_SERVER['REMOTE_ADDR'];
		$key .= mt_rand(10000,99999);
		$key = hash( 'sha256', $key );

		if( $size ){
			$min 	= 0;
			$max 	= ( strlen($key) - $size );
			$start 	= mt_rand( $min, $max );
			$key	= substr( $key, $start, $size );
		}

		return $key;
		
	}
	

	/**
	 * Determines if string has escape slashes.
	 *
	 * @param string $string Value to test.
	 *
	 * @return bool Result of the test.
	 */

	function has_slashes( $string ){
		if( strpos($string, '\\') !== false ){
			return true;
		} else {
			return false;
		}
	}

	
	/**
	 * Convert integer value to boolean equivalent.
	 *
	 * @param int $value Value to convert.
	 *
	 * @return bool Converted result.
	 */

	function int_to_bool( $value ){
		
		if( $value == '1' ){
			return true;
		}
		
		return false;
		
	}

	
	/**
	 * Determine if passed variable is valid JSON.
	 *
	 * @param mixed $string Value to test.
	 *
	 * @return bool 
	 */

	function is_json( $string ){
 		json_decode( $string, true );
 		return ( json_last_error() == JSON_ERROR_NONE );
	}

	
	/**
	 * Automatically create an array from database table records.
	 *
	 * The $value parameter can either be a single column name, or can be a 
	 * variable-style string, used as concatenation, where the desired columns
	 * can be passed as {column-name} variables.
	 *
	 * Variable $value example: 'ID#{id} {first_name} {last_name}' would give you
	 * a value using the 'id', 'first_name', and 'last_name' columns in the format
	 * specified.
	 *
	 * @param string $table Table to pull results from.
	 * @param string $key Column name to use as array key.
	 * @param string $value Column(s) to use as array value.
	 * @param string $where Optional. Any WHERE clauses to add to the generation query.
	 * @param string $order_by Optional. The ORDER BY clause for the generation query. Defaults to sorting by first $value column.
	 *
	 * @return array Generated array of records. 
	 */

	function kv_array( $table, $key, $value, $where = false, $order_by = false ){
		
		$columns 	= array( '`'.$key.'`' );
		$values 	= array( $key );
		
		if( strpos($value, '{') !== false ){
			preg_match_all( "/\{(.*?)\}/", $value, $col );
			foreach( $col[1] as $column ){
				if( !in_array($column, $values) ){
					$columns[] 	= '`'.$column.'`';
					$values[] 	= $column;
				}
			}
		} else {
			$columns[] 	= '`'.$value.'`';
			$values[] 	= $value;
		}
		
		if( ($where) && (substr(trim($where), 0, 5) != 'WHERE') ){
			$where = " WHERE ".$where." ";
		} else {
			$where = '';
		}
		
		if( ($order_by) && (substr(trim($order_by), 0, 8) != 'ORDER BY') ){
			$order_by = " ORDER BY ".$order_by. " ";
		} else {
			$order_by = " ORDER BY ".$columns[1]." ASC ";
		}
		
		$stmt  = "";
		$stmt .= " SELECT ".implode( ', ', $columns )." ";
		$stmt .= " FROM `".$table."` ";
		$stmt .= $where;
		$stmt .= $order_by;
		
		$output = array();
		
		$rQ = mysql_query( $stmt );
		while( $r = mysql_fetch_assoc($rQ) ){
			
			if( count($values) > 2 ){
				$string = $value;
				foreach( $values as $col ){
					$string = str_replace( '{'.$col.'}', $r[$col], $string );
				}
			} else {
				$string = $r[$value];
			}
			
			$output[$r[$key]] = trim( $string );
		}
		
		return $output;
			
	}
	
	
	/**
	 * Wrap a variable value with specific tags.
	 *
	 * @param string $string Value to wrap.
	 * @param string $element Optional. Element to wrap around value. Defaults to 'div'.
	 * @param bool $return Optional. If set to true, the result is returned, otherwise the result is echoed.
	 *
	 * @return void|string Wrapped variable value 
	 */

	function line( $string, $element = 'div', $return = false ){
		$output = '<'.$element.'>'.$string.'</'.$element.'>';
		if( $return ){ return $output; }
		echo $output;
	}
	
	
	/**
	 * Convert numeric value to money representation.
	 *
	 * If $international is specified as true, the value will be formatted with inverted
	 * comma and decimal representation and the dollar sign will be moved to the end of
	 * the value.
	 *
	 * For instance 1000.00 as $international = true would result in '1.000,00$'
	 *
	 * @param mixed $value Numeric value to convert.
	 * @param bool $international Optional. Whether value should be formatted for international currency. Defaults to false.
	 * @param string $symbol Optional. Dollar sign to use. Defaults to $.
	 *
	 * @return string Converted monetary value. 
	 */

	function money( $value, $international = false, $symbol = '$' ){
		
		if( $international ){
			return number_format( $value, 2, ',', '.' ).$symbol;
		}
		
		return $symbol.number_format( $value, 2 );
	
	}

	
	/**
	 * Generate a descriptive singular/plural string based of numeric value.
	 *
	 * Will give you a clean item descriptor depending on your numeric value.
	 * Example: pluralize( 1, 'account', 'accounts' ) will return '1 account'
	 * Example: pluralize( 15, 'person', 'people' ) will return '15 people'
	 *
	 * @param mixed $count Numeric value.
	 * @param string $singular Singular item descriptor.
	 * @param string $plural Optional. Plural item descriptor. Defaults by adding 's' to $singular.
	 * @param bool $format Optional. Convert numeric value using number_format(). Defaults to false.
	 * @param int $precision Optional. Decimal precision, if formatting via number_format(). Defaults to 0.
	 *
	 * @return string Resulting description. 
	 */
	
	function pluralize( $count, $singular, $plural = false, $format = false, $precision = 0 ){
		
		if( !$plural ){
			$plural = $singular.'s';
		}
		
		$value = $count;
		
		if( $format ){
			$value = number_format( $value, $precision );
		}
		
		if( $count == 1 ){
			return $value.' '.$singular;
		} else {
			return $value.' '.$plural;
		}
		
	}

	
	/**
	 * Wrap an array var_dump() with specific tags.
	 *
	 * @param array $array Array to dump.
	 * @param string $element Optional. Element to wrap around var_dump(). Defaults to 'pre'.
	 *
	 * @return void 
	 */
	
	function pre_dump( $array, $element = 'pre' ){
		echo '<'.$element.'>';
			var_dump( $array );
		echo '</'.$element.'>';
	}

	
	/**
	 * Redirect user to specified URL.
	 *
	 * If PHP's headers have already been sent, this function will use
	 * JavaScript to redirect the user (which is unable to handle response codes).
	 *
	 * @param string $url URL to redirect user to.
	 * @param int $code Optional. Specific HTTP Response code to use on redirect. Only applicable to PHP header() redirects. Defaults to 302.
	 *
	 * @return void
	 */
	
	
	function redirect( $url, $code = 302 ){
		
		if( !headers_sent() ){
			header( 'Location: '.$url, true, $code );
			die();
		}
		
		echo "<script>window.location='".$url."';</script>";
		die();
		
	}

	
	/**
	 * Convert all "smartquotes" to their typical counterparts.
	 *
	 * "Smartquotes" are used largely in applications like Microsoft Word, where
	 * typical apostrophes and quotation marks are replaced with stylized versions
	 * to create a better visual output. However, programatically, these can cause
	 * a myriad of issues with processing.
	 *
	 * @param string $string Value to convert.
	 *
	 * @return string Converted value.
	 */
	
	function replace_smartquotes( $string ){
	
		$chr_map = array(
			"\xC2\x82" 		=> "'",
			"\xC2\x8B" 		=> "'",
			"\xC2\x91" 		=> "'",
			"\xC2\x92" 		=> "'",
			"\xC2\x9B" 		=> "'",
			"\xE2\x80\x98" 	=> "'",
			"\xE2\x80\x99" 	=> "'",
			"\xE2\x80\x9A" 	=> "'",
			"\xE2\x80\x9B" 	=> "'",
			"\xE2\x80\xB9" 	=> "'", 
			"\xE2\x80\xBA"	=> "'",
			"\xC2\x84" 		=> '"',
			"\xC2\x93" 		=> '"',
			"\xC2\x94" 		=> '"',
			"\xE2\x80\x9C" 	=> '"',
			"\xE2\x80\x9D" 	=> '"',
			"\xE2\x80\x9E" 	=> '"',
			"\xE2\x80\x9F" 	=> '"',
		);
		
		$chr = array_keys( $chr_map );
		$rpl = array_values( $chr_map );
		$string = str_replace( $chr, $rpl, html_entity_decode($string, ENT_QUOTES, "UTF-8") );
		
		return $string;
	
	}

	
	/**
	 * Recursively remove directory and all of it's contents.
	 *
	 * @param string $dir Server path to remove.
	 *
	 * @return void
	 */

	function rrmdir( $dir ){ 
		if( is_dir($dir) ){ 
			
			$objects = scandir( $dir );
			
			foreach( $objects as $object ){ 
				if( $object != "." && $object != ".." ){
					if( is_dir( $dir. DIRECTORY_SEPARATOR .$object ) && !is_link( $dir."/".$object ) ){
						rrmdir( $dir. DIRECTORY_SEPARATOR .$object );
					} else {
						unlink( $dir. DIRECTORY_SEPARATOR .$object ); 
					}
				} 
			}
			
			rmdir($dir); 
			
		} 
	}
	

	/**
	 * Set browser title via JavaScript.
	 *
	 * @param string $title Value to set as title.
	 *
	 * @return void
	 */

	function setTitle( $title ){
		echo "<script>document.title='".$title."';</script>";
	}

	
	/**
	 * Convert a value to a slug/permalink value to be used in URLs.
	 *
	 * @param string $string Value to convert.
	 *
	 * @return string Converted value.
	 */
	
	function slugify( $string ){
		$slug = iconv( 'UTF-8', 'ASCII//TRANSLIT', $string );
		$slug = trim( $slug );
		$slug = strtolower( $slug );
		$slug = preg_replace( '/[^A-Za-z0-9- ]/', '', $slug );
		$slug = str_replace( ' ', '-', $slug );
		$slug = preg_replace( '/-{2,}/','-', $slug );
		return $slug;
	}

	
	/**
	 * Return ID number from start of a slufied string.
	 *
	 * This can be used if your slug/permalink is in the format of '{id}-friendly-name'
	 * to pull the first / ID value from the beginning of the string.
	 *
	 * @param string $slug Slug/permlaink to retrieve ID from.
	 *
	 * @return mixed ID value.
	 */

	function slug_split( $slug ){
		$parts = explode( '-', $slug );
		return $parts;
	}

	
	/**
	 * Remove all existing slashes from a value.
	 *
	 * @param string $string Value to modify.
	 *
	 * @return string Unslashed value.
	 */
	
	function strip_all_slashes( $string ){
		while( strpos($string, '\\') !== false ){
			$string = stripslashes( $string );
		}
		return $string;
	}

	
	/**
	 * Remove all existing slashes and correctly slash a value.
	 *
	 * @param string $string Value to modify.
	 *
	 * @return string Accurately slashed value.
	 */

	function strip_and_slash( $string ){
		$string = strip_all_slashes( $string );
		$string = addslashes( $string );
		return $string;
	}

	
	/**
	 * Convert string value to boolean equivalent.
	 *
	 * @param string $value Value to convert.
	 *
	 * @return bool Converted result.
	 */

	function str_to_bool( $value ){
		
		$test = strtolower( $value );
		
		if( $test === 'yes' ){ return true; }
		if( $test === 'true' ){ return true; }
		if( $test === '1' ){ return true; }
		
		if( $test === 'no' ){ return false; }
		if( $test === 'false' ){ return false; }
		if( $test === '0' ){ return false; }
		
		return $value;
		
	}

	
	/**
	 * Create a summarized version of value with specified length.
	 *
	 * If the passed value is longer than specified length, the value will be
	 * shortened and an elipsis (...) appended at the end.
	 *
	 * @param string $value Value to summarize.
	 * @param int $length Optional. The maximum length of the summary. Defaults to 150.
	 *
	 * @return string Summarized value.
	 */

    function summary( $string, $length = 150 ){
		
        if( strlen($string) > $length ){
            $string = substr( $string, 0, ($length-3) ).'...';
        }
		
        return $string;
		
    }

	
	/**
	 * Convert string to an accurate variable type, based on it's content.
	 *
	 * Will try to intelligently detect the ideal variable type for JSON,
	 * boolean, integer, float, and string.
	 *
	 * @param mixed $value Value to convert.
	 *
	 * @return mixed Converted result.
	 */

	function typify( $value ){
		
		if( is_json($value) ){
			return json_decode( $value, true );
		}
	
		if( ($value === 'true') || ($value === 'false') ){
			return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
		}
		
		if( is_numeric($value) ){
			if( strpos( '.', $value ) !== false ){
				return floatval( $value );
			} else {
				return intval( $value );
			}
		}
		
		return $value;
	
	}

	
	/**
	 * Uppercase words to be used as a title.
	 *
	 * Works similarly to ucwords(), but will "undo" the capitalization
	 * of certain words (such as articles) that are commonly not capitalized
	 * grammatically in publication.
	 *
	 * @param string $string String to capitalize.
	 *
	 * @return string Converted result.
	 */

	function uctitle( $string ){
		
		$no_uc = array(
			'a', 'an', 'and', 'as', 'as if', 'as long as', 'at',
			'but', 'by',
			'even if',
			'for', 'from',
			'if', 'if only', 'in', 'into', 'is',
			'like',
			'near', 'now that', 'nor', 
			'of', 'off', 'on', 'on top of', 'once', 'onto', 'or', 'out of', 'over',
			'past',
			'so', 'so that', 
			'than', 'that', 'the', 'till', 'to',
			'up', 'upon', 
			'with', 'when',
			'yet',
		);
		
		$marks = array( '.', '?', '!', ';', ':' );
		
		$output = ucwords( $string );
		
		foreach( $no_uc as $v ){
			
			$output = str_replace( ' '.ucwords($v).' ', ' '.$v.' ', $output );
			$output = str_replace( ' '.ucwords($v).',', ' '.$v.',', $output );
			
			foreach( $marks as $m ){
				$output = str_replace( $m.' '.$v.' ', $m.' '.ucwords($v).' ', $output );
			}
			
		}
		
		return $output;
		
	}

