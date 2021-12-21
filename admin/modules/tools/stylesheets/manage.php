<?
	$info = get_item( $_GET['i'], $database[0] );
	if( $_GET['act'] == 'add' ){ $info['limit'] = 1; }
?>


<div class="ca title_box">

    <div class="l">
        <h1><? if( $_GET['act'] == 'add' ){ echo 'Add New'; } else { echo 'Editing'; } ?> <? echo $item_capital; ?></h1>
    </div>
    
    <div class="l">
		<input type="button" value="Return to all <? echo $item_plural_capital; ?>" onclick="window.location = '<? echo $base_url; ?>';">
    </div>
    
    <div class="r">
    </div>

</div>


<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; if( $_GET['act'] == 'edit' ){ echo '&act='.$_GET['act'].'&i='.$_GET['i']; } ?>"
>

    <? field_hidden( 'id', $info['id'] ); ?>
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Information</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Filename:</td>
				<td class="right">
                	<? field_text( 'url', $info['url'], 'font-family:monospace;' ); ?>
                    <div>If the stylesheet file is on an external server, the filename must start with <b>http://</b> or <b>//</b>, otherwise the file must be located in <b>/sources/css/</b></div>
                </td>
			</tr>
            <tr>
                <td class="left">Type:</td>
                <td class="right">
                    <? field_select( 'type', $types, $info['type'] ); ?>
                    <div>Set to "Internal" to allow minification. Set to "External" to allow browser limitations.</div>
                </td>
            </tr>
            <tr>
                <td class="left">Position:</td>
                <td class="right">
                    <? field_select2( 'position', $positions, $info['position'] ); ?>
                </td>
            </tr>
			<tr class="inline-setting inline-setting-0">
				<td class="left">Browser Limitation:</td>
				<td class="right">
                	<? field_select2( 'limit', $limitations, $info['limit'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Include in Editor:</td>
				<td class="right">
                	<? field_select( 'editor', array( 1 => 'Yes', 0 => 'No' ), $info['editor'] ); ?>
                </td>
			</tr>
            <tr>
                <td class="left">Preceding HTML:</td>
                <td class="right">
                    <? field_code( 'before', $info['before'] ); ?>
                    <div>Adds custom code before the stylesheet is placed. Useful for adding <span class="code">preconnect</span>s.</div>
                </td>
            </tr>
			<tr>
				<td class="left">Status:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Active / Enabled', 0 => 'Inactive / Disabled' );
                    	field_select2( 'status', $options, $info['status'] );
					?>
                </td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
    
    <?
		if(
			( $_GET['act'] == 'edit' ) &&
			( substr($info['url'], 0, 4) != 'http' ) &&
			( substr($info['url'], 0, 2) != '//' )
		){
	?>
    
    	<style>
			.CodeMirror { height: 600px; }
		</style>
    
        <table class="form">
            <thead>
                <tr>
                    <td colspan="2"><? echo $item_capital; ?> Editor</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" style="padding:7px 10px;">
                        <? field_checkbox('edit', array(1 => 'Save changes to file on submit')); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?
            $content = file_get_contents( BASE_DIR.'/sources/css/'.$info['url'] );
            field_code( 'content', $content );
        ?>
        
        &nbsp;
    
    <?
		}
	?>
    
	
	<div>
		
        <input
        	type="submit"
            name="<? if( $_GET['act'] == 'edit' ){ echo 'edit'; } else { echo 'add'; } ?>_sub"
            value="Save <? echo $item_capital; ?>"
        >
        
	</div>
  
</form>

<?
	
	// AJAX Table/Records
	
	/*
	if( $_GET['act'] == 'edit' ){
		ajax_section( 'template' );
	}
	*/
	
?>

<?
	if( $_GET['act'] == 'add' ){
		browser_title( 'Add New '.$item_capital );
	} else {
		browser_title( 'Editing '.$item_capital );
	}
?>

<script>
    bind_toggle('#inline', 'inline-setting');
</script>