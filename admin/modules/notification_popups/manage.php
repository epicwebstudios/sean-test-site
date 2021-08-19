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
	
	function toggle_bg_type(){
		$( '.gradient' ).hide();
		if( $('#bg_type').val() == '1' ){
			$( '.gradient' ).show();
		}
	}

	$( document ).ready( function(){
		toggle_bg_type();
	});

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
				<td colspan="2"><? echo $item_capital; ?> Settings</td>
			</tr>
		</thead>
		<tbody>
            <tr>
                <td class="left">Name:</td>
                <td class="right">
                    <? field_text( 'name', $info['name'] ); ?>
					<div>This is used for record keeping on the backend only.</div>
                </td>
            </tr>
            <tr>
                <td class="left">Start Date:</td>
                <td class="right">
                    <? field_date( 'date_start', $info['date_start'] ); ?>
					<div>If you would like this banner to start on a specific date, select it above.</div>
					<div>If empty, the banner will start immediately (if set to "<b>Active</b>").</div>
                </td>
            </tr>
            <tr>
                <td class="left">End Date:</td>
                <td class="right">
                    <? field_date( 'date_end', $info['date_end'] ); ?>
					<div>If you would like this banner to end on a specific date, select it above.</div>
					<div>If empty, the banner will last indefinitely (until deleted or set to "<b>Inactive</b>").</div>
                </td>
            </tr>
			<tr>
				<td class="left">Display Type:</td>
				<td class="right">
                	<?
						$options = array( 0 => 'One-Time Only', 1 => 'Once Per Session' );
                    	field_select2( 'display_type', $options, $info['display_type'] );
					?>
					<div>If "<b>One-Time Only</b>" is selected, a user will only see the pop-up one time, even if they leave and return later.</div>
					<div>If "<b>Once Per Session</b>" is selected, a user will only see the pop-up each time they return to the website.</div>
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
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Content</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Background Type:</td>
				<td class="right">
					<?
						$options = array( 0 => 'Solid Color', 1 => 'Gradient Color' );
						field_select2( 'bg_type', $options, $info['bg_type'], '', 'onchange="toggle_bg_type();"' );
					?>
				</td>
			</tr>
			<tr>
				<td class="left">Background Color:</td>
				<td class="right">
                	<span class="gradient">From</span>
					<? field_color( 'bg_color_1', $info['bg_color_1'] ); ?>
                	<span class="gradient">to <? field_color( 'bg_color_2', $info['bg_color_2'] ); ?> (left to right)</span>
                </td>
			</tr>
			<tr>
				<td class="left">Text Color:</td>
				<td class="right">
                	<? field_color( 'text_color', $info['text_color'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Message / Content:</td>
				<td class="right">
                	<? field_editor( 'content', $info['content'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Close Button Text:</td>
				<td class="right">
                	<? field_text( 'close_btn_text', $info['close_btn_text'] ); ?>
					<div>If blank, "<b>Close</b>" will be used by default.</div>
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