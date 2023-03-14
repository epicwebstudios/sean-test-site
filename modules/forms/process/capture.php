<?

	$path = explode( '/modules', dirname(__FILE__) );
	define( 'BASE_DIR', $path[0] );
	
	
	require_once BASE_DIR.'/sources/init/connect.php';
	require_once BASE_DIR.'/sources/init/global.php';
	
	
	$type 		= $_GET['t'];
	$form_id 	= $_GET['f'];
	$form		= mysql_fetch_assoc( mysql_query( "SELECT `id`, `lead_capture` FROM `m_forms` WHERE `id` = '".$form_id."' LIMIT 1") );
	
	
	if( ($form['id']) && ($form['lead_capture'] == '1') ){
	
		if( $type == 'create' ){
			
			$values = array(
				'form' 		=> $form_id,
				'ip'		=> $_SERVER['REMOTE_ADDR'],
				'browser' 	=> $_SERVER['HTTP_USER_AGENT'],
				'date'		=> time(),
			);
			
			$set = query_build_set( $values );
			mysql_query( "INSERT INTO `m_form_leads` ".$set );	
			
			echo mysql_insert_id();
			die();
		
		}
		
		
		if( $type == 'update' ){
		
			$lead_id = $_POST['lead_id'];
			$on_page = $_POST['on_page'];
			unset( $_POST['lead_id'], $_POST['on_page'] );
			
			$fields = array();
			$rQ = mysql_query( "SELECT `id`, `label` FROM `m_form_fields` WHERE `form` = '".$form_id."' ORDER BY `order` ASC" );
			while( $r = mysql_fetch_assoc($rQ) ){
				if( $_POST['field_'.$r['id']] ){
					$fields[] = array( 'label' => $r['label'], 'value' => $_POST['field_'.$r['id']] );
				}
			}
			
			$values = array(
				'fields'	=> $fields,
				'on_page'	=> $on_page,
				'ip'		=> $_SERVER['REMOTE_ADDR'],
				'browser' 	=> $_SERVER['HTTP_USER_AGENT'],
				'date'		=> time(),
			);
			
			$set = query_build_set( $values );
			mysql_query( "UPDATE `m_form_leads` ".$set." WHERE `id` = '".$lead_id."' LIMIT 1" );	
		
			die();
		
		}
	
	}


