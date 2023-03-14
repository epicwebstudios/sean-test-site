<? 
	$info = get_item( $_GET['i'], $database[0] );
	$info['social'] = json_decode( $info['social'], true );
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
				<td colspan="2"><? echo $item_capital; ?> Information</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Category:</td>
				<td class="right">
                	<? field_select2( 'category', $categories, $info['category'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">First Name:</td>
				<td class="right">
                	<? field_text( 'first', $info['first'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Middle Name:</td>
				<td class="right">
                	<? field_text( 'middle', $info['middle'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Last Name:</td>
				<td class="right">
                	<? field_text( 'last', $info['last'] ); ?>
                </td>
			</tr>
            <tr>
                <td class="left">Permalink:</td>
                <td class="right">
                    <? field_permalink( 'permalink', $info['permalink'], ['first', 'middle', 'last'] ); ?>
                </td>
            </tr>
			<tr>
				<td class="left">Job Position:</td>
				<td class="right">
                	<? field_text( 'position', $info['position'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Department:</td>
				<td class="right">
                	<? field_text( 'department', $info['department'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Photo:</td>
				<td class="right">
					<? field_image( 'photo', $info['photo'], '/staff/' ); ?>
				</td>
			</tr>
			<tr>
				<td class="left">Status:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Active / Visible', 0 => 'Inactive / Hidden' );
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
				<td colspan="2"><? echo $item_capital; ?> Contact Information</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">E-mail Address:</td>
				<td class="right">
                	<? field_text( 'email', $info['email'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Phone Number:</td>
				<td class="right">
                	<? field_text( 'phone', $info['phone'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Fax Number:</td>
				<td class="right">
                	<? field_text( 'fax', $info['fax'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Facebook URL:</td>
				<td class="right">
                	<? field_text( 'social[facebook]', $info['social']['facebook'] ); ?>
                    <div>You must include the <b>http://</b> in order for linking to work correctly.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Twitter URL:</td>
				<td class="right">
                	<? field_text( 'social[twitter]', $info['social']['twitter'] ); ?>
                    <div>You must include the <b>http://</b> in order for linking to work correctly.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Instagram URL:</td>
				<td class="right">
                	<? field_text( 'social[instagram]', $info['social']['instagram'] ); ?>
                    <div>You must include the <b>http://</b> in order for linking to work correctly.</div>
                </td>
			</tr>
			<tr>
				<td class="left">LinkedIn URL:</td>
				<td class="right">
                	<? field_text( 'social[linkedin]', $info['social']['linkedin'] ); ?>
                    <div>You must include the <b>http://</b> in order for linking to work correctly.</div>
                </td>
			</tr>
		</tbody>
	</table>
    
    &nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Biographical Information</td>
			</tr>
		</thead>
	</table>
    <? field_editor( 'bio', $info['bio'] ); ?>
    
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




