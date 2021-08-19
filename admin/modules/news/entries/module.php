<?
	
	global $messages;
	global $settings;
	
	$this_dir = dirname( __FILE__ );
	$ajax_url = explode( '/modules', $this_dir );
	$ajax_url = returnURL().'/admin/modules'.$ajax_url[1].'/ajax';
	$base_url = '?a='.$_GET['a'];
	
	require $this_dir.'/config.php';
	
	$item_capital = ucwords( $item );
	$item_plural_capital = ucwords( $item_plural );
	
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

<script type="text/javascript">
	var base_url = '<? echo $base_url; ?>';
	var ajax_url = '<? echo $ajax_url; ?>';
</script>


<table width="100%">
	<tr>
		<td valign="top" style="padding-top: 0px;">
            
            <? show_messages(); ?>
		
			<?
			
				// -- Listing Page
				
				if(
					( !$_GET['act'] ) || 
					( $_GET['act'] == '' ) || 
					( $_GET['act'] == 'delete' ) || 
					( $_GET['act'] == 'order' )
				){
					require $this_dir.'/listing.php';
				}
				
				
				// -- Add / Edit Page
				
				if(
					( $_GET['act'] == "add" ) || 
					( $_GET['act'] == "edit" )
				){
					
					if(
						( $_GET['act'] == 'add' ) && 
						( !$allow_add )
					){
						redirect( '?a='.$_GET['a'] );
					}
				
					if(
						( $_GET['act'] == 'edit') && 
						( !$allow_edit )
					){
						redirect( '?a='.$_GET['a'] );
					}
				
					require $this_dir.'/manage.php';
				
				}
				
			?>
		
		</td>
	</tr>
</table>




