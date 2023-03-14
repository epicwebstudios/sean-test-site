<?
	
	global $settings, $page;

	require_once dirname( __FILE__ ).'/src/functions.php';
	require_once dirname( __FILE__ ).'/src/javascript.js.php';
	
	$form_id = $_GET['form_id'];
	
	form_render( $form_id );
	
