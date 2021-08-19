<?


	if($_GET['action'] == "optimize"){
		if($_GET['tbl'] == "all"){
			
			$query = mysql_query("SHOW TABLES");
			
			while($table = mysql_fetch_row($query)){
				mysql_query("OPTIMIZE TABLE `".$table[0]."`");
			}
			
			log_action( 'Optimized all MySQL tables' );
			log_message( 'All SQL Tables optimized successfully.', 'success', 'SQL Optimization Successful' );
		
		} else {
			
			$table = $_GET['tbl'];
			$table = explode(" ", $table);
			$table = $table[0];
			
			mysql_query("OPTIMIZE TABLE `".$table."`");
			
			log_action( 'Optimized MySQL table "'.$table.'"' );
			log_message( 'SQL Table "'.$table.'" optimized successfully.', 'success', 'SQL Optimization Successful' );
			
		}	
	}
	
	
	if( $_GET['action'] == 'repair' ){
		
		if($_GET['tbl'] == "all"){
			
			$query = mysql_query("SHOW TABLES");
			
			while($table = mysql_fetch_row($query)){
				mysql_query("REPAIR TABLE `".$table[0]."`");
			}
			
			log_action( 'Repaired all MySQL tables' );
			log_message( 'All SQL Tables repaired successfully.', 'success', 'SQL Repair Successful' );
				
		} else {
			
			$table = $_GET['tbl'];
			$table = explode(" ", $table);
			$table = $table[0];
			
			mysql_query("REPAIR TABLE `".$table."`");
		
			log_action( 'Repaired MySQL table "'.$table.'"' );
			log_message( 'SQL Table "'.$table.'" repaired successfully.', 'success', 'SQL Repair Successful' );
				
		}
	}
	
	
?>




