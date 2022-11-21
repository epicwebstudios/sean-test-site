<?

	
	$process_url = str_replace( BASE_DIR, returnURL(), dirname(__FILE__).'/process/' );
	define( 'PROCESS_URL', $process_url );

	define( 'MANAGE_URL', $ajax_url.'/manage/' );
	

