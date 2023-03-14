<? $info = get_item( $_COOKIE['admin_user'], $database[0] ); ?> 


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
				<td class="left">Change Your Password:</td>
				<td class="right">
                	<? field_password( 'password', '' ); ?>
                    <div>If you'd like to change your password, enter a new password above.</div>
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




