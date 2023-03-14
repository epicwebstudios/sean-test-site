<?

	
	$admins = array( '-' => 'All Administrators' );
	$rQ = mysql_query( "SELECT `id`, `first`, `last` FROM `administrators` ORDER BY `id` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$admins[$r['id']] = $r['first'].' '.$r['last'];
	}
	
	
	$tables = array( '-' => 'All Tables' );
	$rQ = mysql_query( "SELECT DISTINCT `table` as `name` FROM `".$database[0]."` ORDER BY `name` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$tables[$r['name']] = $r['name'];
	}
	
	
	function get_decorated_diff( $old, $new ){
		
		if( $old != $new ){
		
			$from_start = strspn( $old ^ $new, "\0" );        
			$from_end 	= strspn( strrev($old) ^ strrev($new), "\0" );
		
			$old_end = strlen( $old ) - $from_end;
			$new_end = strlen( $new ) - $from_end;
		
			$start 		= substr( $new, 0, $from_start );
			$end 		= substr( $new, $new_end );
			$new_diff 	= substr( $new, $from_start, $new_end - $from_start );  
			$old_diff 	= substr( $old, $from_start, $old_end - $from_start );
		
			$new = $start.'<ins style="background-color: #ccffcc;">'.$new_diff.'</ins>'.$end;
			$old = $start.'<del style="background-color: #ffcccc;">'.$old_diff.'</del>'.$end;
			
		}
		
		return array( 'old' => $old, 'new' => $new );
		
	}


