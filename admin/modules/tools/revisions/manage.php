<?

	$info = get_item( $_GET['i'], $database[0] );
	
	$revision	= json_decode( $info['records'], true );
	$previous 	= false;
	$current	= false;
	
	$stmt  = "";
	$stmt .= " SELECT * ";
	$stmt .= " FROM `".$database[0]."` ";
	$stmt .= " WHERE `p_id` = '".$info['p_id']."' ";
	$stmt .= " AND `table` = '".$info['table']."' ";
	$stmt .= " AND `date` <= '".$info['date']."' ";
	$stmt .= " AND `id` != '".$info['id']."' ";
	$stmt .= " ORDER BY `date` DESC ";
	$stmt .= " LIMIT 1 ";
	
	$rQ = mysql_query( $stmt );
	if( mysql_num_rows($rQ) > 0 ){
		$r 				= mysql_fetch_assoc( $rQ );
		$previous_id	= $r['id'];
		$previous 		= json_decode( $r['records'], true );
	}
	
	$stmt  = "";
	$stmt .= " SELECT * ";
	$stmt .= " FROM `".$info['table']."` ";
	$stmt .= " WHERE `id` = '".$info['p_id']."' ";
	$stmt .= " LIMIT 1 ";
	
	$rQ = mysql_query( $stmt );
	if( mysql_num_rows($rQ) > 0 ){
		$r 				= mysql_fetch_assoc( $rQ );
		$current 		= $r;
	}
	
?>


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
				<td class="left">Table:</td>
				<td class="right black">
					<div><? echo $info['table']; ?></div>
				</td>
			</tr>
			<tr>
				<td class="left">Record ID:</td>
				<td class="right black">
					<div><? echo $info['p_id']; ?></div>
				</td>
			</tr>
			<tr>
				<td class="left">Changed By:</td>
				<td class="right black">
					<div><? echo $admins[$info['admin']]; ?></div>
				</td>
			</tr>
			<tr>
				<td class="left">Revision Date:</td>
				<td class="right black">
					<div><? echo date( 'n/j/Y, g:i A', $info['date'] ); ?></div>
				</td>
			</tr>
			<tr>
				<td class="left">Revision Key:</td>
				<td class="right black">
					<div><? echo $info['rev_key']; ?></div>
				</td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
    
    <div class="ca">
    
        <div class="l w_50">
            <div class="p_r">
    
                <table class="table">
                    <thead>
                        <tr>
                            <td colspan="100">Current Record Comparison</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="category">
                            <td style="width: 150px;">Column</td>
                            <td>Revision Data</td>
                            <td>Current Data</td>
                        </tr>
                        <? 
						
							$has_changed = false;
						
                            foreach( $revision as $key => $value ){
                                
                                $old = nl2br( htmlentities( $revision[$key] ) );
                                $new = '';
                                
                                if( $current ){
                                    $new = nl2br( htmlentities( $current[$key] ) );
                                }
                                
                                $diff = get_decorated_diff( $old, $new );
								
								if( $key != 'order' ){
									if( $diff['old'] != $diff['new'] ){
										$has_changed = true;
									}
								}
								
								if( !$current ){
									$diff['new'] = '<i style="color: #999;">Record Deleted</i>';
								}
                                
                        ?>
                        <tr>
                            
                            <td class="tr">
                                <b><? echo $key; ?>:</b>
                            </td>
                            
                            <td class="right">
                                <div><? echo $diff['old']; ?></div>
                            </td>
                            
                            <td class="right">
                                <div><? echo $diff['new']; ?></div>
                            </td>
                            
                        </tr>
                        <?
                            }
                        ?>
                    </tbody>
                </table>
            
            </div>
		</div>
    
        <div class="l w_50">
            <div class="p_l">
    
                <table class="table">
                    <thead>
                        <tr>
                            <td colspan="100">Previous Record Comparison</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="category">
                            <td style="width: 150px;">Column</td>
                            <td>Revision Data</td>
                            <td>
                                Previous Revision Data
                                <? if( $previous ){ ?>
                                    (<a href="?a=<? echo $_GET['a']; ?>&act=edit&i=<? echo $previous_id; ?>">Revision <? echo $previous_id; ?></a>)
                                <? } ?>
                            </td>
                        </tr>
                        <? 
                            foreach( $revision as $key => $value ){
                                
                                $new = nl2br( htmlentities( $revision[$key] ) );
                                $old = '';
                                
                                if( $previous ){
                                    $old = nl2br( htmlentities( $previous[$key] ) );
                                }
                                
                                $diff = get_decorated_diff( $old, $new );
								
								if( !$previous ){
									$diff['old'] = '<i style="color: #999;">Does Not Exist</i>';
								}
                                
                        ?>
                        <tr>
                            
                            <td class="tr">
                                <b><? echo $key; ?>:</b>
                            </td>
                            
                            <td class="right">
                                <div><? echo $diff['new']; ?></div>
                            </td>
                            
                            <td class="right">
                                <div><? echo $diff['old']; ?></div>
                            </td>
                            
                        </tr>
                        <?
                            }
                        ?>
                    </tbody>
                </table>
            
            </div>
		</div>
            
	</div>
            
	&nbsp;
	
	<div>
		
        <? if( $has_changed ){ ?>
        
            <input
                type="submit"
                name="revert_sub"
                value="Revert Current Record to this Revision"
            >
        
        <? } else { ?>
        
            <input
                type="submit"
                name="no_action"
                disabled
                value="This Revision is the Current Record"
            >
            
        <? } ?>
        
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




