<?


	$path = explode( '/admin', dirname(__FILE__) );
	define( 'BASE_DIR', $path[0] );


	require_once BASE_DIR.'/sources/init/connect.php';
	require_once BASE_DIR.'/sources/init/global.php';
	require_once BASE_DIR.'/sources/php/functions.php';
	require_once BASE_DIR.'/admin/sources/php/functions.php';
	require_once dirname( __FILE__ ).'/config.php';
	require_once dirname( __FILE__ ).'/functions.php';
	
	
	if( !isLoggedIn() ){
		die( 'You do not have permission to access this page.' );
	}
	
	
	if( $_GET['i'] == '' ){
		die( 'You must specify a form to export' );
	}
	
	
	$form = mysql_fetch_assoc( mysql_query( "SELECT * FROM `".$database[1]."` WHERE `id` = '".$_GET['i']."' LIMIT 1" ) );
	
	
	csv_header( 'form-export-'.slugify( $form['name'] ).'-'.date('Y-m-d') );
	
	
	$columns 	= array();
	$results 	= array();
	
	$rQ = mysql_query( "SELECT * FROM `m_form_results` WHERE `form` = '".$form['id']."' ORDER BY `id` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
	
		$fields 	= json_decode( $r['fields'], true );
		$records[]	= $r;
		
		$single = array();
		foreach( $fields as $field ){
			$single[$field['label']] = $field['value'];
		}
		
		$results[] 	= $single;
		
		foreach( $fields as $field ){
			$key 	= $field['label'];
			$value 	= $field['value'];
			if( !in_array($key, $columns) ){
				$columns[] = $key;
			}
		}
	
	}
	
	
	$output = '';
	
	
	// Titles
	
		$row = array();
			
		$row[] = csv_format_text( 'Submission ID' );
		
		foreach( $columns as $column ){
			$row[] = csv_format_text( $column );
		}
			
		$row[] = csv_format_text( 'Date' );
		$row[] = csv_format_text( 'IP Address' );
		$row[] = csv_format_text( 'Browser' );
		$row[] = csv_format_text( 'Page Submitted On' );
		$row[] = csv_format_text( 'Referral' );
		
		$output .= implode( ',', $row ) . "\n";
		
		
	// Data
	
		foreach( $results as $key => $result ){
			
			$row = array();
			
			$row[] = csv_format_text( $records[$key]['id'] );
			
			foreach( $columns as $column ){
				$row[] = csv_format_text( $result[$column] );
			}
			
			$row[] = csv_format_date_time( $records[$key]['date'] );
			$row[] = csv_format_text( $records[$key]['ip'] );
			$row[] = csv_format_text( $records[$key]['browser'] );
			$row[] = csv_format_text( $records[$key]['on_page'] );
			$row[] = csv_format_text( $records[$key]['referral'] );
			
			$output .= implode( ',', $row ) . "\n";
			
		}
		
	
	echo $output;


