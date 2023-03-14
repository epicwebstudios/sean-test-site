<?
	
	define( 'ADMIN_PANEL', true );
	$path = explode( '/admin', __DIR__ );
	define( 'CORE_DIR', $path[0].'/core' );
	require_once CORE_DIR.'/core.php';
	
	$entry 	= $_GET['i'];
	$output_dir = BASE_DIR.'/uploads/news/';
	$field_name = 'photo'; 
	
	if( !is_dir($output_dir) ){
		mkdir( $output_dir );
	}
	
	if( isset($_FILES[$field_name]) ){
		
		$ret 	= array();
		$error 	= $_FILES[$field_name]['error'];
		{
		
			if( !is_array($_FILES[$field_name]['name']) ){
				
				$orig_file = clean_filename( time().'-'.$_FILES[$field_name]['name'] );
				
				move_uploaded_file( $_FILES[$field_name]['tmp_name'], $output_dir.$orig_file );
				
				mysql_query( "INSERT INTO `m_news_photos` SET `entry` = '".$entry."', `filename` = '".$orig_file."', `order` = '999999'" );
				reorder_all( 'm_news_photos', "`entry` = '".$entry."'" );
				
			} else {
				
				$count = count( $_FILES[$field_name]['name'] );
				for( $i=0; $i<$count; $i++ ) {
					
					$orig_file = clean_filename( time().'-'.$_FILES[$field_name]['name'][$i] );
					
					move_uploaded_file( $_FILES[$field_name]['tmp_name'][$i], $output_dir.$orig_file ); 
				
					mysql_query( "INSERT INTO `m_news_photos` SET `entry` = '".$entry."', `filename` = '".$orig_file."', `order` = '999999'" );
					reorder_all( 'm_news_photos', "`entry` = '".$entry."'" );
				
				}
			}
		}
		
		echo $orig_file;
	 
	}

?>