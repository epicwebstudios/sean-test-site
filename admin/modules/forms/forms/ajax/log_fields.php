<?
	
	define( 'ADMIN_PANEL', true );
	$path = explode( '/admin', __DIR__ );
	define( 'CORE_DIR', $path[0].'/core' );
	require_once CORE_DIR.'/core.php';
	
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
	


