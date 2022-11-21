<?
		
		
	$path = explode( '/install', dirname(__FILE__) );
	$path = $path[0];


	$output = array(
		'success' 	=> false,
		'progress'	=> 100,
		'next_step'	=> 0,
		'message' 	=> '',
		'html'		=> '',
	);
	
	
	require $path.'/core/core.php';
		
	$rQ = mysql_query( "SELECT * FROM `crons` ORDER BY `id` ASC" );
	while( $r = mysql_fetch_array($rQ) ){
		$command = $r['min'].' '.$r['hour'].' '.$r['day'].' '.$r['month'].' '.$r['weekday'].' '.$r['type'].' '.$path.'/cron/'.$r['file'];
		mysql_query( "UPDATE `crons` SET `command` = '".$command."' WHERE `id` = '".$r['id']."' LIMIT 1" );
	}
	
	build_crontab();
	set_crontab();
	
	$website_url = explode( '/install', $_SERVER['SCRIPT_URI'] );
	$website_url = $website_url[0];
	
	
	$files = scandir( dirname(__FILE__) );
	foreach( $files as $file ){
		if( ($file != '.') && ($file != '..') ){
			$this_file = dirname( __FILE__ ).'/'.$file;
			if( 
				( file_exists($this_file) ) && 
				( !is_dir($this_file) )
			){
				unlink( $this_file );
			}
		}
	}
	rmdir( dirname(__FILE__) );

	if( file_exists($path.'/.git-ftp-ignore') ){
		unlink( $path.'/.git-ftp-ignore' );
	}

	if( file_exists($path.'/bitbucket-pipelines.yml') ){
		unlink( $path.'/bitbucket-pipelines.yml' );
	}
	
	
	$output['success'] = true;
	
	$output['html'] .= '<h3>Installation Successful</h3>';
	$output['html'] .= '<p>Your new website has been set up successfully.</p>';
	$output['html'] .= '<p><b>You may now login to the Administrative Control Panel using your Epic Web Studios employee login!</b></p>';
	$output['html'] .= '<p><input type="button" onclick="window.location=\''.$website_url.'/admin\';" value="Proceed to Administrative Control Panel &raquo;"></p>';


	echo json_encode( $output );
	die();

