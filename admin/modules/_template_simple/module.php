<?
	
	global $messages;
	global $settings;
	
	$this_dir = dirname( __FILE__ );
	$base_url = '?a='.$_GET['a'];
	
	require $this_dir.'/config.php';
	
	$item_capital = ucwords( $item );
	
	require $this_dir.'/functions.php';
	require $this_dir.'/process.php';
	require $this_dir.'/src/global.php';
	
	if( $include_editor ){
		if( file_exists($this_dir.'/html_editor.php') ){
			require $this_dir."/html_editor.php";
		} else {
			require 'sources/php/base_editor.php';
		}
	}
	
?>


<table width="100%">
	<tr>
		<td valign="top" style="padding-top: 0px;">
		
			<? show_messages(); ?>
		
			<? require $this_dir.'/manage.php'; ?>
		
		</td>
	</tr>
</table>