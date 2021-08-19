<? $content = file_get_contents( BASE_DIR.'/.htaccess' ); ?>


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
    
	<style>
        .CodeMirror { height: 600px; }
    </style>
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Editor</td>
			</tr>
		</thead>
	</table>
    <? field_code( 'content', $content, 'width: 100%;' ); ?>
	
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




