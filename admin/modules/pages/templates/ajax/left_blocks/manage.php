<?
	$info = get_item( $_GET['id'], $database[0] );
	$info = entities( $info, $omit_entities );
						
	$used = array();
	$rQ = mysql_query( "SELECT `block` FROM `".$database[0]."` WHERE `template` = '".$_GET['i']."' AND `location` = '".$location."' ORDER BY `id` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		$used[] = $r['block'];
	}
	
	$options = array();
	foreach( $blocks as $key => $value ){
		if( !in_array($key, $used) ){
			$options[$key] = $value;
		}
	}
?>

<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; echo '?act='.$_GET['act'].'&i='.$_GET['i']; if( $_GET['act'] == 'edit' ){ echo '&id='.$_GET['id']; } ?>"
>

    <? field_hidden( 'parent', $_GET['i'] ); ?>
    <? field_hidden( 'id', $info['id'] ); ?>
    <? field_hidden( 'location', $location ); ?>

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
                <td class="left">Block:</td>
                <td class="right">
                    <?
						if( count($options) > 0 ){
							field_select( 'block', $options, $info['block'] );
						} else {
							echo '<div>No blocks available to add.</div>';
						}
					?>
                </td>
            </tr>
        </tbody>
    </table>
    
    &nbsp;
    
    <div>
    
    	<? if( count($options) > 0 ){ ?>
		
            <input
                type="submit"
                name="<? if( $_GET['act'] == 'edit' ){ echo 'edit'; } else { echo 'add'; } ?>_sub"
                value="Save <? echo $item_capital; ?>"
            >
            
            &nbsp;
        
        <? } ?>
        
        <input
            type="button"
            name="cancel"
            value="Cancel"
            onclick="window.parent.lb_close();"
        >
        
    </div>

</form>
