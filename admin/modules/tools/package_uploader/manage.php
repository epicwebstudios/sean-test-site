<? $info = get_item( 1, $database[0] ); ?> 


<div class="ca title_box">

    <div class="l">
		<h1><? echo $item_capital; ?></h1>
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
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Upload a Package</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">ZIP Package:</td>
				<td class="right">
					<? field_file( 'package', $info['package'] ); ?>
				</td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
	
	<div>
		
        <input
        	type="submit"
            name="edit_sub"
            value="Upload Package"
        >
        
	</div>
      
</form>

<? browser_title( ''.$item_capital ); ?>




