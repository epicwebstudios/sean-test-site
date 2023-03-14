<?


	$types = array( 0 => 'Permanent (301)', 1 => 'Temporary (307)' );

	
	$link_types = array(
		0 => array( 'name' => 'Internal Page', 	'table' => 'pages', 'id' => 'id', 	'label' => 'name' ),
		1 => array( 'name' => 'External URL', 	'table' => false, 	'id' => false, 	'label' => false ),
	);
	
	
	$link_type_options = array();
	foreach( $link_types as $key => $value ){
		$link_type_options[$key] = $value['name'];
	}


