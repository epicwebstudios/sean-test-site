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
                    <div>This is used for record keeping on the backend only. This will not display on the front-end of the website.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Category:</td>
				<td class="right">
                	<? field_select2( 'category', $categories, $info['category'] ); ?>
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
				<td colspan="2"><? echo $item_capital; ?> Author Information</td>
			</tr>
		</thead>
        <tbody>
			<tr>
				<td class="left">Name:</td>
				<td class="right">
                	<? field_text( 'author', $info['author'] ); ?>
                    <div>Ideally this is the full name of the person the testimonial is from (ex: <b>John J. Doe</b>)</div>
                </td>
			</tr>
			<tr>
				<td class="left">Location:</td>
				<td class="right">
                	<? field_text( 'location', $info['location'] ); ?>
                    <div>Ideally this is the city and state location of the author or organization (ex: <b>Erie, PA</b>)</div>
                </td>
			</tr>
			<tr>
				<td class="left">Organization:</td>
				<td class="right">
                	<? field_text( 'organization', $info['organization'] ); ?>
                    <div>Ideally this is the name of the organization the author is involved with, if applicable. (ex: <b>Doe Industries</b>)</div>
                </td>
			</tr>
			<tr>
				<td class="left">Misc. Information:</td>
				<td class="right">
                	<? field_text( 'misc', $info['misc'] ); ?>
                    <div>This field can be used for extra information, such as related industries, services, or products (ex: <b>Plastics manufacturing</b>)</div>
                </td>
			</tr>
			<tr>
				<td class="left">Website / Link:</td>
				<td class="right">
                	<? field_text( 'website', $info['website'] ); ?>
                    <div>You can link to a specific page or website by entering the URL above. Note, you must include the <b>http://</b> for the link to work correctly.</div>
                </td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Summary</td>
			</tr>
		</thead>
        <tbody>
			<tr>
				<td class="left">Summary:</td>
				<td class="right">
                	<? field_textarea( 'summary', $info['summary'] ); ?>
                    <div>This summary should be a singular sentence summary of their testimonial.</div>
					<div>This will be used in feeds and areas that allows little space.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Rating:</td>
				<td class="right">
                	<? field_select2( 'rating', $ratings, $info['rating'] ); ?> / 5
                </td>
			</tr>
        </tbody>
    </table>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Quote</td>
			</tr>
		</thead>
    </table>
    <? field_editor( 'quote', $info['quote'] ); ?>
    
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




