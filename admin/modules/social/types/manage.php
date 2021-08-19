<? $info = get_item( $_GET['i'], $database[0] ); ?>


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
            <? if ($info['icon_tag']) : ?>
                <tr>
                    <td colspan="9999"><i style="padding:5px;font-size:20px;background-color:rgba(0,0,0,0.05);width:100%;text-align:center;" class="fa fa-<?= $info['icon_tag']; ?>" aria-hidden="true"></i></td>
                </tr>
            <? endif; ?>
            <tr>
                <td class="left">Name:</td>
                <td class="right">
                    <? field_text( 'name', $info['name'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Alt Text:</td>
                <td class="right">
		            <? field_text( 'alt', $info['alt'] ); ?>
                </td>
            </tr>
			<tr>
				<td class="left">Font Awesome Icon Tag:</td>
				<td class="right">
					<? field_text( 'icon_tag', $info['icon_tag'], 'font-family:monospace;' ); ?>
                    <div>Ex: <span style="font-family:monospace;background-color:rgba(0,0,0,0.05);">facebook</span> for <span style="font-family:monospace;background-color:rgba(0,0,0,0.05);">&lt;i class="fa fa-<b>facebook</b>" aria-hidden="true"&gt;&lt;/i&gt;</span></div>
				</td>
			</tr>
            <tr>
                <td class="left">Font Awesome Unicode:</td>
                <td class="right">
		            <? field_text( 'icon_unicode', $info['icon_unicode'] ); ?>
                    <div>Ex: <span style="font-family:monospace; background-color:rgba(0,0,0,0.05);">f081</span></div>
                </td>
            </tr>
            <tr>
                <td colspan="9999" style="padding:10px;background-color:rgba(0,0,0,0.05);" class="black"><b>Note:</b> Use icons from <a href="https://fontawesome.com/v4.7/icons/" target="_blank">FontAwesome 4.7</a>.</td>
            </tr>
		</tbody>
	</table>
	
	&nbsp;
	
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