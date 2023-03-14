<table class="table">
	<thead>
		<tr>
			<td colspan="200">
            	
                <? echo $item_plural_capital; ?>
                
				<? if( $allow_add ){ ?>
                    <div class="r">
                    	&nbsp;
                        <input 
                        	type="button"
                            value="Add New <? echo $item_capital; ?>"
                            class="lightbox_iframe"
                            data-size="500x500"
                            href="<? echo $base_url; ?>?i=<? echo $_GET['i']; ?>&act=add"
						/>
                    </div>
				<? } ?>
                
            </td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<? listing_columns( $columns, $allow_order, false, $allow_edit, $allow_delete ); ?>
		</tr>

		<?
			if( mysql_num_rows($query) > 0 ){
				while( $info = mysql_fetch_array($query) ){
					
					foreach( $info as $key => $value ){
						$info[$key] = stripslashes( $info[$key] );
					}
		?>
		
            <tr>
    
                <? // Column output start ?>
                
                
                <td>
                    <b><? echo $info['text']; ?></b>
                </td>
                <td>
                    <?
                        switch ($info['link_type']) {
                            default:
                            case 0:
                                echo '<i>Does not link</i>';
                                break;
                            case 1:
                                echo 'External: <b>'.$info['url'].($info['anchor']?'#'.$info['anchor']:'').'</b>';
	                            break;
                            case 2:
                                echo 'Internal: <b>'.kv_array('pages', 'id', 'name', '`id` = '.$info['ref_id'])[$info['ref_id']].($info['anchor']?'#'.$info['anchor']:'').'</b>';
	                            break;
                        }
                    ?>
                </td>
                <td>
                    <? if( $info['status'] == '1' ){ echo '<b class="tc_green">Active / Visible</b>'; } ?>
                    <? if( $info['status'] == '0' ){ echo '<b class="tc_red">Inactive / Hidden</b>'; } ?>
                </td>
                
                
                <? // Column output end ?>
    
    
                <? if( $allow_order ){ ?>
                    <td align="center">
                        <select onchange="ajax_process( '<? echo $section_id; ?>', '<? echo $_GET['i']; ?>', '&act=order&id=<? echo $info['id']; ?>&o=' + $(this).val() ); return false;">
                            <?
                                $count = reorder_count( $database[0], "`".$parent_column."` = '".$_GET['i']."'" );
                                for( $i = 1; $i <= $count; $i++ ){
                                    echo '<option value="'.$i.'" ';
                                    if( $info['order'] == $i ){ echo 'selected'; }
                                    echo '>'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </td>
                <? } ?>
                
                <? if( $allow_edit ){ ?>
                    <td align="center">
                        <a
                        	class="lightbox_iframe"
                            data-size="500x500"
                            href="<? echo $base_url; ?>?i=<? echo $_GET['i']; ?>&act=edit&id=<? echo $info['id']; ?>"
                        >
                        	Edit
                        </a>
                    </td>
                <? } ?>
                
                <? if( $allow_delete ){ ?>
                    <td align="center">
                        <a
                        	href="#"
                        	onclick="ajax_process( '<? echo $section_id; ?>', '<? echo $_GET['i']; ?>', '&act=delete&id=<? echo $info['id']; ?>', 'Are you sure you want to delete this item?' ); return false;">
                        	Delete
                        </a>
                    </td>
                <? } ?>
                
            </tr>
		
		<?
				}
			} else {
		?>

            <tr>
                <td colspan="200" align="center">
                	There are currently no <? echo $item_plural; ?> in the system.
                </td>
            </tr>

		<?
			}
		?>

	</tbody>
</table>