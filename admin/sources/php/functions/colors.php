<?

	
	function color_convert( $color, $in, $out, $array = true ){
		
		if( ($in == 'hex') && ($out == 'rgb') ){
			$color			= str_replace( '#', '', $color );
			$output			= array();
			$output['r']	= hexdec( substr($color, 0, 2) );
			$output['g']	= hexdec( substr($color, 2, 2) );
			$output['b']	= hexdec( substr($color, 4, 2) );
			if( !$array ){
				$output 	= $output['r'].', '.$output['g'].', '.$output['b'];
			}
			return $output;
		}
		
		if( ($in == 'rgb') && ($out == 'hex') ){
			$output = '#' . sprintf('%02x', $color['r']) . sprintf('%02x', $color['g']) . sprintf('%02x', $color['b']);
			$output = strtoupper( $output );
			return $output;
		}
		
		if( ($in == 'rgb') && ($out == 'cmyk') ){
			$output = array();
			$output['c'] = ( 255 - $color['r'] );
			$output['m'] = ( 255 - $color['g'] );
			$output['y'] = ( 255 - $color['b'] );
			$output['k'] = min( $output['c'], $output['m'], $output['y'] );
			$output['c'] = @(( $output['c'] - $output['k'] ) / ( 255 - $output['k'] ));
			$output['m'] = @(( $output['m'] - $output['k'] ) / ( 255 - $output['k'] ));
			$output['y'] = @(( $output['y'] - $output['k'] ) / ( 255 - $output['k'] ));
			$output['k'] = ( $output['k'] / 255 );
			if( $output['k'] == 1 ){
				$output['c'] = 0;
				$output['m'] = 0;
				$output['y'] = 0;
			}
			$output['c'] = ( $output['c'] * 100 );
			$output['m'] = ( $output['m'] * 100 );
			$output['y'] = ( $output['y'] * 100 );
			$output['k'] = ( $output['k'] * 100 );
			$output['c'] = number_format( $output['c'], 2 );
			$output['m'] = number_format( $output['m'], 2 );
			$output['y'] = number_format( $output['y'], 2 );
			$output['k'] = number_format( $output['k'], 2 );
			if( !$array ){
				$output 	= $output['c'].', '.$output['m'].', '.$output['y'].', '.$output['k'];
			}
			return $output;
		}
		
		
		if( ($in == 'cmyk') && ($out == 'rgb') ){
			$color['k'] = ( $color['k'] * 255 );
			$color['c'] = @(( $color['c'] - $color['k'] ) * ( 255 - $color['k'] ));
			$color['m'] = @(( $color['m'] - $color['k'] ) * ( 255 - $color['k'] ));
			$color['y'] = @(( $color['y'] - $color['k'] ) * ( 255 - $color['k'] ));
			$output = array();
			$output['r'] = ( 255 - $color['c'] );
			$output['g'] = ( 255 - $color['m'] );
			$output['b'] = ( 255 - $color['y'] );
			if( !$array ){
				$output 	= $output['r'].', '.$output['g'].', '.$output['b'];
			}
			return $output;
		}	
			
		if( ($in == 'hex') && ($out == 'cmyk') ){
			$color = color_convert( $color, 'hex', 'rgb' );
			return color_convert( $color, 'rgb', 'cmyk', $array );
		}	
			
		if( ($in == 'cmyk') && ($out == 'hex') ){
			$color = color_convert( $color, 'cmyk', 'rgb' );
			return color_convert( $color, 'rgb', 'hex', $array );
		}	
		
	}

