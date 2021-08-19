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
                    <div>This is used in the backend for organizational purposes only.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Caption Title:</td>
				<td class="right">
                	<? field_text( 'title', $info['title'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Caption Text:</td>
				<td class="right">
                	<? field_textarea( 'caption', $info['caption'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Slide Image:</td>
				<td class="right">
					<? field_image( 'photo', $info['photo'], '/slides/' ); ?>
                    <div>The recommended size for slide images is <b>1600x400</b>. All other sizes will be scaled to fit.</div>
				</td>
			</tr>
			<tr>
				<td class="left">Link Type:</td>
				<td class="right">
                	<? field_select2( 'link_type', $link_type_options, $info['link_type'], '', 'onchange="swap_link_type();"' ); ?>
                </td>
			</tr>
			<tr class="link_type link_type_1">
				<td class="left">External URL:</td>
				<td class="right">
                	<? field_text( 'url', $info['url'] ); ?>
                    <div>You must include the <b>http://</b> to ensure the URL functions correctly.</div>
                </td>
			</tr>
            
            <?
				foreach( $link_types as $key => $single ){
					if( $single['table'] ){
						$options = kv_array( $single['table'], $single['id'], $single['label'] );
			?>
                <tr class="link_type link_type_<? echo $key; ?>">
                    <td class="left"><? echo $single['name']; ?>:</td>
                    <td class="right">
                        <? field_select2( 'ref_id_'.$key, $options, $info['ref_id'] ); ?>
                    </td>
                </tr>
			<?	
					}
				}
			?>
            
			<tr>
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




