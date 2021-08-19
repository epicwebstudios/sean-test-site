<?
	$info = get_item( $_GET['id'], $database[0] );
	$info = entities( $info, $omit_entities );
?>

<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; echo '?act='.$_GET['act'].'&i='.$_GET['i']; if( $_GET['act'] == 'edit' ){ echo '&id='.$_GET['id']; } ?>"
>

    <? field_hidden( 'parent', $_GET['i'] ); ?>
    <? field_hidden( 'id', $info['id'] ); ?>

    <table class="form">
        <thead>
            <tr>
                <td colspan="2">
                    <? if( $_GET['act'] == 'add' ){ echo 'Add New'; } else { echo 'Editing'; } ?>
                    <? echo $item_capital; ?>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left">Name:</td>
                <td class="right">
                    <? field_text( 'name', $info['name'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Description:</td>
                <td class="right">
                    <? field_textarea( 'description', $info['description'] ); ?>
                </td>
            </tr>
			<tr>
				<td class="left">Font File:</td>
				<td class="right">
					<? field_file( 'file', $info['file'], '/identity/fonts/' ); ?>
				</td>
			</tr>
            <tr>
                <td class="left">Font Link:</td>
                <td class="right">
                    <? field_text( 'link', $info['link'] ); ?>
                    <div>Enter the link for more information about downloading or purchasing this font.</div>
                    <div>Note: You must include the <b>http://</b> for the link to work correctly.</div>
                </td>
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
        
        &nbsp;
        
        <input
            type="button"
            name="cancel"
            value="Cancel"
            onclick="window.parent.lb_close();"
        >
        
    </div>

</form>
