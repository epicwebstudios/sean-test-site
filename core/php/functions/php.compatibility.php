<?


	/**
	 * PHP >= 7.4 compatibility
	 *
	 * Recreates deprecated get_magic_quotes_gpc() functionality.
	 */

	function compat_magicquotes( $variable ){
		
		if( is_array($variable) ){
			foreach( $variable as $key => $value ){
				$variable[$key] = compat_magicquotes( $value );
			}
		} else {
		
			while( strpos($variable, '\\') !== false ){
				stripslashes( $variable );
			}
			
			$variable = addcslashes( $variable, "'" );
			
		}
			
		return $variable;
		
	}
	

	if (PHP_VERSION >= '7.4.0' || (PHP_VERSION < '7.4.0' && !get_magic_quotes_gpc())) {
		$_GET    = compat_magicquotes($_GET);
		$_POST   = compat_magicquotes($_POST);
		$_COOKIE = compat_magicquotes($_COOKIE);
	}


	/**
	 * PHP >= 7 compatibility
	 *
	 * Recreates deprecated functions.
	 *
	 * For function documentation, please refer to https://www.php.net/.
	 */

	if (!function_exists('array_key_first')) {
		function array_key_first( array $array ){
			
			foreach( $array as $key => $unused ){
				return $key;
			}
			
			return NULL;
			
		}
	}

	if (!function_exists('array_key_last')) {
		function array_key_last(array $array) {
			
			if( !is_array($array) || empty($array) ){
				return null;
			}

			return array_keys($array)[count($array) - 1];
			
		}
	}


	/**
	 * PHP >= 8 compatibility
	 *
	 * Recreates deprecated functions.
	 *
	 * For function documentation, please refer to https://www.php.net/.
	 */

	if (!function_exists('str_starts_with')) {
		function str_starts_with($haystack, $needle) {
			return strncmp($haystack, $needle, strlen($needle)) === 0;
		}
	}


	if (!function_exists('str_ends_with')) {
		function str_ends_with($haystack, $needle) {
			return $needle === '' || $needle === substr($haystack, -strlen($needle));
		}
	}


	if (!function_exists('str_contains')) {
		function str_contains($haystack, $needle) {
			return $needle !== '' && mb_strpos($haystack, $needle) !== false;
		}
	}

