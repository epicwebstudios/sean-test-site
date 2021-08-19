<?
	$info = get_item( $_GET['id'], $database[0] );
	if( $_GET['act'] == 'add' ){ $info['width'] = 100; }
?>

<script>

	function swap_type(){
		$( '.options' ).hide();
		let value = $( '#type' ).val();
		$( '.options_' + value ).show();
		console.log(value);
		if( value === "8" ){
		    $('.options_1_to_7').hide();
        }else{
            $('.options_1_to_7').show();
        }
		window.parent.ajax_autosize( '600x' + $('.contain').outerHeight() );
	}
	
	function swap_alignment(){
		$( '.columns' ).hide();
		if( $('#alignment').val() == 3 ){
			$( '.columns' ).show();
		}
	}
	
	$( document ).ready( function(){
		swap_type();
		swap_alignment();
	});

</script>

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
                <td class="left">Type:</td>
                <td class="right">
                    <? field_select( 'type', $field_options, $info['type'], '', 'onchange="swap_type();"' ); ?>
                </td>
            </tr>
            <tr class="options options_1_to_7">
                <td class="left">Label:</td>
                <td class="right">
                    <? field_text( 'label', $info['label'] ); ?>
                </td>
            </tr>
            <tr class="options options_1_to_7">
                <td class="left">Notes:</td>
                <td class="right">
                    <? field_text( 'notes', $info['notes'] ); ?>
                    <div>This is greyed out text that will be displayed under the field.</div>
                </td>
            </tr>
            <tr class="options options_1 options_2">
                <td class="left">Placeholder:</td>
                <td class="right">
                    <? field_text( 'placeholder', $info['placeholder'] ); ?>
                    <div>This text is shown in the field before anything is entered by the user.</div>
                </td>
            </tr>
            <tr class="options options_3 options_4 options_5">
                <td class="left">Values / Choices:</td>
                <td class="right">
                    <? field_textarea( 'values', $info['values'] ); ?>
                    <div>Please place each value / choice on its own line.</div>
                </td>
            </tr>
            <tr class="options options_1_to_7">
                <td class="left">Width:</td>
                <td class="right">
                    <? field_select( 'width', $width_options, $info['width'] ); ?>
                </td>
            </tr>
            <tr class="options options_2">
                <td class="left">Height:</td>
                <td class="right">
                    <? field_text( 'height', $info['height'], 'width: 45px;' ); ?> px
                </td>
            </tr>
            <tr class="options options_4 options_5">
                <td class="left">Alignment:</td>
                <td class="right">
                    <?
						$options = array( 1 => 'Vertical / Block', 2 => 'Horizontal / Inline', 3 => 'Multiple Columns' );
                    	field_select( 'alignment', $options, $info['alignment'], '', 'onchange="swap_alignment();"' );
					?>
                    <span class="columns">
                    	&nbsp;&nbsp;
                    	<? field_text( 'columns', $info['columns'], 'width: 35px; text-align: center;' ); ?> columns
                    </span>
                </td>
            </tr>
            <tr class="options options_1 options_2 options_4 options_5 options_6">
                <td class="left">Validation:</td>
                <td class="right">
                    <? field_select( 'validation', $validation_options, $info['validation'] ); ?>
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
