<?

	//----------------------------------------
	// epicPlatform v3.7.0
	// (c) Epic Web Studios, LLC
	//----------------------------------------
	// For the latest releases, please visit:
	// http://epicwebstudios.com/platform
	//----------------------------------------

	if (isset($_GET['debug']))
		ini_set('display_errors', 1);
	
	require 'sources/init/init.php';
	
	$template 		= mysql_fetch_assoc( mysql_query( "SELECT * FROM `page_templates` WHERE `id`= '".$page['template']."'" ) );
	$template_file	= BASE_DIR.'/templates/'.$template['filename'];
	
	if( file_exists($template_file) ) {
		
		if( $page['protect'] == 1 ) {
			if( $_COOKIE['page_'.$page['id']] == $page['e_password'] ){
				require_once $template_file;
			} else {
				require_once BASE_DIR.'/templates/protected.php';
			}
		} else {
			require_once $template_file;
		}
		
	} else {
		echo '<b>Error</b>: The template file <b>'.$template['filename'].'</b> does not exist.';
	}
	
	mysql_close( $connect );

