<?
	
	define( 'IS_AJAX', true );

	$path = explode( '/admin', dirname(__FILE__) );
	$path = $path[0];
	define( 'BASE_DIR', $path );
	
	require_once BASE_DIR.'/sources/init/connect.php';
	require_once BASE_DIR.'/sources/init/global.php';
	require_once BASE_DIR.'/admin/sources/php/functions.php';
	
	$path = explode( '/ajax', dirname(__FILE__) );
	$path = $path[0];
	
	$base_url = explode( '/admin', dirname(__FILE__) );
	$base_url = returnURL().'/admin'.$base_url[1].'/module.php';
	
	$section_id = basename( __DIR__ );
	
	require_once $path.'/config.php';
	require_once $path.'/functions.php';
	require_once dirname( __FILE__ ).'/config.php';
	require_once dirname( __FILE__ ).'/src/global.php';
	require_once dirname( __FILE__ ).'/process.php';
	
	if( !$_GET['act'] ){
		require_once dirname( __FILE__ ).'/listing.php';
	} else if( ($_GET['act'] == 'add') || ($_GET['act'] == 'edit') ){
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
	} else {
		echo 'OK';
	}
?>