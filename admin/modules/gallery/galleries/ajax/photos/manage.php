<? $info = get_item( $_GET['id'], $database[0] ); ?>

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
            	<td colspan="2" style="padding: 10px; text-align: center;">
                	<img src="<? mainURL(); ?>/uploads/gallery/<? echo $info['filename']; ?>" style="max-width: 350px; max-height: 300px;" />
                </td>
            </tr>
            <tr>
                <td class="left">Caption:</td>
                <td class="right">
                    <? field_textarea( 'caption', $info['caption'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Status:</td>
                <td class="right">
                    <?
                        $options = array( 1 => 'Active / Visible', 0 => 'Inactive / Hidden' );
                        field_select2( 'status', $options, $info['status'] );
                    ?>
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
