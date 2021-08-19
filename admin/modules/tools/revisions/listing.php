<div class="ca title_box">

    <div class="l">
    	<h1>Manage <? echo $item_plural_capital; ?></h1>
    </div>
    
    <div class="l">
		<? if( $allow_add ){ ?>
            <input type="button" value="Add <? echo $item_capital; ?>" onclick="window.location = '<? echo $base_url.'&act=add'; ?>'; return false;">
        <? } ?>
    </div>
    
    <div class="r">
    </div>

</div>


<script>

	function set_filter(){
	
		var url = '?a=<? echo $_GET['a']; ?>';
		
		if( $('#f_t').val() != '-' ){
			url += '&f_t=' + $('#f_t').val();
		}
		
		if( $('#f_a').val() != '-' ){
			url += '&f_a=' + $('#f_a').val();
		}
		
		window.location = url;
	
	}

</script>


<? listing_pagination( $pages, $search, $filter_list, 'top' ); ?>

<table class="table">
	<thead>
		<tr>
			<td colspan="200">
            	Current <? echo $item_plural_capital; ?>
                
                <div class="r">
                
                	Table: <? field_select2( 'f_t', $tables, $_GET['f_t'], '', 'onchange="set_filter();"' ); ?>
                    
                    &nbsp;&nbsp;
                    
                	Administrator: <? field_select2( 'f_a', $admins, $_GET['f_a'], '', 'onchange="set_filter();"' ); ?>
                    
                </div>
                
            </td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<? listing_columns( $columns, $allow_order, $allow_duplicate, $allow_edit, $allow_delete, $filter_list ); ?>
		</tr>

		<?
			if( mysql_num_rows($query) > 0 ){
				while( $info = mysql_fetch_assoc($query) ){
					
					foreach( $info as $key => $value ){
						$info[$key] = stripslashes( $info[$key] );
					}
		?>
		
            <tr <? if( $info['status'] == '0' ){ echo 'class="inactive"'; } ?>>
    
                <? // Column output start ?>
                
                
					<td>
						<? echo $info['p_id']; ?>
                    </td>
                    
					<td>
						<b><? echo $info['table']; ?></b>
                    </td>
                    
                    <td>
                    	<? echo $admins[$info['admin']]; ?>
                    </td>
                
					<td>
						<? echo date( 'n/j/Y, g:i A', $info['date'] ); ?>
                    </td>
                
                
                <? // Column output end ?>
    
    
                <? if( $allow_order ){ ?>
                    <td align="center">
                        <select name="order_<? echo $info['id']; ?>" onchange="order_item( '<? echo $info['id']; ?>', this.options[this.selectedIndex].value );">
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
                
                <? if( $allow_duplicate ){ ?>
                    <td align="center">
                        <a href="<? echo $base_url.'&act=duplicate&i='.$info['id']; ?>">Duplicate</a>
                    </td>
                <? } ?>
                
                <? if( $allow_edit ){ ?>
                    <td align="center">
                        <a href="<? echo $base_url.'&act=edit&i='.$info['id']; ?>">View</a>
                    </td>
                <? } ?>
                
                <? if( $allow_delete ){ ?>
                    <td align="center">
                        <a onclick="return delete_item( <? echo $info['id']; ?> );" href="#">Delete</a>
                    </td>
                <? } ?>
                
            </tr>
		
		<?
				}
			} else {
		?>

            <tr>
                <td colspan="200" align="center">
                    <? if( $_GET['s'] ){ ?>
                        Your search for "<? echo $_GET['s']; ?>" returned no <? echo $item_plural; ?>.
                    <? } else { ?>
                        There are currently no <? echo $item_plural; ?> in the system.
                    <? } ?>
                </td>
            </tr>

		<?
			}
		?>

	</tbody>
</table>

<? listing_pagination( $pages, $search, $filter_list, 'bottom' ); ?>

<? browser_title( 'Managing '.$item_plural_capital ); ?>




