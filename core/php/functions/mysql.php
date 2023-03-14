<?


	/**
	 * Returns an array of query results.
	 *
	 * @param string $stmt SQL statement
	 * @param string|null $kv The key value. If null, returns assoc array of all columns. If type is a string, returns the results of only one column, with the string being the column name.
	 * @param string $id Primary key
	 *
	 * @return array
	 */

	function fetch_all( $stmt, $kv = null, $id = 'id' ){
		
		$return = array();
		$query = mysql_query( $stmt );

		if( $query ){
			while( $r = mysql_fetch_assoc($query) ){
				if( !$kv ){
					$return[$r[$id]] = $r;
				} else {
					$return[$r[$id]] = $r[$kv];
				}
			}
		} else {
			echo mysql_error();
		}

		return $return;
	}


	/**
	 * Returns single row of query result.
	 *
	 * @param string $stmt SQL statement.
	 *
	 * @return array|false|null
	 */

	function fetch_assoc( $stmt ){
		
		$query  = mysql_query($stmt);
		$result = array();

		if( $query ){
			if( mysql_num_rows($query) > 0 ){
				$result = mysql_fetch_assoc( $query );
			}
		} else {
			echo mysql_error();
		}

		return $result;
	}


	/**
	 * Returns single entry of query result
	 *
	 * @param string $stmt SQL statement
	 * @param string $kv The key value
	 *
	 * @return false|mixed
	 */

	function fetch_single( $stmt, $kv ){
		
		$query  = mysql_query($stmt);
		$result = false;

		if( $query ){
			if( mysql_num_rows($query) > 0 ){
				$result = mysql_fetch_assoc($query)[$kv];
			}
		} else {
			echo mysql_error();
		}

		return $result;
		
	}
	

	/**
	 * Insert a singular database record.
	 *
	 * If debugging is enabled and query fails, the SQL error is returned.
	 *
	 * @param string $table Database table.
	 * @param array $values Key/value array of record values.
	 * @param bool $debug Debugging status.
	 *
	 * @return int|bool|string New record ID, if successful.
	 */

	function insert_record( $table, $values, $debug = false ){
		
		mysql_query( "INSERT INTO `".$table."` ".query_build_set($values) );
		
		if( mysql_error() ){
			
			if( $debug ){
				return mysql_error();
			}
			
			return false;
			
		}
		
		return mysql_insert_id();
		
	}
	

	/**
	 * Check database table to determine if record already exists.
	 *
	 * @param string $table Name of table to check.
	 * @param string $column Column to check.
	 * @param string $value Value to search for.
	 *
	 * @return bool Result of test.
	 */

	function record_exists( $table, $column, $value ){
		
		$stmt  = "";
		$stmt .= " SELECT COUNT(*) AS `count` ";
		$stmt .= " FROM `".$table."` ";
		$stmt .= " WHERE `".$column."` = '".addcslashes( $value, "'" )."' ";
		$stmt .= " LIMIT 1 ";
		
		$r = mysql_fetch_assoc( mysql_query( $stmt ) );
		
		if( $r['count'] > 0 ){
			return true;
		}
		
		return false;
		
	}
	

	/**
	 * Convert a key/value array into a SQL SET clause.
	 *
	 * Function will use $array key as the column name, value as the column value.
	 *
	 * This function will enforce slashing, remove "smartquotes", and 
	 * automatically convert arrays to JSON.
	 *
	 * @param string $array Key/value pairs to include in SET.
	 *
	 * @return bool|string Resulting SET clause.
	 */
	
	function query_build_set( $array ){
		if( is_array($array) ){
			
			$set = "";
			
			foreach( $array as $column => $value ){
				
				if( is_array($value) ){
					$value = json_encode( $value );
				} else {
					$value = replace_smartquotes( $value );
				}
				
				if( $set != '' ){ $set .= ", "; }
				$set .= "`".$column."` = '".strip_and_slash($value)."'";
				
			}
			
			if( $set != '' ){
				return "SET ".$set;
			} else {
				return false;
			}
			
		} else {
			return false;
		}
	}
	

	/**
	 * Update a singular database record.
	 *
	 * If debugging is enabled and query fails, the SQL error is returned.
	 *
	 * @param string $table Database table.
	 * @param int $id Record ID.
	 * @param array $values Key/value array of new record values.
	 * @param bool $debug Debugging status.
	 *
	 * @return bool|string Result of update.
	 */

	function update_record( $table, $id, $values, $debug = false ){
		
		mysql_query( "UPDATE `".$table."` ".query_build_set($values)." WHERE `id` = '".$id."' LIMIT 1" );
		
		if( mysql_error() ){
			return false;
		}
		
		return true;
		
	}

