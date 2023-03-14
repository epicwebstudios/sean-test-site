<? 
	
	@security();
	
	
	// Set additional query parameters...
	// - This should be used to add additional parameters to the default query other than typical search parameters.
	
	$addl_query = '';
	
	
	if( $_GET['f_f'] ){
		if( $addl_query != '' ){ $addl_query .= " AND "; }
		$addl_query .= " `form` = '".$_GET['f_f']."' ";
	}
	
	
	// ----
	// DO NOT EDIT BELOW UNLESS TRULY NECESSARY
	// ----
	
	
	// Override sorting if ordering is allowed.
		if( $allow_order ){
			$order = '`order` ASC';
		}
	
	
	// Sorting controls and detection
		if( $_GET['sb'] ){
			if( $_GET['d'] ){
				$order = '`'.$_GET['sb'].'` '.strtoupper( $_GET['d'] );
			} else {
				$order = '`'.$_GET['sb'].'` ASC';
			}
		}
		
	
	// Set search (and filtering) query string...
	
		$search_query = '';
		
		if( $_GET['s'] ){
			
			foreach( $search as $column ){
				if( $search_query != '' ){ $search_query .= ' OR '; }
				$search_query .= " `".$column."` LIKE '%".$_GET['s']."%' ";
			}
			
			$search_query = " ( ".$search_query." ) ";
			
		}
		
		
		if( $addl_query ){
			if( $search_query ){
				$search_query = 'WHERE '.$addl_query.' AND '.$search_query;
			} else {
				$search_query = 'WHERE '.$addl_query;
			}
		} else {
			if( $search_query ){
				$search_query = 'WHERE '.$search_query;
			}
		}
	
	
	// Set pages...
	
		$page_stmt 	= "SELECT `id` FROM `".$database[0]."` ".$search_query;
		$pages		= listing_pagination_count( $page_stmt, $page_limit );
	
	
	// Set base query...
		$qry_string = "SELECT * FROM `".$database[0]."` ".$search_query." ORDER BY ".$order." LIMIT ".$pages['limit'];
		if( $_GET['debug'] ){ $message = $qry_string; }
		$query = mysql_query( $qry_string );


