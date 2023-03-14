<table class="table">
	<thead>
		<tr>
			<td colspan="200">
            	
                Current <? echo $item_plural_capital; ?>
                
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
			<? listing_columns( $columns, $allow_order, $allow_duplicate, $allow_edit, $allow_delete ); ?>
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
						<b><? echo $info['name']; ?></b>
                    </td>
                
					<td>
						<? echo summary( $info['description'], 150 ); ?>
                    </td>
                
					<td>
                    	<? if( $info['thumb'] ){ ?>
							<? $image = img_url( '/identity/logos/'.$info['thumb'], 75, 75 ); ?>
                            <a href="<? echo returnURL().'/uploads/identity/logos/'.$info['thumb']; ?>" class="lightbox_img">
                                <img src="<? echo $image; ?>" />
                            </a>
                        <? } ?>
                    </td>
                
					<td>
                    	<?
							
							$output = '';
							
							if( $info['jpg'] ){
								if( $output != '' ){ $output .= ' - '; }
								$output .= '<a href="'.returnURL().'/uploads/identity/logos/'.$info['jpg'].'" target="_blank">JPG</a>';
							}
							
							if( $info['png'] ){
								if( $output != '' ){ $output .= ' - '; }
								$output .= '<a href="'.returnURL().'/uploads/identity/logos/'.$info['png'].'" target="_blank">PNG</a>';
							}
							
							if( $info['psd'] ){
								if( $output != '' ){ $output .= ' - '; }
								$output .= '<a href="'.returnURL().'/uploads/identity/logos/'.$info['psd'].'" target="_blank">PSD</a>';
							}
							
							if( $info['ai'] ){
								if( $output != '' ){ $output .= ' - '; }
								$output .= '<a href="'.returnURL().'/uploads/identity/logos/'.$info['ai'].'" target="_blank">AI</a>';
							}
							
							if( $info['pdf'] ){
								if( $output != '' ){ $output .= ' - '; }
								$output .= '<a href="'.returnURL().'/uploads/identity/logos/'.$info['pdf'].'" target="_blank">PDF</a>';
							}
							
							if( $info['eps'] ){
								if( $output != '' ){ $output .= ' - '; }
								$output .= '<a href="'.returnURL().'/uploads/identity/logos/'.$info['eps'].'" target="_blank">EPS</a>';
							}
							
							echo $output;
							
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