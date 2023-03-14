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
				<td class="left">Thumbnail:</td>
				<td class="right">
					<? field_image( 'thumb', $info['thumb'], '/identity/logos/' ); ?>
                    <div>This thumbnail will be displayed on the listing of your logos. This should be a <b>square</b> and no larger than <b>200x200</b>.</div>
				</td>
			</tr>
			<tr>
				<td class="left">JPG File:</td>
				<td class="right">
					<? field_file( 'jpg', $info['jpg'], '/identity/logos/' ); ?>
				</td>
			</tr>
			<tr>
				<td class="left">PNG File:</td>
				<td class="right">
					<? field_file( 'png', $info['png'], '/identity/logos/' ); ?>
				</td>
			</tr>
			<tr>
				<td class="left">PSD File:</td>
				<td class="right">
					<? field_file( 'psd', $info['psd'], '/identity/logos/' ); ?>
				</td>
			</tr>
			<tr>
				<td class="left">AI File:</td>
				<td class="right">
					<? field_file( 'ai', $info['ai'], '/identity/logos/' ); ?>
				</td>
			</tr>
			<tr>
				<td class="left">PDF File:</td>
				<td class="right">
					<? field_file( 'pdf', $info['pdf'], '/identity/logos/' ); ?>
				</td>
			</tr>
			<tr>
				<td class="left">EPS File:</td>
				<td class="right">
					<? field_file( 'eps', $info['eps'], '/identity/logos/' ); ?>
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
