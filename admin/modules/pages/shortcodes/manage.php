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


<script>

	function swap_type(){
		$( '.type' ).hide();
		var val = $( '#type' ).val();
		$( '.type_' + val ).show();
	}
	
	$( document ).ready( function(){
		swap_type();
	});

</script>


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
				<td class="left">Name:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Type:</td>
				<td class="right">
					<?
                    	field_select2( 'type', $types, $info['type'], '', 'onchange="swap_type();"' );
					?>
				</td>
			</tr>
			<tr>
				<td class="left">Tag:</td>
				<td class="right">
                	<? field_text( 'tag', $info['tag'], 'font-family:monospace;' ); ?>
                    <div>The shortcode plugin will insert this tag wrapped around the ID. Examples: <b>{form}</b> or <b>{form}</b>1234<b>{/form}</b>.</div>
                </td>
			</tr>
			<tr class="type type_1">
				<td class="left">Reference Table:</td>
				<td class="right">
                	<? field_text( 'table', $info['table'], 'font-family:monospace;' ); ?>
                </td>
			</tr>
			<tr class="type type_1">
				<td class="left">ID Column:</td>
				<td class="right">
                	<? field_text( 'id_col', $info['id_col'], 'font-family:monospace;' ); ?>
                    <div>Inside of the reference table, this is the column name of the "ID" column.</div>
                </td>
			</tr>
			<tr class="type type_1">
				<td class="left">Name Column:</td>
				<td class="right">
                	<? field_text( 'name_col', $info['name_col'], 'font-family:monospace;' ); ?>
                    <div>Inside of the reference table, this is the column name of the "Name" column.</div>
                </td>
			</tr>
			<tr class="type type_1">
				<td class="left">Open Replacement:</td>
				<td class="right">
                	<? field_textarea( 'b_replace', $info['b_replace'], 'font-family:monospace;' ); ?>
                    <div>The opening tag will be replaced with this snippet.</div>
                </td>
			</tr>
			<tr class="type type_1">
				<td class="left">Close Replacement:</td>
				<td class="right">
                	<? field_textarea( 'e_replace', $info['e_replace'], 'font-family:monospace;' ); ?>
                    <div>The closing tag will be replaced with this snippet.</div>
                </td>
			</tr>
			<tr class="type type_2">
				<td class="left">Replacement:</td>
				<td class="right">
                	<? field_textarea( 'replace', $info['replace'], 'font-family:monospace;' ); ?>
                    <div>The tag will be replaced with this snippet.</div>
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




