<? $info = get_item( $_GET['id'], $database[0] ); ?>

<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; echo '?act='.$_GET['act'].'&i='.$_GET['i']; if( $_GET['act'] == 'edit' ){ echo '&id='.$_GET['id']; } ?>"
>

	<script>
	
		function swap_type(){
			$( '.input_type' ).hide();
			var value = $( '#type' ).val();
			$( '.input_type_' + value ).show();
			window.parent.ajax_autosize( '500x' + $('.contain').outerHeight() );
		}
		
		$( document ).ready( function(){
			swap_type();
		});
	
	</script>

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
                <td class="left">Type:</td>
                <td class="right">
                    <? 
						$options = array( 0 => 'Select Input Type...', 1 => 'Add by Hex Code', 2 => 'Add by RGB Values' );
						field_select( 'type', $options, $info['type'], '', 'onchange="swap_type();"' );
					?>
                </td>
            </tr>
            <tr class="input_type input_type_1">
                <td class="left">HEX Code:</td>
                <td class="right">
                	<? field_color( 'color_hex', $info['color_hex'] ); ?>
                </td>
            </tr>
            <tr class="input_type input_type_2">
                <td class="left">RGB Values:</td>
                <td class="right">
                	<? $value = json_decode( $info['color_rgb'], true ); ?>
                    R: <? field_text( 'color_rgb[r]', $value['r'], 'width: 40px;' ); ?>
                    G: <? field_text( 'color_rgb[g]', $value['g'], 'width: 40px;' ); ?>
                    B: <? field_text( 'color_rgb[b]', $value['b'], 'width: 40px;' ); ?>
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
