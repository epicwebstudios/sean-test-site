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
				<td class="left">Address:</td>
				<td class="right">
                	<div><? field_text( 'address', $info['address'], 'width: 441px;', 'placeholder="Address"' ); ?></div>
                	<div><? field_text( 'address_2', $info['address_2'], 'width: 441px;', 'placeholder="Address 2"' ); ?></div>
                	<div>
						<? field_text( 'city', $info['city'], 'width: 175px;', 'placeholder="City"' ); ?>
						<? field_text( 'state', $info['state'], 'width: 175px;', 'placeholder="State"' ); ?>
						<? field_text( 'zip', $info['zip'], 'width: 85px;', 'placeholder="Zip Code"' ); ?>
                    </div>
                </td>
			</tr>
			<tr>
				<td class="left">Phone Number:</td>
				<td class="right">
                	<? field_text( 'phone', $info['phone'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Toll-Free Number:</td>
				<td class="right">
                	<? field_text( 'tollfree', $info['tollfree'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Fax Number:</td>
				<td class="right">
                	<? field_text( 'fax', $info['fax'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">E-mail Address:</td>
				<td class="right">
                	<? field_text( 'email', $info['email'] ); ?>
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
    
    <script>
	
		function swap_hours( day ){
			$( '.day_' + day + ' .option' ).hide();
			var value = $( '#hours_' + day + '_type' ).val();
			$( '.day_' + day + ' .option_' + value ).show();
		}
	
	
		$( document ).ready( function(){
			for( var i=1; i<=7; i++ ){
				swap_hours( i );
			}
		});
	
	</script>
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Business Hours</td>
			</tr>
		</thead>
		<tbody>
        	<tr>
				<td class="left">Display Hours:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Yes, Display Business Hours', 0 => 'No, Do Not Display Business Hours' );
                    	field_select2( 'display', $options, $info['display'] );
					?>
                </td>
            </tr>
            
			<?
				$days 	= array( 1 => 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
				$hours 	= json_decode( $info['hours'], true );
				foreach( $hours as $key => $value ){
					$hours[$key]['open'] 	= strtotime( 'Today, '.$hours[$key]['open'] );
					$hours[$key]['close'] 	= strtotime( 'Today, '.$hours[$key]['close'] );
				}
			?>
            
			<? foreach( $days as $key => $value ){ ?>
                <tr class="day_<? echo $key; ?>">
                    <td class="left"><? echo $value; ?>:</td>
                    <td class="right">
                        <?
                            $options = array( 0 => 'Closed', 1 => 'Open', 2 => 'Custom Text' );
                            field_select2( 'hours['.$key.'][type]', $options, $hours[$key]['type'], '', 'onchange="swap_hours( '.$key.' );"' );
                        ?>
                        <div class="option option_1"><? field_time( 'hours['.$key.'][open]', $hours[$key]['open'] ); ?> to <? field_time( 'hours['.$key.'][close]', $hours[$key]['close'] ); ?></div>
                        <div class="option option_2"><? field_text( 'hours['.$key.'][text]', $hours[$key]['text'] ); ?></div>
                    </td>
                </tr>
            <? } ?>
            
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




