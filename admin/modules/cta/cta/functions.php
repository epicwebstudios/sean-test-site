<?

	$link_types = array(
		0 => array( 'name' => 'Do Not Link', 	'table' => false, 	'id' => false, 	'label' => false ),
		1 => array( 'name' => 'External URL', 	'table' => false, 	'id' => false, 	'label' => false ),
		2 => array( 'name' => 'Internal Page', 	'table' => 'pages', 'id' => 'id', 	'label' => 'name' ),
	);


	$link_type_options = array();
	foreach( $link_types as $key => $value ){
		$link_type_options[$key] = $value['name'];
	}

	$categories = kv_array( $database[1], 'id', 'name' );

