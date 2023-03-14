<?

	
	$site_pages = array( 0 => 'No Thank You Page (Do Not Redirect)' );
	$rQ = mysql_query( "SELECT `id`, `name` FROM `pages` ORDER BY `name` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$site_pages[$r['id']] = $r['name'];
	}
	
	
	$field_options = array(
		1 => 'Text Field',
		2 => 'Textarea Field',
		3 => 'Select / Dropdown Field',
		4 => 'Checkboxes',
		5 => 'Radio Buttons',
		6 => 'File Field',
		7 => 'Label / Category',
        8 => 'Line Break'
	);
	
	
	$validation_options = array(
		0 => 'No Validation',
		1 => 'Not Blank',
		2 => 'Valid E-mail Address',
		3 => 'Must Choose One (Checkbox / Radio)'
	);
	
	
	$width_options = array(
		'10' 	=> '10%',
		'20' 	=> '20%',
		'25' 	=> '25%',
		'30' 	=> '30%',
		'33' 	=> '33%',
		'40' 	=> '40%',
		'50' 	=> '50%',
		'60' 	=> '60%',
		'66' 	=> '66%',
		'70' 	=> '70%',
		'75' 	=> '75%',
		'80' 	=> '80%',
		'90' 	=> '90%',
		'100' 	=> '100%',
	);
	
	
	if( $_GET['act'] == 'edit' ){
		$log_fields = array( 0 => 'No Field Selected / Blank' );
		$rQ = mysql_query( "SELECT `id`, `label` FROM `".$database[1]."` WHERE `form` = '".$_GET['i']."' ORDER BY `order` ASC" );
		while( $r = mysql_fetch_assoc($rQ) ){
			$log_fields[$r['id']] = $r['label'];
		}
	}


