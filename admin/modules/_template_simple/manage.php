<? $info = get_item( 1, $database[0] ); ?> 


<div class="ca title_box">

    <div class="l">
		<h1>Editing <? echo $item_capital; ?></h1>
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
				<td colspan="2"><? echo $item_capital; ?> Information</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Name:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Image Example:</td>
				<td class="right">
					<? field_image( 'image', $info['image'] ); ?>
				</td>
			</tr>
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
            name="edit_sub"
            value="Save <? echo $item_capital; ?>"
        >
        
	</div>
      
</form>

<? browser_title( 'Editing '.$item_capital ); ?>