<?


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

