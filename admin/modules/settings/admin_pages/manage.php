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

	function swap_link_type(){
		$( '.link_type' ).hide();
		var id = $( '#external' ).val();
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
            <tr class="menu_type menu_type_<? echo $key; ?>">
                <td class="left">Parent Menu Item:</td>
                <td class="right">
                    <?
                        $options = menu_items_array( 'options' );
                        field_select2( 'parent', $options, $info['parent'] );
                    ?>
                </td>
            </tr>
			<tr>
				<td class="left">Item Label:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Link Type:</td>
				<td class="right">
                	<?
						$options = array( 0 => 'Module', 1 => 'External URL' );
                    	field_select2( 'external', $options, $info['external'], '', 'onchange="swap_link_type();"' );
					?>
                </td>
			</tr>
			<tr class="link_type link_type_0">
				<td class="left">Module Handler:</td>
				<td class="right">
					<? field_select2( 'page', $modules, $info['page'] ); ?>
                    <div>This is the filename of the page that will be loaded into the Admin Panel. All folders / files should be located in <b>/admin/modules/</b>, and this should be the path from this location.</div>
                </td>
			</tr>
			<tr class="link_type link_type_1">
				<td class="left">External URL:</td>
				<td class="right">
                	<? field_text( 'link', $info['link'] ); ?>
                    <div>You must include the <b>http://</b> to ensure the URL functions correctly.</div>
                </td>
			</tr>
			<tr class="link_type link_type_1">
				<td class="left">Open In:</td>
				<td class="right">
                	<?
						$options = array( '' => 'Same Window', '_blank' => 'New Window' );
                    	field_select2( 'target', $options, $info['target'] );
					?>
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




