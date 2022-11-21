<?

	
	/**
	 * cURL a URL
	 *
	 * If $debug is set to true, the response will be an array containing
	 * 'response' (response body), 'code' (HTTP response code),
	 * 'info' (cURL Information), and 'error' (Any cURL errors)
	 *
	 * @param string $request_type Request type to use (expects GET, POST, PUT, or DELETE)
	 * @param string $url URL to ping.
	 * @param array $data Optional. Parameters to pass in request.
	 * @param bool $debug Optional. Pass back all cURL request information.
	 *
	 * @return mixed cURL response body.
	 */

	function curl( $request_type, $url, $data = array(), $debug = false ){
		
		$ch = curl_init();
		
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, strtoupper( $request_type ) );
		
		if( is_array($data) ){
			if( count($data) > 0 ){
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
			}
		}
		
		$output = array(
			'response' 	=> curl_exec( $ch ),
			'code'		=> curl_getinfo( $ch, CURLINFO_HTTP_CODE ),
			'info'		=> curl_getinfo( $ch ),
			'error'		=> curl_error( $ch ),
		);
		
		curl_close( $ch );
		
		if( $debug ){
			return $output;
		}

		return $output['response'];
		
	}

	
	/**
	 * cURL a URL using authentication.
	 *
	 * Will pass $api_key as a Authorization: Bearer token.
	 *
	 * If $debug is set to true, the response will be an array containing
	 * 'response' (response body), 'code' (HTTP response code),
	 * 'info' (cURL Information), and 'error' (Any cURL errors)
	 *
	 * @param string $api_key API key to send with request.
	 * @param string $request_type Request type to use (expects GET, POST, PUT, or DELETE)
	 * @param string $url URL to ping.
	 * @param array $data Optional. Parameters to pass in request.
	 * @param bool $debug Optional. Pass back all cURL request information.
	 *
	 * @return mixed cURL response body.
	 */

	function curl_auth( $api_key, $request_type, $url, $data = array(), $debug = false ){

		$headers = array(
			'Authorization: Bearer '.$api_key,
		);
		
		$ch = curl_init();
		
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, strtoupper( $request_type ) );
		
		if( is_array($data) ){
			if( count($data) > 0 ){
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
			}
		}
		
		$output = array(
			'response' 	=> curl_exec( $ch ),
			'code'		=> curl_getinfo( $ch, CURLINFO_HTTP_CODE ),
			'info'		=> curl_getinfo( $ch ),
			'error'		=> curl_error( $ch ),
		);
		
		curl_close( $ch );
		
		if( $debug ){
			return $output;
		}

		return $output['response'];
		
	}

	
	/**
	 * Ping a URL via cURL
	 *
	 * @param string $request_type Request type to use (expects GET, POST, PUT, or DELETE)
	 * @param string $url URL to ping.
	 * @param array $data Optional. Parameters to pass in request.
	 *
	 * @return void
	 */

	function curl_ping( $request_type, $url, $data = array() ){

		$ch = curl_init();
		
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, strtoupper( $request_type ) );
		
		if( is_array($data) ){
			if( count($data) > 0 ){
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
			}
		}
		
		curl_setopt( $ch, CURLOPT_USERAGENT, 'api' );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 1 ); 
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_FORBID_REUSE, true );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 1 );
		curl_setopt( $ch, CURLOPT_DNS_CACHE_TIMEOUT, 10 );
		curl_setopt( $ch, CURLOPT_FRESH_CONNECT, true );
		
		curl_exec( $ch );
		curl_close( $ch );
		
		return;
		
	}

