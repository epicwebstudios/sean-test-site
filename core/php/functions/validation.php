<?
	

	/**
	 * Test to determine if passed e-mail address is considered disposable.
	 *
	 * Checks to see if a disposable e-mail provider is likely used.
	 * Allows you to intelligently block people from spamming systems.
	 *
	 * @param string $email E-mail address to test.
	 *
	 * @return bool Result of test.
	 */

	function is_email_disposable( $email ){
		$json 	= curl( 'POST', 'https://svc.ewsapi.com/disposable/', array('email' => trim($email)) );
		$json 	= json_decode( $json, true );
		return $json['disposable'];
	}
	

	/**
	 * Test to determine if password is considered strong.
	 *
	 * Will check the password passed to see if it contains a number,
	 * uppercase letter, lowercase letter, special character, and is
	 * at least 8 characters long.
	 *
	 * Returns true (strong) if 4 out of 5 conditions are met.
	 *
	 * If $percentage is true, an array is returned containing both 'result' and strength 'percentage'.
	 *
	 * @param string $password Password to test.
	 * @param bool $percentage Optional. Return result and percentage. Defaults to false.
	 *
	 * @return bool|array Result of test.
	 */

	function is_password_strong( $password, $percentage = false ){
		
		$output = array(
			'result' 		=> false,
			'percentage' 	=> 0,
		);
		
		$length 		= strlen( $password );
		$uppercase 		= preg_match( '@[A-Z]@', $password );
		$lowercase    	= preg_match( '@[a-z]@', $password );
		$number       	= preg_match( '@[0-9]@', $password );
  		$specialchars 	= preg_match( '@[^\w]@', $password );
		$count			= 0;
		
		if( $length >= 8 ){ $count++; }
		if( $uppercase ){ $count++; }
		if( $lowercase ){ $count++; }
		if( $number ){ $count++; }
		if( $specialchars ){ $count++; }
		
		$output['percentage'] = ( $count / 5 );
		
		if( $output['percentage'] >= 0.8 ){
			$output['result'] = true;
		}
		
		if( $percentage ){
			return $output;
		}
		
		return $output['result'];
		
	}
	

	/**
	 * Test to determine if passed e-mail address is valid format.
	 *
	 * @param string $email E-mail address to test.
	 *
	 * @return bool Result of test.
	 */

	function valid_email( $email ){
		return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}

