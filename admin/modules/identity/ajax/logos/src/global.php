<? 
	
	@security();
	
	
	// ----
	// DO NOT EDIT BELOW UNLESS TRULY NECESSARY
	// ----
	
	$item_capital = ucwords( $item );
	$item_plural_capital = ucwords( $item_plural );
	
	
	// Override sorting if ordering is allowed.
		if( $allow_order ){
			$order = '`order` ASC';
		}
	
	
	// Set base query...
		$qry_string = "SELECT * FROM `".$database[0]."` WHERE `".$parent_column."` = '".$_GET['i']."' ORDER BY ".$order;
		if( $_GET['debug'] ){ $message = $qry_string; }
		$query = mysql_query( $qry_string );
	
?> 