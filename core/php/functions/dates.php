<?

	
	/**
	 * Convert a UNIX timestamp to a specific date format.
	 *
	 * Echoes result to screen.
	 *
	 * @param int $date Unix timestamp.
	 * @param int $type Type of output
	 *
	 * @return void
	 */
	
	function displayDate( $date, $type = 1 ){
		
		if( $type == 1 ){
			
			$output = date( 'l, F j, Y \\a\\t g:i A', $date );
		
		} else if( $type == 2 ){
		
			$output 	= '';
			$current 	= time();
			$difference = ( $current - $date );
			$days 		= floor( $difference / 86400 );
			$hours 		= floor( ( $difference - ( $days * 86400 ) ) / 3600 );
			$minutes 	= floor( ( $difference - ( ( $days * 86400 ) + ( $hours  *3600 ) ) ) / 60 );
			
			if( $days > 0 ){
				if( $output != '' ){ $output .= ', '; }
				$output .= $days.'d';
			}
			
			if($hours > 0){
				if( $output != '' ){ $output .= ', '; }
				$output .= $hours.'h';
			}
			
			if($minutes > 0){ 
				if( $output != '' ){ $output .= ', '; }
				$output .= $minutes.'m';
			} else {
				if( ($days <= 0) && ($hours <= 0) ){
					$output .= 'A few moments';
				} else {
					if( $output != '' ){ $output .= ', '; }
					$output .= $minutes.'m';
				}
			}
			
			$output .= ' ago. ('.date( 'n/j/Y \\a\\t g:i A', $date ).')';
			
		} else if($type == 3){
			$output = date( 'l, F j, Y', $date );
		} else if($type == 4){
			$output = date( 'F j, Y \\a\\t g:i A', $date );
		} else if($type == 5){
			$output = date( 'n/j/Y \\a\\t g:i A', $date );
		} else if($type == 6){
			$output = date( 'n/j/Y', $date );
		}
		
		echo $output;
		
	}

	
	/**
	 * Convert number of seconds to a friendly format.
	 *
	 * Will convert number of seconds to #y #d #h #m #s format.
	 *
	 * @param int $seconds Duration, in seconds.
	 *
	 * @return string Friendly duration
	 */

	function friendly_duration( $seconds ){
		
		if( $seconds <= 15 ){
			return 'A few moments ago';
		}
		
		if( $seconds <= 90 ){
			return 'A minute ago';
		}
		
		$output = array();
		
		$limits = array(
			'y' => 31536000,
			'd' => 86400,
			'h' => 3600,
			'm' => 60,
			's' => 1,
		);
		
		foreach( $limits as $k => $v ){
			$o = floor( $seconds / $v );
			if( $o > 0 ){
				$output[] = $o.$k;
				$seconds = ( $seconds - ( $o * $v ) );
			}
		}
		
		return implode( ' ', $output );
		
	}

	
	/**
	 * Get a full list of global timezones.
	 *
	 * Resulting array can be used for timezone selection.
	 *
	 * @return array Timezones
	 */

	function get_timezones(){
				
		$timezones = array(
			'Pacific/Kwajalein' 				=> '(GMT-12:00) International Date Line West',
			'Pacific/Midway' 					=> '(GMT-11:00) Midway Island',
			'Pacific/Apia' 						=> '(GMT-11:00) Samoa',
			'Pacific/Honolulu' 					=> '(GMT-10:00) Hawaii',
			'America/Anchorage' 				=> '(GMT-09:00) Alaska',
			'America/Los_Angeles' 				=> '(GMT-08:00) Pacific Time (US & Canada)',
			'America/Tijuana' 					=> '(GMT-08:00) Tijuana',
			'America/Phoenix' 					=> '(GMT-07:00) Arizona',
			'America/Denver' 					=> '(GMT-07:00) Mountain Time (US & Canada)',
			'America/Chihuahua' 				=> '(GMT-07:00) Chihuahua',
			'America/Chihuahua' 				=> '(GMT-07:00) La Paz',
			'America/Mazatlan' 					=> '(GMT-07:00) Mazatlan',
			'America/Chicago' 					=> '(GMT-06:00) Central Time (US & Canada)',
			'America/Managua' 					=> '(GMT-06:00) Central America',
			'America/Mexico_City' 				=> '(GMT-06:00) Guadalajara',
			'America/Mexico_City' 				=> '(GMT-06:00) Mexico City',
			'America/Monterrey' 				=> '(GMT-06:00) Monterrey',
			'America/Regina' 					=> '(GMT-06:00) Saskatchewan',
			'America/New_York' 					=> '(GMT-05:00) Eastern Time (US & Canada)',
			'America/Indiana/Indianapolis' 		=> '(GMT-05:00) Indiana (East)',
			'America/Bogota' 					=> '(GMT-05:00) Bogota',
			'America/Lima' 						=> '(GMT-05:00) Lima',
			'America/Bogota' 					=> '(GMT-05:00) Quito',
			'America/Halifax' 					=> '(GMT-04:00) Atlantic Time (Canada)',
			'America/Caracas' 					=> '(GMT-04:00) Caracas',
			'America/La_Paz' 					=> '(GMT-04:00) La Paz',
			'America/Santiago' 					=> '(GMT-04:00) Santiago',
			'America/St_Johns' 					=> '(GMT-03:30) Newfoundland',
			'America/Sao_Paulo' 				=> '(GMT-03:00) Brasilia',
			'America/Argentina/Buenos_Aires' 	=> '(GMT-03:00) Buenos Aires',
			'America/Argentina/Buenos_Aires' 	=> '(GMT-03:00) Georgetown',
			'America/Godthab' 					=> '(GMT-03:00) Greenland',
			'America/Noronha' 					=> '(GMT-02:00) Mid-Atlantic',
			'Atlantic/Azores' 					=> '(GMT-01:00) Azores',
			'Atlantic/Cape_Verde' 				=> '(GMT-01:00) Cape Verde Is.',
			'Africa/Casablanca' 				=> '(GMT) Casablanca',
			'Europe/London' 					=> '(GMT) Dublin',
			'Europe/London' 					=> '(GMT) Edinburgh',
			'Europe/Lisbon' 					=> '(GMT) Lisbon',
			'Europe/London' 					=> '(GMT) London',
			'Africa/Monrovia' 					=> '(GMT) Monrovia',
			'Europe/Amsterdam' 					=> '(GMT+01:00) Amsterdam',
			'Europe/Belgrade' 					=> '(GMT+01:00) Belgrade',
			'Europe/Berlin' 					=> '(GMT+01:00) Berlin',
			'Europe/Berlin' 					=> '(GMT+01:00) Bern',
			'Europe/Bratislava' 				=> '(GMT+01:00) Bratislava',
			'Europe/Brussels' 					=> '(GMT+01:00) Brussels',
			'Europe/Budapest' 					=> '(GMT+01:00) Budapest',
			'Europe/Copenhagen' 				=> '(GMT+01:00) Copenhagen',
			'Europe/Ljubljana' 					=> '(GMT+01:00) Ljubljana',
			'Europe/Madrid' 					=> '(GMT+01:00) Madrid',
			'Europe/Paris' 						=> '(GMT+01:00) Paris',
			'Europe/Prague' 					=> '(GMT+01:00) Prague',
			'Europe/Rome' 						=> '(GMT+01:00) Rome',
			'Europe/Sarajevo' 					=> '(GMT+01:00) Sarajevo',
			'Europe/Skopje' 					=> '(GMT+01:00) Skopje',
			'Europe/Stockholm' 					=> '(GMT+01:00) Stockholm',
			'Europe/Vienna' 					=> '(GMT+01:00) Vienna',
			'Europe/Warsaw' 					=> '(GMT+01:00) Warsaw',
			'Africa/Lagos' 						=> '(GMT+01:00) West Central Africa',
			'Europe/Zagreb' 					=> '(GMT+01:00) Zagreb',
			'Europe/Athens' 					=> '(GMT+02:00) Athens',
			'Europe/Bucharest' 					=> '(GMT+02:00) Bucharest',
			'Africa/Cairo' 						=> '(GMT+02:00) Cairo',
			'Africa/Harare' 					=> '(GMT+02:00) Harare',
			'Europe/Helsinki' 					=> '(GMT+02:00) Helsinki',
			'Europe/Istanbul' 					=> '(GMT+02:00) Istanbul',
			'Asia/Jerusalem' 					=> '(GMT+02:00) Jerusalem',
			'Europe/Kiev' 						=> '(GMT+02:00) Kyev',
			'Europe/Minsk' 						=> '(GMT+02:00) Minsk',
			'Africa/Johannesburg' 				=> '(GMT+02:00) Pretoria',
			'Europe/Riga' 						=> '(GMT+02:00) Riga',
			'Europe/Sofia' 						=> '(GMT+02:00) Sofia',
			'Europe/Tallinn' 					=> '(GMT+02:00) Tallinn',
			'Europe/Vilnius' 					=> '(GMT+02:00) Vilnius',
			'Asia/Baghdad' 						=> '(GMT+03:00) Baghdad',
			'Asia/Kuwait' 						=> '(GMT+03:00) Kuwait',
			'Europe/Moscow' 					=> '(GMT+03:00) Moscow',
			'Africa/Nairobi' 					=> '(GMT+03:00) Nairobi',
			'Asia/Riyadh' 						=> '(GMT+03:00) Riyadh',
			'Europe/Moscow' 					=> '(GMT+03:00) St. Petersburg',
			'Europe/Volgograd' 					=> '(GMT+03:00) Volgograd',
			'Asia/Tehran' 						=> '(GMT+03:30) Tehran',
			'Asia/Muscat' 						=> '(GMT+04:00) Abu Dhabi',
			'Asia/Baku' 						=> '(GMT+04:00) Baku',
			'Asia/Muscat' 						=> '(GMT+04:00) Muscat',
			'Asia/Tbilisi' 						=> '(GMT+04:00) Tbilisi',
			'Asia/Yerevan' 						=> '(GMT+04:00) Yerevan',
			'Asia/Kabul' 						=> '(GMT+04:30) Kabul',
			'Asia/Yekaterinburg' 				=> '(GMT+05:00) Ekaterinburg',
			'Asia/Karachi' 						=> '(GMT+05:00) Islamabad',
			'Asia/Karachi' 						=> '(GMT+05:00) Karachi',
			'Asia/Tashkent' 					=> '(GMT+05:00) Tashkent',
			'Asia/Kolkata' 						=> '(GMT+05:30) Chennai',
			'Asia/Kolkata' 						=> '(GMT+05:30) Kolkata',
			'Asia/Kolkata' 						=> '(GMT+05:30) Mumbai',
			'Asia/Kolkata' 						=> '(GMT+05:30) New Delhi',
			'Asia/Kathmandu' 					=> '(GMT+05:45) Kathmandu',
			'Asia/Almaty' 						=> '(GMT+06:00) Almaty',
			'Asia/Dhaka' 						=> '(GMT+06:00) Astana',
			'Asia/Dhaka' 						=> '(GMT+06:00) Dhaka',
			'Asia/Novosibirsk' 					=> '(GMT+06:00) Novosibirsk',
			'Asia/Colombo' 						=> '(GMT+06:00) Sri Jayawardenepura',
			'Asia/Rangoon' 						=> '(GMT+06:30) Rangoon',
			'Asia/Bangkok' 						=> '(GMT+07:00) Bangkok',
			'Asia/Bangkok' 						=> '(GMT+07:00) Hanoi',
			'Asia/Jakarta' 						=> '(GMT+07:00) Jakarta',
			'Asia/Krasnoyarsk' 					=> '(GMT+07:00) Krasnoyarsk',
			'Asia/Hong_Kong' 					=> '(GMT+08:00) Beijing',
			'Asia/Chongqing' 					=> '(GMT+08:00) Chongqing',
			'Asia/Hong_Kong' 					=> '(GMT+08:00) Hong Kong',
			'Asia/Irkutsk' 						=> '(GMT+08:00) Irkutsk',
			'Asia/Kuala_Lumpur' 				=> '(GMT+08:00) Kuala Lumpur',
			'Australia/Perth' 					=> '(GMT+08:00) Perth',
			'Asia/Singapore' 					=> '(GMT+08:00) Singapore',
			'Asia/Taipei' 						=> '(GMT+08:00) Taipei',
			'Asia/Irkutsk' 						=> '(GMT+08:00) Ulaan Bataar',
			'Asia/Urumqi' 						=> '(GMT+08:00) Urumqi',
			'Asia/Tokyo' 						=> '(GMT+09:00) Osaka',
			'Asia/Tokyo' 						=> '(GMT+09:00) Sapporo',
			'Asia/Seoul' 						=> '(GMT+09:00) Seoul',
			'Asia/Tokyo' 						=> '(GMT+09:00) Tokyo',
			'Asia/Yakutsk' 						=> '(GMT+09:00) Yakutsk',
			'Australia/Adelaide' 				=> '(GMT+09:30) Adelaide',
			'Australia/Darwin' 					=> '(GMT+09:30) Darwin',
			'Australia/Brisbane' 				=> '(GMT+10:00) Brisbane',
			'Australia/Sydney' 					=> '(GMT+10:00) Canberra',
			'Pacific/Guam' 						=> '(GMT+10:00) Guam',
			'Australia/Hobart' 					=> '(GMT+10:00) Hobart',
			'Australia/Melbourne' 				=> '(GMT+10:00) Melbourne',
			'Pacific/Port_Moresby' 				=> '(GMT+10:00) Port Moresby',
			'Australia/Sydney' 					=> '(GMT+10:00) Sydney',
			'Asia/Vladivostok' 					=> '(GMT+10:00) Vladivostok',
			'Asia/Magadan' 						=> '(GMT+11:00) Magadan',
			'Asia/Magadan' 						=> '(GMT+11:00) New Caledonia',
			'Asia/Magadan' 						=> '(GMT+11:00) Solomon Is.',
			'Pacific/Auckland' 					=> '(GMT+12:00) Auckland',
			'Pacific/Fiji' 						=> '(GMT+12:00) Fiji',
			'Asia/Kamchatka' 					=> '(GMT+12:00) Kamchatka',
			'Pacific/Fiji' 						=> '(GMT+12:00) Marshall Is.',
			'Pacific/Auckland' 					=> '(GMT+12:00) Wellington',
			'Pacific/Tongatapu' 				=> '(GMT+13:00) Nuku\'alofa',
		);
		
		return $timezones;
		
	}

	
	/**
	 * Get current year
	 *
	 * @param bool $return Optional. If true, will return the result. Default echoes result.
	 *
	 * @return void|string Year
	 */

	function year( $return = false ){
		if( $return ){ return date( 'Y' ); }
		echo date( 'Y' );
	}

