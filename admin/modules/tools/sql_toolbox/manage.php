<div class="ca title_box">

    <div class="l">
		<h1><? echo $item_capital; ?></h1>
    </div>
    
    <div class="l">
        <input type="button" value="Optimize All Tables" onclick="window.location='<? echo $base_url.'&action=optimize&tbl=all'; ?>';">
        &nbsp;&nbsp;
        <input type="button" value="Repair All Tables" onclick="window.location='<? echo $base_url.'&action=repair&tbl=all'; ?>';">
    </div>
    
    <div class="r">
    </div>

</div>


<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; ?>"
>  
	
    <? field_hidden( 'id', $info['id'] ); ?>
    
	<table class="table">
		<thead>
			<tr>
				<td colspan="100">SQL Tables</td>
			</tr>
		</thead>
		<tbody>
        	<tr class="category">
            	<td>Table Name</td>
                <td style="width: 75px;">Status</td>
                <td style="width: 72px;">Optimize</td>
                <td style="width: 60px;">Repair</td>
			</tr>
             
			<?
                $query = mysql_query( "SHOW TABLES" );
                while( $info = mysql_fetch_row($query) ){
					
					$status = '<span class="tc_green"><b>OK</b></span>';
					$class 	= '';
					
					$result = mysql_fetch_array( mysql_query( "CHECK TABLE `".$info[0]."`" ) );
					if( $result['Msg_text'] != 'OK' ){
						$status = '<span class="tc_red"><b>Crashed</b></span>';
						$class 	= 'inactive';
					}
					
            ?>
            
            	<tr class="<? echo $class; ?>">
                
                	<td>
                    	<b><? echo $info[0]; ?></b>
                    </td>
                    
                    <td>
                    	<? echo $status; ?>
					</td>
                    
                    <td>
                    	<a href="<? echo $base_url.'&action=optimize&tbl='.$info[0]; ?>">Optimize</a>
                    </td>
                    
                    <td>
                    	<a href="<? echo $base_url.'&action=repair&tbl='.$info[0]; ?>">Repair</a>
                    </td>
                    
				</tr>
            
            <?
				}
			?>
            
		</tbody>
	</table>
      
</form>

<? browser_title( ''.$item_capital ); ?>




