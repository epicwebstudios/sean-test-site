<?
	$info = get_item( $_GET['i'], $database[0] );
	if( $_GET['act'] == 'add' ){ $info['timezone'] = $settings['timezone']; }
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
				<td colspan="2"><? echo $item_capital; ?> Details</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">First Name:</td>
				<td class="right">
                	<? field_text( 'first', $info['first'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Last Name:</td>
				<td class="right">
                	<? field_text( 'last', $info['last'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">E-mail Address:</td>
				<td class="right">
                	<? field_text( 'email', $info['email'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Timezone:</td>
				<td class="right">
                	<? field_select2( 'timezone', get_timezones(), $info['timezone'] ); ?>
                </td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Login Credentials</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Username:</td>
				<td class="right">
                	<? field_text( 'username', $info['username'], '', 'autocomplete="off"' ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Password:</td>
				<td class="right">
                	<? field_password( 'password', '', '', 'autocomplete="off"' ); ?>
                    <? if( $_GET['act'] == 'edit' ){ ?>
                    	<div>If you wish to change the password to this account, enter it above, otherwise, leave blank.</div>
                    <? } ?>
                </td>
			</tr>
			<tr>
				<td class="left">Level:</td>
				<td class="right">
                	<? field_select2( 'level', $levels, $info['level'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Require MFA?</td>
				<td class="right">
                	<?
						$options = array( 0 => 'No', 1 => 'Yes' );
                    	field_select2( 'force_mfa', $options, $info['force_mfa'] );
					?>
					<div>If set to "<b>Yes</b>", the user will need to check their email for a verification code during login.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Status:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Login Enabled', 0 => 'Login Disabled', 2 => 'Account Locked' );
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




