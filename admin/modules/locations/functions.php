<?

	function get_lat_long( $address_str ){
		$url  = 'http://maps.googleapis.com/maps/api/geocode/json?address=';
		$url .= urlencode( $address_str );
		$url .= '&sensor=false';
		$result_string = file_get_contents( $url );
		$result = json_decode( $result_string, true );
		return $result['results'][0]['geometry']['location'];
	}

	



