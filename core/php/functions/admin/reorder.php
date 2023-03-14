<?
	

	/**
	 * Get number of records that exist in requested table.
	 *
	 * @param string $table Table name.
	 * @param string $where Optional. SQL specific WHERE clause. Defaults to false.
	 *
	 * @return int Resulting record count.
	 */

	function reorder_count( $table, $where = false ){
		if($where){ $where = "WHERE ".$where; }
		$count = mysql_num_rows( mysql_query( "SELECT `id` FROM `".$table."` ".$where ) );
		return $count;
	}
	

	/**
	 * Reorder all values in a specific table.
	 *
	 * @param string $table Table name.
	 * @param string $where Optional. SQL specific WHERE clause. Defaults to false.
	 *
	 * @return void.
	 */
	
	function reorder_all( $table, $where = false ){
		if( $where ){ $where = "WHERE ".$where; }
		$query = mysql_query( "SELECT `id` FROM `".$table."` ".$where." ORDER BY `order` ASC" );
		$c = 1;
		while( $item = mysql_fetch_assoc( $query ) ){
			mysql_query( "UPDATE `".$table."` SET `order` = '".$c."' WHERE `id` = '".$item['id']."' LIMIT 1" );
			$c++;
		}
	}
	

	/**
	 * Reorder one record in a specific table to a defined position.
	 *
	 * @param string $table Table name.
	 * @param int $id Record ID.
	 * @param int $order New order position.
	 * @param string $where Optional. SQL specific WHERE clause. Defaults to false.
	 *
	 * @return void.
	 */
	
	function reorder_one( $table, $id, $order, $where = false ){
		$item = get_item( $id, $table );
		if( $item['order'] != $order ){
			if( $order > $item['order'] ){
				$lower = $item['order'];
				$upper = $order;
			} else {
				$lower = $order;
				$upper = $item['order'];
			}
			if($where){
				$where = "AND (".$where.")";
			}
			
			$query = mysql_query( "SELECT `id`, `order` FROM `".$table."` WHERE (`order` >= '".$lower."' AND `order` <= '".$upper."') ".$where." ORDER BY `order` ASC" );
			while( $record = mysql_fetch_assoc( $query ) ){
				if( $order > $item['order'] ){
					$new_order = $record['order'] - 1;
				} else {
					$new_order = $record['order'] + 1;
				}
				mysql_query( "UPDATE `".$table."` SET `order` = '".$new_order."' WHERE `id` = '".$record['id']."' LIMIT 1" );
			}
			mysql_query( "UPDATE `".$table."` SET `order` = '".$order."' WHERE `id` = '".$id."' LIMIT 1" );
		}
	}


