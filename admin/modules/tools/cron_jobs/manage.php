<? $info = get_item( $_GET['i'], $database[0] ); ?>


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


<script>

	function swap_common(){
	
		var setting = $( '#common' ).val();
		
		var minute 	= '';
		var hour	= '';
		var day		= '';
		var month	= '';
		var weekday	= '';
		
		if( setting == '1' ){
			minute 	= '*';
			hour	= '*';
			day		= '*';
			month	= '*';
			weekday	= '*';
		}
		
		if( setting == '2' ){
			minute 	= '*/5';
			hour	= '*';
			day		= '*';
			month	= '*';
			weekday	= '*';
		}
		
		if( setting == '3' ){
			minute 	= '0';
			hour	= '*';
			day		= '*';
			month	= '*';
			weekday	= '*';
		}
		
		if( setting == '4' ){
			minute 	= '0,30';
			hour	= '*';
			day		= '*';
			month	= '*';
			weekday	= '*';
		}
		
		if( setting == '5' ){
			minute 	= '0';
			hour	= '0';
			day		= '*';
			month	= '*';
			weekday	= '*';
		}
		
		if( setting == '6' ){
			minute 	= '0';
			hour	= '0,12';
			day		= '*';
			month	= '*';
			weekday	= '*';
		}
		
		if( setting == '7' ){
			minute 	= '0';
			hour	= '0';
			day		= '*';
			month	= '*';
			weekday	= '0';
		}
		
		if( setting == '8' ){
			minute 	= '0';
			hour	= '0';
			day		= '1';
			month	= '*';
			weekday	= '*';
		}
		
		if( setting == '9' ){
			minute 	= '0';
			hour	= '0';
			day		= '1,15';
			month	= '*';
			weekday	= '*';
		}
		
		if( setting == '10' ){
			minute 	= '0';
			hour	= '0';
			day		= '1';
			month	= '1';
			weekday	= '*';
		}
		
		$( '#min' ).val( minute );
		$( '#hour' ).val( hour );
		$( '#day' ).val( day );
		$( '#month' ).val( month );
		$( '#weekday' ).val( weekday );
	
	}

</script>


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
				<td class="left">Name:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Description:</td>
				<td class="right">
                	<? field_textarea( 'description', $info['description'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Cron Type:</td>
				<td class="right">
                	<? field_select2( 'type', $types, $info['type'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">File:</td>
				<td class="right">
                	<? field_text( 'file', $info['file'] ); ?>
                    <div>If <b>Local PHP File</b>, this is the <b>filename</b> of the file located within <b>/cron/</b></div>
					<div>If <b>cURL</b>, enter the <b>full URL</b> (including <b>http://</b> of the file.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Use Common Setting:</td>
				<td class="right">
                	<?
						$common_settings = array(
							0 => '',
							1 => 'Once Per Minute',
							2 => 'Once Per 5 Minutes',
							3 => 'Once Per Hour',
							4 => 'Twice Per Hour',
							5 => 'Once Per Day',
							6 => 'Twice Per Day',
							7 => 'Once Per Week',
							8 => 'Once Per Month',
							9 => 'On the 1st and 15th of the Month',
							10 => 'Once Per Year',
						);
                    	field_select2( 'common', $common_settings, $info['common'], '', 'onchange="swap_common();"' );
					?>
                </td>
			</tr>
			<tr>
				<td class="left">Minute:</td>
				<td class="right">
                	<? field_text( 'min', $info['min'], 'width: 50px;' ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Hour:</td>
				<td class="right">
                	<? field_text( 'hour', $info['hour'], 'width: 50px;' ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Day:</td>
				<td class="right">
                	<? field_text( 'day', $info['day'], 'width: 50px;' ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Month:</td>
				<td class="right">
                	<? field_text( 'month', $info['month'], 'width: 50px;' ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Weekday:</td>
				<td class="right">
                	<? field_text( 'weekday', $info['weekday'], 'width: 50px;' ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Status:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Enabled', 0 => 'Disabled' );
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
            name="<? if( $_GET['act'] == 'edit' ){ echo 'edit'; } else { echo 'add'; } ?>_sub"
            value="Save <? echo $item_capital; ?>"
        >
        
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




