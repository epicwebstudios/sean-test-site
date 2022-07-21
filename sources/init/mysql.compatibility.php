<?

	
	// MySQL to MySQLi compatibility definitions
	// Recreates deprecated/removed mysql_ functions using mysqli_ functionality.
	

	if( !function_exists('mysql_connect') ){


		define( 'MYSQL_BOTH', 	MYSQLI_BOTH ); 
		define( 'MYSQL_NUM', 	MYSQLI_NUM ); 
		define( 'MYSQL_ASSOC', 	MYSQLI_ASSOC );	
			
		
		function mysql_affected_rows( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_affected_rows( $link_identifier );
		}
		
		
		function mysql_client_encoding( $link_idenitifer = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_character_set_name( $link_idenitifer );
		}
		
		
		function mysql_close( $link_idenitifer = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			mysqli_close( $link_identifier );
		}
		

		function mysql_connect( $server, $username, $password, $new_link = false, $client_flags = 0 ){
			return mysqli_connect( $server, $username, $password );
		}
		
		
		function mysql_data_seek( $result, $row_number ){
			return mysqli_data_seek( $result, $row_number );
		}
		
		
		function mysql_db_name( $result, $row, $field = NULL ){
			mysqli_data_seek( $result, $row );
			$fetch = mysql_fetch_row( $result );
			return $fetch[0];
		}
		
		
		function mysql_db_query( $database, $query, $link_identifier = false ){
			mysqli_select_db( $database );
			return mysqli_query( $query );
		}


		function mysql_errno( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_errno( $link_identifier );
		}


		function mysql_error( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_error( $link_identifier );
		}
		
		
		function mysql_escape_string( $unescaped_string ){
			global $connect;
			$link_identifier = $connect;
			return mysqli_real_escape_string( $link_identifier, $unescaped_string );
		}
		
		
		function mysql_fetch_array( $result, $result_type = MYSQL_BOTH ){
			switch( $result_type ){
				case MYSQL_ASSOC:
					$result_type = MYSQLI_ASSOC;
					break;
				case MYSQL_NUM:
					$result_type = MYSQLI_NUM;
					break;
				default:
					$result_type = MYSQLI_BOTH;
			}
			return mysqli_fetch_array( $result, $result_type );
		}
		
		
		function mysql_fetch_assoc( $result ){
			return mysqli_fetch_array( $result, MYSQLI_ASSOC );
		}
		
		
		function mysql_fetch_field( $result, $field_offset = 0 ){
			if( $field_offset > 0 ){
				for( $i=0; $i<$field_offset; $i++ ){
					mysqli_fetch_field( $result );
				}
				return mysqli_fetch_field( $result );
			} else {
				return mysqli_fetch_field( $result );
			}
		}
		
		
		function mysql_fetch_lengths( $result ){
			return mysqli_fetch_lengths( $result );
		}
		
		
		function mysql_fetch_object( $result, $class_name, $params ){
			return mysqli_fetch_object( $result, $class_name, $params );
		}
		
		
		function mysql_fetch_row( $result ){
			return mysqli_fetch_row( $result );
		}
		
		
		function mysql_field_flags( $result, $field_offset ){
		
			$flags = array();
			$constants = get_defined_constants( true );
		
			foreach( $constants['mysqli'] as $c => $n ){
				if( preg_match('/MYSQLI_(.*)_FLAG$/', $c, $m) ){
					if( !array_key_exists($n, $flags) ){
						$flags[$n] = $m[1];
					}
				}
			}
				
			$flags_num = mysqli_fetch_field_direct( $result, $field_offset )->flags;
			$result = array();
				
			foreach( $flags as $n => $t ){
				if( $flags_num & $n ){
					$result[] = $t;
				}
			}
				
			$return_flags = implode( ' ', $result );
			$return_flags = str_replace( 'PRI_KEY', 'PRIMARY_KEY', $return_flags );
			$return_flags = strtolower( $return_flags );
			return $return_flags;
			
		}
		
		
		function mysql_field_len( $result, $field_offset ){
			$info = mysqli_fetch_field_direct( $result, $field_offset );
			return $info->length;
		}
		
		
		function mysql_field_name( $result, $field_offset ){
			$info = mysqli_fetch_field_direct( $result, $field_offset );
			return $info->name;
		}
		
		
		function mysql_field_seek( $result, $field_offset ){
			return mysqli_field_seek( $result, $field_offset );
		}
		
		
		function mysql_field_table( $result, $field_offset ){
			$info = mysqli_fetch_field_direct( $result, $field_offset );
			return $info->table;
		}
		
		
		function mysql_field_type( $result, $field_offset ){
			
			$type_id = mysqli_fetch_field_direct( $result, $field_offset )->type;
			$types = array();
			$constants = get_defined_constants( true );
			
			foreach( $constants['mysqli'] as $c => $n ){
				if( preg_match('/^MYSQLI_TYPE_(.*)/', $c, $m) ){
					$types[$n] = $m[1];
				}
			}
			
			if( array_key_exists($type_id, $types) ){
				return $types[$type_id];
			} else {
				return NULL;
			}
			
		}
		
		
		function mysql_free_result( $result ){
			return mysqli_free_result( $result );
		}
		
		
		function mysql_get_client_info( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_get_client_info( $link_identifier );
		}
		
		
		function mysql_get_host_info( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_get_host_info( $link_identifier );
		}
		
		
		function mysql_get_proto_info( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_get_proto_info( $link_identifier );
		}
		
		
		function mysql_get_server_info( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_get_server_info( $link_identifier );
		}
		
		
		function mysql_info( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_info( $link_identifier );
		}


		function mysql_insert_id( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_insert_id( $link_identifier );
		}
		
		
		function mysql_list_dbs( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_query( $link_identifier, "SHOW DATABASES" );
		}
		
		
		function mysql_list_fields( $database_name, $table_name, $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_query( $link_identifier, "SHOW COLUMNS FROM `".$table_name."`" );
		}
		
		
		function mysql_list_processes( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_thread_id( $link_identifier );
		}
		
		
		function mysql_list_tables( $database_name, $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_query( $link_identifier, "SHOW TABLES FROM `".$database_name."`" );
		}
		
		
		function mysql_num_fields( $result ){
			return mysqli_num_fields( $result );
		}
		
		
		function mysql_num_rows( $result ){
			return mysqli_num_rows( $result );
		}
		
		
		function mysql_ping( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_ping( $link_identifier );
		}


		function mysql_query( $query, $link_identifier = false ){
			
			$start = time();
			
			global $connect;
			
			if( !$link_identifier ){ $link_identifier = $connect; }
			$resource = mysqli_query( $link_identifier, $query );
			
			$end = time();
			
			if( ($end-$start) > 5 ){
				$backtrace = debug_backtrace();
				$backtrace = $backtrace[0];
				$file = $backtrace['file'];
				$line = $backtrace['line'];
				file_put_contents( BASE_DIR.'/.logs/slow-queries.log', $file.', line '.$line.': '.$query."\n", FILE_APPEND );
			}
			
			return $resource;
			
		}
		
		
		function mysql_real_escape_string( $unescaped_string, $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_real_escape_string( $link_identifier, $unescaped_string );
		}
		
		
		function mysql_result( $result, $row, $field = 0 ){
			mysql_data_seek( $result, $row );
			if( !empty($field) ){
				while( $field_info = mysqli_fetch_field($result) ){
					if( $field == $field_info->name ){
				  		$fetch = mysqli_fetch_assoc( $result );
				  		return $f[$field];
					}
			  	}
			} else {
			  $fetch = mysqli_fetch_array( $result );
			  return $fetch[0];
			}
		}
		
		
		function mysql_select_db( $database_name, $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_select_db( $link_identifier, $database_name );
		}
		
		
		function mysql_set_charset( $charset, $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_set_charset( $link_identifier, $charset );
		}
		
		
		function mysql_stat( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_stat( $link_identifier );
		}
		
		
		function mysql_tablename( $result, $i ){
			mysqli_data_seek( $result, $i );
			$fetch = mysqli_fetch_array( $result );
			return $fetch[0];
		}
		
		
		function mysql_thread_id( $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_thread_id( $link_identifier );
		}
		
		
		function mysql_unbuffered_query( $query, $link_identifier = false ){
			global $connect;
			if( !$link_identifier ){ $link_identifier = $connect; }
			return mysqli_query( $link_identifier, $query, MYSQLI_USE_RESULT );
		}
		
		
	}
	
