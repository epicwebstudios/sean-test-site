<?

	$list_type 	= $_POST['list_type'];
	setcookie( 'ep_file_manager_list_type', $list_type, (time()+(86400*180)), '/' );
	
