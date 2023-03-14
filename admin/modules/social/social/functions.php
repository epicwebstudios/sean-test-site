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

	$types          = array();
	$types_options  = array();

	$sql = "SELECT * FROM " . $database[1] . ' ORDER BY `name` ASC';
	$query = mysql_query($sql);

	while ($r = mysql_fetch_assoc($query)) {
		$types[$r['id']] = $r;
		$types_options[$r['id']] = '&#x' . $r['icon_unicode'] . ';&nbsp&nbsp&nbsp;' . $r['name'];
	}