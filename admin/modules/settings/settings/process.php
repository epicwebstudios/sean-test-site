<?

	
	// Processing form elements that have been submitted.
	if( isset($_POST['edit_sub']) ){
	
		$id = $_POST['id'];
		$values = array();


		// -- Set values
		
			$values = array(
				'url'					=> $_POST['url'],
				'name'					=> $_POST['name'],
				'title'					=> $_POST['title'],
				'email'					=> $_POST['email'],
				'cleanURLs'				=> $_POST['cleanURLs'],
				'description'			=> $_POST['description'],
				'theme_color'			=> $_POST['theme_color'],
				'image'					=> process_file( 'image', '/og_images/' ),
				'offline'				=> $_POST['offline'],
				'offline_msg'			=> $_POST['offline_msg'],
				'allow_exec'			=> $_POST['allow_exec'],
				'php_path'				=> $_POST['php_path'],
				'viewport'				=> $_POST['viewport'],
				'max_login_attempts'	=> $_POST['max_login_attempts'],
				'head'					=> $_POST['head'],
				'body_open'				=> $_POST['body_open'],
				'body_close'			=> $_POST['body_close'],
				'ps_minify_css'			=> $_POST['ps_minify_css'],
				'ps_minify_js'			=> $_POST['ps_minify_js'],
				'allow_index'			=> $_POST['allow_index'],
				'file_browser'			=> $_POST['file_browser'],
				'banner_image'          => process_file( 'banner_image', '/layout/banner/' ),
				'banner_lazy'			=> $_POST['banner_lazy'],
				'user_agents'			=> process_array_implode('user_agents'),
				'sticky_header'			=> $_POST['sticky_header'],
				'logo_header'          => process_file( 'logo_header', '/layout/' ),
				'logo_footer'          => process_file( 'logo_footer', '/layout/' ),
				'timezone'				=> $_POST['timezone'],
			);


			// -- FavIcon processing
			
				$file_field 	= 'favicon';
		
				$file = basename($_FILES[$file_field]['name']);
				$n_file = clean_filename( $file );
				
				if( $file ){
					$target = BASE_DIR.'/uploads/'.$n_file; 
					if( move_uploaded_file($_FILES[$file_field]['tmp_name'], $target) ){
						$values['favicon'] = time();
						ico_generate( BASE_DIR.'/uploads/'.$n_file, $values['theme_color'] );
						ico_manifests( $values['favicon'], $values['title'], $values['theme_color'] );
					} else {
						echo "<script>alert('Sorry, your file did not upload correctly.');</script>";
					}
				}
			
			// -- FavIcon processing
			
		
		// -- End set values
		
		
		$set = query_build_set( $values );
			
		mysql_query( "UPDATE `".$database[0]."` ".$set." WHERE `id` = '".$id."' LIMIT 1" );
		echo mysql_error();

		update_robots();
			
		log_action( 'Edited '.$item );
		log_message( $item_capital.' has been edited successfully.', 'success', $item_capital.' Edited' );
		
	}
	
	
?>




