<?

	
	// Processing form elements that have been submitted.
	if( (isset($_POST['edit_sub'])) || (isset($_POST['add_sub'])) ){
	
		$parent = $_POST['parent'];
		$id = $_POST['id'];
		
		
		// -- Set values
		
			$values = array(
				'block'		=> $_POST['block'],
				'location'	=> $_POST['location'],
			);
		
		// -- End set values
		

	}
	
	
	// Processing for when "Save" has been clicked on Add page.
	if( isset($_POST['add_sub']) ){
		
		if( $allow_add ){
		
			$values[$parent_column] = $parent;
		
			if( $allow_order ){
				$values['order'] = 999999;
			}
			
			$set = query_build_set( $values );
			
			mysql_query( "INSERT INTO `".$database[0]."` ".$set );
			$new_record = mysql_insert_id();
			
			$values[$log_item] = $blocks[$values[$log_item]];
			
			create_revision( $new_record, $database[0] );
			log_action( 'Added '.$item.' "'.$values[$log_item].'"' );
			log_message( 'The '.$item.' "'.$values[$log_item].'" has been added successfully.', 'success', $item_capital.' Added' ); 
	
			if( $allow_order ){
				reorder_all( $database[0], "`".$parent_column."` = '".$_GET['i']."' AND `location` = '".$location."'" );
			}
		
		} else {
			log_message( 'You do not have permission to add a '.$item.'.', 'error', 'Error' );
		}
		
		echo '<script type="text/javascript">';
			echo "window.parent.ajax_listing( '".$section_id."', '".$parent."' );";
		echo '</script>';

	}
	
	
	// Processing for when "Save" has been clicked on Edit page.
	if( isset($_POST['edit_sub']) ){
		
		$record = get_item( $_POST['id'], $database[0] );
		
		if( ($record['id']) && ($allow_edit) ){
			
			$set = query_build_set( $values );
			
			mysql_query( "UPDATE `".$database[0]."` ".$set." WHERE `id` = '".$id."' LIMIT 1" );
			
			$values[$log_item] = $blocks[$values[$log_item]];
			
			create_revision( $id, $database[0] );
			log_action( 'Edited '.$item.' "'.$values[$log_item].'"' );
			log_message( 'The '.$item.' "'.$values[$log_item].'" has been edited successfully.', 'success', $item_capital.' Edited' );
		
		} else {
			log_message( 'Could not locate '.$item.' you attempted to edit or your do not have permission to edit this '.$item.'.', 'error', 'Error' );
		}
		
		echo '<script type="text/javascript">';
			echo "window.parent.ajax_listing( '".$section_id."', '".$parent."' );";
		echo '</script>';
		
	}
	

	// Processing for when "Delete" has been clicked.
	if( $_GET['act'] == 'delete' ){
		
		$record = get_item( $_GET['id'], $database[0] );
		
		if( ($record['id']) && ($allow_delete) ){
			
			$query = mysql_query( "DELETE FROM `".$database[0]."` WHERE `id` = '".$record['id']."' LIMIT 1" );
			
			$values[$log_item] = $blocks[$values[$log_item]];
			
			log_action( 'Deleted '.$item.' "'.$record[$log_item].'"' );
			
			if( $allow_order ){
				reorder_all( $database[0], "`".$parent_column."` = '".$_GET['i']."' AND `location` = '".$location."'" );
			}
			
		}
		
	}


	// This reorders a single record as requested.
	if( $_GET['act'] == 'order' ){
		
		$record = get_item( $_GET['id'], $database[0] );
		
		if( ($allow_order) && ($record['id']) ){
			$values[$log_item] = $blocks[$values[$log_item]];
			reorder_one( $database[0], $record['id'], $_GET['o'], "`".$parent_column."` = '".$_GET['i']."' AND `location` = '".$location."'" );
			log_action( 'Re-ordered '.$item.' "'.$record[$log_item].'"' );
		}
		
	}
	
?>