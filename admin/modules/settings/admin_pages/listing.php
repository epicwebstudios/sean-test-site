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


<table class="table">
    <thead>
        <tr>
            <td colspan="200">
                Current <? echo $item_plural_capital; ?>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <? listing_columns( $columns, $allow_order, $allow_duplicate, $allow_edit, $allow_delete, $filter_list ); ?>
        </tr>
        
        <? 
			$items = menu_items_array( 'listing' );
            if( count($items) > 0 ){
                foreach( $items as $info ){
        ?>
    
            <tr class=" no-border <? if( $info['status'] == '0' ){ echo 'inactive'; } ?> ">
    
                <? // Column output start ?>
                
                
                    <td>
                        <? echo $info['label']; ?>
                    </td>
                
                    <td>
                        <?
							if( ($info['external'] == '0') && ($info['page'] == '') ){	
								echo '<i>Not Linked</i>';
							} else if( ($info['external'] == '1') && ($info['link'] != '') ){
								echo '<b>External URL:</b> '.$info['link'];
							} else if( ($info['external'] == '0') && ($info['page'] != '') ){
								echo '<b>Module:</b> '.$info['page'];
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
                        <select name="order_<? echo $info['id']; ?>" onchange="order_item( '<? echo $info['id']; ?>', this.options[this.selectedIndex].value );">
                            <?
                                $count = reorder_count( $database[0], "`parent` = '".$info['parent']."'");
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
                        <a href="<? echo $base_url.'&act=edit&i='.$info['id']; ?>">Edit</a>
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
                    There are currently no <? echo $item_plural; ?> in the system.
                </td>
            </tr>
        
        <?
            }
        ?>
       
    </tbody>
</table>

&nbsp;


<? browser_title( 'Managing '.$item_plural_capital ); ?>




