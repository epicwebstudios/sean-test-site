<? $info = get_item( 1, $database[0] ); ?> 


<div class="ca title_box">

    <div class="l">
		<h1>Editing <? echo $item_capital; ?></h1>
    </div>
    
    <div class="r">
    </div>

</div>


<script>

	function update_build(){
		$( '#build' ).val( '<? echo date( 'Ymd' ); ?>' );
	}

	function update_date(){
		$( '#date' ).val( '<? echo date( 'm/d/Y' ); ?>' );
	}
	
	function update_cache(){
		var timestamp = Math.round( new Date().getTime() / 1000 );
		$( '#cache_refresh' ).val( timestamp );
	}

</script>


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
				<td colspan="2"><? echo $item_capital; ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Current Version:</td>
				<td class="right">
                	<? field_text( 'version', $info['version'], 'width: 50px;' ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Current Build:</td>
				<td class="right">
					<? field_text( 'build', $info['build'], 'width: 85px;' ); ?>
                    &nbsp;
                    <a href="#" onclick="update_build(); return false;">Set to Today</a>
				</td>
			</tr>
			<tr>
				<td class="left">Build Date:</td>
				<td class="right">
					<? field_text( 'date', $info['date'], 'width: 85px;' ); ?>
                    &nbsp;
                    <a href="#" onclick="update_date(); return false;">Set to Today</a>
				</td>
			</tr>
			<tr>
				<td class="left">Cache Refresh:</td>
				<td class="right">
					<? field_text( 'cache_refresh', $info['cache_refresh'], 'width: 95px;' ); ?>
                    &nbsp;
                    <a href="#" onclick="update_cache(); return false;">Set to Now</a>
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




