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
		var id = $( '#redirect_type' ).val();
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
				<td class="left">Request:</td>
				<td class="right">
                	<div class="black"><? mainURL(); ?>/<? field_text( 'request', $info['request'] ); ?></div>
                    <div>Omit the trailing slash at the end of the requested URL for the redirect to detect correctly.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Redirect Method:</td>
				<td class="right">
                	<? field_select2( 'type', $types, $info['type'] ); ?>
                    <div>If this redirect is only temporary, please be sure to change the type, as Permanent redirects store in cache and by search engines.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Redirect To:</td>
				<td class="right">
                	<? field_select2( 'redirect_type', $link_type_options, $info['redirect_type'], '', 'onchange="swap_link_type();"' ); ?>
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
                        <? field_select2( 'page_'.$key, $options, $info['page'] ); ?>
                    </td>
                </tr>
			<?	
					}
				}
			?>
            
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




