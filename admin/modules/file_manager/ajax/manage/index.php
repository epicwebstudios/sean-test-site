<?
	
	define( 'IS_AJAX', true );
	define( 'ADMIN_PANEL', true );

	$path = explode( '/admin', __DIR__ );
	define( 'CORE_DIR', $path[0].'/core' );
	require_once CORE_DIR.'/core.php';
	
	$path = explode( '/ajax', dirname(__FILE__) );
	$path = $path[0];
	
	$base_url = explode( '/admin', dirname(__FILE__) );
	$base_url = returnURL().'/admin'.$base_url[1].'/';
	
	$section_id = basename( __DIR__ );
	
	require_once $path.'/config.php';
	require_once $path.'/functions.php';
	require_once dirname( __FILE__ ).'/config.php';
	require_once dirname( __FILE__ ).'/process.php';
	
	require_once BASE_DIR.'/admin/sources/includes/head.php';

?>

<div class="contain">
	<? show_messages(); ?>
	<? require dirname( __FILE__ ).'/manage.php'; ?>
</div>
        
<script type="text/javascript">
	$( document ).ready( function(){
		window.parent.ajax_autosize( $('.contain').outerWidth() + 'x' + $('.contain').outerHeight() );
	});
</script>

<?
	require_once BASE_DIR.'/admin/sources/includes/foot.php';
?>