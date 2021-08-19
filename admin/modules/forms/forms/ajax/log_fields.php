<?

	$path = explode( '/admin', dirname(__FILE__) );
	define( 'BASE_DIR', $path[0] );

	require BASE_DIR.'/sources/init/connect.php';
	require BASE_DIR.'/sources/init/global.php';
	require BASE_DIR.'/admin/sources/php/functions.php';
	
	$form_id 	= $_GET['i'];
	$selected 	= $_GET['s'];
	$output		= '';
	
	$output .= '<option';
		$output .= ' value="0"';
		if( $selected == '0' ){
		$output .= ' selected';
		}
	$output .= '>No Field Selected / Blank</option>';
	
	$rQ = mysql_query( "SELECT `id`, `label` FROM `m_form_fields` WHERE `form` = '".$form_id."' ORDER BY `order` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
	
		$output .= '<option';
			$output .= ' value="'.$r['id'].'"';
			if( $selected == $r['id'] ){
			$output .= ' selected';
			}
		$output .= '>'.$r['label'].'</option>';
		
	}
	
	echo $output;
	


