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
                <td class="left">Category:</td>
                <td class="right">
                    <? field_select2( 'category', $categories, $info['category'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Image:</td>
                <td class="right">
                    <? field_image( 'image', $info['image'], 'layout/cta/' ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Name / Title:</td>
                <td class="right">
                    <? field_text( 'name', $info['name'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Supertitle:</td>
                <td class="right">
                    <? field_text( 'supertitle', $info['supertitle'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Content / Subtitle:</td>
                <td class="right">
		            <? field_textarea( 'content', $info['content'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Use Button(s):</td>
                <td class="right">
		            <? field_select2( 'button', array( 0 => 'Do Not Use Button(s)', 1 => 'Use Button(s)' ), $info['button'] ); ?>
                    <div>Will use (a) button(s) as the clickable link instead of making the entire area clickable.</div>
                </td>
            </tr>
        </tbody>
        <tbody class="button-setting button-setting-0">
            <tr>
                <td class="left">Link Type:</td>
                <td class="right">
		            <? field_select2( 'link_type', $link_type_options, $info['link_type'] ); ?>
                </td>
            </tr>
            <tr class="link-type-setting link-type-setting-1">
                <td class="left">External URL:</td>
                <td class="right">
		            <? field_text( 'url', $info['url'] ); ?>
                    <div>You must include the <b>https://</b> to ensure the URL functions correctly.</div>
                </td>
            </tr>

            <?
            foreach( $link_types as $key => $single ){
	            if( $single['table'] ){
		            $options = kv_array( $single['table'], $single['id'], $single['label'] );
		            ?>
                    <tr class="link-type-setting link-type-setting-<?= $key; ?>">
                        <td class="left"><? echo $single['name']; ?>:</td>
                        <td class="right">
				            <? field_select2( 'ref_id_'.$key, $options, $info['ref_id'] ); ?>
                        </td>
                    </tr>
		            <?
	            }
            }
            ?>
        </tbody>
        <tbody>
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
	

    echo '<div class="button-setting button-setting-1">';

    if ($_GET['act'] == 'edit')
        ajax_section('buttons');
    else
        echo '<div>You must save the CTA before adding buttons.</div>';

	echo '</div>';
	
?>

<?
	if( $_GET['act'] == 'add' ){
		browser_title( 'Add New '.$item_capital );
	} else {
		browser_title( 'Editing '.$item_capital );
	}
?>

<script>
    $(document).ready(function () {
        bind_toggle('#link_type', 'link-type-setting');
        bind_toggle('#button', 'button-setting');
    });
</script>