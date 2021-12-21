<?

	$path = explode( '/admin', dirname(__FILE__) );
	define( 'BASE_DIR', $path[0] );

	require BASE_DIR.'/sources/init/connect.php';
	require BASE_DIR.'/sources/init/global.php';
	require BASE_DIR.'/admin/sources/php/functions.php';
	
	$gallery 	= $_GET['i'];
	$output_dir = BASE_DIR.'/uploads/gallery/';
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
				
				mysql_query( "INSERT INTO `m_photo_photos` SET `gallery` = '".$gallery."', `filename` = '".$orig_file."', `order` = '999999', `status` = 1" );
				reorder_all( 'm_photo_photos', "`gallery` = '".$gallery."'" );
				
			} else {
				
				$count = count( $_FILES[$field_name]['name'] );
				for( $i=0; $i<$count; $i++ ) {
					
					$orig_file = clean_filename( time().'-'.$_FILES[$field_name]['name'][$i] );
					
					move_uploaded_file( $_FILES[$field_name]['tmp_name'][$i], $output_dir.$orig_file ); 
				
					mysql_query( "INSERT INTO `m_photo_photos` SET `gallery` = '".$gallery."', `filename` = '".$orig_file."', `order` = '999999', `status` = 1" );
					reorder_all( 'm_photo_photos', "`gallery` = '".$gallery."'" );
				
				}
			}
		}
		
		echo $orig_file;
	 
	}

?>