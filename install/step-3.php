<?
		
		
	$path = explode( '/install', dirname(__FILE__) );
	$path = $path[0];


	$output = array(
		'success' 	=> false,
		'progress'	=> 56,
		'next_step'	=> 4,
		'message' 	=> '',
		'html'		=> '',
	);
	
	
	chmod( $path.'/uploads/', 0755 );
	
	$website_url = explode( '/install', $_SERVER['SCRIPT_URI'] );
	$website_url = $website_url[0];
	
	$output['success'] = true;
	
	$output['html'] .= '<h3>Enter Your Website Information</h3>';
	$output['html'] .= '<p>Enter a few details about your new website...</p>';
	$output['html'] .= '<div class="row"><input type="text" name="url" placeholder="Website URL" value="'.$website_url.'"></div>';
	$output['html'] .= '<div class="row"><input type="text" name="name" placeholder="Website Name"></div>';
	$output['html'] .= '<div class="row"><input type="text" name="title" placeholder="Website Browser Title"></div>';
	$output['html'] .= '<p><input type="submit" value="Save Website Information"></p>';


	echo json_encode( $output );
	die();

