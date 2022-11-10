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
                            data-size="600x500"
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
						<b><? echo $info['label']; ?></b>
                    </td>
                
					<td>
						<? echo $field_options[$info['type']]; ?>
                    </td>
                
					<td>
						<?
							if( 
								( $info['type'] == '1' ) ||
								( $info['type'] == '2' ) ||
								( $info['type'] == '4' ) ||
								( $info['type'] == '5' ) ||
								( $info['type'] == '6' )
							){
								field_select(
									'validation',
									$validation_options,
									$info['validation'],
									'',
									'onchange="ajax_process( \'fields\', \''.$_GET['i'].'\', \'&act=do&id='.$info['id'].'&validation=\' + $(this).val() ); return false;"'
								);
							}
						?>
                    </td>
                
					<td>
						<?
							field_select(
								'width',
								$width_options,
								$info['width'],
								'',
								'onchange="ajax_process( \'fields\', \''.$_GET['i'].'\', \'&act=do&id='.$info['id'].'&width=\' + $(this).val() ); return false;"'
							);
						?>
                    </td>
                
                
                <? // Column output end ?>
    
    
                <? if( $allow_order ){ ?>
                    <td align="center">
                        <select onchange="ajax_process( '<? echo $section_id; ?>', '<? echo $_GET['i']; ?>', '&act=order&id=<? echo $info['id']; ?>&o=' + $(this).val() ); return false;">
                            <?
                                $count = reorder_count($database[0]);
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
                            data-size="600x500"
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