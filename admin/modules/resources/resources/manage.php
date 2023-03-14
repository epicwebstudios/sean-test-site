<? 
	$info = get_item( $_GET['i'], $database[0] );
	if( $_GET['act'] == 'add' ){ $info['date'] = time(); }
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


<script>
	
	function swap_link_type(){
		$( '.link_type' ).hide();
		var id = $( '#link_type' ).val();
		$( '.link_type_' + id ).show();
	}
	
	$( document ).ready( function(){
		swap_link_type();
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
				<td class="left">Description:</td>
				<td class="right">
                	<? field_textarea( 'description', $info['description'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Category:</td>
				<td class="right">
                	<? field_select2( 'category', $categories, $info['category'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">File Type:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'File Upload', 2 => 'External URL / File' );
                    	field_select2( 'link_type', $options, $info['link_type'], '', 'onchange="swap_link_type();"' );
					?>
                </td>
			</tr>
			<tr class="link_type link_type_1">
				<td class="left">File:</td>
				<td class="right">
					<? field_file( 'filename', $info['filename'] ); ?>
				</td>
			</tr>
			<tr class="link_type link_type_2">
				<td class="left">External URL:</td>
				<td class="right">
					<? field_text( 'url', $info['url'] ); ?>
                    <div>Please note, you must include the <b>http://</b> in order for the URL to work correctly.</div>
				</td>
			</tr>
			<tr>
				<td class="left">Date:</td>
				<td class="right">
					<? field_date( 'upload_date', $info['date'] ); ?> at <? field_time( 'upload_time', $info['date'] ); ?> 
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




